<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = DB::table('barang')->count();

        $totalAset = DB::table('barang')->sum('harga');

        $barangAktif = DB::table('barang')->where('status', 1)->count();

        return view('dashboard', compact('totalBarang', 'totalAset', 'barangAktif'));
    }
}
