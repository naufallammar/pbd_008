@extends('layouts.app')

@section('title', 'Dashboard - Sistem POS')

@section('content')
<div>


    <!-- Page Header -->
    <div class="mb-4">
        <h3 class="font-weight-bold mb-1" style="color: #1a202c;">Dashboard</h3>
        <p class="text-muted small mb-0">Ringkasan stok dan transaksi</p>
    </div>

    <!-- 3 Summary Cards -->
    <div class="row mb-4">
        <!-- Card 1: Pengadaan -->
        <div class="col-md-4 mb-3">
            <div class="stat-card h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-title">Pengadaan</span>
                    <i class="fas fa-clipboard-list text-muted"></i>
                </div>
                <div class="stat-value">{{ $poMenunggu }}</div>
                <div class="stat-sub">Menunggu penerimaan</div>
            </div>
        </div>

        <!-- Card 2: Hari Ini -->
        <div class="col-md-4 mb-3">
            <div class="stat-card h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-title">Hari Ini</span>
                    <i class="fas fa-cash-register text-muted"></i>
                </div>
                <div class="stat-value">Rp {{ number_format($penjualanHariIni->total_omzet, 0, ',', '.') }}</div>
                <div class="stat-sub">{{ $penjualanHariIni->jumlah_transaksi }} transaksi penjualan</div>
            </div>
        </div>

        <!-- Card 3: Margin -->
        <div class="col-md-4 mb-3">
            <div class="stat-card h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-title">Margin</span>
                    <i class="fas fa-percentage text-muted"></i>
                </div>
                <div class="stat-value">{{ $persenMargin }}%</div>
                <div class="stat-sub">Margin penjualan aktif</div>
            </div>
        </div>
    </div>

    <!-- Stok Barang Saat Ini -->
    <div class="mt-2">
        <h6 class="font-weight-bold mb-3" style="color: #2d3748;">Stok Barang Saat Ini</h6>
        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa; font-size: 0.75rem; color: #718096; text-transform: uppercase;">
                        <tr>
                            <th class="border-top-0 pl-4" width="8%">No</th>
                            <th class="border-top-0">Barang</th>
                            <th class="border-top-0">Satuan</th>
                            <th class="border-top-0 text-right pr-4">Stok</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.9rem;">
                        @forelse($stokBarang as $index => $item)
                        <tr>
                            <td class="pl-4 text-muted">{{ $index + 1 }}</td>
                            <td class="font-weight-medium">{{ $item->nama_barang }}</td>
                            <td class="text-muted">{{ $item->nama_satuan }}</td>
                            <td class="text-right pr-4 font-weight-bold">{{ $item->stok_saat_ini }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada data barang aktif.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
