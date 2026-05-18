<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Province;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cityMappings = [
            ['name' => 'BANDAR LAMPUNG', 'province' => 'LAMPUNG'],
            ['name' => 'MEDAN', 'province' => 'SUMATERA UTARA'],
            ['name' => 'TANGERANG SELATAN', 'province' => 'BANTEN'],
            ['name' => 'BINJAI', 'province' => 'SUMATERA UTARA'],
            ['name' => 'PONTIANAK', 'province' => 'KALIMANTAN BARAT'],
            ['name' => 'PAMEKASAN', 'province' => 'JAWA TIMUR'],
            ['name' => 'TANGERANG', 'province' => 'BANTEN'],
            ['name' => 'SEMARANG', 'province' => 'JAWA TENGAH'],
            ['name' => 'BEKASI', 'province' => 'JAWA BARAT'],
            ['name' => 'PALEMBANG', 'province' => 'SUMATERA SELATAN'],
            ['name' => 'SINTANG', 'province' => 'KALIMANTAN BARAT'],
            ['name' => 'BLITAR', 'province' => 'JAWA TIMUR'],
            ['name' => 'BANDUNG', 'province' => 'JAWA BARAT'],
            ['name' => 'BOGOR', 'province' => 'JAWA BARAT'],
            ['name' => 'PASURUAN', 'province' => 'JAWA TIMUR'],
            ['name' => 'SURABAYA', 'province' => 'JAWA TIMUR'],
            ['name' => 'PAYAKUMBUH', 'province' => 'SUMATERA BARAT'],
            ['name' => 'SOLO', 'province' => 'JAWA TENGAH'],
            ['name' => 'PEKALONGAN', 'province' => 'JAWA TENGAH'],
            ['name' => 'TEGAL', 'province' => 'JAWA TENGAH'],
            ['name' => 'JAKARTA', 'province' => 'DKI JAKARTA'],
            ['name' => 'BENGKONG LAUT', 'province' => 'KEP. RIAU'],
            ['name' => 'CIREBON', 'province' => 'JAWA BARAT'],
            ['name' => 'SAMARINDA', 'province' => 'KALIMANTAN TIMUR'],
            ['name' => 'PATI', 'province' => 'JAWA TENGAH'],
        ];

        foreach ($cityMappings as $mapping) {
            $province = Province::where('name', $mapping['province'])->first();

            if ($province) {
                City::updateOrCreate(
                    ['name' => $mapping['name'], 'province_id' => $province->id]
                );
            }
        }
    }
}
