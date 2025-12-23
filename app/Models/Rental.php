<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{

//     Car ke Rental (One-to-Many)
// Logika: 1 Mobil (Car) bisa disewa banyak kali (Many) (misal: hari ini disewa si A, besok disewa si B). Tapi 1 data transaksi (Rental) spesifik hanya mencatat 1 mobil yang keluar.

// Sintaks Laravel:

// Di Model Car: hasMany (mempunyai banyak).

// Di Model Rental: belongsTo (milik dari).
    protected $fillable = [
        'user_id',
        'car_id',
        'tanggal_sewa',
        'tanggal_dikembalikan',
        'lama_sewa',
        'total_bayar',
        'status_transaksi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
