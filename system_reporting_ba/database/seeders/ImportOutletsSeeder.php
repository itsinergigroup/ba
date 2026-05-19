<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Outlet;
use App\Models\City;

class ImportOutletsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlets = [
            "Intan Kosmetik", "Kita Cosmetic", "Aeon Bxc", "Toko Tegal", "Toko Mekar",
            "Gado-Gado Kosmetik", "Beauty Cosmetic", "Aeon Sentul", "Abigail", "Rumah Makeup Poris 1",
            "Rumah Makeup Poris 2", "Rumah Makeup Poris  3", "Mecca Beauty Store", "Lancar Baby", "Kumara Store",
            "Berlian Indah", "Aeon Tanjung Barat", "Lotte Avenue", "Nia Collection", "Kamala Jawi",
            "Amora", "Mirza Beauty", "Nadya Beauty", "Mahmud", "Kamala",
            "Radysa Cosmetic", "Istana Cosmetic", "Naga Pondok Gede", "Naga Hankam", "Naga Jatiwaringin",
            "Ra Shop", "Nada Kosmetik", "Jogya Riau Junction", "Borma Cikutra", "Borma Cipadung",
            "Prama Banjaran", "Prama Babakan Sari", "Miyu Cosmetik", "Aeon Pakuwon", "Kim Kosmetik",
            "Toko Daun Indah", "Eka Kosmetik", "Jasa Mekar", "Jogja Kepatihan", "Lares Store",
            "Naga Kahfi", "Naga Tb. Simatupang", "Toko Oenta Cosmetic Tenggarong", "Alana", "Rini Jova",
            "Jessica Beauty Corner", "Top Mode", "Naga Pekayon", "Svj Cosmetic", "Dd Cosmetic",
            "Jm Kosmetik", "Saga Beauty Pusat", "Tiara Beauty", "Saga Aimas", "Top Mode 100",
            "Laris Kartasura", "Luwes Gentan", "Luwes Kestalan", "Borma Gempol", "Borma Kerkof",
            "Djasa Mekar", "Prama Cijerah", "Citra 3 Boulevard", "Moni Cosmetic", "Fame Store",
            "Belly Beauty", "B'Uniq", "Livi Beauty House"
        ];

        // Karena tidak ada data Kota, kita akan menempatkan semua di city pertama yang ada di DB
        $city = City::first();
        if (!$city) {
            // Jika tidak ada city, buat default
            $province = \App\Models\Province::firstOrCreate(['name' => 'Default Province']);
            $city = City::create(['name' => 'Default City', 'province_id' => $province->id]);
        }

        foreach ($outlets as $name) {
            $name = trim($name);
            if (!empty($name)) {
                Outlet::updateOrCreate(
                    ['name' => $name],
                    ['city_id' => $city->id]
                );
            }
        }
    }
}
