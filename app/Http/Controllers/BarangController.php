<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        $barang = DB::table('barang')->get();
        return view('barang.index', compact('barang'));
    }

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
    public function laporanProfit()
{

    $laporan = DB::select("
        SELECT
            idbarang,
            nama_barang,
            nama_satuan,
            harga AS harga_modal,
            f_hitung_profit_bersih(harga, 10) AS profit_bersih,
            (harga + f_hitung_profit_bersih(harga, 10)) AS harga_jual_proyeksi
        FROM v_katalog_barang
    ");

    return view('barang.profit', compact('laporan'));
}

}
