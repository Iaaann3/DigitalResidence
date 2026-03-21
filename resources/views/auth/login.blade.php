@extends('layouts.app')

@section('content')

<!-- Login Loading Overlay -->
<div id="loginOverlay" class="login-overlay">
    <div class="login-overlay__inner">
        <img src="{{ asset('assets/images/logos/digital.png') }}"
             alt="Digital Residence"
             class="login-overlay__logo">
        <div class="login-overlay__ring">
            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <circle class="ring-track" cx="50" cy="50" r="42"/>
                <circle class="ring-spin"  cx="50" cy="50" r="42"/>
            </svg>
        </div>
        <p class="login-overlay__text">Sedang masuk<span>.</span><span>.</span><span>.</span></p>
    </div>
</div>

<div class="login-container">
    <div class="logo">
        <img src="{{ asset('assets/images/logos/digital.png') }}" alt="Logo">
    </div>
    <h1 class="residence-name">Digital Residence</h1>

    <form class="login-form" method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        @if (session('error'))
            <div class="alert alert-danger" style="border-radius:10px;margin-bottom:20px;padding:15px;background:rgba(231,76,60,.1);border:1px solid #e74c3c;backdrop-filter:blur(5px);">
                {{ session('error') }}
            </div>
        @endif

        <div class="input-group">
            <input id="no_rumah" type="text"
                   class="@error('no_rumah') is-invalid @enderror"
                   name="no_rumah" value="{{ old('no_rumah') }}"
                   placeholder="No. Rumah" required autofocus>
            @error('no_rumah')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="input-group password-group">
            <input id="password" type="password"
                   class="@error('password') is-invalid @enderror"
                   name="password" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePassword()">
                <i class="fas fa-eye" id="toggle-icon"></i>
            </span>
            @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <button type="submit" class="submit-btn" id="submitBtn">
            <span id="btnText">Submit</span>
        </button>
    </form>

    <div class="divider"><span>atau</span></div>

    <a href="{{ route('google.login') }}" class="google-login-btn">
        <img src="https://www.google.com/favicon.ico" alt="Google Icon" class="google-icon">
        <span>Login dengan Google</span>
    </a><br>

    <div class="contact-admin-link">
        <i class="fas fa-question-circle"></i> Belum terdaftar?
        <a href="https://wa.me/628815873744?text=Halo%20Admin,%20saya%20belum%20terdaftar%20di%20sistem."
           target="_blank" class="btn-outline-success btn-sm">
            <i class="ti ti-brand-whatsapp"></i> Hubungi Admin
        </a>
    </div>
</div>

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background: linear-gradient(to bottom, #a8dadc, #f1faee);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        color: #333;
        width: 100%;
    }

    /* ─── Login Overlay ────────────────────────────────── */
    .login-overlay {
        position: fixed;
        inset: 0;
        background: linear-gradient(135deg, #172e67 0%, #2d7087 50%, #358ade 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: opacity .4s ease, visibility .4s ease;
    }
    .login-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .login-overlay__inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0;
        position: relative;
    }

    /* Logo di tengah ring — overlap ke atas ring */
    .login-overlay__logo {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        position: relative;
        z-index: 2;
        margin-bottom: -106px; /* tarik ke bawah masuk ke tengah ring (140/2 - 72/2 = 34px, plus ring margin) */
        animation: overlayLogoPulse 1.8s ease-in-out infinite;
    }
    @keyframes overlayLogoPulse {
        0%, 100% { transform: scale(1); }
        50%       { transform: scale(1.07); }
    }

    /* SVG spinner ring */
    .login-overlay__ring {
        width: 140px;
        height: 140px;
        margin-bottom: 28px;
    }
    .login-overlay__ring svg { width: 100%; height: 100%; transform: rotate(-90deg); }

    .ring-track {
        fill: none;
        stroke: rgba(255,255,255,.15);
        stroke-width: 6;
    }
    .ring-spin {
        fill: none;
        stroke: white;
        stroke-width: 6;
        stroke-linecap: round;
        stroke-dasharray: 264;        /* 2 * π * 42 ≈ 264 */
        stroke-dashoffset: 200;
        animation: ringRotate 1.4s ease-in-out infinite;
        filter: drop-shadow(0 0 6px rgba(255,255,255,.6));
    }
    @keyframes ringRotate {
        0%   { stroke-dashoffset: 240; transform-origin: 50% 50%; transform: rotate(0deg); }
        50%  { stroke-dashoffset: 60; }
        100% { stroke-dashoffset: 240; transform-origin: 50% 50%; transform: rotate(360deg); }
    }

    /* Loading text */
    .login-overlay__text {
        font-size: 15px;
        color: rgba(255,255,255,.85);
        letter-spacing: .08em;
        font-weight: 500;
    }
    .login-overlay__text span {
        display: inline-block;
        animation: dotBlink 1.2s ease-in-out infinite;
    }
    .login-overlay__text span:nth-child(2) { animation-delay: .2s; }
    .login-overlay__text span:nth-child(3) { animation-delay: .4s; }
    @keyframes dotBlink {
        0%, 100% { opacity: .2; }
        50%       { opacity: 1;  }
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%       { transform: translateX(-8px); }
        40%       { transform: translateX(8px); }
        60%       { transform: translateX(-5px); }
        80%       { transform: translateX(5px); }
    }

    /* ─── Login Container ──────────────────────────────── */
    .login-container {
        background: rgba(255,255,255,.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,.1);
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }

    .logo { display: flex; justify-content: center; align-items: center; margin-bottom: 20px; }
    .logo img { width: 100px; height: 100px; border-radius: 50%; background-color: #f1faee; border: 3px solid #457b9d; padding: 10px; object-fit: contain; }

    .residence-name { font-size: 24px; font-weight: 600; color: #457b9d; margin: 0 0 30px; }

    .login-form { width: 100%; }

    /* Inputs */
    .input-group { margin-bottom: 20px; position: relative; width: 100%; }
    .input-group input { width: 100%; padding: 15px 20px; border: none; border-radius: 10px; background-color: rgba(255,255,255,.5); font-size: 16px; color: #457b9d; transition: background-color .3s; }
    .input-group input:focus { outline: none; background-color: rgba(255,255,255,.8); box-shadow: 0 0 0 3px rgba(69,123,157,.3); }
    .input-group input::placeholder { color: rgba(69,123,157,.7); }
    .input-group .is-invalid { border: 2px solid #e74c3c; }
    .invalid-feedback { color: #e74c3c; font-size: 12px; position: absolute; bottom: -18px; left: 0; text-align: left; }

    /* Password toggle */
    .password-group { position: relative; }
    .toggle-password { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: rgba(69,123,157,.7); z-index: 10; transition: color .3s; padding: 5px; }
    .toggle-password:hover { color: #457b9d; }
    .toggle-password i { font-size: 16px; }

    /* Submit button */
    .submit-btn {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 600;
        color: white;
        background: linear-gradient(to right, #20535a, #197072);
        cursor: pointer;
        transition: background .3s, transform .2s, opacity .2s;
        position: relative;
        overflow: hidden;
    }
    .submit-btn:hover   { background: linear-gradient(to right, #18156b, #144c52); transform: translateY(-2px); }
    .submit-btn.loading { opacity: .75; cursor: not-allowed; transform: none; }

    /* Google button */
    .google-login-btn { display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #ddd; border-radius: 10px; padding: 12px 20px; text-decoration: none; color: #444; font-weight: 500; transition: all .3s; box-shadow: 0 2px 5px rgba(0,0,0,.1); margin-top: 20px; width: 100%; }
    .google-login-btn:hover { background: #f7f7f7; box-shadow: 0 4px 8px rgba(0,0,0,.15); transform: translateY(-2px); }
    .google-icon { width: 20px; height: 20px; margin-right: 12px; flex-shrink: 0; }

    /* Divider */
    .divider { position: relative; margin: 25px 0; text-align: center; color: #666; font-size: 14px; }
    .divider::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #ddd; z-index: 1; }
    .divider span { position: relative; background: rgba(255,255,255,.2); backdrop-filter: blur(10px); padding: 0 15px; z-index: 2; }

    /* Contact */
    .contact-admin-link { font-size: 14px; margin-top: 20px; color: #457b9d; text-align: center; line-height: 1.6; }
    .contact-admin-link a { color: #457b9d; text-decoration: none; font-weight: 500; border-bottom: 1px solid transparent; transition: border-bottom .3s; display: inline-block; margin-top: 5px; }
    .contact-admin-link a:hover { border-bottom: 1px solid #457b9d; }

    .alert { width: 100%; }

    /* ─── Responsive ────────────────────────────────────── */
    @media (max-width: 768px) {
        body { padding: 20px; }
        .login-container { padding: 35px 30px; max-width: 100%; }
    }
    @media (max-width: 480px) {
        body { padding: 15px; }
        .login-container { padding: 30px 25px; }
        .logo img { width: 85px; height: 85px; }
        .residence-name { font-size: 22px; margin-bottom: 25px; }
        .input-group { margin-bottom: 18px; }
        .input-group input { padding: 14px 18px; font-size: 15px; }
        .submit-btn { padding: 14px; font-size: 17px; }
        .google-login-btn { padding: 11px 18px; font-size: 14px; }
        .google-icon { width: 18px; height: 18px; }
        .contact-admin-link { font-size: 13px; margin-top: 18px; }
        .divider { margin: 20px 0; }
        .login-overlay__ring { width: 120px; height: 120px; }
        .login-overlay__logo { width: 60px; height: 60px; margin-bottom: -90px; }
    }
    @media (max-width: 360px) {
        body { padding: 10px; }
        .login-container { padding: 25px 20px; }
        .logo img { width: 75px; height: 75px; }
        .residence-name { font-size: 20px; margin-bottom: 20px; }
        .input-group input { padding: 12px 16px; font-size: 14px; }
        .submit-btn { padding: 12px; font-size: 16px; }
        .google-login-btn { padding: 10px 15px; font-size: 13px; }
        .contact-admin-link { font-size: 12px; }
    }
    @media (max-width: 320px) {
        .login-container { padding: 20px 15px; }
        .input-group input { padding: 11px 14px; font-size: 13px; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    /* ── Toggle password ── */
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('toggle-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    /* ── Login via AJAX — overlay hanya muncul kalau sukses ── */
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var form    = this;
        var btn     = document.getElementById('submitBtn');
        var btnText = document.getElementById('btnText');
        var overlay = document.getElementById('loginOverlay');

        /* Validasi HTML5 dulu */
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        /* Disable tombol & ubah teks saat request berlangsung */
        btn.classList.add('loading');
        btn.disabled  = true;
        btnText.textContent = 'Memeriksa...';

        fetch(form.action, {
            method:  'POST',
            body:    new FormData(form),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.success) {
                /* ✅ Login berhasil — tampilkan overlay, lalu redirect */
                overlay.style.display = 'flex';
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        overlay.classList.add('active');
                        setTimeout(function () {
                            /* Sembunyikan overlay sebelum redirect
                               biar browser tidak cache state overlay = visible */
                            overlay.classList.remove('active');
                            overlay.style.opacity = '0';
                            setTimeout(function () {
                                window.location.href = data.redirect_url;
                            }, 300);
                        }, 1000); /* overlay keliatan ~1 detik */
                    });
                });
            } else {
                /* ❌ Login gagal — tampilkan pesan error, reset tombol */
                showError(data.message || 'No. Rumah atau password salah.');
                resetBtn();
            }
        })
        .catch(function () {
            /* Network error — fallback submit biasa */
            form.submit();
        });

        function resetBtn() {
            btn.classList.remove('loading');
            btn.disabled        = false;
            btnText.textContent = 'Submit';
        }

        function showError(msg) {
            /* Hapus alert lama kalau ada */
            var old = document.getElementById('loginError');
            if (old) old.remove();

            var alert = document.createElement('div');
            alert.id  = 'loginError';
            alert.style.cssText = 'border-radius:10px;margin-bottom:20px;padding:15px;background:rgba(231,76,60,.1);border:1px solid #e74c3c;backdrop-filter:blur(5px);color:#e74c3c;font-size:14px;text-align:left;';
            alert.textContent = msg;

            /* Sisipkan di atas input pertama */
            form.insertBefore(alert, form.firstChild);

            /* Shake animation pada form */
            form.style.animation = 'shake .4s ease';
            setTimeout(function () { form.style.animation = ''; }, 400);
        }
    });
</script>

@endsection