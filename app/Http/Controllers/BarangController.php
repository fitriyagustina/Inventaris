<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get barang
        $barang = barang::latest()->paginate(5);

        //render view with barang
        return view('barang.index', compact('barang'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [

            'nama_barang'     => 'required',
            'gambar'     => 'required',
            'kondisi'     => 'required'

        ]);

        //upload gambar
        $gambar = $request->file('gambar');
        $gambar->storeAs('public/barang', $gambar->hashName());

        //create barang
        barang::create([

            'nama_barang'     => $request->nama_barang,
            'kondisi'     => $request->kondisi,
            'gambar'     => $gambar->hashName(),

        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * edit
     *
     * @param  mixed $barang
     * @return void
     */
    public function edit(barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

     /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $barang
     * @return void
     */
    public function update(Request $request, barang $barang)
    {
        //validate form
        $this->validate($request, [
            'nama_barang'     => 'required',
            'kondisi' => 'required',
            'gambar'     => 'required'

        ]);

        //check if gambar is uploaded
        if ($request->hasFile('gambar')) {

            //upload new gambar
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/barang', $gambar->hashName());

            //delete old gambar
            Storage::delete('public/barang/'.$barang->gambar);

            //update barang with new gambar
            $barang->update([

            'nama_barang'     => $request->nama_barang,
            'kondisi'     => $request->kondisi,
            'gambar'     => $gambar->hashName(),

            ]);

        } else {

            //update barang without gambar
            $barang->update([
                'nama_barang'     => $request->nama_barang,
                'kondisi'     => $request->kondisi,


            ]);
        }

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy(barang $barang)
    {
        //delete image
        Storage::delete('public/barang/'. $barang->image);

        //delete barang
        $barang->delete();

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
