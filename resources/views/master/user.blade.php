@extends('layouts.app')

@section('title', 'Master User - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Master User</h3>
            <p class="text-muted">Kelola akun pengguna dan penugasan role</p>
        </div>
        {{-- <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahUser">
            + Tambah User
        </button> --}}
    </div>

    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    {{-- <th class="text-right">Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $u)
                    <tr>
                        <td>#{{ $u->iduser }}</td>
                        <td><strong>{{ $u->username }}</strong></td>
                        <td><span class="badge badge-info">{{ $u->nama_role }}</span></td>
                        <td class="text-right">
                            {{-- <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditUser{{ $u->iduser }}">
                                Edit
                            </button>
                            <form action="{{ route('master.user.destroy', $u->iduser) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">Belum ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div class="modal" id="modalTambahUser">
        <div class="modal-dialog">
            <form action="{{ route('master.user.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <span>Tambah User</span>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="idrole" class="form-control" required>
                            @foreach ($roles as $r)
                                <option value="{{ $r->idrole }}">{{ $r->nama_role }}</option>
                            @endforeach
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
    @foreach ($users as $u)
        <div class="modal" id="modalEditUser{{ $u->iduser }}">
            <div class="modal-dialog">
                <form action="{{ route('master.user.update', $u->iduser) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <span>Edit User</span>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $u->username }}" required>
                        </div>
                        <div class="form-group">
                            <label>Password Baru <span class="text-muted">(Kosongkan jika tidak diubah)</span></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="idrole" class="form-control" required>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->idrole }}" {{ $u->idrole == $r->idrole ? 'selected' : '' }}>
                                        {{ $r->nama_role }}
                                    </option>
                                @endforeach
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
