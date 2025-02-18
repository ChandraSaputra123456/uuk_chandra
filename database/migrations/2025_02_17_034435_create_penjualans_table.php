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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->integer('id_penjualan')->autoIncrement(); // Auto-increment sudah otomatis primary key
            $table->date('tanggal_penjualan');
            $table->decimal('total_harga', 10, 2);
            $table->unsignedInteger('id_pelanggan'); // Unsigned integer untuk foreign key

            // Foreign key
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->dropForeign(['id_pelanggan']);
        });

        Schema::dropIfExists('penjualans');
    }
};
