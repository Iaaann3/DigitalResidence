<nav class="sidebar-nav" style="overflow-y: hidden; height: auto; padding-left: 15px; padding-right: 15px;">
  <ul id="sidebarnav">

    {{-- GRUP: KEUANGAN --}}
    <li class="nav-small-cap">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">Keuangan</span>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}"
         href="{{ route('admin.pembayaran.index') }}">
        <span><i class="ti ti-cash"></i></span>
        <span class="hide-menu">Pembayaran</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link {{ request()->routeIs('admin.biaya_setting.*') ? 'active' : '' }}"
         href="{{ route('admin.biaya_setting.index') }}">
        <span><i class="ti ti-settings-dollar"></i></span>
        <span class="hide-menu">Biaya Setting</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link {{ request()->routeIs('admin.rekenings.*') ? 'active' : '' }}"
         href="{{ route('admin.rekenings.index') }}">
        <span><i class="ti ti-building-bank"></i></span>
        <span class="hide-menu">Rekening</span>
      </a>
    </li>

    {{-- GRUP: INFORMASI & KONTEN --}}
    <li class="nav-small-cap mt-2">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">Informasi & Konten</span>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link {{ request()->routeIs('admin.iklan.*') ? 'active' : '' }}"
         href="{{ route('admin.iklan.index') }}">
        <span><i class="ti ti-broadcast"></i></span>
        <span class="hide-menu">Iklan</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}"
         href="{{ route('admin.pengumuman.index') }}">
        <span><i class="fa fa-bullhorn"></i></span>
        <span class="hide-menu">Pengumuman</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}"
         href="{{ route('admin.kegiatan.index') }}">
        <span><i class="ti ti-calendar-event"></i></span>
        <span class="hide-menu">Kegiatan</span>
      </a>
    </li>

    {{-- GRUP: ASPIRASI WARGA --}}
    <li class="nav-small-cap mt-2">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">Aspirasi Warga</span>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link {{ request()->routeIs('admin.keluhan.*') ? 'active' : '' }}"
         href="{{ route('admin.keluhan.index') }}">
        <span><i class="ti ti-message-report"></i></span>
        <span class="hide-menu">Keluhan Warga</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link {{ request()->routeIs('admin.saran.*') ? 'active' : '' }}"
         href="{{ route('admin.saran.index') }}">
        <span><i class="ti ti-message-dots"></i></span>
        <span class="hide-menu">Saran & Kritik</span>
      </a>
    </li>

    {{-- GRUP: MANAJEMEN --}}
    <li class="nav-small-cap mt-2">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">Manajemen</span>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
         href="{{ route('admin.users.index') }}">
        <span><i class="fas fa-user"></i></span>
        <span class="hide-menu">User</span>
      </a>
    </li>

  </ul>
</nav>