@extends('layouts.app')

@section('title', 'Detail Penjualan #' . $header->idpenjualan)

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 style="margin: 0 0 4px;">Detail Nota #INV-{{ $header->idpenjualan }}</h3>
            <p class="text-muted" style="margin: 0;">Waktu Transaksi: {{ $header->created_at }} | Kasir: {{ $header->username ?? 'System' }}</p>
        </div>
        <div>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary btn-sm">Kembali ke Riwayat</a>
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary btn-sm">+ Transaksi Baru</a>
        </div>
    </div>



    <div class="card">
        <div class="table-card" style="margin-bottom: 16px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $idx => $d)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td><strong>{{ $d->nama_barang }}</strong></td>
                        <td>{{ $d->nama_satuan }}</td>
                        <td class="text-right">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-right">{{ $d->jumlah }}</td>
                        <td class="text-right"><strong>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="text-align: right; padding-top: 8px;">
            <p style="margin: 4px 0;">Subtotal: <strong>Rp {{ number_format($header->subtotal_nilai, 0, ',', '.') }}</strong></p>
            <p style="margin: 4px 0;">PPN (11%): <strong>Rp {{ number_format($header->ppn, 0, ',', '.') }}</strong></p>
            <h3 style="margin: 8px 0 0; color: #1a736e;">Total Bayar: Rp {{ number_format($header->total_nilai, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>
@endsection
