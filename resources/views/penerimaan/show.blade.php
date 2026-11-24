@extends('layouts.app')

@section('title', 'Detail Penerimaan #' . $header->idpenerimaan . ' - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Detail Penerimaan #{{ $header->idpenerimaan }}</h3>
            <p class="text-muted">Rincian barang yang diterima dari vendor.</p>
        </div>
        <a href="{{ route('penerimaan.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card mb-4">
        <div class="row">
            <div class="col-md-6" style="margin-bottom: 0;">
                <p style="margin: 0 0 6px;">
                    <strong>Referensi PO:</strong>
                    <a href="{{ route('pengadaan.show', $header->idpengadaan) }}" class="text-teal" style="text-decoration: none; font-weight: 600;">
                        PO #{{ $header->idpengadaan }}
                    </a>
                </p>
                <p style="margin: 0;"><strong>Vendor:</strong> {{ $header->nama_vendor }}</p>
            </div>
            <div class="col-md-6 text-right" style="margin-bottom: 0;">
                <p style="margin: 0 0 6px;"><strong>Tanggal Terima:</strong> {{ $header->created_at }}</p>
                <p style="margin: 0;"><strong>Petugas Penerima:</strong> {{ $header->username }}</p>
            </div>
        </div>
    </div>

    <h4 class="mb-4">Daftar Barang Diterima</h4>
    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Satuan</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Jumlah Diterima</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($details as $d)
                    <tr>
                        <td><strong>{{ $d->nama_barang }}</strong></td>
                        <td>{{ $d->nama_satuan }}</td>
                        <td class="text-right">Rp {{ number_format($d->harga_satuan_terima, 0, ',', '.') }}</td>
                        <td class="text-right text-profit">+{{ $d->jumlah_terima }}</td>
                        <td class="text-right"><strong>Rp {{ number_format($d->sub_total_terima, 0, ',', '.') }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">Tidak ada rincian barang diterima.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
