@extends('layouts.app')

@section('title', 'Margin Penjualan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Master Margin Penjualan</h3>

    </div>

    <!-- Form Tambah Margin (Langsung tanpa Modal) -->


    <!-- Tabel 1: Daftar Margin -->
    <div class="card">
        <h4>Daftar Tingkat Margin</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Margin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayatMargin as $rm)
                    <tr>
                        <td>#{{ $rm->idmargin_penjualan }}</td>
                        <td><strong>{{ $rm->persen }}%</strong></td>
                        <td>
                            <span class="badge {{ $rm->status_margin == 1 ? 'badge-success' : 'badge-secondary' }}">
                                {{ $rm->status_margin == 1 ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Belum ada data margin.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tabel 2: Simulasi Harga Jual -->

@endsection
