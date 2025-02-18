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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->integer('id_pelanggan')->autoIncrement()->unsigned(); // autoIncrement sudah membuat primary key secara otomatis
            $table->string('nama_pelanggan');
            $table->text('alamat');
            $table->string('nomor_telepon', 15);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
