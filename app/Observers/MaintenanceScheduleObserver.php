<?php

namespace App\Observers;

use App\Models\MaintenanceSchedule;
use App\Models\AuditLog;

class MaintenanceScheduleObserver
{
    public function created(MaintenanceSchedule $schedule): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'description' => sprintf(
                'Create MaintenanceSchedule ID:%d user_id:%d agent_id:%d date:%s status:%s',
                $schedule->id,
                $schedule->user_id,
                $schedule->agent_id,
                $schedule->scheduled_date,
                $schedule->status
            ),
            'ip_address' => request()->ip(),
        ]);
    }

    public function updated(MaintenanceSchedule $schedule): void
    {
        $changes = [];
        foreach ($schedule->getChanges() as $key => $val) {
            if (in_array($key, ['updated_at'])) {
                continue;
            }
            $original = $schedule->getOriginal($key);
            $changes[] = "{$key}:{$original}=>{$val}";
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' => sprintf(
                'Update MaintenanceSchedule ID:%d (%s)',
                $schedule->id,
                implode(', ', $changes)
            ),
            'ip_address' => request()->ip(),
        ]);
    }

    public function deleted(MaintenanceSchedule $schedule): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'description' => sprintf('Delete MaintenanceSchedule ID:%d', $schedule->id),
            'ip_address' => request()->ip(),
        ]);
    }
}
