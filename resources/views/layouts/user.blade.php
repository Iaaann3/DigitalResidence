<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Digital Residence')</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* ─── Base ─────────────────────────────────────────── */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* ─── Layout ────────────────────────────────────────── */
        .mobile-container      { max-width: 1200px; margin: 0 auto; background: white; min-height: 100vh; position: relative; overflow: hidden; }
        .header-section        { background: linear-gradient(135deg, #02409e 0%, #022a39 50%); color: white; padding: 40px 30px 140px; position: relative; border-radius: 30px 30px 0 0; }
        .profile-avatar        { position: absolute; top: 30px; right: 30px; width: 60px; height: 60px; background: rgba(255,255,255,.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255,255,255,.3); }
        .profile-avatar i      { font-size: 24px; color: white; }
        .greeting-text         { font-size: 16px; opacity: .9; margin-bottom: 8px; }
        .user-name             { font-size: 28px; font-weight: 700; margin: 0; }
        .balance-card          { position: absolute; bottom: -70px; left: 30px; right: 30px; background: white; border-radius: 20px; padding: 25px; box-shadow: 0 12px 40px rgba(0,0,0,.12); }
        .balance-info          { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .balance-label         { font-size: 14px; color: #6b7280; margin: 0 0 5px; }
        .balance-amount        { font-size: 32px; font-weight: 700; color: #111827; margin: 0; }
        .balance-detail        { font-size: 12px; color: #1e58d6; text-decoration: none; font-weight: 500; }
        .topup-btn             { background: #075498; color: white; border: none; border-radius: 14px; padding: 12px 24px; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .check-bill-btn        { background: #053480; color: white; border: none; border-radius: 18px; padding: 18px; font-size: 18px; font-weight: 600; width: 100%; margin: 40px 0; display: flex; align-items: center; justify-content: center; gap: 12px; }
        .main-content          { padding: 90px 30px 30px; }
        .section-title         { font-size: 22px; font-weight: 700; color: #111827; margin-bottom: 25px; }
        .service-grid          { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 25px; margin-bottom: 40px; max-width: 1200px; }
        .service-item          { text-align: center; text-decoration: none; color: inherit; }
        .service-icon          { width: 64px; height: 64px; background: #1868af; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: white; font-size: 24px; }
        .service-label         { font-size: 15px; font-weight: 600; color: #374151; }
        .info-section          { margin-top: 30px; }
        .info-header           { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .view-all-link         { color: #3b82f6; font-size: 14px; font-weight: 600; text-decoration: none; }
        .news-item             { display: flex; gap: 12px; padding: 10px 0; }
        .news-image            { width: 70px; height: 70px; border-radius: 8px; background: #e5e7eb; flex-shrink: 0; }
        .news-content h6       { font-size: 15px; font-weight: 600; color: #111827; margin: 0 0 4px; line-height: 1.3; }
        .news-content p        { font-size: 13px; color: #6b7280; margin: 0; line-height: 1.3; }

        /* ─── Responsive ────────────────────────────────────── */
        @media (max-width: 768px) {
            .mobile-container                { max-width: 400px; }
            .header-section                  { padding: 30px 20px 120px; }
            .profile-avatar                  { top: 20px; right: 20px; width: 50px; height: 50px; }
            .profile-avatar i                { font-size: 20px; }
            .greeting-text                   { font-size: 14px; margin-bottom: 5px; }
            .user-name                       { font-size: 22px; }
            .balance-card                    { bottom: -60px; left: 20px; right: 20px; padding: 20px; border-radius: 16px; }
            .balance-amount                  { font-size: 24px; }
            .topup-btn                       { padding: 10px 20px; font-size: 14px; border-radius: 12px; gap: 8px; }
            .check-bill-btn                  { border-radius: 16px; padding: 16px; font-size: 16px; margin: 30px 0; gap: 10px; }
            .main-content                    { padding: 80px 20px 20px; }
            .section-title                   { font-size: 18px; margin-bottom: 20px; }
            .service-grid                    { grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
            .service-icon                    { width: 56px; height: 56px; margin-bottom: 12px; font-size: 20px; }
            .service-label                   { font-size: 13px; }
            .news-image                      { width: 60px; height: 60px; }
            .news-content h6                 { font-size: 13px; }
            .news-content p                  { font-size: 11px; }
            .transition-logo                 { width: 100px; height: 100px; }
            .logo-image                      { width: 100px; height: 100px; }
            .transition-text .brand-name     { font-size: 20px; }
            .transition-text .brand-subtitle { font-size: 14px; }
        }

        /* ─── Page Transition ───────────────────────────────── */
        .transition-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #172e67 0%, #2d7087 50%, #358ade 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 5000;
            opacity: 0;
            visibility: hidden;
            transition: opacity .6s cubic-bezier(.25,.46,.45,.94),
                        visibility .6s cubic-bezier(.25,.46,.45,.94);
        }
        .transition-overlay.active        { opacity: 1; visibility: visible; }
        .transition-overlay.d-none        { display: flex !important; } /* override Bootstrap */

        .transition-logo-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        .transition-logo {
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: logoFloat 3s ease-in-out infinite;
        }
        .logo-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        .transition-text                     { color: white; text-align: center; margin-top: 20px; }
        .transition-text .brand-name         { font-size: 24px; font-weight: 700; letter-spacing: 1px; margin-bottom: 5px; }
        .transition-text .brand-subtitle     { font-size: 16px; font-weight: 400; opacity: .9; letter-spacing: 2px; }

        /* Floating particles */
        .particle {
            position: absolute;
            background: rgba(255,255,255,.1);
            border-radius: 50%;
            animation: particleFloat 4s ease-in-out infinite;
        }
        .particle:nth-child(1) { width: 4px; height: 4px; top: 20%; left: 15%;  animation-delay: 0s;   }
        .particle:nth-child(2) { width: 6px; height: 6px; top: 30%; right: 20%; animation-delay: 1s;   }
        .particle:nth-child(3) { width: 3px; height: 3px; top: 60%; left: 25%;  animation-delay: 2s;   }
        .particle:nth-child(4) { width: 5px; height: 5px; top: 70%; right: 30%; animation-delay: 1.5s; }
        .particle:nth-child(5) { width: 4px; height: 4px; top: 85%; left: 40%;  animation-delay: .5s;  }

        .loading-spinner  { margin-top: 40px; display: flex; gap: 8px; }
        .spinner-dot {
            width: 12px; height: 12px;
            background: rgba(255,255,255,.6);
            border-radius: 50%;
            animation: spinnerBounce 1.4s ease-in-out infinite both;
        }
        .spinner-dot:nth-child(1) { animation-delay: -.32s; }
        .spinner-dot:nth-child(2) { animation-delay: -.16s; }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0)     scale(1);    }
            50%       { transform: translateY(-20px) scale(1.08); }
        }
        @keyframes particleFloat {
            0%, 100% { transform: translateY(0)     scale(1);   opacity: .1; }
            25%       {                                           opacity: .3; }
            50%       { transform: translateY(-30px) scale(1.2); opacity: .6; }
            75%       {                                           opacity: .2; }
        }
        @keyframes spinnerBounce {
            0%, 80%, 100% { transform: scale(0); }
            40%            { transform: scale(1); }
        }

        @yield('styles')
    </style>
</head>
<body>

    @include('layouts.components.header')
    @yield('content')
    @stack('scripts')
    @include('layouts.components.bottomnav')

    <!-- Page Transition Overlay -->
    <div id="pageTransition" class="transition-overlay d-none">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>

        <div class="transition-logo-container">
            <div class="transition-logo">
                <img src="{{ asset('assets/images/logos/digital.png') }}"
                     alt="Digital Residence"
                     class="logo-image">
            </div>

            <div class="transition-text">
                <div class="brand-name">DIGITAL RESIDENCE</div>
                <div class="brand-subtitle">The Future of Residential Living</div>
            </div>

            <div class="loading-spinner">
                <div class="spinner-dot"></div>
                <div class="spinner-dot"></div>
                <div class="spinner-dot"></div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var overlay = document.getElementById('pageTransition');

            function showOverlay() {
                overlay.classList.remove('d-none');
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        overlay.classList.add('active');
                    });
                });
            }

            function hideOverlay() {
                overlay.classList.remove('active');
                setTimeout(function () { overlay.classList.add('d-none'); }, 600);
            }

            /* Intercept semua klik link internal */
            document.addEventListener('click', function (e) {
                var link = e.target.closest('a[href]');
                if (!link) return;

                var href = link.getAttribute('href');

                // Lewati: anchor, javascript, tab baru, download, link eksternal
                if (!href
                    || href.startsWith('#')
                    || href.startsWith('javascript')
                    || link.target === '_blank'
                    || link.hasAttribute('download')
                    || (href.startsWith('http') && !href.startsWith(window.location.origin))
                ) return;

                // Lewati kalau sudah di halaman yang sama
                try {
                    var dest = new URL(href, window.location.href);
                    if (dest.pathname === window.location.pathname
                        && dest.search === window.location.search) return;
                } catch (err) {}

                e.preventDefault();
                showOverlay();
                setTimeout(function () { window.location.href = href; }, 400);
            });

            // Sembunyikan overlay saat halaman selesai load (1.5 detik biar keliatan)
            window.addEventListener('pageshow', function () {
                setTimeout(hideOverlay, 1500);
            });

            // Back / Forward browser
            window.addEventListener('popstate', showOverlay);
        });
    </script>
</body>
</html>