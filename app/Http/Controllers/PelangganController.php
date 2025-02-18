<?php

namespace App\Http\Controllers;

//import Model "Post
use App\Models\Pelanggan;

use Illuminate\Http\Request;

//return type View
use Illuminate\View\View;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{    
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        //get posts
        //$pelanggans = Pelanggan::latest()->paginate(5);
        $pelanggans = Pelanggan::orderBy('id_pelanggan', 'asc')->paginate(5);

        //render view with posts
        return view('pelanggans.index', compact('pelanggans'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        // Get the last id_pelanggan from the database
        $lastPelanggan = Pelanggan::orderBy('id_pelanggan', 'desc')->first();
        $nextId = $lastPelanggan ? $lastPelanggan->id_pelanggan + 1 : 1; // If no records, start from 1

        // Pass the next id_pelanggan to the view
        return view('pelanggans.create', compact('nextId'));
    }
 
    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate form
        $this->validate($request, [
            'id_pelanggan'=> 'required|min:1',
            'nama_pelanggan'=> 'required|min:2',
            'alamat'=> 'required|min:2',
            'nomor_telepon'=> 'required|min:2',
        ]);

        // Create new pelanggan with the provided id_pelanggan
        Pelanggan::create([
            'id_pelanggan'=> $request->id_pelanggan,
            'nama_pelanggan'=> $request->nama_pelanggan,
            'alamat'=> $request->alamat,
            'nomor_telepon'=> $request->nomor_telepon,
        ]);

        // Redirect to the index
        return redirect()->route('pelanggans.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id_pelanggan): View
    {
        //get post by ID
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);

        //render view with post
        return view('pelanggans.show', compact('pelanggan'));
    }

    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id_pelanggan): View
    {
        //get post by ID
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);

        //render view with post
        return view('pelanggans.edit', compact('pelanggan'));
    }
        
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id_pelanggan): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'id_pelanggan'=> 'required|min:1',
            'nama_pelanggan'=> 'required|min:2',
            'alamat'=> 'required|min:2',
            'nomor_telepon'=> 'required|min:2',
        ]);

        //get post by ID
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);

            //update post without image
            $pelanggan->update([
                'id_pelanggan'=> $request->id_pelanggan,
                'nama_pelanggan'=> $request->nama_pelanggan,
                'alamat'=> $request->alamat,
                'nomor_telepon'=> $request->nomor_telepon,
            ]);
        

        //redirect to index
        return redirect()->route('pelanggans.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id_pelanggan): RedirectResponse
    {
        //get post by ID
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);

        //delete post
        $pelanggan->delete();

        // Reset auto-increment ID
        \DB::statement("ALTER TABLE pelanggans AUTO_INCREMENT = 1");

        //redirect to index
        return redirect()->route('pelanggans.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}