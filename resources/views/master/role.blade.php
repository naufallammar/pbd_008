@extends('layouts.app')

@section('title', 'Master Role - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Master Role</h3>
            <p class="text-muted">Kelola hak akses peran pengguna sistem</p>
        </div>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahRole">
            + Tambah Role
        </button>
    </div>


    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Role</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $r)
                    <tr>
                        <td>#{{ $r->idrole }}</td>
                        <td><strong>{{ $r->nama_role }}</strong></td>
                        <td class="text-right">
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditRole{{ $r->idrole }}">
                                Edit
                            </button>
                            <form action="{{ route('master.role.destroy', $r->idrole) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus role ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-muted">Belum ada data role.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div class="modal" id="modalTambahRole">
        <div class="modal-dialog">
            <form action="{{ route('master.role.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <span>Tambah Role</span>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Role</label>
                        <input type="text" name="nama_role" class="form-control" placeholder="Contoh: Admin" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit (Ditaruh di luar tabel agar HTML valid) -->
    @foreach ($roles as $r)
        <div class="modal" id="modalEditRole{{ $r->idrole }}">
            <div class="modal-dialog">
                <form action="{{ route('master.role.update', $r->idrole) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <span>Edit Role</span>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Role</label>
                            <input type="text" name="nama_role" class="form-control" value="{{ $r->nama_role }}" required>
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
