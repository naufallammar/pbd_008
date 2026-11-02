<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index()
    {
        $barang = DB::table('v_katalog_barang')->where('status', 1)->get();

        $marginActive = DB::table('margin_penjualan')->where('status', 1)->first();

        return view('kasir.index', compact('barang', 'marginActive'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subtotal_nilai' => 'required|numeric',
            'ppn' => 'required|numeric',
            'total_nilai' => 'required|numeric',
            'idmargin_penjualan' => 'required',
        ]);

        $iduser = Auth::id();

        $proses = DB::select("CALL sp_buat_penjualan_baru(?, ?, ?, ?, ?)", [
            $request->subtotal_nilai,
            $request->ppn,
            $request->total_nilai,
            $iduser,
            $request->idmargin_penjualan
        ]);

        $idpenjualan_baru = $proses[0]->id_penjualan_baru;


        return redirect()->route('dashboard')->with('success', 'Transaksi kasir sukses! Nota #' . $idpenjualan_baru);
    }
}
