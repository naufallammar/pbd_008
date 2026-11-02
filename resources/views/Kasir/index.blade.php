<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir (POS)</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

@if ($errors->any())
    <div class="alert alert-danger mx-5 mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('error_system'))
    <div class="alert alert-danger mx-5 mt-3 font-weight-bold">
        ⚠ {{ session('error_system') }}
    </div>
@endif
<div class="container py-5">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3 shadow-sm">⬅️ Kembali ke Dashboard</a>

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf
        <input type="hidden" name="idmargin_penjualan" value="{{ $marginActive->idmargin_penjualan ?? 1 }}">

        <div class="row">
            <!-- Panel Kiri: Form Input Transaksi -->
            <div class="col-md-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0 font-weight-bold">🛒 Keranjang Belanja</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Pilih Produk</label>
                            <select id="produk-select" class="form-control">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barang as $b)
                                    <option value="{{ $b->idbarang }}|{{ $b->nama_barang ?? $b->nama }}|{{ $b->harga }}">
                                        {{ $b->nama_barang ?? $b->nama }} (Rp {{ number_format($b->harga, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label class="font-weight-bold">Jumlah Beli</label>
                                <input type="number" id="produk-qty" class="form-control" value="1" min="1">
                            </div>
                            <div class="col-6 d-flex align-items-end">
                                <button type="button" id="btn-tambah" class="btn btn-success btn-block font-weight-bold">+ Tambah</button>
                            </div>
                        </div>

                        <table class="table table-bordered mt-4" id="tabel-keranjang">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Belanjaan Dinamis -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Panel Kanan: Kalkulator Pembayaran -->
            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0 font-weight-bold">💳 Total Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="text-muted mb-1">Subtotal Nilai</label>
                            <input type="number" name="subtotal_nilai" id="subtotal" class="form-control form-control-lg font-weight-bold" value="0" readonly>
                        </div>

                        <div class="form-group">
                            <label class="text-muted mb-1">PPN (11%)</label>
                            <input type="number" name="ppn" id="ppn" class="form-control" value="0" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label class="text-muted mb-1 text-danger font-weight-bold">Total Nilai Yang Harus Dibayar</label>
                            <input type="number" name="total_nilai" id="total_nilai" class="form-control form-control-lg font-weight-bold bg-light text-danger border-danger" value="0" readonly>
                        </div>

                        <button type="submit" class="btn btn-danger btn-lg btn-block font-weight-bold shadow-sm">Checkout Transaksi (SP) 🚀</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentSubtotal = 0;
        const btnTambah = document.getElementById('btn-tambah');
        const produkSelect = document.getElementById('produk-select');
        const produkQty = document.getElementById('produk-qty');
        const tabelKeranjangBody = document.querySelector('#tabel-keranjang tbody');

        const inputSubtotal = document.getElementById('subtotal');
        const inputPpn = document.getElementById('ppn');
        const inputTotalNilai = document.getElementById('total_nilai');

        btnTambah.addEventListener('click', function(e) {
            e.preventDefault();

            let rawData = produkSelect.value;

            if (!rawData || rawData === "") {
                alert('Silakan pilih barang terlebih dahulu!');
                return;
            }

            let splitData = rawData.split('|');
            let id = splitData[0];
            let nama = splitData[1];
            let harga = parseFloat(splitData[2]);
            let qty = parseInt(produkQty.value);

            if (isNaN(qty) || qty < 1) {
                alert('Jumlah beli minimal 1!');
                return;
            }

            let rowTotal = harga * qty;
            currentSubtotal += rowTotal;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    ${nama}
                    <input type="hidden" name="barang_id[]" value="${id}">
                    <input type="hidden" name="qty[]" value="${qty}">
                    <input type="hidden" name="harga_satuan[]" value="${harga}">
                </td>
                <td>Rp ${harga.toLocaleString('id-ID')}</td>
                <td>${qty}</td>
                <td>Rp ${rowTotal.toLocaleString('id-ID')}</td>
            `;
            tabelKeranjangBody.appendChild(newRow);

            let hitungPpn = Math.round(currentSubtotal * 0.11);
            let grandTotal = currentSubtotal + hitungPpn;

            inputSubtotal.value = currentSubtotal;
            inputPpn.value = hitungPpn;
            inputTotalNilai.value = grandTotal;

            produkSelect.value = '';
            produkQty.value = '1';
        });
    });
</script>

</body>
</html>
