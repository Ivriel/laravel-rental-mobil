<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Toyota'],
            ['name' => 'Honda'],
            ['name' => 'Daihatsu'],
            ['name' => 'Mitsubishi'],
            ['name' => 'Suzuki'],
            ['name' => 'Nissan'],
            ['name' => 'Wuling'],
            ['name' => 'Hyundai'],
            ['name' => 'Mazda'],
            ['name' => 'Mercedes-Benz'],
            ['name' => 'BMW'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
