<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            'LAMPUNG',
            'SUMATERA UTARA',
            'BANTEN',
            'KALIMANTAN BARAT',
            'JAWA TIMUR',
            'JAWA TENGAH',
            'JAWA BARAT',
            'SUMATERA SELATAN',
            'SUMATERA BARAT',
            'DKI JAKARTA',
            'KEP. RIAU',
            'KALIMANTAN TIMUR',
        ];

        foreach ($provinces as $name) {
            Province::updateOrCreate(['name' => $name]);
        }
    }
}
