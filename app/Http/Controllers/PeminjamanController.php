<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\siswa;
use App\Models\peminjaman;
use Illuminate\Http\Request;
use Illumiate\Support\Facades\Storage;

class peminjamanController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get peminjaman
        $peminjaman = peminjaman::all();

        //render view with peminjaman
        return view('peminjaman.index', compact('peminjaman'));
    }


    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $data = siswa::all();
        $item = barang::all();
        return view('peminjaman.create', compact('data', 'item'));
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

        'siswa_id' => 'required',
        'barang_id' => 'required',
        'tgl_pinjam' =>'required',
        'tgl_kembali' => 'required',


        ]);

        //create peminjaman
        peminjaman::create([
            'siswa_id'     => $request->siswa_id,
            'barang_id'     => $request->barang_id,
            'tgl_pinjam'     => $request->tgl_pinjam,
            'tgl_kembali'     => $request->tgl_kembali,

        ]);
        //redirect to index
        return redirect()->route('peminjaman.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * edit
     *
     * @param  mixed $peminjaman
     * @return void
     */
    public function edit(peminjaman $peminjaman)
    {
        $data = siswa::all();
        $item = barang::all();
        $pinjam = peminjaman::all();
        return view('peminjaman.edit', compact('peminjaman', 'data','item', 'pinjam'));
    }

    public function destroy(peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with(['success' => 'Data Berhasil Didelete!']);
    }
    public function update(Request $request, peminjaman $peminjaman)
    {
        //validate form
        $this->validate($request, [

        'siswa_id' => 'required',
        'barang_id' => 'required',
        'tgl_pinjam' =>'required',
        'tgl_kembali' => 'required',
        ]);

            //update post without image
            $peminjaman->update([
                'siswa_id'     => $request->siswa_id,
                'barang_id'     => $request->barang_id,
                'tgl_pinjam'     => $request->tgl_pinjam,
                'tgl_kembali'     => $request->tgl_kembali,
            ]);


        //redirect to index
        return redirect()->route('peminjaman.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
}
