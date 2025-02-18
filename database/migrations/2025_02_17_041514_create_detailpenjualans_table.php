<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('detailpenjualans', function (Blueprint $table) {
            $table->integer('id_detail')->autoIncrement();
            $table->integer('id_penjualan'); // Disesuaikan dengan tipe integer pada tabel penjualans
            $table->integer('id_produk'); // Disesuaikan dengan tipe integer pada tabel produks
            $table->integer('jumlah_produk');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        
            // Menambahkan Foreign Key
            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualans')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detailpenjualans', function (Blueprint $table) {
            // Hapus foreign key sebelum drop table
            $table->dropForeign(['id_penjualan']);
            $table->dropForeign(['id_produk']);
        });

        Schema::dropIfExists('detailpenjualans');
    }
};
