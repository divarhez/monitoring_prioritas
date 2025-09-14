<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Helpers\FileHelper;

class MaintenanceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\MaintenanceReport::with(['devices.user', 'schedule.agent'])->orderByDesc('created_at');

        if ($request->has('category')) {
            $query->whereHas('schedule', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        if ($request->has('month')) {
            $month = date('m', strtotime($request->month));
            $query->whereMonth('created_at', $month);
        }

        $reports = $query->get();

        if (request()->has('export') && request('export') === 'pdf') {
            $pdf = Pdf::loadView('maintenance_reports.export_pdf', compact('reports'));
            return $pdf->download('maintenance_reports.pdf');
        }
        return view('maintenance_reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Data untuk form input laporan
        $users = \App\Models\User::where('role', 'user')->orderBy('name')->get();
        $devices = \App\Models\Device::with('user')->orderBy('type')->get();
        $schedules = \App\Models\MaintenanceSchedule::with('user')->orderBy('scheduled_date')->get();

        return view('maintenance_reports.create', compact('users', 'devices', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id'    => 'required|exists:maintenance_schedules,id',
            'device_ids'     => 'required|array|min:1',
            'device_ids.*'   => 'exists:devices,id',
            'problematic_devices' => 'nullable|array',
            'problematic_devices.*' => 'exists:devices,id',
            'result'         => 'required|string',
            'recommendation' => 'nullable|string',
            'photo'          => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = FileHelper::upload($request->file('photo'), 'maintenance_photos');
        }

        // Buat record laporan
        $report = \App\Models\MaintenanceReport::create([
            'maintenance_schedule_id' => $validated['schedule_id'],
            'result'         => $validated['result'],
            'recommendation' => $validated['recommendation'] ?? null,
            'photo'          => $photoPath,
            // report_pdf akan diisi otomatis setelah PDF digenerate
        ]);

        // Attach devices with problematic status
        $problematicDevices = $validated['problematic_devices'] ?? [];
        $deviceData = [];
        foreach ($validated['device_ids'] as $deviceId) {
            $deviceData[$deviceId] = [
                'is_problematic' => in_array($deviceId, $problematicDevices),
                'repair_status' => in_array($deviceId, $problematicDevices) ? 'in_progress' : null,
            ];
        }
        $report->devices()->attach($deviceData);

        // Muat relasi yang dibutuhkan untuk PDF
        $report->load(['devices.user', 'schedule.agent']);

        // Generate PDF otomatis dari template single report
        $pdf = Pdf::loadView('maintenance_reports.single_export_pdf', [
            'report' => $report,
        ]);

        $pdfDir = 'maintenance_reports/generated';
        $pdfName = 'maintenance_report_' . $report->id . '.pdf';
        $pdfPath = $pdfDir . '/' . $pdfName;

        // Pastikan direktori ada di disk public
        if (!Storage::disk('public')->exists($pdfDir)) {
            Storage::disk('public')->makeDirectory($pdfDir);
        }

        Storage::disk('public')->put($pdfPath, $pdf->output());

        // Simpan path PDF ke kolom report_pdf (relative path pada disk 'public')
        $report->update(['report_pdf' => $pdfPath]);

        // Update status jadwal based on problematic devices
        if ($report->schedule) {
            $hasProblematicDevices = $report->devices()->wherePivot('is_problematic', true)->exists();
            $report->schedule->status = $hasProblematicDevices ? 'under_repair' : 'done';
            $report->schedule->save();
        }

        return redirect()->route('maintenance-report.index')->with('success', 'Laporan berhasil disimpan dan PDF otomatis dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'maintenance_schedule_id' => 'required|exists:maintenance_schedules,id',
            'device_ids' => 'required|array|min:1',
            'device_ids.*' => 'exists:devices,id',
            'result' => 'required|string',
            'recommendation' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $report = \App\Models\MaintenanceReport::findOrFail($id);
        $data = $request->only(['maintenance_schedule_id', 'result', 'recommendation']);
        if ($request->hasFile('photo')) {
            $data['photo'] = FileHelper::upload($request->file('photo'), 'maintenance_photos');
        }
        $report->update($data);
        $report->devices()->sync($request->device_ids);
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' => 'Update laporan maintenance ID: ' . $report->id,
            'ip_address' => $request->ip(),
        ]);
        return redirect()->route('maintenance-report.index')->with('success', 'Laporan maintenance berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Download PDF report by report id (serves via storage path)
     */
    public function download(string $id)
    {
        $report = \App\Models\MaintenanceReport::findOrFail($id);

        if (!$report->report_pdf) {
            abort(404, 'File report tidak tersedia.');
        }

        $relativePath = ltrim($report->report_pdf, '/');
        $disk = Storage::disk('public');

        if (!$disk->exists($relativePath)) {
            abort(404, 'File report tidak ditemukan di penyimpanan.');
        }

        $absolutePath = storage_path('app/public/' . $relativePath);
        return response()->download($absolutePath, basename($absolutePath), [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Update repair status for a specific device in a maintenance report
     */
    public function updateRepairStatus(Request $request, string $reportId, string $deviceId)
    {
        $request->validate([
            'repair_status' => 'required|in:in_progress,completed',
        ]);

        $report = \App\Models\MaintenanceReport::findOrFail($reportId);
        $device = \App\Models\Device::findOrFail($deviceId);

        // Update the pivot table
        $report->devices()->updateExistingPivot($deviceId, [
            'repair_status' => $request->repair_status,
        ]);

        // Check if all problematic devices are completed
        $allProblematicCompleted = !$report->devices()
            ->wherePivot('is_problematic', true)
            ->wherePivot('repair_status', '!=', 'completed')
            ->exists();

        // Update schedule status if all repairs are done
        if ($report->schedule && $allProblematicCompleted) {
            $report->schedule->status = 'done';
            $report->schedule->save();
        }

        // Log the action
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update_repair_status',
            'description' => 'Update repair status for device ID: ' . $deviceId . ' in report ID: ' . $reportId . ' to ' . $request->repair_status,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Status perbaikan berhasil diupdate.');
    }
}
