@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="logo">
        <img src="{{ asset('assets/images/logos/digital.png') }}" alt="Logo">
    </div>
    <h1 class="residence-name">Digital Residence</h1>

    <!-- Form Login Biasa -->
    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf

        @if (session('error'))
            <div class="alert alert-danger" style="border-radius: 10px; margin-bottom: 20px; padding: 15px; background: rgba(231, 76, 60, 0.1); border: 1px solid #e74c3c; backdrop-filter: blur(5px);">
                {{ session('error') }}
            </div>
        @endif

        <div class="input-group">
            <input id="no_rumah" type="text" class="@error('no_rumah') is-invalid @enderror" name="no_rumah" value="{{ old('no_rumah') }}" placeholder="No. Rumah" required autofocus>
            @error('no_rumah')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Input Password dengan Toggle Eye -->
        <div class="input-group password-group">
            <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePassword()">
                <i class="fas fa-eye" id="toggle-icon"></i>
            </span>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        
        <button type="submit" class="submit-btn">
            Submit
        </button>
    </form>

    <div class="divider">
        <span>atau</span>
    </div>

    <!-- Tombol Login Google -->
    <a href="{{ route('google.login') }}" class="google-login-btn">
        <img src="https://www.google.com/favicon.ico" alt="Google Icon" class="google-icon">
        <span>Login dengan Google</span>
    </a><br>
        
    <div class="contact-admin-link">
        <i class="fas fa-question-circle"></i> Belum terdaftar? 
        <a href="https://wa.me/628815873744?text=Halo%20Admin,%20saya%20belum%20terdaftar%20di%20sistem." 
        target="_blank" 
        class=" btn-outline-success btn-sm">
            <i class="ti ti-brand-whatsapp"></i> WhatsApp Admin
        </a>
    </div>
</div>

<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background: linear-gradient(to bottom, #a8dadc, #f1faee);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        color: #333333;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        box-sizing: border-box;
    }

    .logo img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #f1faee;
        border: 3px solid #457b9d;
        padding: 10px;
    }

    .residence-name {
        font-size: 24px;
        font-weight: 600;
        color: #457b9d;
        margin: 20px 0;
    }

    /* Form Input Styles */
    .input-group {
        margin-bottom: 20px;
        position: relative;
    }

    .input-group input {
        width: 100%;
        padding: 15px 20px;
        border: none;
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.5);
        font-size: 16px;
        color: #457b9d;
        transition: background-color 0.3s;
        box-sizing: border-box;
    }
    
    .input-group input:focus {
        outline: none;
        background-color: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 0 3px rgba(69, 123, 157, 0.3);
    }
    
    .input-group input::placeholder {
        color: rgba(69, 123, 157, 0.7);
    }

    .input-group .is-invalid {
        border: 2px solid #e74c3c;
    }

    .invalid-feedback {
        color: #e74c3c;
        font-size: 12px;
        position: absolute;
        bottom: -18px;
        left: 0;
    }

    /* Tambahan: Style untuk Password Toggle */
    .password-group {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: rgba(69, 123, 157, 0.7);
        z-index: 10;
        transition: color 0.3s;
        padding: 5px;
    }

    .toggle-password:hover {
        color: #457b9d;
    }

    .toggle-password i {
        font-size: 16px;
    }

    .contact-admin-link {
        font-size: 14px;
        margin-bottom: 25px;
        color: #457b9d;
    }
    
    .contact-admin-link a {
        color: #457b9d;
        text-decoration: none;
        font-weight: 500;
        border-bottom: 1px solid transparent;
        transition: border-bottom 0.3s;
    }
    
    .contact-admin-link a:hover {
        border-bottom: 1px solid #457b9d;
    }

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
        transition: background-color 0.3s, transform 0.2s;
        margin-bottom: 25px;
    }

    .submit-btn:hover {
        background: linear-gradient(to right, #18156b, #144c52);
        transform: translateY(-2px);
    }

    /* Google Login Button Styles */
    .google-login-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 12px 20px;
        text-decoration: none;
        color: #444;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-top: 20px;
    }

    .google-login-btn:hover {
        background: #f7f7f7;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    .google-icon {
        width: 20px;
        height: 20px;
        margin-right: 12px;
    }

    /* Divider Styles */
    .divider {
        position: relative;
        margin: 25px 0;
        text-align: center;
        color: #666;
        font-size: 14px;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #ddd;
        z-index: 1;
    }

    .divider span {
        position: relative;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0 15px;
        z-index: 2;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .login-container {
            padding: 30px 20px;
            margin: 0 15px;
        }
        
        .residence-name {
            font-size: 20px;
        }
        
        .google-login-btn {
            padding: 10px 15px;
            font-size: 14px;
        }
        
        .google-icon {
            width: 18px;
            height: 18px;
        }
    }
</style>

<!-- Font Awesome untuk icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggle-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>

@endsection