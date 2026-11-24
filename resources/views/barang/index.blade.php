@extends('layouts.app')

@section('title', 'Master Barang - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Master Barang</h3>
            <p class="text-muted">Kelola data barang, harga modal, satuan</p>
        </div>

    </div>

    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th class="text-right">Harga Modal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barang as $b)
                    <tr>
                        <td>#{{ $b->idbarang }}</td>
                        <td><span class="badge badge-secondary">{{ $b->jenis }}</span></td>
                        <td><strong>{{ $b->nama_barang }}</strong></td>
                        <td>{{ $b->nama_satuan }}</td>
                        <td class="text-right">Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $b->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $b->status == 1 ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-muted">Belum ada data master barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
