<header class="topbar">
    <strong></strong>
    <div class="d-flex align-items-center">
        <span class="text-muted">{{ session('username') }} - {{ session('nama_role') }}</span>
        <div class="user-badge-icon"></div>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm"
                onclick="return confirm('Yakin ingin keluar?')">Keluar</button>
        </form>
    </div>
</header>
