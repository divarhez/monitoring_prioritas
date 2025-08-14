<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = \App\Models\User::count();
        $agentCount = \App\Models\Agent::count();
        $deviceCount = \App\Models\Device::count();
        $scheduleCount = \App\Models\MaintenanceSchedule::whereMonth('scheduled_date', now()->month)->count();

        $recentMaintenances = \App\Models\MaintenanceSchedule::with(['user', 'agent', 'device'])
            ->orderBy('scheduled_date', 'desc')
            ->limit(10)
            ->get();

        $categoryStats = [
            'hardware' => \App\Models\MaintenanceSchedule::where('category', 'hardware')->whereMonth('scheduled_date', now()->month)->count(),
            'software' => \App\Models\MaintenanceSchedule::where('category', 'software')->whereMonth('scheduled_date', now()->month)->count(),
            'jaringan' => \App\Models\MaintenanceSchedule::where('category', 'jaringan')->whereMonth('scheduled_date', now()->month)->count(),
        ];

        return view('dashboard', compact('userCount', 'agentCount', 'deviceCount', 'scheduleCount', 'recentMaintenances', 'categoryStats'));
    }
}
