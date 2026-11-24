@extends('layouts.app')

@section('title', 'Riwayat Penerimaan Barang - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Riwayat Penerimaan Barang</h3>
            <p class="text-muted">Daftar barang masuk berdasarkan Purchase Order (PO).</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">Dashboard</a>
            <a href="{{ route('penerimaan.create') }}" class="btn btn-primary btn-sm">+ Catat Penerimaan</a>
        </div>
    </div>

    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>No. Penerimaan</th>
                    <th>No. PO</th>
                    <th>Tanggal Terima</th>
                    <th>Vendor</th>
                    <th>Diterima Oleh</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penerimaan as $row)
                    <tr>
                        <td><strong>#{{ $row->idpenerimaan }}</strong></td>
                        <td>
                            <a href="{{ route('pengadaan.show', $row->idpengadaan) }}" class="text-teal" style="text-decoration: none; font-weight: 600;">
                                PO #{{ $row->idpengadaan }}
                            </a>
                        </td>
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $row->nama_vendor }}</td>
                        <td>{{ $row->username }}</td>
                        <td class="text-right">
                            <a href="{{ route('penerimaan.show', $row->idpenerimaan) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">Belum ada catatan penerimaan barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
