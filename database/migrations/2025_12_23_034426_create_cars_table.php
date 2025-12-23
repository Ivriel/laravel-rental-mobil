<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id(); // Atribut 1
            $table->string('nama'); // Atribut 2
            $table->string('nopol')->unique(); // Atribut 3 (Bagus, sudah unik)
           $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->year('tahun'); // Atribut 5
            $table->string('warna'); // Atribut 6
            $table->integer('kapasitas_penumpang'); // Atribut 7 (Gunakan integer, bukan int)
            $table->integer('harga_per_hari'); // Atribut 8 (Gunakan integer, bukan int)
            $table->string('status')->default('tersedia'); // Atribut 9
            $table->string('gambar')->nullable(); // Atribut 10 (Saran: Tambahkan untuk upload foto mobil)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
