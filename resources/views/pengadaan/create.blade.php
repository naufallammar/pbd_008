@extends('layouts.app')

@section('title', 'Buat Pengadaan Baru - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Buat Pengadaan Baru</h3>
            <p class="text-muted">Pilih vendor serta daftar barang dan jumlah yang akan dipesan.</p>
        </div>
        <a href="{{ route('pengadaan.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    @if (session('error_system'))
        <div class="alert alert-danger">{{ session('error_system') }}</div>
    @endif

    <form action="{{ route('pengadaan.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="form-group" style="margin-bottom: 0;">
                <label>Pilih Vendor</label>
                <select name="idvendor" class="form-control" required>
                    <option value="">-- Pilih Vendor --</option>
                    @foreach ($vendors as $v)
                        <option value="{{ $v->idvendor }}">{{ $v->badan_hukum }} {{ $v->nama_vendor }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Daftar Barang Dipesan</h4>
            <button type="button" id="btnTambahBaris" class="btn btn-secondary btn-sm">
                + Tambah Baris Barang
            </button>
        </div>

        <div class="table-card mb-4">
            <table class="table" id="tabelItem">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th style="width: 180px;">Jumlah</th>
                        <th class="text-right" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="barang_id[]" class="form-control" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->idbarang }}">
                                        {{ $b->nama_barang }} ({{ $b->nama_satuan }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="qty[]" class="form-control" min="1" value="1" required>
                        </td>
                        <td class="text-right">
                            <button type="button" class="btn btn-danger btn-sm btn-hapus">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary">Simpan Pengadaan</button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.querySelector('#tabelItem tbody');
    const btnTambahBaris = document.getElementById('btnTambahBaris');

    btnTambahBaris.addEventListener('click', function () {
        const barisPertama = tbody.querySelector('tr');
        const barisBaru = barisPertama.cloneNode(true);
        barisBaru.querySelector('select').value = '';
        barisBaru.querySelector('input[type="number"]').value = '1';
        tbody.appendChild(barisBaru);
    });

    tbody.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-hapus')) {
            if (tbody.querySelectorAll('tr').length > 1) {
                e.target.closest('tr').remove();
            }
        }
    });
});
</script>
@endpush
