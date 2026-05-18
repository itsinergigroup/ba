<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateOutletAreaDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Intan Kosmetik', 'area' => 'Medan'],
            ['name' => 'Kita Cosmetic', 'area' => 'Pontianak'],
            ['name' => 'Aeon Bxc', 'area' => 'Jakarta'],
            ['name' => 'Toko Tegal', 'area' => 'Pekalongan'],
            ['name' => 'Toko Mekar', 'area' => 'Pekalongan'],
            ['name' => 'Gado-Gado Kosmetik', 'area' => 'Palembang'],
            ['name' => 'Beauty Cosmetic', 'area' => 'Batam'],
            ['name' => 'Aeon Sentul', 'area' => 'Bogor'],
            ['name' => 'Abigail', 'area' => 'Sintang'],
            ['name' => 'Rumah Makeup Poris 1', 'area' => 'Tangerang'],
            ['name' => 'Rumah Makeup Poris 2', 'area' => 'Tangerang'],
            ['name' => 'Rumah Makeup Poris 3', 'area' => 'Tangerang'],
            ['name' => 'Mecca Beauty Store', 'area' => 'Pamekasan'],
            ['name' => 'Lancar Baby', 'area' => 'Surabaya'],
            ['name' => 'Kumara Store', 'area' => 'Solo'],
            ['name' => 'Berlian Indah', 'area' => 'Samarinda'],
            ['name' => 'Aeon Tanjung Barat', 'area' => 'Jakarta'],
            ['name' => 'Lotte Avenue', 'area' => 'Jakarta'],
            ['name' => 'Nia Collection', 'area' => 'Blitar'],
            ['name' => 'Kamala Jawi', 'area' => 'Pontianak'],
            ['name' => 'Amora', 'area' => 'Pontianak'],
            ['name' => 'Mirza Beauty', 'area' => 'Pasuruan'],
            ['name' => 'Nadya Beauty', 'area' => 'Pasuruan'],
            ['name' => 'Mahmud', 'area' => 'Bandung'],
            ['name' => 'Kamala', 'area' => 'Pontianak'],
            ['name' => 'Radysa Cosmetic', 'area' => 'Medan'],
            ['name' => 'Istana Cosmetic', 'area' => 'Payakumbuh'],
            ['name' => 'Naga Pondok Gede', 'area' => 'Bekasi'],
            ['name' => 'Naga Hankam', 'area' => 'Bekasi'],
            ['name' => 'Naga Jatiwaringin', 'area' => 'Bekasi'],
            ['name' => 'Ra Shop', 'area' => 'Lampung'],
            ['name' => 'Nada Kosmetik', 'area' => 'Lampung'],
            ['name' => 'Jogya Riau Junction', 'area' => 'Bandung'],
            ['name' => 'Borma Cikutra', 'area' => 'Bandung'],
            ['name' => 'Borma Cipadung', 'area' => 'Bandung'],
            ['name' => 'Prama Banjaran', 'area' => 'Bandung'],
            ['name' => 'Prama Babakan Sari', 'area' => 'Bandung'],
            ['name' => 'Miyu Cosmetik', 'area' => 'Surabaya'],
            ['name' => 'Aeon Pakuwon', 'area' => 'Surabaya'],
            ['name' => 'Kim Kosmetik', 'area' => 'Binjai'],
            ['name' => 'Toko Daun Indah', 'area' => 'Cirebon'],
            ['name' => 'Eka Kosmetik', 'area' => 'Cirebon'],
            ['name' => 'Jasa Mekar', 'area' => 'Bandung'],
            ['name' => 'Jogja Kepatihan', 'area' => 'Bandung'],
            ['name' => 'Lares Store', 'area' => 'Semarang'],
            ['name' => 'Naga Kahfi', 'area' => 'Jakarta'],
            ['name' => 'Naga Tb. Simatupang', 'area' => 'Jakarta'],
            ['name' => 'Toko Oenta Cosmetic Tenggarong', 'area' => 'Tenggarong'],
            ['name' => 'Alana', 'area' => 'Pekanbaru'],
            ['name' => 'Rini Jova', 'area' => 'Pekanbaru'],
            ['name' => 'Jessica Beauty Corner', 'area' => 'Indramayu'],
            ['name' => 'Top Mode', 'area' => 'Makasar'],
            ['name' => 'Naga Pekayon', 'area' => 'Bekasi'],
            ['name' => 'Svj Cosmetic', 'area' => 'Tanjungpinang'],
            ['name' => 'Dd Cosmetic', 'area' => 'Tanjungpinang'],
            ['name' => 'Jm Kosmetik', 'area' => 'Palembang'],
            ['name' => 'Saga Beauty Pusat', 'area' => 'Sorong'],
            ['name' => 'Tiara Beauty', 'area' => 'Sorong'],
            ['name' => 'Saga Aimas', 'area' => 'Sorong'],
            ['name' => 'Top Mode 100', 'area' => 'Batam'],
            ['name' => 'Laris Kartasura', 'area' => 'Sukoharjo'],
            ['name' => 'Luwes Gentan', 'area' => 'Pati'],
            ['name' => 'Luwes Kestalan', 'area' => 'Pati'],
            ['name' => 'Borma Gempol', 'area' => 'Bandung'],
            ['name' => 'Borma Kerkof', 'area' => 'Bandung'],
            ['name' => 'Djasa Mekar', 'area' => 'Bandung'],
            ['name' => 'Prama Cijerah', 'area' => 'Bandung'],
            ['name' => 'Citra 3 Boulevard', 'area' => 'Makasar'],
            ['name' => 'Moni Cosmetic', 'area' => 'Tanjungpinang'],
            ['name' => 'Fame Store', 'area' => 'Ambon'],
            ['name' => 'Belly Beauty', 'area' => 'Ambon'],
            ['name' => "B'Uniq", 'area' => 'Kupang'],
            ['name' => 'Livi Beauty House', 'area' => 'Banjarmasin'],
        ];

        foreach ($data as $item) {
            $area = \App\Models\Area::where('name', $item['area'])->first();
            if ($area) {
                \App\Models\Outlet::where('name', $item['name'])->update([
                    'area_id' => $area->id
                ]);
            }
        }
    }
}
