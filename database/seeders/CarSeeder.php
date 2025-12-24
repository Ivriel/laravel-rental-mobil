<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data contoh mobil sesuai struktur jadual anda
        $cars = [
            [
                'nama' => 'Avanza Veloz',
                'brand_id' => 1, // Toyota (sesuai id di jadual brands)
                'nopol' => 'B 1234 ABC',
                'tahun' => '2022',
                'warna' => 'Hitam',
                'kapasitas_penumpang' => 7,
                'harga_per_hari' => 350000,
                'status' => 'tersedia',
                'gambar' => null, // Boleh diisi nama fail gambar nanti
            ],
            [
                'nama' => 'Civic Turbo',
                'brand_id' => 2, // Honda
                'nopol' => 'D 9999 XYZ',
                'tahun' => '2023',
                'warna' => 'Putih',
                'kapasitas_penumpang' => 5,
                'harga_per_hari' => 800000,
                'status' => 'tersedia',
                'gambar' => null,
            ],
            [
                'nama' => 'Xenia',
                'brand_id' => 3, // Daihatsu
                'nopol' => 'B 4567 DEF',
                'tahun' => '2021',
                'warna' => 'Silver',
                'kapasitas_penumpang' => 7,
                'harga_per_hari' => 300000,
                'status' => 'tersedia',
                'gambar' => null,
            ],
            [
                'nama' => 'Xpander Cross',
                'brand_id' => 4, // Mitsubishi
                'nopol' => 'L 1122 MNO',
                'tahun' => '2022',
                'warna' => 'Abu-abu',
                'kapasitas_penumpang' => 7,
                'harga_per_hari' => 450000,
                'status' => 'tersedia',
                'gambar' => null,
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
