<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleViewerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'rbs@example.com'],
            [
                'name' => 'User RBS',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'rbs',
                'is_active' => true,
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'name' => 'User View Only',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'view user only',
                'is_active' => true,
            ]
        );
    }
}
