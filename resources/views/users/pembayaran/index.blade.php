@extends('layouts.user')

@section('content')

<style>
body { background: #F5F7FA; }

/* ══════════════════════════════════════════
   LAYOUT WRAPPER
   ══════════════════════════════════════════ */
.ph {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 0 100px;
}

/* ── Top bar ─────────────────────────────── */
.ph__topbar {
    background: white;
    padding: 18px 28px;
    position: sticky;
    top: 0;
    z-index: 100;
    border-bottom: 1px solid #F0F0F0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ph__topbar-title {
    font-size: 1rem;
    font-weight: 700;
    color: #111;
}
.ph__topbar-sub {
    font-size: .75rem;
    color: #ABABAB;
}

/* ── Desktop grid ────────────────────────── */
.ph__desktop {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 0;
    align-items: start;
}

/* ── LEFT PANEL (hero + stats) ───────────── */
.ph__left {
    position: sticky;
    top: 57px; /* topbar height */
    height: calc(100vh - 57px);
    overflow-y: auto;
    border-right: 1px solid #F0F0F0;
    background: white;
    display: flex;
    flex-direction: column;
}

/* Hero */
.ph__hero {
    background: linear-gradient(145deg, #2848a7 0%, #1a4d8c 100%);
    padding: 32px 28px 44px;
    color: white;
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
}
.ph__hero::after {
    content: '';
    position: absolute;
    bottom: -28px; left: -20px; right: -20px;
    height: 56px;
    background: white;
    border-radius: 50% 50% 0 0 / 100% 100% 0 0;
}
.ph__hero-circle1 {
    position: absolute;
    width: 160px; height: 160px;
    border-radius: 50%;
    border: 32px solid rgba(255,255,255,.07);
    top: -40px; right: -40px;
}
.ph__hero-circle2 {
    position: absolute;
    width: 100px; height: 100px;
    border-radius: 50%;
    border: 22px solid rgba(255,255,255,.05);
    top: 50px; right: 70px;
}
.ph__hero-label {
    font-size: .68rem;
    opacity: .75;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: 8px;
    font-weight: 700;
    position: relative;
    z-index: 1;
}
.ph__hero-amount {
    font-size: 1.9rem;
    font-weight: 800;
    letter-spacing: -.02em;
    margin-bottom: 4px;
    position: relative;
    z-index: 1;
    line-height: 1.1;
}
.ph__hero-sub {
    font-size: .72rem;
    opacity: .65;
    position: relative;
    z-index: 1;
}

/* Stats cards */
.ph__stats {
    padding: 24px 20px 16px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.ph__stat {
    background: #F8FAF8;
    border-radius: 12px;
    padding: 14px 14px;
    border: 1.5px solid #F0F0F0;
    transition: border-color .2s;
}
.ph__stat:hover { border-color: #C8ECD1; }
.ph__stat-val {
    font-size: 1.2rem;
    font-weight: 800;
    color: #111;
    margin-bottom: 3px;
    line-height: 1;
}
.ph__stat-val--green  { color: #284ca7; }
.ph__stat-val--yellow { color: #F5A623; }
.ph__stat-val--red    { color: #E53935; }
.ph__stat-label {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: #ABABAB;
}

/* Info section */
.ph__left-info {
    padding: 0 20px 24px;
    border-top: 1px solid #F5F5F5;
    margin-top: auto;
}
.ph__left-info-title {
    font-size: .65rem;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #C0C0C0;
    padding: 16px 0 10px;
}
.ph__left-info-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #F8F8F8;
}
.ph__left-info-row:last-child { border-bottom: none; }
.ph__left-info-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: #E8F8EE;
    color: #284aa7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .75rem;
    flex-shrink: 0;
}
.ph__left-info-key {
    font-size: .72rem;
    color: #ABABAB;
    margin-bottom: 1px;
}
.ph__left-info-val {
    font-size: .8rem;
    font-weight: 700;
    color: #333;
}

/* ── RIGHT PANEL (transaction list) ─────── */
.ph__right-panel {
    background: #F5F7FA;
    min-height: calc(100vh - 57px);
}

/* ── Group label ─────────────────────────── */
.ph__group-label {
    font-size: .65rem;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #ABABAB;
    padding: 20px 24px 8px;
}

/* ── Item ────────────────────────────────── */
.ph__item {
    background: white;
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 24px;
    border-bottom: 1px solid #F5F5F5;
    transition: background .15s, transform .15s;
    cursor: default;
    margin: 0 0 1px;
}
.ph__item:hover {
    background: #FAFFFE;
    transform: translateX(3px);
}

/* Icon */
.ph__icon {
    width: 46px; height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .95rem;
    flex-shrink: 0;
}
.ph__icon--green  { background: #E8F8EE; color: #2841a7; }
.ph__icon--yellow { background: #FFF8E1; color: #F5A623; }
.ph__icon--red    { background: #FFF0F0; color: #E53935; }

/* Middle */
.ph__mid { flex: 1; min-width: 0; }
.ph__mid-title {
    font-size: .9rem;
    font-weight: 700;
    color: #111;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ph__mid-sub {
    font-size: .72rem;
    color: #ABABAB;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.ph__mid-dot {
    width: 3px; height: 3px;
    background: #D0D0D0;
    border-radius: 50%;
}
.ph__badge {
    font-size: .62rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 100px;
}
.ph__badge--green  { background: #E8F8EE; color: #2841a7; }
.ph__badge--yellow { background: #FFF8E1; color: #E6940A; }
.ph__badge--red    { background: #FFF0F0; color: #E53935; }

/* Right amount */
.ph__amount-wrap { text-align: right; flex-shrink: 0; }
.ph__amount {
    font-size: .95rem;
    font-weight: 800;
    display: block;
    margin-bottom: 2px;
}
.ph__amount--green { color: #2839a7; }
.ph__amount--red   { color: #E53935; }
.ph__amount--dark  { color: #111; }
.ph__amount-curr {
    font-size: .65rem;
    color: #C0C0C0;
    font-weight: 500;
}

/* ── Empty ───────────────────────────────── */
.ph__empty {
    text-align: center;
    padding: 100px 20px;
    color: #ABABAB;
}
.ph__empty-icon { font-size: 2.8rem; margin-bottom: 14px; opacity: .35; }
.ph__empty-title { font-size: .95rem; font-weight: 700; margin-bottom: 4px; color: #555; }
.ph__empty-sub   { font-size: .78rem; }

/* ── Animations ──────────────────────────── */
.ph__hero  { animation: phFade .4s ease both; }
.ph__stat  { animation: phUp .35s ease both; }
.ph__stat:nth-child(1) { animation-delay: .08s; }
.ph__stat:nth-child(2) { animation-delay: .12s; }
.ph__stat:nth-child(3) { animation-delay: .16s; }
.ph__stat:nth-child(4) { animation-delay: .20s; }

.ph__item  { animation: phSlide .3s ease both; }
.ph__item:nth-child(1)  { animation-delay: .05s; }
.ph__item:nth-child(2)  { animation-delay: .09s; }
.ph__item:nth-child(3)  { animation-delay: .13s; }
.ph__item:nth-child(4)  { animation-delay: .17s; }
.ph__item:nth-child(5)  { animation-delay: .21s; }
.ph__item:nth-child(n+6){ animation-delay: .25s; }

@keyframes phFade  { from{opacity:0;} to{opacity:1;} }
@keyframes phUp    { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
@keyframes phSlide { from{opacity:0;transform:translateX(-8px);} to{opacity:1;transform:translateX(0);} }

/* ══════════════════════════════════════════
   MOBILE — single column (≤768px)
   ══════════════════════════════════════════ */
@media (max-width: 768px) {
    .ph { max-width: 480px; }

    .ph__topbar { padding: 18px 20px; }
    .ph__topbar-sub { display: none; }

    /* Stack left + right vertically */
    .ph__desktop {
        display: block;
    }

    /* Left panel: not sticky, normal flow */
    .ph__left {
        position: static;
        height: auto;
        border-right: none;
        border-bottom: 1px solid #F0F0F0;
    }

    .ph__hero { padding: 28px 24px 40px; }
    .ph__hero-amount { font-size: 1.7rem; }

    .ph__stats {
        grid-template-columns: repeat(4, 1fr);
        padding: 20px 16px 14px;
        gap: 8px;
    }
    .ph__stat-val { font-size: 1rem; }

    .ph__left-info { display: none; } /* hide on mobile */

    .ph__right-panel { min-height: auto; }

    .ph__group-label { padding: 16px 20px 6px; }

    .ph__item { padding: 14px 20px; }
    .ph__item:hover { transform: none; }
}

@media (max-width: 480px) {
    .ph__stats { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="ph">

    {{-- Top bar --}}
    <div class="ph__topbar">
        <div class="ph__topbar-title">Riwayat Transaksi</div>
        <div class="ph__topbar-sub">Digital Residence — IPL</div>
    </div>

    @php
        $totalLunas  = $pembayarans->where('status','pembayaran berhasil')->sum('total');
        $cntLunas    = $pembayarans->where('status','pembayaran berhasil')->count();
        $cntPending  = $pembayarans->filter(fn($i) => $i->status != 'pembayaran berhasil' && $i->dibayar && $i->dibayar->foto)->count();
        $cntBelum    = $pembayarans->count() - $cntLunas - $cntPending;
        $totalAll    = $pembayarans->sum('total');
        $grouped     = $pembayarans->groupBy(fn($i) => \Carbon\Carbon::parse($i->tanggal_jatuh_tempo)->translatedFormat('F Y'));
    @endphp

    <div class="ph__desktop">

        {{-- ═══ LEFT PANEL ════════════════════════ --}}
        <div class="ph__left">

            {{-- Hero --}}
            <div class="ph__hero">
                <div class="ph__hero-circle1"></div>
                <div class="ph__hero-circle2"></div>
                <div class="ph__hero-label">Total Sudah Dibayar</div>
                <div class="ph__hero-amount">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
                <div class="ph__hero-sub">{{ $cntLunas }} transaksi berhasil</div>
            </div>

            {{-- Stats --}}
            <div class="ph__stats">
                <div class="ph__stat">
                    <div class="ph__stat-val ph__stat-val--green">{{ $cntLunas }}</div>
                    <div class="ph__stat-label">Lunas</div>
                </div>
                <div class="ph__stat">
                    <div class="ph__stat-val ph__stat-val--yellow">{{ $cntPending }}</div>
                    <div class="ph__stat-label">Pending</div>
                </div>
                <div class="ph__stat">
                    <div class="ph__stat-val ph__stat-val--red">{{ $cntBelum }}</div>
                    <div class="ph__stat-label">Belum Bayar</div>
                </div>
                <div class="ph__stat">
                    <div class="ph__stat-val">{{ $pembayarans->count() }}</div>
                    <div class="ph__stat-label">Total</div>
                </div>
            </div>

            {{-- Info (desktop only) --}}
            <div class="ph__left-info">
                <div class="ph__left-info-title">Ringkasan</div>
                <div class="ph__left-info-row">
                    <div class="ph__left-info-icon"><i class="fas fa-wallet"></i></div>
                    <div>
                        <div class="ph__left-info-key">Total Tagihan</div>
                        <div class="ph__left-info-val">Rp {{ number_format($totalAll, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="ph__left-info-row">
                    <div class="ph__left-info-icon"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <div class="ph__left-info-key">Sudah Dibayar</div>
                        <div class="ph__left-info-val">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="ph__left-info-row">
                    <div class="ph__left-info-icon" style="background:#FFF0F0;color:#E53935;"><i class="fas fa-exclamation-circle"></i></div>
                    <div>
                        <div class="ph__left-info-key">Belum Dibayar</div>
                        <div class="ph__left-info-val" style="color:#E53935;">
                            Rp {{ number_format($totalAll - $totalLunas, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /.ph__left --}}

        {{-- ═══ RIGHT PANEL ═══════════════════════ --}}
        <div class="ph__right-panel">

            @if($pembayarans->isEmpty())
                <div class="ph__empty">
                    <div class="ph__empty-icon">🧾</div>
                    <div class="ph__empty-title">Belum ada riwayat transaksi</div>
                    <div class="ph__empty-sub">Transaksi Anda akan muncul di sini</div>
                </div>
            @else

                @foreach($grouped as $bulan => $items)

                    <div class="ph__group-label">{{ $bulan }}</div>

                    @foreach($items as $item)
                    @php
                        $isLunas   = $item->status == 'pembayaran berhasil';
                        $isPending = !$isLunas && $item->dibayar && $item->dibayar->foto;

                        $iconClass   = $isLunas ? 'ph__icon--green'    : ($isPending ? 'ph__icon--yellow'   : 'ph__icon--red');
                        $icon        = $isLunas ? 'fa-check-circle'    : ($isPending ? 'fa-clock'            : 'fa-times-circle');
                        $badgeClass  = $isLunas ? 'ph__badge--green'   : ($isPending ? 'ph__badge--yellow'   : 'ph__badge--red');
                        $badgeText   = $isLunas ? 'Berhasil'           : ($isPending ? 'Menunggu'             : 'Belum Bayar');
                        $amtClass    = $isLunas ? 'ph__amount--green'  : ($isPending ? 'ph__amount--dark'    : 'ph__amount--red');
                    @endphp

                    <div class="ph__item">
                        <div class="ph__icon {{ $iconClass }}">
                            <i class="fas {{ $icon }}"></i>
                        </div>

                        <div class="ph__mid">
                            <div class="ph__mid-title">Iuran IPL</div>
                            <div class="ph__mid-sub">
                                {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                                <span class="ph__mid-dot"></span>
                                <span class="ph__badge {{ $badgeClass }}">{{ $badgeText }}</span>
                            </div>
                        </div>

                        <div class="ph__amount-wrap">
                            <span class="ph__amount {{ $amtClass }}">
                                Rp {{ number_format($item->total, 0, ',', '.') }}
                            </span>
                            <span class="ph__amount-curr">IDR</span>
                        </div>
                    </div>

                    @endforeach
                @endforeach

            @endif

        </div>{{-- /.ph__right-panel --}}

    </div>{{-- /.ph__desktop --}}

</div>{{-- /.ph --}}

@endsection