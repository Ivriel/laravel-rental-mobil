<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,petugas')->only(['index']);
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
        $this->middleware('role:admin,petugas,pelanggan')->only(['showCars']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('brands.index',[
           'brands'=> Brand::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255'
        ]);

        Brand::create($validatedData);

        return redirect()->route('brands.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    public function showCars(Brand $brand) {
        $cars = $brand->cars()->get();
        return view('brands.cars',[
            'brand' => $brand,
            'cars' => $cars
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('brands.edit',[
            'brand'=>$brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|max:255'
        ];

        $validatedData = $request->validate($rules);
        Brand::where('id',$id)->update($validatedData);

        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         Brand::destroy($id);
         return redirect()->route('brands.index');
    }
}
