@extends('layouts.app')

@section('title', 'Detail & Kartu Stok - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Kartu Stok: {{ $barang->nama_barang }}</h3>
            <p class="text-muted">Riwayat pergerakan barang masuk dan keluar.</p>
        </div>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <!-- Info Ringkas Barang -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="stat-card">
                <div class="stat-title">ID & Kode Jenis</div>
                <div class="stat-value">#{{ $barang->idbarang }} ({{ $barang->jenis }})</div>
                <div class="stat-sub">
                    Status:
                    <span class="badge {{ $barang->status == 1 ? 'badge-success' : 'badge-danger' }}">
                        {{ $barang->status == 1 ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card">
                <div class="stat-title">Sisa Stok Saat Ini</div>
                <div class="stat-value text-teal">{{ $barang->stok_terakhir }} {{ $barang->nama_satuan }}</div>
                <div class="stat-sub">Harga Modal: Rp {{ number_format($barang->harga, 0, ',', '.') }} / {{ $barang->nama_satuan }}</div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Kartu Stok -->
    <h4 class="mb-4">Log Mutasi Kartu Stok</h4>
    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>Waktu Transaksi</th>
                    <th>Jenis</th>
                    <th class="text-right">Masuk</th>
                    <th class="text-right">Keluar</th>
                    <th class="text-right">Saldo Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayatStok as $rs)
                    <tr>
                        <td>{{ $rs->created_at }}</td>
                        <td>
                            @if ($rs->jenis_transaksi == 'M')
                                <span class="badge badge-success">Barang Masuk (Penerimaan)</span>
                            @else
                                <span class="badge badge-danger">Barang Keluar (Penjualan)</span>
                            @endif
                        </td>
                        <td class="text-right text-profit">{{ $rs->masuk > 0 ? '+' . $rs->masuk : '-' }}</td>
                        <td class="text-right" style="color: #e53e3e; font-weight: 600;">{{ $rs->keluar > 0 ? '-' . $rs->keluar : '-' }}</td>
                        <td class="text-right"><strong>{{ $rs->stock }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">Belum ada riwayat mutasi stok untuk barang ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
