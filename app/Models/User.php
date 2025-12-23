<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

//     User ke Rental (One-to-Many)
// Logika: 1 Orang (User) bisa melakukan banyak kali (Many) penyewaan mobil di waktu yang berbeda. Tapi 1 data transaksi (Rental) hanya boleh dimiliki oleh 1 orang.

// Sintaks Laravel: * Di Model User: hasMany (mempunyai banyak).

// Di Model Rental: belongsTo (milik dari).

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',     // Untuk membedakan Admin, Petugas, Pelanggan
        'no_telp',  // Sesuai requirement soal
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
