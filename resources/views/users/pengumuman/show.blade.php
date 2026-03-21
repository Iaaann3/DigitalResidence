@extends('layouts.user')

@section('content')

<style>
body { background: #F5F7FA; }

.pgm-show {
    max-width: 860px;
    margin: 0 auto;
    padding: 36px 24px 100px;
}

/* ── Back nav ─────────────────────────────────────────── */
.pgm-show__back-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    animation: showUp .35s ease both;
}
.pgm-show__back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .78rem;
    font-weight: 700;
    color: #6B7280;
    text-decoration: none;
    letter-spacing: .04em;
    transition: color .2s, gap .2s;
}
.pgm-show__back-btn:hover { color: #283fa7; gap: 12px; text-decoration: none; }
.pgm-show__back-btn i { font-size: .7rem; }
.pgm-show__breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .72rem;
    color: #C4C9D4;
}
.pgm-show__breadcrumb a {
    color: #C4C9D4;
    text-decoration: none;
    transition: color .15s;
}
.pgm-show__breadcrumb a:hover { color: #2839a7; }
.pgm-show__breadcrumb i { font-size: .55rem; }

/* ── Article card ─────────────────────────────────────── */
.pgm-show__card {
    background: white;
    border-radius: 18px;
    border: 1.5px solid #F0F0F0;
    overflow: hidden;
    animation: showUp .4s ease .05s both;
}

/* Meta strip */
.pgm-show__meta {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    padding: 24px 32px 0;
    margin-bottom: 14px;
}
.pgm-show__tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .68rem;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
    background: #ECFDF5;
    color: #052e96;
    padding: 4px 11px;
    border-radius: 100px;
}
.pgm-show__meta-sep { width: 3px; height: 3px; border-radius: 50%; background: #D1D5DB; }
.pgm-show__meta-info {
    font-size: .75rem;
    color: #9CA3AF;
    display: flex;
    align-items: center;
    gap: 5px;
}
.pgm-show__meta-info i { font-size: .65rem; color: #2839a7; }

/* Title */
.pgm-show__title {
    font-size: clamp(1.3rem, 3vw, 1.75rem);
    font-weight: 800;
    color: #0F172A;
    letter-spacing: -.025em;
    line-height: 1.25;
    padding: 0 32px;
    margin-bottom: 24px;
}

/* Image */
.pgm-show__img-wrap {
    position: relative;
    overflow: hidden;
    background: #F0F0F0;
}
.pgm-show__img-wrap img {
    width: 100%;
    height: 380px;
    object-fit: cover;
    display: block;
    transition: transform .6s ease;
}
.pgm-show__img-wrap:hover img { transform: scale(1.02); }
.pgm-show__img-wrap::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #283da7, #202ec9);
}

/* Body */
.pgm-show__body-wrap {
    padding: 28px 32px 24px;
}

/* Divider */
.pgm-show__divider {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 22px;
}
.pgm-show__divider-line { flex: 1; height: 1px; background: #F0F0F0; }
.pgm-show__divider-dot  { width: 5px; height: 5px; border-radius: 50%; background: #282ea7; flex-shrink: 0; }

/* Article text */
.pgm-show__body {
    font-size: .95rem;
    color: #374151;
    line-height: 1.9;
    margin-bottom: 28px;
}

/* Info row */
.pgm-show__info-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 0;
}
@media (max-width: 520px) { .pgm-show__info-row { grid-template-columns: 1fr; } }

.pgm-show__info-card {
    background: #F8FAF8;
    border: 1.5px solid #EBEBEB;
    border-radius: 12px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: border-color .2s;
}
.pgm-show__info-card:hover { border-color: #C8ECD1; }
.pgm-show__info-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    background: #ECFDF5;
    color: #2848a7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .78rem;
    flex-shrink: 0;
}
.pgm-show__info-label {
    font-size: .62rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: #9CA3AF;
    margin-bottom: 2px;
}
.pgm-show__info-val {
    font-size: .83rem;
    font-weight: 700;
    color: #1F2937;
    line-height: 1.3;
}

/* Footer */
.pgm-show__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1.5px solid #F3F4F6;
    padding: 16px 32px;
    flex-wrap: wrap;
    gap: 10px;
}
.pgm-show__footer-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ECFDF5;
    color: #2833a7;
    border: 1.5px solid #C8ECD1;
    border-radius: 9px;
    padding: 10px 18px;
    font-size: .82rem;
    font-weight: 700;
    text-decoration: none;
    transition: background .2s, color .2s, transform .15s;
}
.pgm-show__footer-back:hover {
    background: #283ba7;
    color: white;
    transform: translateY(-1px);
    text-decoration: none;
}
.pgm-show__footer-note {
    font-size: .7rem;
    color: #C4C9D4;
    letter-spacing: .04em;
}

/* ── Responsive ──────────────────────────────────────── */
@media (max-width: 600px) {
    .pgm-show { padding: 20px 12px 80px; }
    .pgm-show__meta, .pgm-show__title { padding-left: 20px; padding-right: 20px; }
    .pgm-show__body-wrap { padding: 20px 20px 18px; }
    .pgm-show__footer { padding: 14px 20px; }
    .pgm-show__img-wrap img { height: 220px; }
    .pgm-show__footer-back { width: 100%; justify-content: center; }
    .pgm-show__breadcrumb { display: none; }
}

/* ── Keyframes ───────────────────────────────────────── */
@keyframes showUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}
</style>

<div class="pgm-show">

    {{-- Back nav + breadcrumb --}}
    <div class="pgm-show__back-nav">
        <a href="{{ route('user.pengumuman.index') }}" class="pgm-show__back-btn">
            <i class="fas fa-arrow-left"></i> Semua Pengumuman
        </a>
        <div class="pgm-show__breadcrumb">
            <a href="{{ route('user.home.index') }}">Beranda</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('user.pengumuman.index') }}">Pengumuman</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ Str::limit($pengumuman->judul ?? 'Detail', 32) }}</span>
        </div>
    </div>

    {{-- Article card --}}
    <div class="pgm-show__card">

        {{-- Meta --}}
        <div class="pgm-show__meta">
            <span class="pgm-show__tag">
                <i class="fas fa-bullhorn"></i> Pengumuman
            </span>
            <span class="pgm-show__meta-sep"></span>
            <span class="pgm-show__meta-info">
                <i class="fas fa-calendar-alt"></i>
                {{ isset($pengumuman->tanggal)
                    ? \Carbon\Carbon::parse($pengumuman->tanggal)->translatedFormat('d F Y')
                    : \Carbon\Carbon::parse($pengumuman->created_at)->translatedFormat('d F Y') }}
            </span>
            <span class="pgm-show__meta-sep"></span>
            <span class="pgm-show__meta-info">
                <i class="fas fa-user"></i>
                {{ $pengumuman->author ?? 'Admin' }}
            </span>
        </div>

        {{-- Title --}}
        <h1 class="pgm-show__title">
            {{ ucfirst($pengumuman->judul ?? 'Judul Pengumuman') }}
        </h1>

        {{-- Image --}}
        @if($pengumuman->gambar)
        <div class="pgm-show__img-wrap">
            <img src="{{ asset('storage/'.$pengumuman->gambar) }}"
                 alt="{{ $pengumuman->judul }}">
        </div>
        @endif

        {{-- Body --}}
        <div class="pgm-show__body-wrap">

            <div class="pgm-show__divider">
                <div class="pgm-show__divider-line"></div>
                <div class="pgm-show__divider-dot"></div>
                <div class="pgm-show__divider-line"></div>
            </div>

            <div class="pgm-show__body">
                {{ $pengumuman->isi ?? 'Konten pengumuman tidak tersedia.' }}
            </div>

            {{-- Info cards --}}
            <div class="pgm-show__info-row">
                <div class="pgm-show__info-card">
                    <div class="pgm-show__info-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="pgm-show__info-label">Tanggal</div>
                        <div class="pgm-show__info-val">
                            {{ isset($pengumuman->tanggal)
                                ? \Carbon\Carbon::parse($pengumuman->tanggal)->translatedFormat('d F Y')
                                : \Carbon\Carbon::parse($pengumuman->created_at)->translatedFormat('d F Y') }}
                        </div>
                    </div>
                </div>
                <div class="pgm-show__info-card">
                    <div class="pgm-show__info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="pgm-show__info-label">Lingkungan</div>
                        <div class="pgm-show__info-val">Digital Residence</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="pgm-show__footer">
            <a href="{{ route('user.pengumuman.index') }}" class="pgm-show__footer-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <span class="pgm-show__footer-note">Digital Residence</span>
        </div>

    </div>

</div>

@endsection