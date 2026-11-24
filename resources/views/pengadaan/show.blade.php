@extends('layouts.app')
@section('title', 'Detail Pengadaan #' . $header->idpengadaan)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="font-weight-bold text-dark">Detail Pengadaan #{{ $header->idpengadaan }}</h3>
    <div>
        <a href="{{ route('pengadaan.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        @if($header->status != 'S')
            <a href="{{ route('penerimaan.create', ['idpengadaan' => $header->idpengadaan]) }}" class="btn btn-success btn-sm">
                <i class="fas fa-truck-loading"></i> Proses Penerimaan
            </a>
        @endif
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>Vendor:</strong> {{ $header->badan_hukum }} {{ $header->nama_vendor }}</p>
                <p class="mb-1"><strong>Tanggal:</strong> {{ $header->timestamp }}</p>
                <p class="mb-0"><strong>Dibuat oleh:</strong> {{ $header->username }}</p>
            </div>
            <div class="col-md-6 text-md-right">
                <p class="mb-1"><strong>Status:</strong>
                    @if($header->status == 'P') <span class="badge badge-warning">Proses</span>
                    @elseif($header->status == 'D') <span class="badge badge-info">Diterima Sebagian</span>
                    @else <span class="badge badge-success">Selesai</span> @endif
                </p>
                <p class="mb-1"><strong>Subtotal:</strong> Rp {{ number_format($header->subtotal_nilai, 0, ',', '.') }}</p>
                <p class="mb-1"><strong>PPN (11%):</strong> Rp {{ number_format($header->ppn, 0, ',', '.') }}</p>
                <h5 class="font-weight-bold text-primary">Total: Rp {{ number_format($header->total_nilai, 0, ',', '.') }}</h5>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Barang</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Qty Pesan</th>
                    <th>Sisa Belum Diterima</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $d)
                <tr>
                    <td>{{ $d->nama_barang }}</td>
                    <td>{{ $d->nama_satuan }}</td>
                    <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $d->jumlah }}</td>
                    <td>
                        @if($d->sisa_belum_terima > 0)
                            <span class="badge badge-danger">{{ $d->sisa_belum_terima }}</span>
                        @else
                            <span class="badge badge-success">0 (Lengkap)</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($d->sub_total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
