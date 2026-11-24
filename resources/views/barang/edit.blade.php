@extends('layouts.app')

@section('title', 'Edit Barang - Sistem POS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Edit Master Barang</h3>
            <p class="text-muted">Perbarui informasi barang, satuan, atau harga modal.</p>
        </div>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card" style="max-width: 600px;">
        <form action="{{ route('barang.update', $barang->idbarang) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Kode Jenis (1 Karakter)</label>
                <input type="text" name="jenis" class="form-control" maxlength="1"
                    value="{{ old('jenis', $barang->jenis) }}" required>
                @error('jenis')
                    <span class="text-muted" style="color: #e53e3e;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama" class="form-control" maxlength="45"
                    value="{{ old('nama', $barang->nama_barang) }}" required>
                @error('nama')
                    <span class="text-muted" style="color: #e53e3e;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Satuan</label>
                <select name="idsatuan" class="form-control" required>
                    @foreach ($satuan as $s)
                        <option value="{{ $s->idsatuan }}"
                            {{ old('idsatuan', $barang->idsatuan) == $s->idsatuan ? 'selected' : '' }}>
                            {{ $s->nama_satuan }}
                        </option>
                    @endforeach
                </select>
                @error('idsatuan')
                    <span class="text-muted" style="color: #e53e3e;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Harga Modal (Rp)</label>
                <input type="number" name="harga" class="form-control" min="0"
                    value="{{ old('harga', $barang->harga) }}" required>
                @error('harga')
                    <span class="text-muted" style="color: #e53e3e;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Status Barang</label>
                <select name="status" class="form-control">
                    <option value="1" {{ old('status', $barang->status) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status', $barang->status) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
