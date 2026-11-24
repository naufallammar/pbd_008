@extends('layouts.app')

@section('title', 'Master Satuan - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Master Satuan</h3>
            <p class="text-muted">Kelola satuan unit barang (PCS, LUSIN, BOX, dll.)</p>
        </div>
        {{-- <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahSatuan">
            + Tambah Satuan
        </button> --}}
    </div>

    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Satuan</th>
                    <th>Status</th>
                    {{-- <th class="text-right">Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($satuan as $s)
                    <tr>
                        <td>#{{ $s->idsatuan }}</td>
                        <td><strong>{{ $s->nama_satuan }}</strong></td>
                        <td>
                            <span class="badge {{ $s->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $s->status == 1 ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="text-right">
                            {{-- <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditSatuan{{ $s->idsatuan }}">
                                Edit
                            </button>
                            <form action="{{ route('master.satuan.destroy', $s->idsatuan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus satuan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">Belum ada data satuan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div class="modal" id="modalTambahSatuan">
        <div class="modal-dialog">
            <form action="{{ route('master.satuan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <span>Tambah Satuan</span>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Satuan</label>
                        <input type="text" name="nama_satuan" class="form-control" placeholder="Contoh: PACK" required>
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

    <!-- Modal Edit (Di luar tabel agar HTML valid) -->
    @foreach ($satuan as $s)
        <div class="modal" id="modalEditSatuan{{ $s->idsatuan }}">
            <div class="modal-dialog">
                <form action="{{ route('master.satuan.update', $s->idsatuan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <span>Edit Satuan</span>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Satuan</label>
                            <input type="text" name="nama_satuan" class="form-control" value="{{ $s->nama_satuan }}" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $s->status == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ $s->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
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
