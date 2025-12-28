<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user= auth()->user();

        if($user->role === 'admin'){
            return $this->adminDashboard();
        } elseif($user->role === 'petugas') {
            return $this->petugasDashboard();
        } else {
            return $this->pelangganDashboard();
        }
    }

    // 'booking', 'diambil', 'kembali', 'selesai'

    private function adminDashboard()
    {
        $data = [
            'totalCars' => Car::count(),
            'totalUsers' => User::where('role','pelanggan')->count(),
            'totalRentals' => Rental::count(),
            'totalActiveRentals' => Rental::where('status_transaksi','diambil')->count(),
            'totalPendingRentals' => Rental::where('status_transaksi','booking')->count(),
            'totalReturnedRentals' => Rental::where('status_transaksi','kembali')->count(),
            'availableCars' => Car::where('status','tersedia')->count(),
            'recentRentals' => Rental::with(['car','user'])->latest()->take(5)->get(),
         'totalRevenue' => Rental::sum('total_bayar'),
        ];
        
        return view('dashboard', $data);
    }

    private function petugasDashboard()
    {
        $data = [
            'totalCars' => Car::count(),
            'availableCars' => Car::where('status','tersedia')->count(),
            'rentedCars' => Car::where('status','disewa')->count(),
            'pendingRentals' => Rental::where('status_transaksi','diambil')->count(),
            'activeRentals' => Rental::where('status_transaksi','diambil')->count(),
            'recentRentals' => Rental::with(['car','user'])->latest()->take(5)->get(),
            'todayRentals' => Rental::whereDate('tanggal_sewa',today())->count()
        ];

        return view('dashboard',$data);
    }

    private function pelangganDashboard()
    {
        $userId = auth()->id();

        $data = [
            'myRentals' => Rental::where('user_id',$userId)->count(),
            'activeRentals' => Rental::where('user_id',$userId)->whereIn('status_transaksi',['booking','diambil'])->count(),
            'completedRentals' => Rental::where('user_id',$userId)->where('status_transaksi','selesai')->count(),
            'totalSpent' => Rental::where('user_id',$userId)->sum('total_bayar'),
            'recentRentals' => Rental::with(['car'])
            ->where('user_id',$userId)
            ->latest()
            ->take(3)
            ->get(),
            'availableCars' => Car::where('status','tersedia')->count()
        ];
             return view('dashboard',$data);
    }
}
