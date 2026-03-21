@extends('layouts.user')

@section('content')

<style>
/* ── Base ─────────────────────────────────────────────── */
body {
    background: #F5F6FA;
    min-height: 100vh;
}

.kg-wrapper {
    max-width: 960px;
    margin: 0 auto;
    padding: 32px 20px 80px;
}

/* ── Header ───────────────────────────────────────────── */
.kg-header {
    margin-bottom: 32px;
    animation: kgFadeDown .5s ease both;
}
.kg-header__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #2833a7;
    margin-bottom: 8px;
}
.kg-header__eyebrow span {
    width: 20px;
    height: 2px;
    background: #2850a7;
    display: inline-block;
    border-radius: 2px;
}
.kg-header__title {
    font-size: clamp(1.6rem, 4vw, 2.2rem);
    font-weight: 800;
    color: #111827;
    letter-spacing: -.02em;
    line-height: 1.15;
    margin: 0 0 6px;
}
.kg-header__sub {
    font-size: .9rem;
    color: #6b7280;
}

/* ── Counter chip ─────────────────────────────────────── */
.kg-count {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: white;
    border: 1.5px solid #E5E7EB;
    border-radius: 100px;
    padding: 5px 14px;
    font-size: .78rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 24px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.kg-count__dot {
    width: 7px; height: 7px;
    background: #18377a;
    border-radius: 50%;
    animation: kgPulse 1.8s ease-in-out infinite;
}
@keyframes kgPulse {
    0%,100% { transform: scale(1); opacity:1; }
    50%      { transform: scale(1.5); opacity:.5; }
}

/* ── Masonry ──────────────────────────────────────────── */
.kg-masonry {
    columns: 3;
    column-gap: 18px;
}
@media (max-width: 768px) { .kg-masonry { columns: 2; } }
@media (max-width: 480px) { .kg-masonry { columns: 1; } }

/* ── Card ─────────────────────────────────────────────── */
.kg-card {
    break-inside: avoid;
    background: #ffffff;
    border-radius: 16px;
    border: 1.5px solid #F0F0F0;
    overflow: hidden;
    margin-bottom: 18px;
    display: block;
    text-decoration: none;
    color: inherit;
    transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    animation: kgFadeUp .5s ease both;
    position: relative;
}
.kg-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0,0,0,.09);
    border-color: #D1FAE5;
    text-decoration: none;
    color: inherit;
}

/* Stagger */
.kg-card:nth-child(1)  { animation-delay: .05s; }
.kg-card:nth-child(2)  { animation-delay: .10s; }
.kg-card:nth-child(3)  { animation-delay: .15s; }
.kg-card:nth-child(4)  { animation-delay: .20s; }
.kg-card:nth-child(5)  { animation-delay: .25s; }
.kg-card:nth-child(6)  { animation-delay: .30s; }
.kg-card:nth-child(7)  { animation-delay: .35s; }
.kg-card:nth-child(8)  { animation-delay: .40s; }
.kg-card:nth-child(9)  { animation-delay: .45s; }

/* Top accent bar */
.kg-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #1e2e89, #122088);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .3s ease;
}
.kg-card:hover::before { transform: scaleX(1); }

/* Card body */
.kg-card__body { padding: 18px 18px 14px; }

/* Tags row */
.kg-card__tags {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
    flex-wrap: wrap;
    gap: 6px;
}
.kg-tag {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 100px;
    background: #ECFDF5;
    color: #0a1d89;
}
.kg-location {
    font-size: 11px;
    color: #9CA3AF;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Title */
.kg-card__title {
    font-size: .97rem;
    font-weight: 700;
    color: #111827;
    line-height: 1.4;
    margin-bottom: 8px;
    transition: color .2s;
}
.kg-card:hover .kg-card__title { color: #0d1f79; }

/* Date */
.kg-card__date {
    font-size: .78rem;
    color: #9CA3AF;
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 10px;
}
.kg-card__date i { color: #3128a7; font-size: .7rem; }

/* Desc */
.kg-card__desc {
    font-size: .82rem;
    color: #6B7280;
    line-height: 1.6;
    margin-bottom: 14px;
}

/* Footer */
.kg-card__footer {
    border-top: 1px solid #F3F4F6;
    padding: 12px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.kg-card__cta {
    font-size: .78rem;
    font-weight: 700;
    color: #2831a7;
    display: flex;
    align-items: center;
    gap: 5px;
    letter-spacing: .02em;
    transition: gap .2s;
}
.kg-card:hover .kg-card__cta { gap: 9px; }
.kg-card__arrow {
    width: 22px; height: 22px;
    background: #ECFDF5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .65rem;
    color: #144771;
    transition: background .2s, transform .2s;
}
.kg-card:hover .kg-card__arrow {
    background: #0c275d;
    color: white;
    transform: translateX(3px);
}

/* ── Empty state ──────────────────────────────────────── */
.kg-empty {
    text-align: center;
    padding: 80px 20px;
    animation: kgFadeUp .5s ease both;
}
.kg-empty__icon {
    font-size: 3rem;
    margin-bottom: 16px;
    opacity: .4;
}
.kg-empty__title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 6px;
}
.kg-empty__sub { font-size: .85rem; color: #9CA3AF; }

/* ── Pagination ───────────────────────────────────────── */
.kg-pagination {
    margin-top: 40px;
    display: flex;
    justify-content: center;
    animation: kgFadeUp .6s ease .3s both;
}

/* ── Keyframes ────────────────────────────────────────── */
@keyframes kgFadeDown {
    from { opacity:0; transform:translateY(-16px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes kgFadeUp {
    from { opacity:0; transform:translateY(20px); }
    to   { opacity:1; transform:translateY(0); }
}
</style>

<div class="kg-wrapper">

    {{-- Header --}}
    <div class="kg-header">
        
        <h1 class="kg-header__title">Kegiatan Terbaru</h1>
        <p class="kg-header__sub">Temukan berbagai kegiatan menarik di lingkungan Anda</p>
    </div>

    @if($kegiatan->isEmpty())

        {{-- Empty state --}}
        <div class="kg-empty">
            <div class="kg-empty__icon">📭</div>
            <div class="kg-empty__title">Belum ada kegiatan</div>
            <div class="kg-empty__sub">Kegiatan akan muncul di sini saat tersedia</div>
        </div>

    @else

        {{-- Counter chip --}}
        <div class="kg-count">
            <span class="kg-count__dot"></span>
            {{ $kegiatan->total() }} Kegiatan tersedia
        </div>

        {{-- Masonry grid --}}
        <div class="kg-masonry">
            @foreach($kegiatan as $item)
            <a href="{{ route('user.kegiatan.show', $item->id) }}" class="kg-card">

                <div class="kg-card__body">
                    {{-- Tags row --}}
                    <div class="kg-card__tags">
                        <span class="kg-tag">🗓 Kegiatan</span>
                        <span class="kg-location">
                            <i class="fas fa-map-marker-alt" style="font-size:.65rem;color:#28a745;"></i>
                            {{ Str::limit($item->lokasi, 22) }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <div class="kg-card__title">{{ ucfirst($item->nama_kegiatan) }}</div>

                    {{-- Date --}}
                    <div class="kg-card__date">
                        <i class="fas fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                    </div>

                    {{-- Desc — panjang random biar masonry keliatan --}}
                    <div class="kg-card__desc">
                        {{ Str::limit($item->deskripsi, rand(80, 140)) }}
                    </div>
                </div>

                {{-- Footer --}}
                <div class="kg-card__footer">
                    <span class="kg-card__cta">
                        Lihat Detail
                        <span class="kg-card__arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </span>
                </div>

            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="kg-pagination">
            {{ $kegiatan->links('pagination::tailwind') }}
        </div>

    @endif

</div>

@endsection