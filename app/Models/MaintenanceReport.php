<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_schedule_id',
        'result',
        'recommendation',
        'photo',
        'report_pdf',
        'user_id',
        'agent_id',
        'status',
        'detail',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(\App\Models\User::class, 'agent_id');
    }

    public function schedule()
    {
        return $this->belongsTo(\App\Models\MaintenanceSchedule::class, 'maintenance_schedule_id');
    }

    public function devices()
    {
        return $this->belongsToMany(\App\Models\Device::class, 'maintenance_report_devices')->withPivot('is_problematic', 'repair_status');
    }
}
