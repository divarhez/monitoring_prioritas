<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    // Eager-load the user by default to avoid N+1 in listings
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(\App\Models\MaintenanceReport::class, 'device_id');
    }

    protected $fillable = [
        'user_id',
        'type',
        'brand',
        'model',
        'serial_number',
        'description',
        'category',
    ];
}
