<?php

namespace App\Http\Controllers;

//import Model "Post
use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\Detailpenjualan;

use Illuminate\Http\Request;

//return type View
use Illuminate\View\View;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

class PenjualanController extends Controller
{    
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        
       
        // Ambil data penjualan dengan eager loading relasi detailpenjualans dan pelanggan
        $penjualans = Penjualan::with(['pelanggan', 'detailpenjualans'])->orderBy('id_penjualan', 'asc')->paginate(5);

        // render view dengan data penjualan
        return view('penjualans.index', compact('penjualans'));
    }
   

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        // Ambil semua data pelanggan
        $pelanggans = Pelanggan::all();
        
        // Generate ID Penjualan otomatis berdasarkan urutan terakhir
        $lastPenjualan = Penjualan::orderBy('id_penjualan', 'desc')->first();
        
        // Tentukan ID penjualan berikutnya
        $nextIdPenjualan = $lastPenjualan ? sprintf('%02d', (intval(substr($lastPenjualan->id_penjualan, -2)) + 1)) : '01';
        
        return view('penjualans.create', compact('pelanggans', 'nextIdPenjualan'));
    }
 
    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'id_penjualan'=> 'required|min:1',
            'tanggal_penjualan'=> 'required|min:1',
            'total_harga'=> 'required|min:2',
            'id_pelanggan'=> 'required|min:1',
            
        ]);

        // Pastikan id_penjualan belum ada
        if (Penjualan::where('id_penjualan', $request->id_penjualan)->exists()) {
            return redirect()->back()->with('error', 'ID Penjualan sudah ada!');
        }
        // Mengambil ID penjualan terakhir dan menambahkan 1
        $lastPenjualan = Penjualan::latest()->first();
        $nextId = $lastPenjualan ? (int) substr($lastPenjualan->id_penjualan, 1) + 1 : 1; // Ambil ID terakhir dan tambah 1
        $idPenjualan = sprintf('%02d', $nextId); // Format menjadi 2 digit (01, 02, dst)
        
       // Menghapus simbol 'Rp' dan mengganti koma dengan titik untuk total_harga
       $total_harga = str_replace(['Rp', '.', ','], ['', '', '.'], $request->total_harga);
       $total_harga = trim($total_harga); // Menghapus spasi

        // Menyimpan data penjualan
        Penjualan::create([
            'id_penjualan' => $request->id_penjualan, // ID yang sudah digenerate otomatis
            'tanggal_penjualan'=> $request->tanggal_penjualan,
            'total_harga'=> $total_harga,
            'id_pelanggan'=> $request->id_pelanggan,
        ]);
        //redirect to index
        return redirect()->route('penjualans.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id_penjualan): View
    {
        //get post by ID
        $penjualan = Penjualan::findOrFail($id_penjualan);

        //render view with post
        return view('penjualans.show', compact('penjualan'));
    }

    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id_penjualan): View
    {
        $penjualan = Penjualan::findOrFail($id_penjualan);
        $pelanggans = Pelanggan::all(); // Ambil semua data pelanggan

        return view('penjualans.edit', compact('penjualan', 'pelanggans'));
    }

        
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id_penjualan): RedirectResponse
    {
        // Validasi form
        $this->validate($request, [
            'id_penjualan'=> 'required|min:1',
            'tanggal_penjualan'=> 'required|min:1',
            'total_harga'=> 'required|min:2',
            'id_pelanggan'=> 'required|min:1',
        ]);

        // Mengambil data penjualan berdasarkan ID
        $penjualan = Penjualan::findOrFail($id_penjualan);

        // Mengubah format 'total_harga' sebelum update
        $total_harga = str_replace(['Rp', '.', ','], ['', '', '.'], $request->total_harga);
        $total_harga = trim($total_harga); // Menghapus spasi jika ada

        // Melakukan update pada data penjualan
        $penjualan->update([
            'id_penjualan' => $request->id_penjualan,
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'total_harga' => $total_harga,  // Pastikan ini angka yang valid
            'id_pelanggan' => $request->id_pelanggan,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('penjualans.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id_penjualan): RedirectResponse
    {
        //get post by ID
        $penjualan = Penjualan::findOrFail($id_penjualan);

        //delete post
        $penjualan->delete();

        //redirect to index
        return redirect()->route('penjualans.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}