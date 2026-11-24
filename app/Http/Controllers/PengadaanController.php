<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengadaanController extends Controller
{
    public function index()
    {
        $pengadaan = DB::select("SELECT * FROM v_pengadaan ORDER BY idpengadaan DESC");
        return view('pengadaan.index', compact('pengadaan'));
    }

    public function create()
    {
        $vendors = DB::select("SELECT * FROM v_vendor WHERE status = ?", ['1']);
        $barang = DB::select("SELECT * FROM v_katalog_barang WHERE status = ?",['1']);

        return view('pengadaan.create', compact('vendors', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idvendor'  => 'required',
            'barang_id' => 'required|array|min:1',
            'qty'       => 'required|array|min:1',
        ]);

        $iduser = Auth::id();

        try {
            DB::beginTransaction();

            $idpengadaan_aktif = null;

            foreach ($request->barang_id as $key => $idbarang) {
                $qty = (int) $request->qty[$key];
                if ($qty <= 0) continue;

                $vendorParam = ($idpengadaan_aktif === null) ? $request->idvendor : null;

                $result = DB::select("CALL sp_tambah_item_pengadaan(?, ?, ?, ?, ?)", [
                    $idpengadaan_aktif,
                    $iduser,
                    $vendorParam,
                    $idbarang,
                    $qty
                ]);

                if (!empty($result) && isset($result[0]->id_pengadaan)) {
                    $idpengadaan_aktif = $result[0]->id_pengadaan;
                }
            }

            if (!$idpengadaan_aktif) {
                throw new \Exception("Tidak ada item valid yang berhasil disimpan.");
            }

            DB::commit();
            return redirect()->route('pengadaan.index')->with('success', 'Pengadaan (PO #' . $idpengadaan_aktif . ') berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error_system', 'Gagal membuat pengadaan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $header = DB::selectOne("SELECT * FROM v_pengadaan WHERE idpengadaan = ?", [$id]);
        $details = DB::select("SELECT * FROM v_detail_pengadaan WHERE idpengadaan = ?", [$id]);

        return view('pengadaan.show', compact('header', 'details'));
    }
}
