<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MaintenanceScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = \App\Models\MaintenanceSchedule::with(['user', 'agent'])->get();
            $query = \App\Models\MaintenanceSchedule::with(['user', 'agent']);
            if (request()->filled('category')) {
                $query->where('category', request()->category);
            }
            $schedules = $query->get();
        if (request()->has('export') && request('export') === 'excel') {
            $path = \App\Helpers\ExcelExportHelper::exportMaintenanceSchedules($schedules);
            return response()->download($path)->deleteFileAfterSend(true);
        }
        if (request()->has('export') && request('export') === 'pdf') {
            $pdf = Pdf::loadView('maintenance_schedules.export_pdf', compact('schedules'));
            return $pdf->download('maintenance_schedules.pdf');
        }
        return view('maintenance_schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $users = \App\Models\User::where('role', 'user')->get();
    $agents = \App\Models\User::where('role', 'agent')->get();
    return view('maintenance_schedules.create', compact('users', 'agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'agent_id' => 'required|exists:users,id',
            'scheduled_date' => 'required|date',
            'category' => 'required|in:hardware,software,jaringan',
            'status' => 'nullable|in:scheduled,done,missed',
        ]);

        // Default status ke 'scheduled' bila tidak diisi (form create tidak memiliki field status)
        $data['status'] = $data['status'] ?? 'scheduled';

        $schedule = \App\Models\MaintenanceSchedule::create($data);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'description' => 'Menambah jadwal maintenance ID: ' . $schedule->id,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('maintenance-schedules.index')->with('success', 'Jadwal maintenance berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $schedule = \App\Models\MaintenanceSchedule::with(['user', 'agent'])->findOrFail($id);
    return view('maintenance_schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $schedule = \App\Models\MaintenanceSchedule::findOrFail($id);
    $users = \App\Models\User::where('role', 'user')->get();
    $agents = \App\Models\User::where('role', 'agent')->get();
    return view('maintenance_schedules.edit', compact('schedule', 'users', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'agent_id' => 'required|exists:users,id',
            'scheduled_date' => 'required|date',
            'category' => 'required|in:hardware,software,jaringan',
            'status' => 'required|string',
        ]);
        $schedule = \App\Models\MaintenanceSchedule::findOrFail($id);
        $schedule->update($request->all());
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' => 'Update jadwal maintenance ID: ' . $schedule->id,
            'ip_address' => $request->ip(),
        ]);
        return redirect()->route('maintenance-schedules.index')->with('success', 'Jadwal maintenance berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $schedule = \App\Models\MaintenanceSchedule::findOrFail($id);
    $schedule->delete();
    \App\Models\AuditLog::create([
        'user_id' => auth()->id(),
        'action' => 'delete',
        'description' => 'Hapus jadwal maintenance ID: ' . $id,
        'ip_address' => request()->ip(),
    ]);
    return redirect()->route('maintenance-schedules.index')->with('success', 'Jadwal maintenance berhasil dihapus');
    }
}
