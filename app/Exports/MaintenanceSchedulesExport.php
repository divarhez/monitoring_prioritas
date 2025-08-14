<?php
namespace App\Exports;
use App\Models\MaintenanceSchedule;
use Maatwebsite\Excel\Concerns\FromCollection;
class MaintenanceSchedulesExport implements FromCollection {
    public function collection() {
        return MaintenanceSchedule::with(['user','agent'])->get();
    }
}
