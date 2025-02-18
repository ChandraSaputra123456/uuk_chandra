<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
     /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'id_pelanggan',
        'nama_pelanggan',
        'alamat',
        'nomor_telepon',
        
    ];

    protected $primaryKey = 'id_pelanggan';
    public $incrementing = true; // Sesuai dengan auto-increment pada migrasi
    protected $keyType = 'int'; // id_pelanggan sekarang adalah integer
    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'pelanggans'; // Nama tabel di database
}
