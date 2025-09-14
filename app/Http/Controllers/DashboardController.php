<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = strtolower($user->role ?? '');

        $userCount = \App\Models\User::count();
        $agentCount = \App\Models\User::where('role', 'agent')->count();
        $deviceCount = \App\Models\Device::count();
        $scheduleCount = \App\Models\MaintenanceSchedule::whereMonth('scheduled_date', now()->month)->count();

        // Statistik kategori: jumlah maintenance SELESAI berdasarkan laporan yang DIBUAT bulan berjalan
        // (lebih akurat karena "done" direkam saat laporan dibuat)
        $categories = ['hardware', 'software', 'jaringan'];
        $categoryStats = array_fill_keys($categories, 0);

        $reportQuery = \App\Models\MaintenanceReport::query()
            ->join('maintenance_schedules', 'maintenance_schedules.id', '=', 'maintenance_reports.maintenance_schedule_id')
            ->whereYear('maintenance_reports.created_at', now()->year)
            ->whereMonth('maintenance_reports.created_at', now()->month);

        // Jika agent, tampilkan grafik untuk laporan yang dikerjakan agent tersebut
        if ($user && $role === 'agent') {
            $reportQuery->where('maintenance_schedules.user_id', $user->id);
        }

        $rows = $reportQuery
            ->selectRaw('maintenance_schedules.category, COUNT(*) as total')
            ->groupBy('maintenance_schedules.category')
            ->pluck('total', 'maintenance_schedules.category')
            ->toArray();

        $categoryStats = array_merge($categoryStats, $rows);

        // Grafik perangkat: top 5 tipe perangkat berdasarkan jumlah laporan tahun berjalan
        $deviceQuery = \App\Models\MaintenanceReport::query()
            ->join('maintenance_schedules', 'maintenance_schedules.id', '=', 'maintenance_reports.maintenance_schedule_id')
            ->join('maintenance_report_devices', 'maintenance_report_devices.maintenance_report_id', '=', 'maintenance_reports.id')
            ->join('devices', 'devices.id', '=', 'maintenance_report_devices.device_id')
            ->whereYear('maintenance_reports.created_at', now()->year);

        if ($user && $role === 'agent') {
            $deviceQuery->where('maintenance_schedules.user_id', $user->id);
        }

        $deviceRows = $deviceQuery
            ->selectRaw("COALESCE(NULLIF(devices.type, ''), 'Lainnya') as type, COUNT(*) as total")
            ->groupBy('type')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total', 'type');

        $deviceStats = [
            'labels' => $deviceRows->keys()->values(),
            'data' => $deviceRows->values()->values(),
        ];

        // Statistik maintenance bulanan - optimized query
        $maintenanceStatsRaw = \App\Models\MaintenanceReport::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('count', 'month')
            ->toArray();

        $months = [];
        $maintenanceCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0,0,0,$i,1));
            $maintenanceCounts[] = $maintenanceStatsRaw[$i] ?? 0;
        }
        $maintenanceStats = [
            'labels' => $months,
            'data' => $maintenanceCounts
        ];

        // Pastikan semua variabel dikirim ke view
        return view('dashboard', [
            'userCount' => $userCount ?? 0,
            'agentCount' => $agentCount ?? 0,
            'deviceCount' => $deviceCount ?? 0,
            'scheduleCount' => $scheduleCount ?? 0,
            'categoryStats' => $categoryStats ?? ['hardware'=>0,'software'=>0,'jaringan'=>0],
            'deviceStats' => $deviceStats ?? ['labels'=>[],'data'=>[]],
            'maintenanceStats' => $maintenanceStats ?? ['labels'=>[],'data'=>[]],
        ]);
    }

    public function generateReport()
    {
        $user = auth()->user();
        $role = strtolower($user->role ?? '');

        $userCount = \App\Models\User::count();
        $agentCount = \App\Models\User::where('role', 'agent')->count();
        $deviceCount = \App\Models\Device::count();
        $scheduleCount = \App\Models\MaintenanceSchedule::whereMonth('scheduled_date', now()->month)->count();

        $categories = ['hardware', 'software', 'jaringan'];
        $categoryStats = array_fill_keys($categories, 0);

        $reportQuery = \App\Models\MaintenanceReport::query()
            ->join('maintenance_schedules', 'maintenance_schedules.id', '=', 'maintenance_reports.maintenance_schedule_id')
            ->whereYear('maintenance_reports.created_at', now()->year)
            ->whereMonth('maintenance_reports.created_at', now()->month);

        if ($user && $role === 'agent') {
            $reportQuery->where('maintenance_schedules.user_id', $user->id);
        }

        $rows = $reportQuery
            ->selectRaw('maintenance_schedules.category, COUNT(*) as total')
            ->groupBy('maintenance_schedules.category')
            ->pluck('total', 'maintenance_schedules.category')
            ->toArray();

        $categoryStats = array_merge($categoryStats, $rows);

        $deviceQuery = \App\Models\MaintenanceReport::query()
            ->join('maintenance_schedules', 'maintenance_schedules.id', '=', 'maintenance_reports.maintenance_schedule_id')
            ->join('maintenance_report_devices', 'maintenance_report_devices.maintenance_report_id', '=', 'maintenance_reports.id')
            ->join('devices', 'devices.id', '=', 'maintenance_report_devices.device_id')
            ->whereYear('maintenance_reports.created_at', now()->year);

        if ($user && $role === 'agent') {
            $deviceQuery->where('maintenance_schedules.user_id', $user->id);
        }

        $deviceRows = $deviceQuery
            ->selectRaw("COALESCE(NULLIF(devices.type, ''), 'Lainnya') as type, COUNT(*) as total")
            ->groupBy('type')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total', 'type');

        $deviceStats = [
            'labels' => $deviceRows->keys()->values(),
            'data' => $deviceRows->values()->values(),
        ];

        $months = [];
        $maintenanceCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0,0,0,$i,1));
            $maintenanceCounts[] = \App\Models\MaintenanceReport::whereMonth('created_at', $i)->whereYear('created_at', now()->year)->count();
        }
        $maintenanceStats = [
            'labels' => $months,
            'data' => $maintenanceCounts
        ];

        $pdf = Pdf::loadView('dashboard_report', [
            'userCount' => $userCount ?? 0,
            'agentCount' => $agentCount ?? 0,
            'deviceCount' => $deviceCount ?? 0,
            'scheduleCount' => $scheduleCount ?? 0,
            'categoryStats' => $categoryStats ?? ['hardware'=>0,'software'=>0,'jaringan'=>0],
            'deviceStats' => $deviceStats ?? ['labels'=>[],'data'=>[]],
            'maintenanceStats' => $maintenanceStats ?? ['labels'=>[],'data'=>[]],
        ]);

        return $pdf->stream('dashboard-report.pdf');
    }
}
