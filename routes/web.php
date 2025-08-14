<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified']);

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('agents', App\Http\Controllers\AgentController::class);
    Route::resource('devices', App\Http\Controllers\DeviceController::class);
    Route::resource('maintenance-schedules', App\Http\Controllers\MaintenanceScheduleController::class);
    Route::resource('maintenance-reports', App\Http\Controllers\MaintenanceReportController::class);
    Route::resource('checklists', App\Http\Controllers\ChecklistController::class);
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent-dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('agent.dashboard');
    // Agent hanya bisa input laporan dan checklist
    Route::resource('maintenance-reports', App\Http\Controllers\MaintenanceReportController::class)->only(['create', 'store', 'index']);
    Route::resource('checklists', App\Http\Controllers\ChecklistController::class)->only(['create', 'store', 'index']);
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('user.dashboard');
    // User hanya bisa lihat perangkat dan histori
    Route::resource('devices', App\Http\Controllers\DeviceController::class)->only(['index', 'show']);
    Route::resource('maintenance-reports', App\Http\Controllers\MaintenanceReportController::class)->only(['index', 'show']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
