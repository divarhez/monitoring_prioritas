
<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Devices
Route::middleware(['auth'])->group(function () {
    Route::resource('devices', App\Http\Controllers\DeviceController::class);
});
// Laporan Maintenance (akses: admin, agent, helpdesk)
Route::middleware(['auth','role:admin,agent,helpdesk'])->group(function () {
    Route::get('/maintenance-report', [App\Http\Controllers\MaintenanceReportController::class, 'index'])->name('maintenance-report.index');
});
Route::middleware(['auth','role:admin,agent'])->group(function () {
    Route::get('/maintenance-report/create', [App\Http\Controllers\MaintenanceReportController::class, 'create'])->name('maintenance-report.create');
    Route::post('/maintenance-report', [App\Http\Controllers\MaintenanceReportController::class, 'store'])->name('maintenance-report.store');
});

// Download PDF laporan maintenance (menghindari ketergantungan storage:link)
Route::middleware(['auth','role:admin,agent,helpdesk'])->get(
    '/maintenance-report/{report}/download',
    [App\Http\Controllers\MaintenanceReportController::class, 'download']
)->name('maintenance-report.download');

// Update repair status for devices in maintenance reports
Route::middleware(['auth','role:agent'])->post(
    '/maintenance-report/{reportId}/device/{deviceId}/update-repair-status',
    [App\Http\Controllers\MaintenanceReportController::class, 'updateRepairStatus']
)->name('maintenance-report.update-repair-status');


// User Prioritas
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
});

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified']);

// Admin: full access, export data
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('agents', App\Http\Controllers\AgentController::class);
    Route::resource('maintenance-schedules', App\Http\Controllers\MaintenanceScheduleController::class);
    // Route resource maintenance-reports dihapus agar tidak bentrok dengan /maintenance-report
});

// Agent: only see assigned, input/update maintenance/checklist/report
Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent-dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('agent.dashboard');
    // Route resource maintenance-reports dihapus agar tidak bentrok dengan /maintenance-report
});

// Helpdesk: monitoring only (read-only)
Route::middleware(['auth', 'role:helpdesk'])->group(function () {
    Route::get('/helpdesk-dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('helpdesk.dashboard');
    // Route resource maintenance-reports dihapus agar tidak bentrok dengan /maintenance-report
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Maintenance History (sidebar): visible to admin/agent/helpdesk (read-only)
Route::middleware(['auth','role:admin,agent,helpdesk'])->get(
    '/maintenance-history',
    [App\Http\Controllers\MaintenanceHistoryController::class, 'index']
)->name('maintenance-history.index');

require __DIR__.'/auth.php';
