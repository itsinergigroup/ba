<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Product;

class BrandProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'AMURA' => [
                'RETINOL SERUM (15ml)' => 108000,
                'DAY CREAM (10g)' => 70000,
                'NIGHT CREAM (10g)' => 80000,
                'STAY YOUNG FACEWASH (60g)' => 60000,
                'TONER (100ml)' => 60000,
                'HYDRAGLOW PRO-AGE DAY CREAM (30g)' => 124000,
                'RICH NIGHT PRO-AGE CREAM NIGHT (30g)' => 115000,
                'ESSENTIAL GENTLE CLEANSER (110ml)' => 75000,
                'EYE-SEE PEPTIDE SERUM (10ml)' => 80000,
                'BRIGHT EHANCHING SERUM (20ml)' => 135000,
                'PRO AGE SERUM (20ml)' => 135000,
                'GOLD SERUM (20ml)' => 108000,
                'SUNSCREEN (30ml)' => 89000,
                'DARK SPOT' => 89000,
                'PUDDING MOISTURIZER FOR ANTIAGING (30 gr)' => 146000,
                'PUDDING MOISTURIZER FOR HYDRATING (30 gr)' => 146000,
                'UV DEFENSE TINTED SUNSCREEN 40 SPF (15 ml)' => 99000,
            ],
            'REGLOW' => [
                'NEW REGLOW CREAM (20 gr)' => 99000,
                'NEW REGLOW TONER (150 ml)' => 99000,
                'NEW REGLOW FACIAL WASH (90 ml)' => 85000,
                'NEW REGLOW NIGHT CREAM (20 gr)' => 95000,
                'NEW REGLOW SERUM (20 ml)' => 90000,
                'REGLOW SHEET MASK - NEW PACKAGING' => 19000,
                'REGLOW PEELING SERUM' => 89000,
                'REGLOW TONER HYDRATION' => 99000,
                'REGLOW MOISTURIZER' => 110000,
                'REGLOW FACIAL FOAM' => 99000,
                'REGLOW ACNE GEL' => 89000,
                'REGLOW SUNCREEN' => 99000,
                'REGLOW BODY LOTION 50 ml' => 45000,
                'REGLOW BODY LOTION 180 ml' => 85000,
                'REGLOW PEELING GEL 50 ml' => 90000,
                'REGLOW EYELASH & BROW SERUM' => 91600,
                'REGLOW TONE UP SUNSCREEN SPF 35' => 89000,
                'REGLOW PHYSICAL SUNSCREEN SPF 40 PA+++' => 99000,
                'REGLOW WRAPPING MASK' => 145000,
            ],
            'PURELA' => [
                'CLEANSING GEL (CG) 100ML' => 45000,
                'CLEANSING GEL (CG) 250ML' => 65000,
                'BODY LOTION (BL) 60 GR' => 50000,
                'BODY LOTION (BL) 185 GR' => 75000,
                'HAIR LOTION (HL) 60 ML' => 40000,
                'HAIR LOTION (HL) 100 ML' => 60000,
                'GOODNIGHT OIL (GO) 60 ML' => 35000,
                'SHOOTING CREAM (SC) 8 ML' => 79000,
                'CALMING CREAM (CC) 60 GR' => 79000,
                'SUNSCREEN' => 70000,
                'FACIAL WASH' => 70000,
                'COLOGNE JUMBO HAPPY SOFT' => 31000,
                'COLOGNE JUMBO PURE LOVE' => 31000,
                'COLOGNE JUMBO FUN JOY' => 31000,
                'COLOGNE JUMBO ACTIVE FRESH' => 31000,
            ],
        ];

        foreach ($data as $brandName => $products) {
            $brand = Brand::firstOrCreate(['name' => $brandName]);

            foreach ($products as $productName => $het) {
                Product::updateOrCreate(
                    [
                        'brand_id' => $brand->id,
                        'name' => $productName,
                    ],
                    [
                        'het' => $het,
                    ]
                );
            }
        }
    }
}
