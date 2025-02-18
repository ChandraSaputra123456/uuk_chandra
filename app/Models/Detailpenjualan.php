<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailpenjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_detail',
        'id_penjualan',
        'id_produk',
        'jumlah_produk',
        'subtotal',
    ];

    protected $primaryKey = 'id_detail';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'detailpenjualans'; // Pastikan nama tabel benar

    /**
     * Relasi ke model Penjualan (FK: id_penjualan)
     */
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }

    /**
     * Relasi ke model Produk (FK: id_produk)
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
