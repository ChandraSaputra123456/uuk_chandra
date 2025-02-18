<?php 

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Detailpenjualan;
use App\Models\Penjualan;  // Mengimpor model Penjualan
use App\Models\Produk;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function generatePDF()
    {
        $detailpenjualans = Detailpenjualan::all();
        $produks = Produk::all();  // Mengambil semua produk

        $data = [
            'detailpenjualans' => $detailpenjualans,
            'produks' => $produks,  // Masukkan produk ke dalam data
            'title' => 'Laporan Detail Penjualan',
            'date' => date('d-m-Y')
        ];

        // Generate PDF dengan data yang telah dikirim
        $pdf = Pdf::loadView('pdf.report', $data);
        return $pdf->stream('laporan.pdf');
    }

    public function generateSecondPDF()
    {
        // Mengambil data penjualan
        $penjualans = Penjualan::all();  // Pastikan model Penjualan diimpor

        $data = [
            'penjualans' => $penjualans,
            'title' => 'Laporan Penjualan',
            'date' => date('d-m-Y')
        ];

        $pdf = Pdf::loadView('pdf.second_report', $data);
        return $pdf->stream('laporan_penjualan.pdf');
    }
}
