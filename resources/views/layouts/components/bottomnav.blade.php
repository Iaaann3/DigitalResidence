<style>
/* ── Wrapper ─────────────────────────────────────────── */
.bn {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    z-index: 1000;
    display: flex;
    justify-content: center;
    pointer-events: none;
}

.bn__bar {
    width: 100%;
    max-width: 480px;
    background: white;
    border-top: 1px solid #F0F0F0;
    box-shadow: 0 -8px 32px rgba(0,0,0,.08);
    border-radius: 20px 20px 0 0;
    padding: 8px 12px 12px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    pointer-events: all;
    position: relative;
}

/* ── Nav item ────────────────────────────────────────── */
.bn__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 12px;
    transition: background .15s;
    flex: 1;
    min-width: 0;
}
.bn__item:hover { background: #F8F8F8; text-decoration: none; }
.bn__item:active { background: #F0F0F0; }

.bn__icon {
    font-size: 1.1rem;
    color: #BDBDBD;
    transition: color .2s, transform .2s;
    line-height: 1;
}
.bn__label {
    font-size: .6rem;
    font-weight: 600;
    color: #BDBDBD;
    letter-spacing: .02em;
    transition: color .2s;
    white-space: nowrap;
}

/* Active state */
.bn__item.active .bn__icon  { color: #284ea7; }
.bn__item.active .bn__label { color: #284ea7; }
.bn__item.active .bn__icon  { transform: translateY(-1px); }

/* Active dot indicator */
.bn__item.active::after {
    content: '';
    position: absolute;
    bottom: 6px;
    width: 4px; height: 4px;
    background: #284ea7;
    border-radius: 50%;
}

/* ── Center FAB (transaksi — DANA style) ─────────────── */
.bn__fab-wrap {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    position: relative;
    margin-top: -28px; /* angkat ke atas */
}

.bn__fab {
    width: 54px; height: 54px;
    background: linear-gradient(135deg, #284aa7, #203cc9);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    text-decoration: none;
    box-shadow: 0 6px 20px rgba(40, 76, 167, 0.4);
    transition: transform .2s, box-shadow .2s;
    border: 3px solid white;
}
.bn__fab:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 28px rgba(40, 55, 167, 0.5);
    text-decoration: none;
    color: white;
}
.bn__fab:active { transform: scale(.95); }

.bn__fab-label {
    font-size: .6rem;
    font-weight: 700;
    color: #2841a7;
    letter-spacing: .02em;
    margin-top: 2px;
}

/* ── Profile item (foto) ─────────────────────────────── */
.bn__profile {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 12px;
    transition: background .15s;
    flex: 1;
}
.bn__profile:hover { background: #F8F8F8; text-decoration: none; }

.bn__avatar {
    width: 26px; height: 26px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #BDBDBD;
    transition: border-color .2s;
}
.bn__avatar--active { border-color: #282aa7; }

.bn__avatar-fallback {
    width: 26px; height: 26px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2855a7, #2031c9);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: .65rem;
    font-weight: 700;
    border: 2px solid #BDBDBD;
    transition: border-color .2s;
}
.bn__profile.active .bn__avatar,
.bn__profile.active .bn__avatar-fallback { border-color: #283fa7; }

.bn__profile-label {
    font-size: .6rem;
    font-weight: 600;
    color: #BDBDBD;
    transition: color .2s;
}
.bn__profile.active .bn__profile-label { color: #283ba7; }

/* Safe area (iPhone notch) */
@media (max-width: 480px) {
    .bn__bar { padding-bottom: env(safe-area-inset-bottom, 12px); }
}

/* ── Desktop (>768px) ────────────────────────────────── */
@media (min-width: 800px) {
    .bn {
        justify-content: center;
    }
    .bn__bar {
        max-width: 720px;
        border-radius: 20px 20px 0 0;
        border-left: 1px solid #F0F0F0;
        border-right: 1px solid #F0F0F0;
        padding: 10px 32px 14px;
        gap: 8px;
    }

    /* Item lebih lebar di desktop, icon + label sejajar */
    .bn__item {
        flex-direction: row;
        gap: 7px;
        padding: 10px 16px;
        justify-content: center;
    }
    .bn__icon { font-size: 1rem; }
    .bn__label {
        font-size: .78rem;
        font-weight: 600;
    }

    /* FAB lebih besar di desktop */
    .bn__fab-wrap { margin-top: -24px; }
    .bn__fab {
        width: 52px; height: 52px;
        font-size: 1.1rem;
    }
    .bn__fab-label { font-size: .72rem; }

    /* Profile row */
    .bn__profile {
        flex-direction: row;
        gap: 7px;
        padding: 10px 16px;
        justify-content: center;
    }
    .bn__avatar, .bn__avatar-fallback {
        width: 24px; height: 24px;
    }
    .bn__profile-label {
        font-size: .78rem;
        font-weight: 600;
    }

    /* Active dot position di desktop */
    .bn__item.active::after {
        bottom: 4px;
    }
}
</style>

@php
    $currentRoute = request()->route()?->getName() ?? '';
@endphp

<nav class="bn" aria-label="Bottom Navigation">
    <div class="bn__bar">

        {{-- Home --}}
        <a href="{{ route('user.home.index') }}"
           class="bn__item {{ str_starts_with($currentRoute, 'user.home') ? 'active' : '' }}">
            <i class="fas fa-home bn__icon"></i>
            <span class="bn__label">Beranda</span>
        </a>

        {{-- Kegiatan — sesuaikan route kalau beda --}}
        <a href="{{ route('user.kegiatan.index') }}"
           class="bn__item {{ str_starts_with($currentRoute, 'user.kegiatan') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt bn__icon"></i>
            <span class="bn__label">Kegiatan</span>
        </a>

        {{-- CENTER FAB — Transaksi --}}
        <div class="bn__fab-wrap">
            <a href="{{ route('user.pembayaran.index') }}" class="bn__fab">
                <i class="fas fa-history"></i>
            </a>
            <span class="bn__fab-label">Transaksi</span>
        </div>

        {{-- Pengumuman --}}
        <a href="{{ route('user.pengumuman.index') }}"
           class="bn__item {{ str_starts_with($currentRoute, 'user.pengumuman') ? 'active' : '' }}">
            <i class="fas fa-bullhorn bn__icon"></i>
            <span class="bn__label">Info</span>
        </a>

        {{-- Profile (dengan foto) --}}
        <a href="{{ route('user.profile.index') }}"
           class="bn__profile {{ in_array($currentRoute, ['profile.index','profile.edit']) ? 'active' : '' }}">
            @if(Auth::user()->profile_photo_path ?? null)
                <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                     alt="{{ Auth::user()->name }}"
                     class="bn__avatar {{ in_array($currentRoute, ['profile.index','profile.edit']) ? 'bn__avatar--active' : '' }}">
            @else
                <div class="bn__avatar-fallback {{ in_array($currentRoute, ['profile.index','profile.edit']) ? 'bn__avatar--active' : '' }}">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
            @endif
            <span class="bn__profile-label">Profil</span>
        </a>

    </div>
</nav>

{{-- Spacer biar konten tidak ketutup bottom nav --}}
<div style="height: 72px;"></div>