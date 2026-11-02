<div class="container mt-5">
    <div class="jumbotron shadow-sm bg-white border">
        <h1 class="display-4 font-weight-bold">Halo, {{ session('username') }}! </h1>

        <hr class="my-4">

        <div class="row mt-4">
            @if(session('nama_role') == 'Superadmin')
                <div class="col-md-4 mb-3">
                    <div class="card bg-light border-left border-primary shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Master Barang</h5>
                            <p class="card-text text-muted">Kelola data barang, edit harga, dan cek satuan.</p>
                            <a href="{{ route('barang.index') }}" class="btn btn-primary btn-sm">Buka Kelola Barang</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-light border-left border-info shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Margin & Proyeksi</h5>
                            <p class="card-text text-muted">Lihat proyeksi harga jual</p>
                            <a href="#" class="btn btn-info btn-sm">Pantau Keuntungan</a>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('nama_role') == 'Kasir')
                <div class="col-md-4 mb-3">
                    <div class="card bg-light border-left border-success shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold"> Transaksi POS</h5>
                            <p class="card-text text-muted">Buka aplikasi kasir untuk melayani transaksi penjualan.</p>
<a href="{{ route('penjualan.index') }}" class="btn btn-success btn-sm font-weight-bold">
    Buka Kasir
</a>


                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-4 pt-3 border-top">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger font-weight-bold shadow-sm" onclick="return confirm('Apakah Anda yakin ingin keluar?')">🚪 Keluar dari Sistem</button>
            </form>
        </div>
    </div>
</div>
