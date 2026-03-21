@extends('layouts.user')

@section('content')

<style>
/* ── Base ─────────────────────────────────────────────── */
body { background: #F7F8FC; }

.kg-show {
    max-width: 720px;
    margin: 0 auto;
    padding: 36px 20px 100px;
}

/* ── Back nav ─────────────────────────────────────────── */
.kg-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .8rem;
    font-weight: 600;
    color: #6B7280;
    text-decoration: none;
    letter-spacing: .04em;
    text-transform: uppercase;
    margin-bottom: 28px;
    transition: color .2s, gap .2s;
    animation: kgUp .4s ease both;
}
.kg-back:hover { color: #1a73e8; gap: 12px; text-decoration: none; }
.kg-back i { font-size: .75rem; }

/* ── Meta bar ─────────────────────────────────────────── */
.kg-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 18px;
    animation: kgUp .4s ease .05s both;
}
.kg-tag {
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 100px;
    background: #EBF3FE;
    color: #1a73e8;
}
.kg-meta-date, .kg-meta-loc {
    font-size: .78rem;
    color: #9CA3AF;
    display: flex;
    align-items: center;
    gap: 5px;
}
.kg-meta-date i, .kg-meta-loc i { color: #1a73e8; font-size: .7rem; }
.kg-meta-sep {
    width: 3px; height: 3px;
    background: #D1D5DB;
    border-radius: 50%;
}

/* ── Title ────────────────────────────────────────────── */
.kg-title {
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 800;
    color: #0F172A;
    line-height: 1.25;
    letter-spacing: -.025em;
    margin-bottom: 24px;
    animation: kgUp .4s ease .1s both;
}

/* ── Image ────────────────────────────────────────────── */
.kg-img-wrap {
    border-radius: 18px;
    overflow: hidden;
    margin-bottom: 32px;
    animation: kgUp .5s ease .15s both;
    position: relative;
    background: #E5E7EB;
}
.kg-img-wrap img {
    width: 100%;
    height: 340px;
    object-fit: cover;
    display: block;
    transition: transform .6s ease;
}
.kg-img-wrap:hover img { transform: scale(1.03); }

/* Blue line overlay bawah gambar */
.kg-img-wrap::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #1a73e8, #60aff5);
}

/* ── Divider ──────────────────────────────────────────── */
.kg-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    animation: kgUp .4s ease .2s both;
}
.kg-divider__line {
    flex: 1;
    height: 1px;
    background: #E5E7EB;
}
.kg-divider__dot {
    width: 6px; height: 6px;
    background: #1a73e8;
    border-radius: 50%;
}

/* ── Body text ────────────────────────────────────────── */
.kg-body {
    font-size: .95rem;
    color: #374151;
    line-height: 1.85;
    margin-bottom: 32px;
    animation: kgUp .4s ease .25s both;
}

/* ── Info cards ───────────────────────────────────────── */
.kg-info-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 36px;
    animation: kgUp .4s ease .3s both;
}
@media (max-width: 480px) { .kg-info-row { grid-template-columns: 1fr; } }

.kg-info-card {
    background: white;
    border: 1.5px solid #F0F2F8;
    border-radius: 14px;
    padding: 16px 18px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    transition: border-color .2s, box-shadow .2s;
}
.kg-info-card:hover {
    border-color: #BFD7F8;
    box-shadow: 0 4px 16px rgba(26,115,232,.08);
}
.kg-info-icon {
    width: 36px; height: 36px;
    background: #EBF3FE;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1a73e8;
    font-size: .85rem;
    flex-shrink: 0;
}
.kg-info-label {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #9CA3AF;
    margin-bottom: 3px;
}
.kg-info-value {
    font-size: .88rem;
    font-weight: 600;
    color: #1F2937;
    line-height: 1.3;
}

/* ── Footer action ────────────────────────────────────── */
.kg-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 24px;
    border-top: 1.5px solid #F0F2F8;
    animation: kgUp .4s ease .35s both;
}
.kg-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #EBF3FE;
    color: #1a73e8;
    font-size: .85rem;
    font-weight: 700;
    padding: 11px 20px;
    border-radius: 10px;
    text-decoration: none;
    transition: background .2s, transform .2s;
    border: 1.5px solid #BFD7F8;
}
.kg-back-btn:hover {
    background: #1a73e8;
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
    border-color: #1a73e8;
}
.kg-share-note {
    font-size: .75rem;
    color: #D1D5DB;
    letter-spacing: .04em;
}

/* ── Keyframes ────────────────────────────────────────── */
@keyframes kgUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
}

@media (max-width: 480px) {
    .kg-img-wrap img { height: 220px; }
    .kg-footer { flex-direction: column; gap: 12px; align-items: flex-start; }
    .kg-back-btn { width: 100%; justify-content: center; }
}
</style>

<div class="kg-show">

    {{-- Back nav --}}
    <a href="{{ route('user.kegiatan.index') }}" class="kg-back">
        <i class="fas fa-arrow-left"></i> Semua Kegiatan
    </a>

    {{-- Meta --}}
    <div class="kg-meta">
        <span class="kg-tag">Kegiatan</span>
        <span class="kg-meta-sep"></span>
        <span class="kg-meta-date">
            <i class="fas fa-calendar-alt"></i>
            {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}
        </span>
        @if($kegiatan->lokasi)
        <span class="kg-meta-sep"></span>
        <span class="kg-meta-loc">
            <i class="fas fa-map-marker-alt"></i>
            {{ $kegiatan->lokasi }}
        </span>
        @endif
    </div>

    {{-- Title --}}
    <h1 class="kg-title">{{ ucfirst($kegiatan->nama_kegiatan ?? 'Nama Kegiatan') }}</h1>

    {{-- Image --}}
    @if($kegiatan->gambar)
    <div class="kg-img-wrap">
        <img src="{{ asset('storage/'.$kegiatan->gambar) }}"
             alt="{{ $kegiatan->nama_kegiatan }}">
    </div>
    @endif

    {{-- Divider --}}
    <div class="kg-divider">
        <div class="kg-divider__line"></div>
        <div class="kg-divider__dot"></div>
        <div class="kg-divider__line"></div>
    </div>

    {{-- Body --}}
    <div class="kg-body">
        {{ $kegiatan->deskripsi ?? 'Deskripsi kegiatan tidak tersedia.' }}
    </div>

    {{-- Info cards --}}
    <div class="kg-info-row">
        <div class="kg-info-card">
            <div class="kg-info-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
                <div class="kg-info-label">Tanggal</div>
                <div class="kg-info-value">
                    {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}
                </div>
            </div>
        </div>
        <div class="kg-info-card">
            <div class="kg-info-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div>
                <div class="kg-info-label">Lokasi</div>
                <div class="kg-info-value">
                    {{ $kegiatan->lokasi ?? 'Tidak ditentukan' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="kg-footer">
        <a href="{{ route('user.kegiatan.index') }}" class="kg-back-btn">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Daftar
        </a>
        <span class="kg-share-note">Digital Residence</span>
    </div>

</div>

@endsection