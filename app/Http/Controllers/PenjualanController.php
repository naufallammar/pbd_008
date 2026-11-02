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
            'subtotal_nilai'     => 'required|numeric',
            'ppn'                => 'required|numeric',
            'total_nilai'        => 'required|numeric',
            'idmargin_penjualan' => 'required',
            'barang_id'          => 'required|array',
            'qty'                => 'required|array',
            'harga_satuan'       => 'required|array',
        ]);

        $iduser = Auth::id();

        DB::beginTransaction();

        try {
            $proses = DB::select("CALL sp_buat_penjualan_baru(?, ?, ?, ?, ?)", [
                $request->subtotal_nilai,
                $request->ppn,
                $request->total_nilai,
                $iduser,
                $request->idmargin_penjualan
            ]);

            if (is_array($proses) && isset($proses[0])) {
                $idpenjualan_baru = $proses[0]->id_penjualan_baru ?? null;
            } else {
                $idpenjualan_baru = $proses->id_penjualan_baru ?? null;
            }

            if (!$idpenjualan_baru) {
                throw new \Exception("Gagal mendapatkan ID Penjualan baru dari database.");
            }

            foreach ($request->barang_id as $key => $idbarang) {
                DB::table('detail_penjualan')->insert([
                    'idpenjualan'  => $idpenjualan_baru,
                    'idbarang'     => $idbarang,
                    'qty'          => $request->qty[$key],
                    'harga_satuan' => $request->harga_satuan[$key],
                    'created_at'   => now(),
                    'updated_at'   => now()
                ]);
            }

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Transaksi kasir sukses! Nota #' . $idpenjualan_baru);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error_system', 'Transaksi gagal: ' . $e->getMessage());
        }
    }
}
