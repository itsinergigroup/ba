<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['Area' => 'Medan', 'Region' => 'SUMUT-ACEH-SULBAR'],
            ['Area' => 'Pontianak', 'Region' => 'KALBAR-KALTENG-KALSEL'],
            ['Area' => 'Jakarta', 'Region' => 'NKAM'],
            ['Area' => 'Pekalongan', 'Region' => 'JATENG-DIY'],
            ['Area' => 'Palembang', 'Region' => 'LAMPUNG-SUMSEL-BABEL-BENGKULU'],
            ['Area' => 'Batam', 'Region' => 'KEPRI-RIAU-JAMBI'],
            ['Area' => 'Bogor', 'Region' => 'NKAM'],
            ['Area' => 'Sintang', 'Region' => 'KALBAR-KALTENG-KALSEL'],
            ['Area' => 'Tangerang', 'Region' => 'JABODETEBAK'],
            ['Area' => 'Pamekasan', 'Region' => 'JATIM-BALINUS'],
            ['Area' => 'Surabaya', 'Region' => 'JATIM-BALINUS'],
            ['Area' => 'Solo', 'Region' => 'JATENG-DIY'],
            ['Area' => 'Samarinda', 'Region' => 'KALTIM-KALTARA'],
            ['Area' => 'Blitar', 'Region' => 'JATIM-BALINUS'],
            ['Area' => 'Pasuruan', 'Region' => 'JATIM-BALINUS'],
            ['Area' => 'Bandung', 'Region' => 'JABAR - CIREBON'],
            ['Area' => 'Payakumbuh', 'Region' => 'SUMUT-ACEH-SULBAR'],
            ['Area' => 'Bekasi', 'Region' => 'NKAM'],
            ['Area' => 'Lampung', 'Region' => 'LAMPUNG-SUMSEL-BABEL-BENGKULU'],
            ['Area' => 'Binjai', 'Region' => 'SUMUT-ACEH-SULBAR'],
            ['Area' => 'Cirebon', 'Region' => 'JABAR - CIREBON'],
            ['Area' => 'Semarang', 'Region' => 'JATIM-BALINUS'],
            ['Area' => 'Tenggarong', 'Region' => 'KALTIM-KALTARA'],
            ['Area' => 'Pekanbaru', 'Region' => 'KEPRI-RIAU-JAMBI'],
            ['Area' => 'Indramayu', 'Region' => 'JABAR - CIREBON'],
            ['Area' => 'Makasar', 'Region' => 'SULSEL-SULBAR-SULTRA-SULTENG-MALUKU-PAPUA'],
            ['Area' => 'Tanjungpinang', 'Region' => 'KEPRI-RIAU-JAMBI'],
            ['Area' => 'Sorong', 'Region' => 'SULSEL-SULBAR-SULTRA-SULTENG-MALUKU-PAPUA'],
            ['Area' => 'Sukoharjo', 'Region' => 'JATENG-DIY'],
            ['Area' => 'Pati', 'Region' => 'JATIM-BALINUS'],
            ['Area' => 'Ambon', 'Region' => 'SULSEL-SULBAR-SULTRA-SULTENG-MALUKU-PAPUA'],
            ['Area' => 'Kupang', 'Region' => 'JATIM-BALINUS'],
            ['Area' => 'Banjarmasin', 'Region' => 'KALBAR-KALTENG-KALSEL'],
        ];

        foreach ($data as $item) {
            \App\Models\Region::firstOrCreate(['name' => $item['Region']]);
            $region = \App\Models\Region::where('name', $item['Region'])->first();
            \App\Models\Area::firstOrCreate([
                'name' => $item['Area'],
                'region_id' => $region->id
            ]);
        }
    }
}
