<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    \App\Models\Device::delete();
    \App\Models\User::delete();

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@company.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Agent Satu',
            'email' => 'agent1@company.com',
            'password' => bcrypt('password'),
            'role' => 'agent',
        ]);

        \App\Models\User::create([
            'name' => 'User Prioritas',
            'email' => 'user1@company.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}
