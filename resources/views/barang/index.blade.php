<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Barang</title>
    <link rel="stylesheet" href="https://jsdelivr.net">
</head>
<body class="container mt-5">
<a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">⬅️ Kembali ke Dashboard</a>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">CUD Master Data Barang</h5>
            <button class="btn btn-light btn-sm font-weight-bold" data-toggle="modal" data-target="#modalTambah">+ Tambah Barang</button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-striped table-bordered mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>ID Barang</th>
                        <th>Jenis</th>
                        <th>Nama Barang</th>
                        <th>ID Satuan</th>
                        <th>Status</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $b)
                    <tr>
                        <td>{{ $b->idbarang }}</td>
                        <td><span class="badge badge-secondary">{{ $b->jenis }}</span></td>
                        <td>{{ $b->nama }}</td>
                        <td>{{ $b->idsatuan }}</td>
                        <td>{{ $b->status == 1 ? 'Aktif' : 'Non-Aktif' }}</td>
                        <td>Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('barang.destroy', $b->idbarang) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data barang ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- MODAL FORM EDIT (UPDATE) -->
                    <div class="modal fade" id="modalEdit{{ $b->idbarang }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('barang.update', $b->idbarang) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header"><h5 class="modal-title">Ubah Barang #{{ $b->idbarang }}</h5></div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <label>Jenis (Char 1)</label>
                                            <input type="text" name="jenis" class="form-control" maxlength="1" value="{{ $b->jenis }}" placeholder="A/B/C">
                                        </div>
                                        <div class="col-6">
                                            <label>ID Satuan (FK)</label>
                                            <input type="number" name="idsatuan" class="form-control" value="{{ $b->idsatuan }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Barang</label>
                                        <input type="text" name="nama" class="form-control" value="{{ $b->nama }}" required>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <label>Harga</label>
                                            <input type="number" name="harga" class="form-control" value="{{ $b->harga }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ $b->status == 1 ? 'selected' : '' }}>Aktif (1)</option>
                                                <option value="0" {{ $b->status == 0 ? 'selected' : '' }}>Non-Aktif (0)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer"><button type="submit" class="btn btn-warning">Simpan Perubahan</button></div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data di tabel barang MySQL Anda.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL FORM TAMBAH (CREATE) -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('barang.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Tambah Barang Baru</h5></div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-6">
                            <label>Jenis (Char 1)</label>
                            <input type="text" name="jenis" class="form-control" maxlength="1" placeholder="Misal: A">
                        </div>
                        <div class="col-6">
                            <label>ID Satuan (FK)</label>
                            <input type="number" name="idsatuan" class="form-control" placeholder="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label>Harga</label>
                            <input type="number" name="harga" class="form-control" placeholder="15000" required>
                        </div>
                        <div class="col-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Aktif (1)</option>
                                <option value="0">Non-Aktif (0)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-success">Simpan Data</button></div>
            </form>
        </div>
    </div>

    <script src="https://jsdelivr.net"></script>
    <script src="https://jsdelivr.net"></script>
</body>
</html>
