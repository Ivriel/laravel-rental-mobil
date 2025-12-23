<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::create([
        'name' => 'Administrator',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'no_telp' => '08123456789'
    ]);

    User::create([
        'name' => 'Petugas Lapangan',
        'email' => 'petugas@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'petugas',
        'no_telp' => '08122223333'
    ]);
    }
}
