@extends('layouts.app')

@section('title', 'Kasir Baru - Sistem POS')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 style="margin: 0 0 4px;">Transaksi Kasir Baru</h3>
            <p class="text-muted" style="margin: 0;">
                Margin Penjualan Aktif: <span class="badge badge-success">{{ $persenMargin }}%</span> (Termasuk PPN 11%)
            </p>
        </div>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary btn-sm">Kembali ke Riwayat</a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <form action="{{ route('penjualan.store') }}" method="POST" onsubmit="return confirm('Simpan transaksi penjualan ini?')">
            @csrf
            <div class="table-card" style="margin-bottom: 16px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Stok Tersedia</th>
                            <th>Harga Jual (+{{ $persenMargin }}%)</th>
                            <th width="16%">Jumlah Beli (Qty)</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $b)
                        <tr class="baris-item" data-harga="{{ $b->harga_jual }}">
                            <td>
                                <strong>{{ $b->nama_barang }}</strong>
                                <input type="hidden" name="barang_id[]" value="{{ $b->idbarang }}">
                            </td>
                            <td>{{ $b->nama_satuan }}</td>
                            <td>
                                @if($b->stok_tersedia > 0)
                                    <span class="badge badge-success">{{ $b->stok_tersedia }}</span>
                                @else
                                    <span class="badge badge-danger">Habis (0)</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($b->harga_jual, 0, ',', '.') }}</td>
                            <td>
                                <input type="number"
                                       name="qty[]"
                                       class="form-control input-qty"
                                       min="0"
                                       max="{{ $b->stok_tersedia }}"
                                       value="0"
                                       {{ $b->stok_tersedia <= 0 ? 'readonly' : '' }}>
                            </td>
                            <td class="text-right font-weight-bold text-subtotal">Rp 0</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #718096;">Tidak ada barang aktif.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="background: #f8f9fa; padding: 16px 20px; border-radius: 8px; border: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div class="text-muted">Subtotal: <strong id="labelSubtotal">Rp 0</strong> | PPN (11%): <strong id="labelPpn">Rp 0</strong></div>
                    <div style="font-size: 1.25rem; font-weight: 700; color: #1a736e; margin-top: 4px;">
                        Total Bayar: <span id="labelGrandTotal">Rp 0</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 0.95rem;">
                    Proses & Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    document.querySelectorAll('.input-qty').forEach(function(input) {
        input.addEventListener('input', function() {
            let subtotalAll = 0;
            document.querySelectorAll('.baris-item').forEach(function(row) {
                const harga = parseInt(row.getAttribute('data-harga')) || 0;
                const qtyInput = row.querySelector('.input-qty');
                const maxStok = parseInt(qtyInput.getAttribute('max')) || 0;
                let qty = parseInt(qtyInput.value) || 0;

                if (qty > maxStok) { qty = maxStok; qtyInput.value = maxStok; }
                if (qty < 0) { qty = 0; qtyInput.value = 0; }

                const sub = harga * qty;
                row.querySelector('.text-subtotal').textContent = formatRupiah(sub);
                subtotalAll += sub;
            });

            const ppn = Math.round(subtotalAll * 0.11);
            document.getElementById('labelSubtotal').textContent = formatRupiah(subtotalAll);
            document.getElementById('labelPpn').textContent = formatRupiah(ppn);
            document.getElementById('labelGrandTotal').textContent = formatRupiah(subtotalAll + ppn);
        });
    });
</script>
@endsection
