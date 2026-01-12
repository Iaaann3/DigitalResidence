<div class="bottom-nav d-flex justify-content-between align-items-center bg-white shadow-sm border-top fixed-bottom" 
     style="z-index: 1030; padding: 6px 0;">

    <!-- Home -->
    <a href="{{ route('user.home.index') }}" 
       class="flex-fill text-center nav-item {{ request()->routeIs('user.home.index') ? 'text-success fw-bold' : 'text-muted' }}">
        <i class="fas fa-home fa-fw icon-nav"></i>
        <span class="nav-label">Home</span>
    </a>

    <!-- Kegiatan -->
    <a href="{{ route('user.kegiatan.index') }}" 
       class="flex-fill text-center nav-item {{ request()->routeIs('user.kegiatan.index') ? 'text-success fw-bold' : 'text-muted' }}">
        <i class="fas fa-flag fa-fw icon-nav"></i>
        <span class="nav-label">Kegiatan</span>
    </a>

    <!-- Payment History -->
    <a href="{{ route('user.pembayaran.index') }}" 
       class="flex-fill text-center nav-item {{ request()->routeIs('user.pembayaran.index') ? 'text-success fw-bold' : 'text-muted' }}">
        <i class="fas fa-history fa-fw icon-nav"></i>
        <span class="nav-label">Riwayat</span>
    </a>

    <!-- Pengumuman -->
    <a href="{{ route('user.pengumuman.index') }}" 
       class="flex-fill text-center nav-item {{ request()->routeIs('user.pengumuman.index') ? 'text-success fw-bold' : 'text-muted' }}">
        <i class="fas fa-bullhorn fa-fw icon-nav"></i>
        <span class="nav-label">Pengumuman</span>
    </a>

    <!-- Profile -->
    <a href="{{ route('user.profile.index') }}" 
       class="flex-fill text-center nav-item {{ request()->routeIs('user.profile.index') ? 'text-success fw-bold' : 'text-muted' }}">
        <i class="fas fa-user fa-fw icon-nav"></i>
        <span class="nav-label">Profil</span>
    </a>
</div>

<style>
.nav-item {
    display: flex;
    flex-direction: column;  /* susun vertikal */
    align-items: center;     /* sejajarkan tengah */
    justify-content: center;
    font-size: 12px;
}
.icon-nav {
    font-size: 16px;         /* kecilin ikon */
    margin-bottom: 2px;
}
.nav-label {
    font-size: 11px;
    line-height: 1.2;
}
.bottom-nav a {
    transition: color 0.2s;
    text-decoration: none;
}
.bottom-nav a:hover {
    color: #16a34a; /* hijau */
}
</style>
