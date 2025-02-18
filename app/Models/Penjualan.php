<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_penjualan',
        'tanggal_penjualan',
        'total_harga',
        'id_pelanggan',
    ];

    protected $primaryKey = 'id_penjualan';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'penjualans';

    /**
     * Relasi ke model Pelanggan (FK: id_pelanggan)
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Relasi ke model Detailpenjualan (FK: id_penjualan)
     */
    public function detailpenjualans()
    {
        return $this->hasMany(Detailpenjualan::class, 'id_penjualan', 'id_penjualan');
    }

    /**
     * Menghitung total harga dari detail penjualan
     */
    public function getTotalHargaAttribute()
    {
        return $this->detailpenjualans->isNotEmpty() ? $this->detailpenjualans->sum('subtotal') : 0;
    }
}
