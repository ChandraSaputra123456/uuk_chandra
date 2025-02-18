<?php

namespace App\Http\Controllers;

use App\Models\Detailpenjualan;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DetailpenjualanController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        $detailpenjualans = Detailpenjualan::join('penjualans', 'detailpenjualans.id_penjualan', '=', 'penjualans.id_penjualan')
            ->join('pelanggans', 'penjualans.id_pelanggan', '=', 'pelanggans.id_pelanggan')
            ->select('detailpenjualans.*', 
                    DB::raw("LPAD(detailpenjualans.id_penjualan, 2, '0') as id_penjualan"), 
                    DB::raw("LPAD(detailpenjualans.id_produk, 3, '0') as id_produk"),
                    'penjualans.id_pelanggan', 'pelanggans.nama_pelanggan')
            ->orderBy('id_detail', 'asc')
            ->paginate(5);
        
        // Get the latest id_detail from the database, and increment it
        $latestDetail = Detailpenjualan::latest()->first();
        $nextIdDetail = $latestDetail ? str_pad($latestDetail->id_detail + 1, 4, '0', STR_PAD_LEFT) : '0001'; // Format to 4 digits



        $produks = Produk::all();

        return view('detailpenjualans.index', compact('nextIdDetail', 'detailpenjualans', 'produks'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        $latestDetail = DetailPenjualan::latest()->first();
        $nextIdDetail = $latestDetail ? str_pad($latestDetail->id_detail + 1, 4, '0', STR_PAD_LEFT) : '01';
    
        $penjualans = Penjualan::with('pelanggan')->get();
         // Mengambil data penjualan dan produk
        $produks = Produk::all()->map(function ($produk) {
            $produk->id_produk = str_pad($produk->id_produk, 3, '0', STR_PAD_LEFT);
            return $produk;
        });
        
        return view('detailpenjualans.create', compact('penjualans', 'produks', 'nextIdDetail'));
    }

    /**
     * store
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Get the last id_detail to generate the next one
        $latestDetail = Detailpenjualan::latest()->first();
        $nextIdDetail = $latestDetail ? str_pad($latestDetail->id_detail + 1, 4, '0', STR_PAD_LEFT) : '0001';
        $this->validate($request, [
            'id_penjualan' => 'required|exists:penjualans,id_penjualan',
            'id_produk' => 'required|array|min:1',
            'id_produk.*' => 'required|exists:produks,id_produk',
            'jumlah_produk' => 'required|array|min:1',
            'jumlah_produk.*' => 'required|integer|min:1',
        ]);

        $id_penjualan = $request->id_penjualan;
        $id_produk = $request->id_produk;
        $jumlah_produk = $request->jumlah_produk;

        // Jika tabel kosong, reset auto-increment ke 1
        if (Detailpenjualan::count() == 0) {
            DB::statement('ALTER TABLE detailpenjualans AUTO_INCREMENT = 0001');
        }

        // Proses penyimpanan data detail penjualan
        foreach ($id_produk as $index => $produk) {
            $hargaProduk = Produk::where('id_produk', $produk)->value('harga');
            if (!$hargaProduk) {
                continue;
            }

            $subtotal = $hargaProduk * $jumlah_produk[$index];

            Detailpenjualan::create([
                'id_detail' => str_pad(Detailpenjualan::max('id_detail') + 1, 4, '0', STR_PAD_LEFT),
                'id_penjualan' => $id_penjualan,
                'id_produk' => $produk,
                'jumlah_produk' => $jumlah_produk[$index],
                'subtotal' => $subtotal,
            ]);
        }

        return redirect()->route('detailpenjualans.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * show
     *
     * @param  int $id_detail
     * @return View
     */
    public function show(int $id_detail): View
    {
        $detailpenjualan = Detailpenjualan::with(['produk', 'penjualan.pelanggan'])->findOrFail($id_detail);

        return view('detailpenjualans.show', compact('detailpenjualan'));
    }

    /**
     * edit
     *
     * @param  int $id_detail
     * @return View
     */
    public function edit(int $id_detail): View
    {
        $detailpenjualan = Detailpenjualan::with(['produk', 'penjualan.pelanggan'])->findOrFail($id_detail);
        $penjualans = Penjualan::with('pelanggan')->get();
        $produks = Produk::all();

        // Pastikan id_detail diformat menjadi 4 digit
    $formattedIdDetail = str_pad($detailpenjualan->id_detail, 4, '0', STR_PAD_LEFT);

        return view('detailpenjualans.edit', compact('detailpenjualan', 'penjualans', 'produks', 'formattedIdDetail'));
    }

    /**
     * update
     *
     * @param  Request $request
     * @param  int $id_detail
     * @return RedirectResponse
     */
    public function update(Request $request, int $id_detail): RedirectResponse
    {
        $this->validate($request, [
            'id_penjualan' => 'required|exists:penjualans,id_penjualan',
            'id_produk' => 'required|array|min:1',
            'id_produk.*' => 'required|exists:produks,id_produk',
            'jumlah_produk' => 'required|array|min:1',
            'jumlah_produk.*' => 'required|integer|min:1',
        ]);

        // Hapus semua detail penjualan terkait dengan id_detail yang diberikan
        DetailPenjualan::where('id_detail', $id_detail)->delete();

        $id_penjualan = $request->id_penjualan;
        $id_produk = $request->id_produk;
        $jumlah_produk = $request->jumlah_produk;

        // Proses penyimpanan data detail penjualan setelah update
        foreach ($id_produk as $index => $produk) {
            $hargaProduk = Produk::where('id_produk', $produk)->value('harga');
            if (!$hargaProduk) {
                continue;
            }

            $subtotal = $hargaProduk * $jumlah_produk[$index];

            // id_detail otomatis ditangani oleh Laravel karena auto-increment
            DetailPenjualan::create([
                'id_penjualan' => $id_penjualan,
                'id_produk' => $produk,
                'jumlah_produk' => $jumlah_produk[$index],
                'subtotal' => $subtotal,
            ]);
        }

        return redirect()->route('detailpenjualans.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     *
     * @param  int $id_detail
     * @return RedirectResponse
     */
    public function destroy(int $id_detail): RedirectResponse
    {
        $detailpenjualan = Detailpenjualan::findOrFail($id_detail);
        $detailpenjualan->delete();

        // Hapus detail penjualan berdasarkan ID
        Detailpenjualan::where('id_detail', $id_detail)->delete();

        // Jika tabel kosong, reset auto-increment ke 1
        if (Detailpenjualan::count() == 0) {
            DB::statement('ALTER TABLE detailpenjualans AUTO_INCREMENT = 1');
        }


        return redirect()->route('detailpenjualans.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
