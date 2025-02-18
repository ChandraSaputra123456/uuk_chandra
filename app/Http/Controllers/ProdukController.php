<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProdukController extends Controller
{    
    public function index(): View
    {
        $produks = Produk::orderBy('id_produk', 'asc')->paginate(5);
        return view('produks.index', compact('produks'));
    }

    public function create(): View
    {
        // Ambil ID terakhir secara numerik
        $lastProduk = Produk::orderBy('id_produk', 'desc')->first();
        $lastId = $lastProduk ? intval($lastProduk->id_produk) : 0;
        $newId = str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        return view('produks.create', compact('newId'));
    }
 
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'nama_produk' => 'required|min:2',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|min:1',
        ]);

        // Ambil ID terakhir secara numerik
        $lastProduk = Produk::orderBy('id_produk', 'desc')->first();
        $lastId = $lastProduk ? intval($lastProduk->id_produk) : 0;
        $newId = str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        Produk::create([
            'id_produk'   => $newId,
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok
        ]);

        return redirect()->route('produks.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    public function show(string $id_produk): View
    {
        $produk = Produk::findOrFail($id_produk);
        return view('produks.show', compact('produk'));
    }

    public function edit(string $id_produk): View
    {
        $produk = Produk::findOrFail($id_produk);
        return view('produks.edit', compact('produk'));
    }
        
    public function update(Request $request, $id_produk): RedirectResponse
    {
        $this->validate($request, [
            'nama_produk' => 'required|min:2',
            'harga' => 'required|min:1',
            'stok' => 'required|min:1',
        ]);
         
        $produk = Produk::findOrFail($id_produk);
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok
        ]);

        return redirect()->route('produks.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id_produk): RedirectResponse
    {
        $produk = Produk::findOrFail($id_produk);
        $produk->delete();

        return redirect()->route('produks.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
