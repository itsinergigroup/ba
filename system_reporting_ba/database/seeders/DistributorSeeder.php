<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Distributor;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $distributors = [
            'PT Sukses Mandiri Persada Distrindo',
            'CV Tunas Jaya Persada',
            'CV Anugerah Sukses Mandiri Distribusi',
            'PT CSW Bandung',
            'UD Nurdin Makmur',
            'CV MSS Lampung',
            'PT Mestika Sakti Medan',
            'PT MPJ Surabaya',
            'PT Yafindo Mitra Permata',
            'PT Anugerah Niaga Jaya',
            'PT Kurnia Maju Perkasa',
            'PT Funny Citra Jaya',
            'CV Taher Jaya Asta',
            'PT Laju Kerja Bersama',
            'PT Sinar Ponti Lestari',
            'CV Salsa Debar Mandiri (SADEMA)',
            'PT Haries Putra Jaya',
            'CV Retail Kosmetika Indonesia',
            'CV Sukses Mandiri',
            'UD Garuda Mas',
            'CV Kirana Berkat Cemerlang',
            'CV Lestari Bali Bersama',
            'CV Natural Beauty Indonesia',
            'CV Yielded Spirit Indonesia',
            'PT Prima Bintang Permata',
            'CV Sahabat Makmur Mandiri',
            'Toko Merona',
            'Toko Rumah Makeup',
            'Toko THR Shop',
            'Toko Yan',
            'Naga Group',
            'Boots Group',
            'Century',
            'Aeon Group',
        ];

        foreach ($distributors as $name) {
            Distributor::updateOrCreate(['name' => $name]);
        }
    }
}
