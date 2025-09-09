<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceSchedule;

class MaintenanceHistoryController extends Controller
{
    /**
     * Show recent maintenance schedules (history).
     * Visible from sidebar so admin can quickly verify newly added schedules.
     */
    public function index()
    {
        // Load latest reports for each schedule to expose downloadable PDF (if any)
        $histories = MaintenanceSchedule::with([
                'user',
                'agent',
                'reports' => function ($q) {
                    $q->latest();
                }
            ])
            ->orderByDesc('scheduled_date')
            ->orderByDesc('created_at')
            ->get();

        return view('maintenance_history.index', compact('histories'));
    }
}
