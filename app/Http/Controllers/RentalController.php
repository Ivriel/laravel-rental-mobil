<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if($user->role === 'pelanggan') {
            // pelanggan cuma lihat punya dia sendiri
            $rentals = Rental::with(['car','user'])
            ->where('user_id',$user->id)
            ->latest()
            ->get();
        } else if ($user->role === 'petugas'){
            // petugas melihat semua data
            $rentals = Rental::with(['car','user'])->latest()->get();
        }

        return view('rentals.index',compact('rentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $selectedCar = Car::findOrFail($request->car_id);
        return view('rentals.create', compact('selectedCar'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // 1. Validasi Input (Hanya cek keberadaan data dan formatnya)
        $request->validate([
            'car_id'               => 'required|exists:cars,id',
            'tanggal_sewa'         => 'required|date|after_or_equal:today',
            'tanggal_dikembalikan' => 'required|date|after_or_equal:tanggal_sewa',
        ]);

        // 2. Ambil data mobil dari database dengan id yang dioper dari function create (Cek harga aslinya)
        $car = Car::findOrFail($request->car_id);

        // 3. HITUNG ULANG DI SERVER (LOGIKA KEAMANAN)
        $start = Carbon::parse($request->tanggal_sewa);
        $end   = Carbon::parse($request->tanggal_dikembalikan);
        
        // Selisih hari + 1 (Inklusif)
        $lamaSewaAsli = $start->diffInDays($end) + 1;
        
        // Total bayar berdasarkan harga asli di database dikali durasi asli
        $totalBayarAsli = $lamaSewaAsli * $car->harga_per_hari;

        // 4. Simpan ke Database (Gunakan hasil hitungan server, bukan dari Form)
        Rental::create([
            'user_id'          => auth()->id(),
            'car_id'           => $car->id,
            'tanggal_sewa'     => $request->tanggal_sewa,
            'tanggal_dikembalikan'  => $request->tanggal_dikembalikan,
            'lama_sewa'        => $lamaSewaAsli,    // <--- Hasil hitung server
            'total_bayar'      => $totalBayarAsli, // <--- Hasil hitung server
            'status_transaksi' => 'booking',
        ]);

        // 5. Update status mobil agar tidak disewa orang lain
        $car->update(['status' => 'disewa']);

        // 6. Redirect
        return redirect()->route('rentals.index')->with('success', 'Booking berhasil! Total: Rp ' . number_format($totalBayarAsli, 0, ',', '.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        $rental->load(['car.brand','user']);

        if(auth()->user()->role === 'pelanggan' && $rental->user_id !== auth()->id()) {
            abort(403, 'Anda tidak diizinkan melihat detail rental orang lain.');
        }

        return view('rentals.show', compact('rental'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
