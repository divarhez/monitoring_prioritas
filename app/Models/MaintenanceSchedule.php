<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'scheduled_date',
        'category',
        'status',
    ];

    // Auto eager-load user to simplify views
    protected $with = ['user', 'agent'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(\App\Models\MaintenanceReport::class, 'maintenance_schedule_id');
    }
}
