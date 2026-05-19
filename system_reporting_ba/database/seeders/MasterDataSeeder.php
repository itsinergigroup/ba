<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Districts / Locations
        $jawaBarat = \App\Models\Province::create(['name' => 'Jawa Barat']);
        $dkiJakarta = \App\Models\Province::create(['name' => 'DKI Jakarta']);

        $bandung = \App\Models\City::create(['province_id' => $jawaBarat->id, 'name' => 'Bandung']);
        $jakartaSelatan = \App\Models\City::create(['province_id' => $dkiJakarta->id, 'name' => 'Jakarta Selatan']);

        // 2. Distributors
        $distributorA = \App\Models\Distributor::create(['name' => 'Distributor SRN Bandung', 'address' => 'Jl. Soekarno Hatta No. 123']);
        $distributorB = \App\Models\Distributor::create(['name' => 'Distributor SRN Jakarta', 'address' => 'Jl. Gatot Subroto No. 45']);

        // 3. Brands & Products
        $brandA = \App\Models\Brand::create(['name' => 'Loreal']);
        $brandB = \App\Models\Brand::create(['name' => 'Maybelline']);

        \App\Models\Product::create(['brand_id' => $brandA->id, 'name' => 'Loreal Revitalift Serum', 'het' => 250000]);
        \App\Models\Product::create(['brand_id' => $brandA->id, 'name' => 'Loreal Crystal Micro Essence', 'het' => 180000]);
        \App\Models\Product::create(['brand_id' => $brandB->id, 'name' => 'Maybelline Superstay Matte', 'het' => 125000]);
        \App\Models\Product::create(['brand_id' => $brandB->id, 'name' => 'Maybelline Fit Me Foundation', 'het' => 155000]);

        // 4. Outlets
        \App\Models\Outlet::create(['name' => 'Guardian TSM', 'city_id' => $bandung->id, 'address' => 'Trans Studio Mall Lt. 1']);
        \App\Models\Outlet::create(['name' => 'Watson Senayan City', 'city_id' => $jakartaSelatan->id, 'address' => 'Senayan City Mall Lt. LG']);

        // 5. Users (Admin & BA)
        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@srn.com',
            'password' => \Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Sinta BA',
            'email' => 'sinta@distributor.com',
            'password' => \Hash::make('password'),
            'role' => 'ba',
            'distributor_id' => $distributorA->id,
        ]);
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => \Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'BA User',
            'email' => 'ba@gmail.com',
            'password' => \Hash::make('password'),
            'role' => 'ba',
            'distributor_id' => $distributorA->id,
        ]);
    }
}
