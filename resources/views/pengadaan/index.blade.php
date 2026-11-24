@extends('layouts.app')
@section('title', 'Daftar Pengadaan (PO)')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="font-weight-bold text-dark"><i class="fas fa-shopping-cart text-primary mr-2"></i>Daftar Pengadaan (PO)</h3>
    <div>
        <a href="{{ route('pengadaan.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat PO Baru</a>
    </div>
</div>



<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No. PO</th>
                        <th>Tanggal</th>
                        <th>Vendor</th>
                        <th>Dibuat Oleh</th>
                        <th>Subtotal</th>
                        <th>PPN (11%)</th>
                        <th>Total Nilai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengadaan as $row)
                    <tr>
                        <td class="font-weight-bold">#{{ $row->idpengadaan }}</td>
                        <td>{{ $row->timestamp }}</td>
                        <td>{{ $row->badan_hukum }} {{ $row->nama_vendor }}</td>
                        <td>{{ $row->username }}</td>
                        <td>Rp {{ number_format($row->subtotal_nilai, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($row->ppn, 0, ',', '.') }}</td>
                        <td class="font-weight-bold">Rp {{ number_format($row->total_nilai, 0, ',', '.') }}</td>
                        <td>
                            @if($row->status == 'P')
                                <span class="badge badge-warning">Proses</span>
                            @elseif($row->status == 'D')
                                <span class="badge badge-info">Diterima Sebagian</span>
                            @elseif($row->status == 'S')
                                <span class="badge badge-success">Selesai</span>
                            @else
                                <span class="badge badge-secondary">{{ $row->status }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pengadaan.show', $row->idpengadaan) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if($row->status != 'S')
                                <a href="{{ route('penerimaan.create', ['idpengadaan' => $row->idpengadaan]) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-truck-loading"></i> Terima
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Belum ada data pengadaan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
