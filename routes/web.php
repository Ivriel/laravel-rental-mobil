<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('brands',BrandController::class)->except('show');
    Route::resource('cars',CarController::class);
    Route::resource('rentals',RentalController::class);
    Route::resource('reports',ReportController::class)->except(['destroy','edit','update']);

       // Route untuk update status rental (hanya petugas/admin)
    Route::patch('/rentals/{rental}/status', [RentalController::class, 'updateStatus'])
        ->name('rentals.updateStatus')
        ->middleware('auth');

    Route::get('/brands/{brand}/cars',[BrandController::class, 'showCars'])->name('brands.cars');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
