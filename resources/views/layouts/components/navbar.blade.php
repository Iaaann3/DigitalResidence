<header class="topbar">
    <div class="with-vertical">
        <nav class="navbar navbar-expand-lg p-2">
            <div class="container-fluid">

                {{-- Toggle sidebar desktop --}}
                <li class="nav-item nav-icon-hover-bg rounded-circle ms-n2 list-unstyled">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>

                {{-- Toggler mobile --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="ti ti-dots fs-7"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="d-flex align-items-center w-100 justify-content-between">

                        {{-- Brand --}}
                        <h5 class="mb-0 text-uppercase fw-bold text-primary">
                            Digital <span class="fw-normal text-muted">Residence</span>
                        </h5>

                        {{-- Navbar kanan --}}
                        <ul class="navbar-nav flex-row align-items-center">

                            {{-- Dark/Light Mode --}}
                            <li class="nav-item me-2">
                                <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                    <i class="ti ti-moon"></i>
                                </a>
                                <a class="nav-link sun light-layout" href="javascript:void(0)">
                                    <i class="ti ti-sun"></i>
                                </a>
                            </li>

                            {{-- Profile Dropdown --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link d-flex align-items-center gap-2 pe-0"
                                   href="javascript:void(0)"
                                   id="profileDropdown"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">

                                    {{-- Avatar: foto atau inisial --}}
                                    @if(Auth::user()->foto)
                                        <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                                             class="rounded-circle border border-2 border-primary"
                                             width="35" height="35"
                                             style="object-fit:cover;"
                                             alt="{{ Auth::user()->name }}">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                             style="width:35px; height:35px; font-size:14px;">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <span class="d-none d-md-block fw-semibold" style="font-size:13px;">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <i class="ti ti-chevron-down d-none d-md-block" style="font-size:12px;"></i>
                                </a>

                                {{-- Dropdown Menu --}}
                                <ul class="dropdown-menu dropdown-menu-end mt-2 shadow rounded-3 p-0 overflow-hidden"
                                    style="min-width:260px;">

                                    {{-- Header profil --}}
                                    <li class="px-3 py-3 border-bottom"
                                        style="background: linear-gradient(135deg, #1e3a8a, #2563eb);">
                                        <div class="d-flex align-items-center gap-3">
                                            @if(Auth::user()->foto)
                                                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                                                     class="rounded-circle border border-2 border-white"
                                                     width="50" height="50"
                                                     style="object-fit:cover;">
                                            @else
                                                <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center fw-bold"
                                                     style="width:50px; height:50px; font-size:18px; flex-shrink:0;">
                                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-white" style="font-size:14px;">
                                                    {{ Auth::user()->name }}
                                                </div>
                                                <small class="text-white-50">
                                                    {{ Auth::user()->email }}
                                                </small>
                                                <div class="mt-1">
                                                    <span class="badge bg-white text-primary" style="font-size:10px;">
                                                        {{ ucfirst(Auth::user()->role ?? 'Admin') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    {{-- Logout --}}
                                    <li class="px-3 py-2">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        </form>
                                        <a href="#"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                           class="dropdown-item text-danger d-flex align-items-center gap-2 px-0">
                                            <i class="ti ti-logout"></i> Logout
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>