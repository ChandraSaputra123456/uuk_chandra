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
        Schema::create('produks', function (Blueprint $table) {
            $table->integer('id_produk')->autoIncrement(); // Konsisten dengan id_pelanggan dan id_penjualan
            $table->string('nama_produk'); // Nama produk dibatasi 100 karakter
            $table->decimal('harga', 10, 2);
            $table->integer('stok'); // Menggunakan integer biasa, tidak unsigned

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
