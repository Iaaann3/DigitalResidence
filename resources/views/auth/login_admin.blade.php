@extends('layouts.app')

@section('content')
<div class="login-bg">
  <div class="login-card">

    <div class="login-logo-ring">
      <img src="{{ asset('assets/images/logos/digital.png') }}" alt="Logo">
    </div>

    <h1 class="login-app-name">Digital Residence</h1>

    <div class="login-badge-wrap">
      <span class="login-badge">
        <i class="fas fa-shield-alt"></i> Login Admin
      </span>
    </div>

    <form method="POST" action="{{ route('admin.login') }}">
      @csrf

      <div class="lf-field">
        <label class="lf-label" for="username">Username</label>
        <div class="lf-input-wrap">
          <i class="fas fa-user lf-icon"></i>
          <input id="username" type="text" name="username"
                 class="lf-input @error('username') is-invalid @enderror"
                 value="{{ old('username') }}" placeholder="Masukkan username"
                 required autofocus>
        </div>
        @error('username')
          <span class="lf-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="lf-field">
        <label class="lf-label" for="password">Password</label>
        <div class="lf-input-wrap">
          <i class="fas fa-lock lf-icon"></i>
          <input id="password" type="password" name="password"
                 class="lf-input @error('password') is-invalid @enderror"
                 placeholder="Masukkan password" required>
          <button type="button" class="lf-eye" onclick="togglePassword()">
            <i class="fas fa-eye" id="toggle-icon"></i>
          </button>
        </div>
        @error('password')
          <span class="lf-error">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit" class="lf-btn">
        <i class="fas fa-sign-in-alt"></i> Masuk sebagai Admin
      </button>

      <div class="lf-switch">
        Bukan admin? Login sebagai <a href="{{ route('login') }}">User</a>
      </div>

    </form>
  </div>
</div>

<style>
body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.login-bg {
    background: #f0f4f8;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    box-sizing: border-box;
}

.login-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    padding: 40px 36px;
    width: 100%;
    max-width: 380px;
    box-sizing: border-box;
    text-align: center;
}

/* Logo */
.login-logo-ring {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #E6F1FB;
    border: 2px solid #B5D4F4;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    overflow: hidden;
}
.login-logo-ring img {
    width: 52px;
    height: 52px;
    object-fit: contain;
    border-radius: 50%;
}

.login-app-name {
    font-size: 20px;
    font-weight: 600;
    color: #0f172a;
    margin: 0 0 10px;
}

/* Badge pill */
.login-badge-wrap { margin-bottom: 28px; }
.login-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #E6F1FB;
    color: #0C447C;
    font-size: 12px;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 100px;
    border: 1px solid #B5D4F4;
}

/* Field */
.lf-field { margin-bottom: 18px; text-align: left; }
.lf-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: .4px;
}
.lf-input-wrap { position: relative; }
.lf-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
    pointer-events: none;
}
.lf-input {
    width: 100%;
    padding: 11px 14px 11px 36px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    color: #0f172a;
    background: #fff;
    box-sizing: border-box;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.lf-input:focus {
    border-color: #378ADD;
    box-shadow: 0 0 0 3px rgba(55,138,221,.12);
}
.lf-input::placeholder { color: #cbd5e1; }
.lf-input.is-invalid { border-color: #E24B4A; }
.lf-eye {
    position: absolute;
    right: 11px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #94a3b8;
    padding: 4px;
    transition: color .2s;
}
.lf-eye:hover { color: #378ADD; }
.lf-error {
    display: block;
    font-size: 12px;
    color: #E24B4A;
    margin-top: 5px;
}

/* Submit */
.lf-btn {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    background: #185FA5;
    cursor: pointer;
    transition: background .2s, transform .15s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 6px;
}
.lf-btn:hover {
    background: #0C447C;
    transform: translateY(-1px);
}
.lf-btn:active { transform: translateY(0); }

/* Switch */
.lf-switch {
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1px solid #f1f5f9;
    font-size: 13px;
    color: #64748b;
}
.lf-switch a {
    color: #185FA5;
    text-decoration: none;
    font-weight: 600;
}
.lf-switch a:hover { text-decoration: underline; }
</style>

<script>
function togglePassword() {
    const inp = document.getElementById('password');
    const icon = document.getElementById('toggle-icon');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        inp.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endsection