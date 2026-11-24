@extends('layouts.app')

@section('title', 'Catat Penerimaan Barang - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Catat Penerimaan Barang</h3>
            <p class="text-muted">Pilih Purchase Order (PO) dan masukkan jumlah barang yang diterima.</p>
        </div>
        <a href="{{ route('penerimaan.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    @if (session('error_system'))
        <div class="alert alert-danger">{{ session('error_system') }}</div>
    @endif

    <div class="card mb-4">
        <!-- Form GET untuk memilih PO -->
        <form action="{{ route('penerimaan.create') }}" method="GET">
            <div class="form-group" style="margin-bottom: 0;">
                <label>Pilih Nomor Pengadaan (PO) yang Belum Selesai</label>
                <select name="idpengadaan" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Nomor PO --</option>
                    @foreach ($pengadaanList as $po)
                        <option value="{{ $po->idpengadaan }}" {{ $selectedPoId == $po->idpengadaan ? 'selected' : '' }}>
                            PO #{{ $po->idpengadaan }} - {{ $po->nama_vendor }} ({{ $po->status == 'D' ? 'Diterima Sebagian' : 'Proses' }})
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @if ($selectedPoId && count($itemsPo) > 0)
        <form action="{{ route('penerimaan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="idpengadaan" value="{{ $selectedPoId }}">

            <h4 class="mb-4">Input Jumlah Barang yang Datang</h4>
            <div class="table-card mb-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th class="text-right">Dipesan</th>
                            <th class="text-right">Sisa Belum Diterima</th>
                            <th style="width: 220px;">Jumlah Diterima Sekarang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($itemsPo as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->nama_barang }}</strong>
                                    <input type="hidden" name="barang_id[]" value="{{ $item->idbarang }}">
                                </td>
                                <td>{{ $item->nama_satuan }}</td>
                                <td class="text-right">{{ $item->jumlah_pesan }}</td>
                                <td class="text-right">
                                    <span class="badge badge-danger">{{ $item->sisa_pesanan }}</span>
                                </td>
                                <td>
                                    <input type="number" name="jumlah_terima[]" class="form-control"
                                           min="0" max="{{ $item->sisa_pesanan }}" value="{{ $item->sisa_pesanan }}" required>
                                    <span class="text-muted" style="font-size: 0.78rem;">Isi 0 jika belum datang</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Simpan Penerimaan & Tambah Stok</button>
            </div>
        </form>
    @elseif ($selectedPoId)
        <div class="alert alert-success">Semua barang pada PO #{{ $selectedPoId }} sudah diterima lengkap.</div>
    @endif
@endsection
