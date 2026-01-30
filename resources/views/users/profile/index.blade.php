@extends('layouts.user')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
        }

        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            min-height: 100vh;
        }

        /* Top Navigation Bar */
        .top-navbar {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 16px 24px;
            display: grid;
            grid-template-columns: 60px 1fr 60px;
            align-items: center;
            gap: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .nav-logo {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 10px;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .nav-title {
            text-align: center;
            color: white;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .nav-settings {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
            text-decoration: none;
        }

        .nav-settings:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: rotate(90deg);
        }

        /* Profile Card Section */
        .profile-card {
            padding: 40px 24px;
            text-align: center;
            background: linear-gradient(180deg, #f8fafc 0%, white 100%);
        }

        .avatar-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
        }

        .avatar-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: 700;
            border: 5px solid white;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
            position: relative;
        }

        .avatar-edit-icon {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 36px;
            height: 36px;
            background: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            border: 3px solid white;
            cursor: pointer;
            transition: all 0.3s;
        }

        .avatar-edit-icon:hover {
            background: #2563eb;
            transform: scale(1.1);
        }

        .profile-name {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .profile-email {
            font-size: 15px;
            color: #64748b;
            margin-bottom: 24px;
        }

        .btn-edit-profile {
            background: #3b82f6;
            color: white;
            padding: 12px 32px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-edit-profile:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        /* Information List */
        .info-section {
            padding: 0 24px 24px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 24px 0 12px;
            margin: 0;
        }

        .info-list {
            list-style: none;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 18px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item:hover {
            background: #f8fafc;
        }

        .info-icon-box {
            width: 48px;
            height: 48px;
            background: #eff6ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 16px;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
            min-width: 0;
        }

        .info-label {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            color: #64748b;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .info-badge {
            background: #3b82f6;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-right: 8px;
        }

        .info-arrow {
            color: #cbd5e1;
            font-size: 20px;
            flex-shrink: 0;
        }

        /* Stats Section */
        .stats-section {
            padding: 0 24px 32px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .stat-box {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .stat-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 12px;
        }

        .stat-icon.blue { background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); }
        .stat-icon.green { background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); }
        .stat-icon.purple { background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%); }
        .stat-icon.orange { background: linear-gradient(135deg, #fb923c 0%, #f97316 100%); }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        /* Settings List */
        .settings-list {
            list-style: none;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .settings-item {
            display: flex;
            align-items: center;
            padding: 18px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .settings-item:last-child {
            border-bottom: none;
        }

        .settings-item:hover {
            background: #f8fafc;
        }

        .settings-item.logout {
            color: #ef4444;
        }

        .settings-item.logout .settings-icon-box {
            background: #fee2e2;
        }

        .settings-icon-box {
            width: 48px;
            height: 48px;
            background: #f1f5f9;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-right: 16px;
            flex-shrink: 0;
        }

        .settings-label {
            flex: 1;
            font-size: 16px;
            font-weight: 500;
            color: #1e293b;
        }

        .settings-item.logout .settings-label {
            color: #ef4444;
        }

        /* Footer */
        .profile-footer {
            text-align: center;
            padding: 32px 24px;
            color: #94a3b8;
            font-size: 13px;
        }

        .avatar-wrapper {
    position: relative;
    width: 130px;               /* ukuran lingkaran – lebih besar dari edit page */
    height: 130px;
    margin: 0 auto 24px;        /* jarak bawah ke nama */
}

.avatar-circle {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    overflow: hidden;
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 54px;            /* ukuran inisial lebih besar */
    font-weight: 700;
    border: 5px solid white;
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;          /* gambar mengisi penuh tanpa distorsi */
    object-position: center;
    display: block;
}

.avatar-initial {
    font-size: 54px;            /* inisial juga lebih besar */
}

/* Opsional: efek hover */
.avatar-wrapper:hover .avatar-circle {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

        /* Responsive */
        @media (min-width: 768px) {
            .profile-container {
                margin: 24px auto;
                border-radius: 24px;
                box-shadow: 0 8px 32px rgba(0,0,0,0.08);
                overflow: hidden;
            }

            .top-navbar {
                border-radius: 24px 24px 0 0;
            }

            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .info-section,
            .stats-section {
                padding-left: 40px;
                padding-right: 40px;
            }

            .profile-card {
                padding: 48px 40px;
            }
        }

        @media (max-width: 767px) {
            .top-navbar {
                padding: 14px 20px;
                grid-template-columns: 50px 1fr 50px;
            }

            .nav-logo {
                width: 44px;
                height: 44px;
            }

            .nav-title {
                font-size: 18px;
            }

            .nav-settings {
                width: 40px;
                height: 40px;
            }

            .profile-name {
                font-size: 24px;
            }

            .avatar-circle {
                width: 100px;
                height: 100px;
                font-size: 40px;
            }

            .avatar-wrapper {
                width: 100px;
                height: 100px;
            }
        }

        /* Animation */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide {
            animation: slideUp 0.5s ease-out forwards;
        }

        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }
    </style>

    <div class="profile-container">
        <!-- Top Navigation -->
        <nav class="top-navbar">
               <i class="fa-regular fa-user"></i>
            <h1 class="nav-title">My Profile</h1>
            <a class="nav-profile">
                <span style="font-size: 24px; color: white;"><i class="fa-solid fa-user"></i></span>
            </a>
        </nav>

        <!-- Profile Card -->
        <section class="profile-card">
            <div class="avatar-wrapper">
    @if($user->profile_photo_path)
        <div class="avatar-circle">
            <img src="{{ Storage::url($user->profile_photo_path) }}" 
                 alt="Foto Profil {{ $user->name }}" 
                 class="avatar-img">
            </div>
                @else
                    <div class="avatar-circle avatar-initial">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>
                @endif
            </div>
            <h2 class="profile-name">{{ $user->name }}</h2>
            <p class="profile-email">{{ $user->email }}</p>
            <a href="{{ route('user.profile.edit') }}" class="btn-edit-profile">Edit Profile</a>
        </section>

        <!-- Personal Information -->
        <section class="info-section">
            <h3 class="section-title">Personal Information</h3>
            <ul class="info-list">
                <li class="info-item animate-slide delay-1">
                    <div class="info-icon-box"><i class="fa-solid fa-house"></i>    </div>
                    <div class="info-content">
                        <div class="info-label">No. Rumah</div>
                        <div class="info-value">{{ $user->no_rumah ?? '-' }}</div>
                    </div>
                    <span class="info-arrow">›</span>
                </li>
                <li class="info-item animate-slide delay-2">
                    <div class="info-icon-box"><i class="fa-solid fa-phone"></i></div>
                    <div class="info-content">
                        <div class="info-label">No. Telepon</div>
                        <div class="info-value">{{ $user->no_tlp ?? '-' }}</div>
                    </div>
                    <span class="info-arrow">›</span>
                </li>
                <li class="info-item animate-slide delay-3">
                    <div class="info-icon-box"><i class="fa-solid fa-map-pin"></i></div>
                    <div class="info-content">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $user->alamat ?? '-' }}</div>
                    </div>
                    <span class="info-arrow">›</span>
                </li>
            </ul>
        </section>

        <!-- Activity Stats -->
        <section class="stats-section">
            <h3 class="section-title">Activity Overview</h3>
            <div class="stats-grid">
                <a href="#" class="stat-box animate-slide delay-2">
                    <div class="stat-icon green"><i class="fa-solid fa-rectangle-ad"></i></div>
                    <div class="stat-number">{{ $iklanCount }}</div>
                    <div class="stat-label">Iklan Saya</div>
                </a>
                <a href="{{ route('user.saran.index') }}" class="stat-box animate-slide delay-4">
                    <div class="stat-icon purple"><i class="fa-solid fa-comment-dots"></i></div>
                    <div class="stat-number">{{ $kritikCount }}</div>
                    <div class="stat-label">Kritik/Saran</div>
                </a>
            </div>
        </section>

        <!-- Settings & Actions -->
        <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" style="all: unset; width: 100%;">
        <section class="info-section">
            <ul class="settings-list">
                <li class="settings-item logout">
                    <div class="settings-icon-box">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </div>
                    <span class="settings-label">Log Out</span>
                    <span class="info-arrow">›</span>
                </li>
            </ul>
        </section>
    </button>
</form>


        <!-- Footer -->
        <footer class="profile-footer">
            <p>Digital Residence Version 1.0</p>
        </footer>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate numbers
        function animateNumber(id, target) {
            const element = document.getElementById(id);
            if (!element) return;
            
            let current = 0;
            const duration = 2000;
            const increment = target / (duration / 16);
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 16);
        }

        // Start animations
        setTimeout(() => {
            animateNumber('prospekCount', 0);
            animateNumber('ticketsCount', 0);
        }, 500);

    });
</script>
@endpush