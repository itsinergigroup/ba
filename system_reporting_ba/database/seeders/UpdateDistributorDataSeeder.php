<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateDistributorDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'CV ANUGERAH SUKSES MANDIRI DISTRIBUSI', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT ANUGERAH NIAGA JAYA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV MITRA SEHATI SEJATI', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT CAHAYA SEJAHTERA WALUYA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT MITRA PHARMASI JAYA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT MESTIKA SAKTI', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV TUNAS JAYA PERSADA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT KURNIA MAJU PERKASA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT YAFINDO MITRA PERMATA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT FUNNY CITRA JAYA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT SUKSES MAKMUR PERSADA DISTRINDO', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV TAHER JAYA ASTA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT SINAR PONTI LESTARI', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV SALSA DEBAR MANDIRI (SADEMA)', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV BORNEO RETAIL KOSMETIKA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV KIRANA BERKАТ СЕМERLANG', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV SUKSES MANDIRI', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT HARIES PUTRA JAYA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT LAJU KERJA BERSAMA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'UD (NURIN MAKMUR)', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'UD GARUDA MAS', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV LESTARI BALI BERSAMA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV NATURAL BEAUTY INDONESIA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV SAHABAT MAKMUR ABADI', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV YIELDED SPIRIT INDONESIA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT PRIMA BINTANG PERMATA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT CIPTA ANUGERAH REZEKI', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT MAJU TAMA KARYA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV SAGARA TIMUR GROUP CAB.NTT', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV KARUNIA ABADI', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV SINAR MITRA UTAMA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV ABBAS JAYA BULUKUMBA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV GLORY ANUGRAH SEJAHTERA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV SAGARA TIMUR GROUP CAB.NTB', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT WAN SETIA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT SINAR MITRA ANDALAN', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'PT ANUGERAH BINA USAHA NUSANTARA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV PUTRA PANGGIL JAYA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'CV ALLEGRA NUSANTARA', 'channel' => 'Indirect', 'account_type' => 'GT'],
            ['name' => 'RUMAH MAKEUP', 'channel' => 'Direct', 'account_type' => 'GT'],
            ['name' => 'THR', 'channel' => 'Direct', 'account_type' => 'GT'],
            ['name' => 'KIOS MART', 'channel' => 'Direct', 'account_type' => 'GT'],
            ['name' => 'MERONA', 'channel' => 'Direct', 'account_type' => 'GT'],
            ['name' => 'AEON', 'channel' => 'Direct', 'account_type' => 'MT'],
            ['name' => 'BOOTS', 'channel' => 'Direct', 'account_type' => 'MT'],
            ['name' => 'NAGA', 'channel' => 'Direct', 'account_type' => 'MT'],
            ['name' => 'CENTURY', 'channel' => 'Direct', 'account_type' => 'MT'],
            ['name' => 'TOKO YAN', 'channel' => 'Direct', 'account_type' => 'MT'],
        ];

        foreach ($data as $row) {
            // Kita gunakan firstOrCreate atau update untuk memastikan data masuk/terupdate
            $distributor = \App\Models\Distributor::where('name', $row['name'])->first();
            if ($distributor) {
                $distributor->update([
                    'channel' => ucfirst($row['channel']),
                    'account_type' => $row['account_type']
                ]);
            } else {
                \App\Models\Distributor::create([
                    'name' => $row['name'],
                    'channel' => ucfirst($row['channel']),
                    'account_type' => $row['account_type']
                ]);
            }
        }
    }
}
