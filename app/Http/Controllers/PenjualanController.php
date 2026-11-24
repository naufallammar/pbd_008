<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = DB::select("
            SELECT p.*, u.username, m.persen AS persen_margin
            FROM penjualan p
            LEFT JOIN user u ON p.iduser = u.iduser
            LEFT JOIN margin_penjualan m ON p.idmargin_penjualan = m.idmargin_penjualan
            ORDER BY p.idpenjualan DESC
        ");

        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        // Ambil margin aktif dari View v_riwayat_margin
        $marginAktif = DB::selectOne("
            SELECT * FROM v_riwayat_margin
            WHERE status_margin = 1
            ORDER BY idmargin_penjualan DESC
            LIMIT 1
        ");
        $persenMargin = $marginAktif ? $marginAktif->persen : 0;

        // Ambil barang aktif beserta stok terakhir & harga jual (modal + margin)
        $barang = DB::select("
            SELECT
                idbarang,
                nama_barang,
                nama_satuan,
                harga AS harga_modal,
                f_cek_stok_terakhir(idbarang) AS stok_tersedia,
                (harga + f_hitung_profit_bersih(harga, ?)) AS harga_jual
            FROM v_katalog_barang
            WHERE status = 1
            ORDER BY nama_barang ASC
        ", [$persenMargin]);

        return view('penjualan.create', compact('barang', 'marginAktif', 'persenMargin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|array|min:1',
            'qty'       => 'required|array|min:1',
        ]);

        $iduser = session('iduser') ?? 1;

        $marginAktif = DB::selectOne("
            SELECT idmargin_penjualan
            FROM v_riwayat_margin
            WHERE status_margin = 1
            ORDER BY idmargin_penjualan DESC
            LIMIT 1
        ");

        if (!$marginAktif) {
            return redirect()->back()->with('error', 'Margin penjualan aktif belum diatur oleh Superadmin!');
        }

        $adaItem = false;
        foreach ($request->qty as $q) {
            if ((int) $q > 0) {
                $adaItem = true;
                break;
            }
        }

        if (!$adaItem) {
            return redirect()->back()->with('error', 'Masukkan jumlah (Qty) minimal 1 barang!');
        }

        DB::beginTransaction();
        try {
            // 1. Panggil SP sp_buat_penjualan_baru untuk membuat header transaksi
            $header = DB::selectOne("CALL sp_buat_penjualan_baru(0, 0, 0, ?, ?)", [
                $iduser,
                $marginAktif->idmargin_penjualan,
            ]);

            $idpenjualan = $header->id_penjualan_baru ?? null;
            if (!$idpenjualan) {
                throw new \Exception("Gagal membuat nomor nota penjualan.");
            }

            // 2. Panggil SP sp_tambah_item_penjualan untuk setiap item
            foreach ($request->barang_id as $index => $idbarang) {
                $qty = (int) $request->qty[$index];
                if ($qty <= 0) continue;

                DB::statement("CALL sp_tambah_item_penjualan(?, ?, ?)", [
                    $idpenjualan,
                    $idbarang,
                    $qty,
                ]);
            }

            DB::commit();
            return redirect()->route('penjualan.show', $idpenjualan)->with('success', 'Transaksi Penjualan #' . $idpenjualan . ' berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transaksi gagal: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $header = DB::selectOne("
            SELECT p.*, u.username, m.persen AS persen_margin
            FROM penjualan p
            LEFT JOIN user u ON p.iduser = u.iduser
            LEFT JOIN margin_penjualan m ON p.idmargin_penjualan = m.idmargin_penjualan
            WHERE p.idpenjualan = ?
        ", [$id]);

        if (!$header) {
            return redirect()->route('penjualan.index')->with('error', 'Nota penjualan tidak ditemukan.');
        }

        $details = DB::select("
            SELECT dp.*, b.nama AS nama_barang, s.nama_satuan
            FROM detail_penjualan dp
            JOIN barang b ON dp.idbarang = b.idbarang
            JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE dp.penjualan_idpenjualan = ?
        ", [$id]);

        return view('penjualan.show', compact('header', 'details'));
    }
}
