<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cars.index',[
            "cars" => Car::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cars.create',[
            "brands" => Brand::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validatedRequest = $request->validate([
        'nama' => 'required|string|max:255',
        'nopol' => 'required|string|max:20|unique:cars', // Tambahkan unique agar nopol tidak kembar
        'brand_id' => 'required|exists:brands,id',
        'tahun' => 'required|integer|min:1900|max:' . date('Y'),
        'warna' => 'required|string|max:50',
        'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', 
        'kapasitas_penumpang' => 'required|integer|min:1',
        'harga_per_hari'=> 'required|integer|min:0', // Pakai integer agar pas dengan DB
        'status' => 'required|in:tersedia,disewa' // Pakai 'in' agar sesuai enum di DB
    ]);

    // 1. Logika untuk Upload Gambar
    if ($request->hasFile('gambar')) {
        // Simpan ke storage/app/public/cars
        $path = $request->file('gambar')->store('cars', 'public');
        // Masukkan path file ke array data yang akan disimpan
        $validatedRequest['gambar'] = $path;
    }

    // 2. Simpan ke Database
    Car::create($validatedRequest);

    return redirect()->route('cars.index');
}
    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return view('cars.show',[
            'car'=> $car,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('cars.edit',[
            'car' => $car,
            'brands' => Brand::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validatedRequest = $request->validate([
            'nama' => 'required|string|max:255',
            'nopol' => 'required|string|max:20|unique:cars,nopol,' . $car->id, // unique kecuali untuk car dengan id ini
            'brand_id' => 'required|exists:brands,id',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
            'warna' => 'required|string|max:50',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',  // nullable = opsional
            'kapasitas_penumpang' => 'required|integer|min:1',
            'harga_per_hari'=> 'required|integer|min:0',
            'status' => 'required|in:tersedia,disewa'
        ]);

        // 2. Handle upload gambar baru (jika ada)
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($car->gambar && Storage::disk('public')->exists($car->gambar)) {
                Storage::disk('public')->delete($car->gambar);
            }
            
            // Store new image
            $path = $request->file('gambar')->store('cars', 'public');
            $validatedRequest['gambar'] = $path;
        }

        // Update the car
        $car->update($validatedRequest);

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Car::destroy($id);
        return redirect()->route('cars.index');
    }
}
