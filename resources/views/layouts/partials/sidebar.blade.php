<aside class="sidebar">
    <div class="sidebar-brand">Menanggal Mart</div>
    <div class="sidebar-menu">
        <a href="{{ route('dashboard') }}"
            class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>

        @if (session('nama_role') == 'Superadmin')
            <div class="menu-header">Master Data</div>
            <a href="{{ route('master.role') }}"
                class="nav-link-custom {{ request()->routeIs('master.role*') ? 'active' : '' }}">Role</a>
            <a href="{{ route('master.user') }}"
                class="nav-link-custom {{ request()->routeIs('master.user*') ? 'active' : '' }}">User</a>
            <a href="{{ route('master.satuan') }}"
                class="nav-link-custom {{ request()->routeIs('master.satuan*') ? 'active' : '' }}">Satuan</a>
            <a href="{{ route('master.vendor') }}"
                class="nav-link-custom {{ request()->routeIs('master.vendor*') ? 'active' : '' }}">Vendor</a>
            <a href="{{ route('barang.index') }}"
                class="nav-link-custom {{ request()->routeIs('barang.*') ? 'active' : '' }}">Barang</a>
            <a href="{{ route('master.margin') }}"
                class="nav-link-custom {{ request()->routeIs('master.margin*') ? 'active' : '' }}">
                Margin Penjualan
            </a>
        @endif

        <div class="menu-header">Transaksi</div>
        @if (in_array(session('nama_role'), ['Superadmin', 'Gudang']))
            <a href="{{ route('pengadaan.index') }}"
                class="nav-link-custom {{ request()->routeIs('pengadaan.*') ? 'active' : '' }}">Pengadaan</a>
            <a href="{{ route('penerimaan.index') }}"
                class="nav-link-custom {{ request()->routeIs('penerimaan.*') ? 'active' : '' }}">Penerimaan</a>
        @endif

        @if (in_array(session('nama_role'), ['Superadmin', 'Kasir']))
            <a href="{{ route('penjualan.index') }}"
                class="nav-link-custom {{ request()->routeIs('penjualan.*') ? 'active' : '' }}">Penjualan
                (Kasir)</a>
        @endif
    </div>
</aside>
