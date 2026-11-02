<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Proyeksi Keuntungan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light container mt-5">

    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3 shadow-sm">⬅️ Kembali ke Dashboard</a>

    <div class="card shadow border-0">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0 font-weight-bold">📈 Laporan Analisis & Proyeksi Keuntungan (Via DB Function)</h5>
        </div>
        <div class="card-body">
            <p class="text-muted">Laporan ini menghitung estimasi profit bersih sebesar <strong>10%</strong> dari harga modal barang menggunakan MySQL Function <code>f_hitung_profit_bersih()</code> secara langsung di level *database*.</p>

            <table class="table table-striped table-bordered mt-4">
                <thead class="thead-dark">
                    <tr>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Harga Modal</th>
                        <th class="text-success">Estimasi Laba Bersih (10%)</th>
                        <th class="text-primary">Proyeksi Harga Jual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $l)
                    <tr>
                        <td>{{ $l->idbarang }}</td>
                        <td>{{ $l->nama_barang }}</td>
                        <td><span class="badge badge-secondary p-2">{{ $l->nama_satuan }}</span></td>
                        <td>Rp {{ number_format($l->harga_modal, 0, ',', '.') }}</td>
                        <td class="text-success font-weight-bold">Rp {{ number_format($l->profit_bersih, 0, ',', '.') }}</td>
                        <td class="text-primary font-weight-bold">Rp {{ number_format($l->harga_jual_proyeksi, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
