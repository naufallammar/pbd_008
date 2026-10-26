<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <!-- PERBAIKAN: Tautan resmi Bootstrap CSS yang lengkap -->
    <link rel="stylesheet" href="https://jsdelivr.net">
    <style>
        .sidebar { min-height: 100vh; backgrouphp artisan servend: #212529; color: white; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 12px 20px; }
        .sidebar a:hover, .sidebar a.active { background: #343a40; color: white; border-left: 4px solid #007bff; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- 1. KOMPONEN SIDEBAR (NAVIGASI UTAMA) -->
        <nav class="col-md-2 d-none d-md-block sidebar px-0">
            <div class="sidebar-heading p-4 bg-dark text-center font-weight-bold">
                Aplikasi UTS Naufal
            </div>
            <div class="list-group list-group-flush mt-3">
                <a href="{{ route('dashboard') }}" class="active">📊 Dashboard</a>
                <a href="/barang">📦 Master Barang (CUD)</a>
                <a href="/satuan">🏷️ Master Satuan</a> <!-- Menambahkan menu satuan -->
            </div>
        </nav>

        <!-- 2. KONTEN UTAMA DASHBOARD -->
        <main class="col-md-10 ml-sm-auto px-4 mt-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h4>Ringkasan Basis Data (Dashboard)</h4>
            </div>

            <!-- Baris Info Widget Statistik -->
            <div class="row">
                <!-- Total Ringkasan Baris Data -->
                <div class="col-md-4 mb-4">
                    <div class="card border-primary shadow-sm h-100 py-2 border-top-0 border-right-0 border-bottom-0" style="border-left: 4px solid #007bff;">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Produk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarang }} Item</div>
                        </div>
                    </div>
                </div>

                <!-- Total Nilai Agregasi Harga -->
                <div class="col-md-4 mb-4">
                    <div class="card border-success shadow-sm h-100 py-2 border-top-0 border-right-0 border-bottom-0" style="border-left: 4px solid #28a745;">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Nilai Aset</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalAset, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Kondisi Filter Data -->
                <div class="col-md-4 mb-4">
                    <div class="card border-warning shadow-sm h-100 py-2 border-top-0 border-right-0 border-bottom-0" style="border-left: 4px solid #ffc107;">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Barang Status Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $barangAktif }} Item</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- JAVASCRIPT pembantu Bootstrap diletakkan di paling bawah agar web dimuat lebih cepat -->
<script src="https://jsdelivr.net"></script>
<script src="https://jsdelivr.net"></script>
</body>
</html>
