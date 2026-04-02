<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/digital1.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
  <title>Digital Residence</title>
  <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />
  <style>
    /* Hilangkan scroll sidebar */
    .left-sidebar {
      overflow-y: hidden !important;
    }
    .sidebar-nav {
      overflow-y: hidden !important;
      height: auto !important;
    }
    /* Brand section di sidebar */
    .sidebar-brand-box {
      text-align: center;
      padding: 20px 16px 12px;
      border-bottom: 1px solid rgba(0,0,0,0.08);
    }
    .sidebar-brand-box .brand-logo-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid var(--bs-primary);
      margin-bottom: 12px;
    }
    .sidebar-brand-box .admin-icon {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background: var(--bs-primary);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      margin: 0 auto 8px;
    }
    .sidebar-brand-box .admin-name {
      font-size: 13px;
      font-weight: 600;
      color: #333;
    }
    .sidebar-brand-box .admin-badge {
      font-size: 10px;
      padding: 2px 8px;
      border-radius: 20px;
      background: rgba(var(--bs-primary-rgb), 0.12);
      color: var(--bs-primary);
      display: inline-block;
      margin-top: 4px;
    }
    /* Saat collapsed sembunyikan brand text */
    .left-sidebar.mini-sidebar .sidebar-brand-box .hide-on-collapse {
      display: none !important;
    }
  </style>
</head>

<body>

  <div id="main-wrapper">

    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical" id="sidebarDesktop">


      @include('layouts.components.sidebar')
    </aside>
    <!-- Sidebar End -->

    <div class="page-wrapper" style="padding-top: 100px;">
      @include('layouts.components.navbar')

      <div class="container-fluid">
        @yield('content')
        @stack('scripts')
      </div>
    </div>

  </div>

  <!-- JS -->
  <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
  <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
  <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
  <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="{{ asset('assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboards/dashboard.js') }}"></script>

  <script>
    const sidebarToggle = document.getElementById('headerCollapse');
    const sidebar       = document.getElementById('sidebarDesktop');
    const sidebarLogo   = document.getElementById('sidebarLogo');

    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('mini-sidebar');

      const isCollapsed = sidebar.classList.contains('mini-sidebar');
      sidebarLogo.style.width  = isCollapsed ? '40px'  : '80px';
      sidebarLogo.style.height = isCollapsed ? '40px'  : '80px';
    });
  </script>

</body>
</html>