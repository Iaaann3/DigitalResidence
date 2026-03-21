@extends('layouts.user')

@section('content')

<style>
body { background: #F5F7FA; }

.pgm {
    max-width: 960px;
    margin: 0 auto;
    padding: 36px 20px 100px;
}

/* ── Header ───────────────────────────────────────────── */
.pgm__header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 12px;
    animation: pgmUp .4s ease both;
}
.pgm__header-left {}
.pgm__eyebrow {
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: #2846a7;
    display: flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 6px;
}
.pgm__eyebrow::before {
    content: '';
    width: 18px; height: 2px;
    background: #2844a7;
    border-radius: 2px;
}
.pgm__title {
    font-size: clamp(1.5rem, 3.5vw, 2rem);
    font-weight: 800;
    color: #0F172A;
    letter-spacing: -.025em;
    line-height: 1.15;
}
.pgm__count {
    font-size: .75rem;
    font-weight: 600;
    color: #9CA3AF;
    margin-top: 4px;
}

/* ── List ─────────────────────────────────────────────── */
.pgm__list {
    display: flex;
    flex-direction: column;
    gap: 1px;
    background: #EBEBEB;
    border-radius: 16px;
    overflow: hidden;
    border: 1.5px solid #EBEBEB;
}

/* ── Card ─────────────────────────────────────────────── */
.pgm__card {
    background: white;
    display: grid;
    grid-template-columns: 4px 1fr;
    transition: background .15s;
    animation: pgmSlide .35s ease both;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
}
.pgm__card:hover { background: #FAFFFE; text-decoration: none; color: inherit; }

/* Stagger */
.pgm__card:nth-child(1) { animation-delay:.05s; }
.pgm__card:nth-child(2) { animation-delay:.09s; }
.pgm__card:nth-child(3) { animation-delay:.13s; }
.pgm__card:nth-child(4) { animation-delay:.17s; }
.pgm__card:nth-child(5) { animation-delay:.21s; }
.pgm__card:nth-child(n+6){ animation-delay:.25s; }

/* Left accent bar */
.pgm__bar { background: #E5E7EB; transition: background .2s; }
.pgm__card:hover .pgm__bar { background: #284aa7; }

/* Card inner */
.pgm__inner {
    padding: 20px 22px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
}

/* Date column */
.pgm__date-col {
    flex-shrink: 0;
    width: 44px;
    text-align: center;
    background: #F5F7FA;
    border-radius: 10px;
    padding: 8px 6px;
    border: 1.5px solid #F0F0F0;
    transition: border-color .2s, background .2s;
}
.pgm__card:hover .pgm__date-col {
    border-color: #C8ECD1;
    background: #F0FDF4;
}
.pgm__date-day {
    font-size: 1.1rem;
    font-weight: 800;
    color: #111;
    line-height: 1;
    display: block;
}
.pgm__date-mon {
    font-size: .55rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #283da7;
    display: block;
    margin-top: 2px;
}

/* Content */
.pgm__content { flex: 1; min-width: 0; }
.pgm__content-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 6px;
    flex-wrap: wrap;
}
.pgm__content-title {
    font-size: .95rem;
    font-weight: 700;
    color: #111827;
    line-height: 1.35;
    transition: color .2s;
}
.pgm__card:hover .pgm__content-title { color: #053f96; }

.pgm__content-body {
    font-size: .8rem;
    color: #6B7280;
    line-height: 1.6;
    margin-bottom: 12px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.pgm__content-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}
.pgm__author {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .72rem;
    color: #9CA3AF;
}
.pgm__author-av {
    width: 20px; height: 20px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2846a7, #2058c9);
    color: white;
    font-size: .6rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.pgm__cta {
    font-size: .72rem;
    font-weight: 700;
    color: #2850a7;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: gap .2s;
}
.pgm__card:hover .pgm__cta { gap: 8px; }
.pgm__cta i { font-size: .6rem; }

/* ── Desktop: 2-col layout ────────────────────────────── */
@media (min-width: 768px) {
    .pgm__layout {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 28px;
        align-items: start;
    }

    /* Sidebar */
    .pgm__sidebar {
        position: sticky;
        top: 24px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    /* Stat cards */
    .pgm__stat {
        background: white;
        border-radius: 14px;
        padding: 18px 18px;
        border: 1.5px solid #F0F0F0;
        transition: border-color .2s;
        animation: pgmUp .4s ease both;
    }
    .pgm__stat:hover { border-color: #C8ECD1; }
    .pgm__stat:nth-child(1) { animation-delay: .06s; }
    .pgm__stat:nth-child(2) { animation-delay: .10s; }
    .pgm__stat:nth-child(3) { animation-delay: .14s; }
    .pgm__stat-val {
        font-size: 1.5rem;
        font-weight: 800;
        color: #111;
        line-height: 1;
        margin-bottom: 4px;
    }
    .pgm__stat-val--green { color: #2850a7; }
    .pgm__stat-label {
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #ABABAB;
    }
    .pgm__stat-icon {
        font-size: .8rem;
        margin-bottom: 8px;
    }
    .pgm__stat-icon--green { color: #2857a7; }
    .pgm__stat-icon--gray  { color: #ABABAB; }
}

/* Mobile: hide sidebar */
@media (max-width: 767px) {
    .pgm__sidebar { display: none; }
    .pgm__layout  { display: block; }
    .pgm__header  { margin-bottom: 24px; }
}

/* ── Empty state ──────────────────────────────────────── */
.pgm__empty {
    background: white;
    border-radius: 16px;
    border: 1.5px solid #F0F0F0;
    padding: 80px 20px;
    text-align: center;
    animation: pgmUp .5s ease both;
}
.pgm__empty-icon { font-size: 2.5rem; margin-bottom: 14px; opacity: .35; }
.pgm__empty-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 5px;
}
.pgm__empty-sub { font-size: .82rem; color: #9CA3AF; margin-bottom: 20px; }
.pgm__empty-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ECFDF5;
    color: #284aa7;
    border: 1.5px solid #C8ECD1;
    border-radius: 8px;
    padding: 9px 18px;
    font-size: .82rem;
    font-weight: 700;
    text-decoration: none;
    transition: background .2s;
}
.pgm__empty-back:hover { background: #2831a7; color: white; text-decoration: none; }

/* ── Pagination ───────────────────────────────────────── */
.pgm__pagination {
    margin-top: 24px;
    display: flex;
    justify-content: center;
    animation: pgmUp .4s ease .3s both;
}

/* ── Keyframes ────────────────────────────────────────── */
@keyframes pgmUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes pgmSlide {
    from { opacity:0; transform:translateX(-6px); }
    to   { opacity:1; transform:translateX(0); }
}
</style>

<div class="pgm">

    {{-- Header --}}
    <div class="pgm__header">
        <div class="pgm__header-left">
            <div class="pgm__eyebrow">Digital Residence</div>
            <h1 class="pgm__title">Pengumuman</h1>
            @if(isset($pengumuman) && count($pengumuman) > 0)
            <div class="pgm__count">{{ count($pengumuman) }} pengumuman tersedia</div>
            @endif
        </div>
    </div>

    <div class="pgm__layout">

        {{-- ── Sidebar (desktop only) ─────────────────── --}}
        @if(isset($pengumuman) && count($pengumuman) > 0)
        <div class="pgm__sidebar">
            <div class="pgm__stat">
                <div class="pgm__stat-icon pgm__stat-icon--green">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="pgm__stat-val pgm__stat-val--green">{{ count($pengumuman) }}</div>
                <div class="pgm__stat-label">Total Pengumuman</div>
            </div>
            <div class="pgm__stat">
                <div class="pgm__stat-icon pgm__stat-icon--gray">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="pgm__stat-val">
                    {{ \Carbon\Carbon::parse($pengumuman->first()->created_at)->translatedFormat('M Y') }}
                </div>
                <div class="pgm__stat-label">Terbaru</div>
            </div>
            <div class="pgm__stat">
                <div class="pgm__stat-icon pgm__stat-icon--gray">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="pgm__stat-val" style="font-size:.95rem;">Digital Residence</div>
                <div class="pgm__stat-label">Lingkungan</div>
            </div>
        </div>
        @endif

        {{-- ── Main content ────────────────────────────── --}}
        <div>
            @if(isset($pengumuman) && count($pengumuman) > 0)

                <div class="pgm__list">
                    @foreach($pengumuman as $item)
                    <a href="{{ isset($item->id) ? route('user.pengumuman.show', $item->id) : '#' }}"
                       class="pgm__card">
                        <div class="pgm__bar"></div>
                        <div class="pgm__inner">

                            {{-- Date box --}}
                            <div class="pgm__date-col">
                                <span class="pgm__date-day">
                                    {{ isset($item->created_at) ? $item->created_at->format('d') : date('d') }}
                                </span>
                                <span class="pgm__date-mon">
                                    {{ isset($item->created_at) ? $item->created_at->format('M') : date('M') }}
                                </span>
                            </div>

                            {{-- Content --}}
                            <div class="pgm__content">
                                <div class="pgm__content-top">
                                    <div class="pgm__content-title">
                                        {{ $item->judul ?? 'Judul Pengumuman' }}
                                    </div>
                                </div>
                                <div class="pgm__content-body">
                                    {{ Str::limit($item->isi ?? 'Konten pengumuman tidak tersedia.', 120) }}
                                </div>
                                <div class="pgm__content-footer">
                                    <div class="pgm__author">
                                        <div class="pgm__author-av">
                                            {{ strtoupper(substr($item->author ?? 'A', 0, 1)) }}
                                        </div>
                                        {{ $item->author ?? 'Admin' }}
                                    </div>
                                    <span class="pgm__cta">
                                        Baca selengkapnya
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if(method_exists($pengumuman, 'links'))
                <div class="pgm__pagination">
                    {{ $pengumuman->links('pagination::tailwind') }}
                </div>
                @endif

            @else

                {{-- Empty state --}}
                <div class="pgm__empty">
                    <div class="pgm__empty-icon">📭</div>
                    <div class="pgm__empty-title">Belum ada pengumuman</div>
                    <div class="pgm__empty-sub">Pengumuman terbaru akan muncul di sini</div>
                    <a href="javascript:history.back()" class="pgm__empty-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

            @endif
        </div>

    </div>
</div>

@endsection