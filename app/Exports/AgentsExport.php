<?php
namespace App\Exports;
use App\Models\Agent;
use Maatwebsite\Excel\Concerns\FromCollection;
class AgentsExport implements FromCollection {
    public function collection() {
        return Agent::all();
    }
}
