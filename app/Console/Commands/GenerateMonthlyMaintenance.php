<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Agent;
use App\Models\MaintenanceSchedule;
use Carbon\Carbon;

class GenerateMonthlyMaintenance extends Command
{
    protected $signature = 'maintenance:generate-monthly';
    protected $description = 'Generate monthly maintenance schedule for priority users';

    public function handle()
    {
        $users = User::where('role', 'user')->get();
        $agents = Agent::all();
        $date = Carbon::now()->startOfMonth();
        $agentCount = $agents->count();
        if ($agentCount === 0) {
            $this->error('Tidak ada agent di database. Tambahkan agent terlebih dahulu.');
            return;
        }
        $i = 0;
        foreach ($users as $user) {
            $agent = $agents[$i % $agentCount] ?? null;
            if ($agent) {
                MaintenanceSchedule::create([
                    'user_id' => $user->id,
                    'agent_id' => $agent->id,
                    'scheduled_date' => $date,
                    'status' => 'scheduled',
                ]);
                $i++;
            }
        }
        $this->info('Monthly maintenance schedule generated.');
    }
}
