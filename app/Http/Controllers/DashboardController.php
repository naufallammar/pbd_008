<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $poMenunggu = DB::selectOne("
            SELECT COUNT(*) AS total
            FROM v_pengadaan
            WHERE status IN ('P', 'D')
        ")->total ?? 0;

        $penjualanHariIni = DB::selectOne("
            SELECT
                COALESCE(SUM(total_nilai), 0) AS total_omzet,
                COUNT(*) AS jumlah_transaksi
            FROM penjualan
            WHERE DATE(created_at) = CURDATE()
        ");

        $marginAktif = DB::selectOne("
            SELECT persen
            FROM v_riwayat_margin
            WHERE status_margin = 1
            ORDER BY idmargin_penjualan DESC
            LIMIT 1
        ");
        $persenMargin = $marginAktif ? $marginAktif->persen : 0;

        $stokBarang = DB::select("
            SELECT
                idbarang,
                nama_barang,
                nama_satuan,
                f_cek_stok_terakhir(idbarang) AS stok_saat_ini
            FROM v_katalog_barang
            WHERE status = 1
            ORDER BY nama_barang ASC
        ");

        return view('dashboard', compact(
            'poMenunggu',
            'penjualanHariIni',
            'persenMargin',
            'stokBarang'
        ));
    }
}
