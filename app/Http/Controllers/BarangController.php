<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        $barang = DB::select("
            SELECT *, f_cek_stok_terakhir(idbarang) AS stok_terakhir
            FROM v_katalog_barang
            ORDER BY idbarang DESC
        ");
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $satuan = DB::select("SELECT * FROM v_satuan WHERE status = 1");
        return view('barang.create', compact('satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'    => 'required|max:1',
            'nama'     => 'required|max:45',
            'idsatuan' => 'required|integer',
            'status'   => 'required|in:0,1',
            'harga'    => 'required|integer|min:0',
        ]);

        DB::insert("
            INSERT INTO barang (jenis, nama, idsatuan, status, harga)
            VALUES (?, ?, ?, ?, ?)
        ", [
            strtoupper($request->jenis),
            $request->nama,
            $request->idsatuan,
            $request->status,
            $request->harga,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data Master Barang berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $barang = DB::selectOne("
            SELECT *, f_cek_stok_terakhir(idbarang) AS stok_terakhir
            FROM v_katalog_barang
            WHERE idbarang = ?
        ", [$id]);

        if (!$barang) {
            return redirect()->route('barang.index')->with('error', 'Barang tidak ditemukan.');
        }

        $riwayatStok = DB::select("
            SELECT * FROM kartu_stok
            WHERE idbarang = ?
            ORDER BY idkartu_stok DESC
        ", [$id]);

        return view('barang.show', compact('barang', 'riwayatStok'));
    }

    public function edit(string $id)
    {
        $barang = DB::selectOne("SELECT * FROM v_katalog_barang WHERE idbarang = ?", [$id]);

        if (!$barang) {
            return redirect()->route('barang.index')->with('error', 'Barang tidak ditemukan.');
        }

        $satuan = DB::select("SELECT * FROM v_satuan WHERE status = 1");

        return view('barang.edit', compact('barang', 'satuan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis'    => 'required|max:1',
            'nama'     => 'required|max:45',
            'idsatuan' => 'required|integer',
            'status'   => 'required|in:0,1',
            'harga'    => 'required|integer|min:0',
        ]);

        DB::update("
            UPDATE barang
            SET jenis = ?, nama = ?, idsatuan = ?, status = ?, harga = ?
            WHERE idbarang = ?
        ", [
            strtoupper($request->jenis),
            $request->nama,
            $request->idsatuan,
            $request->status,
            $request->harga,
            $id,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data Master Barang berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        try {
            DB::delete("DELETE FROM barang WHERE idbarang = ?", [$id]);
            return redirect()->route('barang.index')->with('success', 'Data Master Barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('barang.index')->with('error', 'Barang tidak dapat dihapus karena sudah tercatat dalam transaksi. Ubah status ke Non-Aktif.');
        }
    }

    public function laporanProfit(Request $request)
    {
        $marginAktif = DB::selectOne("
            SELECT * FROM v_riwayat_margin
            WHERE status_margin = 1
            ORDER BY idmargin_penjualan DESC
            LIMIT 1
        ");

        $persenSimulasi = $request->input('persen', $marginAktif ? $marginAktif->persen : 10);

        $laporan = DB::select("
            SELECT
                idbarang,
                nama_barang,
                jenis,
                nama_satuan,
                harga AS harga_modal,
                f_cek_stok_terakhir(idbarang) AS stok_saat_ini,
                f_hitung_profit_bersih(harga, ?) AS profit_bersih,
                (harga + f_hitung_profit_bersih(harga, ?)) AS harga_jual_proyeksi
            FROM v_katalog_barang
            WHERE status = 1
            ORDER BY nama_barang ASC
        ", [$persenSimulasi, $persenSimulasi]);

        $riwayatMargin = DB::select("SELECT * FROM v_riwayat_margin ORDER BY idmargin_penjualan DESC");

        return view('barang.profit', compact('laporan', 'persenSimulasi', 'marginAktif', 'riwayatMargin'));
    }

    public function storeMargin(Request $request)
    {
        $request->validate(['persen' => 'required|numeric|min:0|max:500']);
        $iduser = session('iduser') ?? 1;

        DB::beginTransaction();
        try {
            DB::update("UPDATE margin_penjualan SET status = 0");
            DB::insert("
                INSERT INTO margin_penjualan (persen, status, iduser, created_at, updated_at)
                VALUES (?, 1, ?, NOW(), NOW())
            ", [
                $request->persen,
                $iduser,
            ]);
            DB::commit();
            return redirect()->route('laporan.profit')->with('success', 'Margin aktif berhasil diperbarui menjadi ' . $request->persen . '%!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('laporan.profit')->with('error', 'Gagal menyimpan margin: ' . $e->getMessage());
        }
    }
}
