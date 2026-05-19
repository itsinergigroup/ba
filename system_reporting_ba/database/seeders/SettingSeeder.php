<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'attendance_start_time',
                'value' => '07:00',
                'group' => 'attendance',
            ],
            [
                'key' => 'attendance_end_time',
                'value' => '17:00',
                'group' => 'attendance',
            ],
            [
                'key' => 'check_in_limit',
                'value' => '08:00',
                'group' => 'attendance',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
