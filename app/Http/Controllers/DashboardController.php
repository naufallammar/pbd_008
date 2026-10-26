<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung total seluruh baris barang (DML: SELECT COUNT)
        $totalBarang = DB::table('barang')->count();

        // 2. Menghitung total nilai aset harga barang (DML: SELECT SUM)
        $totalAset = DB::table('barang')->sum('harga');

        // 3. Menghitung barang yang berstatus aktif (DML: SELECT COUNT WHERE)
        $barangAktif = DB::table('barang')->where('status', 1)->count();

        // Kirim data statistik tersebut ke file view dashboard
        return view('dashboard', compact('totalBarang', 'totalAset', 'barangAktif'));
    }
}
