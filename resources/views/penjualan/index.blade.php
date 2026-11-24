@extends('layouts.app')

@section('title', 'Daftar Penjualan - Sistem POS')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 style="margin: 0 0 4px;">Riwayat Penjualan (POS)</h3>
            <p class="text-muted" style="margin: 0;">Daftar transaksi penjualan kepada pelanggan</p>
        </div>
        <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
            + Transaksi Baru (Kasir)
        </a>
    </div>

    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>No. Nota</th>
                    <th>Waktu Transaksi</th>
                    <th>Kasir</th>
                    <th>Margin</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">PPN (11%)</th>
                    <th class="text-right">Total Nilai</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualan as $p)
                <tr>
                    <td><strong>#INV-{{ $p->idpenjualan }}</strong></td>
                    <td>{{ $p->created_at }}</td>
                    <td>{{ $p->username ?? 'System' }}</td>
                    <td><span class="badge badge-info">{{ $p->persen_margin ?? 0 }}%</span></td>
                    <td class="text-right">Rp {{ number_format($p->subtotal_nilai, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($p->ppn, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($p->total_nilai, 0, ',', '.') }}</strong></td>
                    <td class="text-right">
                        <a href="{{ route('penjualan.show', $p->idpenjualan) }}" class="btn btn-secondary btn-sm">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #718096;">Belum ada transaksi penjualan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
