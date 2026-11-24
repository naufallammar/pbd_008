@extends('layouts.app')

@section('title', 'Master Vendor - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Master Vendor</h3>
            <p class="text-muted">Kelola daftar pemasok (supplier) barang</p>
        </div>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahVendor">
            + Tambah Vendor
        </button>
    </div>

    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Vendor</th>
                    <th>Badan Hukum</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vendors as $v)
                    <tr>
                        <td>#{{ $v->idvendor }}</td>
                        <td><strong>{{ $v->nama_vendor }}</strong></td>
                        <td><span class="badge badge-secondary">{{ $v->badan_hukum }}</span></td>
                        <td>
                            <span class="badge {{ $v->status == '1' ? 'badge-success' : 'badge-danger' }}">
                                {{ $v->status == '1' ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="text-right">
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditVendor{{ $v->idvendor }}">
                                Edit
                            </button>
                            <form action="{{ route('master.vendor.destroy', $v->idvendor) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus vendor ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">Belum ada data vendor.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div class="modal" id="modalTambahVendor">
        <div class="modal-dialog">
            <form action="{{ route('master.vendor.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <span>Tambah Vendor</span>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Vendor</label>
                        <input type="text" name="nama_vendor" class="form-control" placeholder="Contoh: PT Maju Jaya" required>
                    </div>
                    <div class="form-group">
                        <label>Badan Hukum</label>
                        <select name="badan_hukum" class="form-control">
                            <option value="PT">PT</option>
                            <option value="CV">CV</option>
                            <option value="UD">UD</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    @foreach ($vendors as $v)
        <div class="modal" id="modalEditVendor{{ $v->idvendor }}">
            <div class="modal-dialog">
                <form action="{{ route('master.vendor.update', $v->idvendor) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <span>Edit Vendor</span>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Vendor</label>
                            <input type="text" name="nama_vendor" class="form-control" value="{{ $v->nama_vendor }}" required>
                        </div>
                        <div class="form-group">
                            <label>Badan Hukum</label>
                            <select name="badan_hukum" class="form-control">
                                <option value="PT" {{ $v->badan_hukum == 'PT' ? 'selected' : '' }}>PT</option>
                                <option value="CV" {{ $v->badan_hukum == 'CV' ? 'selected' : '' }}>CV</option>
                                <option value="UD" {{ $v->badan_hukum == 'UD' ? 'selected' : '' }}>UD</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $v->status == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ $v->status == '0' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
