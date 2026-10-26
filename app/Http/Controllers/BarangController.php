<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    // READ: Menampilkan seluruh baris dari tabel 'barang'
    public function index()
    {
        $barang = DB::table('barang')->get();
        return view('barang.index', compact('barang'));
    }

    // CREATE: Menyimpan data baru lewat query INSERT INTO barang
    public function store(Request $request)
    {
        DB::table('barang')->insert([
            'jenis'    => $request->jenis,
            'nama'     => $request->nama,
            'idsatuan' => $request->idsatuan,
            'status'   => $request->status,
            'harga'    => $request->harga,
        ]);
        return redirect()->back()->with('success', 'Data Master Barang berhasil disimpan!');
    }

    // UPDATE: Mengubah data terpilih lewat kueri UPDATE barang WHERE idbarang = ?
    public function update(Request $request, string $id)
    {
        DB::table('barang')->where('idbarang', $id)->update([
            'jenis'    => $request->jenis,
            'nama'     => $request->nama,
            'idsatuan' => $request->idsatuan,
            'status'   => $request->status,
            'harga'    => $request->harga,
        ]);
        return redirect()->back()->with('success', 'Data Master Barang berhasil diubah!');
    }

    // DELETE: Menghapus data lewat kueri DELETE FROM barang WHERE idbarang = ?
    public function destroy(string $id)
    {
        DB::table('barang')->where('idbarang', $id)->delete();
        return redirect()->back()->with('success', 'Data Master Barang berhasil dihapus!');
    }
}
