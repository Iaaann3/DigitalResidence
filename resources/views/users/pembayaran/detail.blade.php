<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan IPL — Digital Residence</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #F0F4F8;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 32px 16px 64px;
        }

        /* ── Outer card ───────────────────────── */
        .inv {
            width: 100%;
            max-width: 480px;
            animation: invUp .5s cubic-bezier(.22,1,.36,1) both;
        }
        @keyframes invUp {
            from { opacity:0; transform:translateY(28px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* ── Top receipt notch ────────────────── */
        .inv__notch-top {
            height: 18px;
            background: white;
            border-radius: 16px 16px 0 0;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
        }
        .inv__notch-top::before,
        .inv__notch-top::after {
            content: '';
            width: 36px; height: 36px;
            background: #F0F4F8;
            border-radius: 50%;
            position: absolute;
            top: 0;
        }
        .inv__notch-top::before { left: -18px; }
        .inv__notch-top::after  { right: -18px; }

        /* ── Header ───────────────────────────── */
        .inv__head {
            background: white;
            padding: 24px 28px 28px;
            position: relative;
        }

        /* Back button */
        .inv__back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #9CA3AF;
            text-decoration: none;
            margin-bottom: 20px;
            transition: color .2s;
        }
        .inv__back:hover { color: #2846a7; text-decoration: none; }
        .inv__back i { font-size: .7rem; }

        /* Logo + brand */
        .inv__brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .inv__brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #284ca7, #203cc9);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(40,167,69,.3);
        }
        .inv__brand-name {
            font-size: .82rem;
            font-weight: 800;
            color: #111827;
            letter-spacing: .04em;
            text-transform: uppercase;
        }
        .inv__brand-sub {
            font-size: .72rem;
            color: #9CA3AF;
            margin-top: 1px;
        }

        /* Invoice title + month */
        .inv__title-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }
        .inv__title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #0F172A;
            letter-spacing: -.02em;
            line-height: 1.2;
        }
        .inv__month-badge {
            background: #ECFDF5;
            color: #053096;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 100px;
            border: 1.5px solid #D1FAE5;
            white-space: nowrap;
        }

        /* ── Dashed separator (receipt perforation) ── */
        .inv__perf {
            background: white;
            padding: 0 28px;
            display: flex;
            align-items: center;
            gap: 0;
            position: relative;
        }
        .inv__perf::before,
        .inv__perf::after {
            content: '';
            width: 24px; height: 24px;
            background: #F0F4F8;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .inv__perf-line {
            flex: 1;
            border-top: 2px dashed #E5E7EB;
            margin: 0 4px;
        }

        /* ── Body ─────────────────────────────── */
        .inv__body {
            background: white;
            padding: 20px 28px 24px;
        }

        /* Section label */
        .inv__section-label {
            font-size: .65rem;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #D1D5DB;
            margin-bottom: 14px;
        }

        /* Line item */
        .inv__item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 0;
            border-bottom: 1px solid #F3F4F6;
            gap: 12px;
            animation: invFade .4s ease both;
        }
        .inv__item:last-child { border-bottom: none; }

        .inv__item:nth-child(1) { animation-delay: .1s; }
        .inv__item:nth-child(2) { animation-delay: .18s; }
        .inv__item:nth-child(3) { animation-delay: .26s; }

        @keyframes invFade {
            from { opacity:0; transform:translateX(-8px); }
            to   { opacity:1; transform:translateX(0); }
        }

        .inv__item-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .inv__item-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            flex-shrink: 0;
        }
        .inv__item-icon--green  { background:#ECFDF5; color:#28a745; }
        .inv__item-icon--blue   { background:#EFF6FF; color:#3B82F6; }
        .inv__item-icon--orange { background:#FFF7ED; color:#F97316; }

        .inv__item-name {
            font-size: .85rem;
            font-weight: 600;
            color: #374151;
            line-height: 1.3;
        }
        .inv__item-desc {
            font-size: .72rem;
            color: #9CA3AF;
            margin-top: 1px;
        }

        .inv__item-amount {
            font-size: .88rem;
            font-weight: 700;
            color: #111827;
            white-space: nowrap;
        }
        .inv__item-amount .curr {
            font-size: .7rem;
            font-weight: 500;
            color: #9CA3AF;
            margin-right: 2px;
        }

        /* Jatuh tempo — different style */
        .inv__item--due .inv__item-amount {
            font-size: .82rem;
            color: #EF4444;
            font-weight: 700;
        }

        /* ── Subtotal section ─────────────────── */
        .inv__subtotal {
            background: #F9FAFB;
            border-radius: 12px;
            padding: 14px 16px;
            margin: 16px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: invFade .4s ease .32s both;
        }
        .inv__subtotal-label {
            font-size: .8rem;
            font-weight: 600;
            color: #6B7280;
        }
        .inv__subtotal-val {
            font-size: .88rem;
            font-weight: 700;
            color: #374151;
        }
        .inv__subtotal-val .curr {
            font-size: .7rem;
            font-weight: 500;
            color: #9CA3AF;
            margin-right: 2px;
        }

        /* ── Grand total ──────────────────────── */
        .inv__total {
            background: linear-gradient(135deg, #143980, #0d398a);
            border-radius: 14px;
            padding: 20px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
            animation: invFade .4s ease .4s both;
        }
        /* Shimmer */
        .inv__total::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.08) 50%, transparent 60%);
            animation: invShimmer 3s ease-in-out infinite;
        }
        @keyframes invShimmer {
            0%   { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        /* Dot pattern */
        .inv__total::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.07) 1px, transparent 1px);
            background-size: 16px 16px;
        }

        .inv__total-label {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.89);
            margin-bottom: 4px;
            position: relative;
            z-index: 1;
        }
        .inv__total-sub {
            font-size: .7rem;
            color: rgba(255, 255, 255, 0.9);
            position: relative;
            z-index: 1;
        }
        .inv__total-amount {
            text-align: right;
            position: relative;
            z-index: 1;
        }
        .inv__total-curr {
            font-size: .75rem;
            color: rgba(255,255,255,.5);
            display: block;
            text-align: right;
            margin-bottom: 2px;
        }
        .inv__total-val {
            font-size: 1.55rem;
            font-weight: 800;
            color: white;
            letter-spacing: -.02em;
            line-height: 1;
        }

        /* ── Bottom notch ─────────────────────── */
        .inv__notch-bot {
            height: 18px;
            background: white;
            border-radius: 0 0 16px 16px;
            position: relative;
        }
        .inv__notch-bot::before,
        .inv__notch-bot::after {
            content: '';
            width: 36px; height: 36px;
            background: #F0F4F8;
            border-radius: 50%;
            position: absolute;
            bottom: 0;
        }
        .inv__notch-bot::before { left: -18px; }
        .inv__notch-bot::after  { right: -18px; }

        /* ── Footer ───────────────────────────── */
        .inv__footer {
            text-align: center;
            padding: 20px 0 0;
            animation: invFade .4s ease .5s both;
        }
        .inv__footer-note {
            font-size: .75rem;
            color: #9CA3AF;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .inv__footer-note i { color: #283ba7; font-size: .7rem; }

        /* ── Responsive ───────────────────────── */
        @media (max-width: 480px) {
            body { padding: 16px 12px 48px; }
            .inv__head, .inv__body { padding-left: 20px; padding-right: 20px; }
            .inv__perf { padding: 0 20px; }
            .inv__total-val { font-size: 1.3rem; }
        }
    </style>
</head>
<body>

<div class="inv">

    {{-- Top notch --}}
    <div class="inv__notch-top"></div>

    {{-- Header --}}
    <div class="inv__head">
        <a href="{{ route('user.home.index') }}" class="inv__back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="inv__brand">
            <div class="inv__brand-icon">
                <i class="fas fa-home"></i>
            </div>
            <div>
                <div class="inv__brand-name">Digital Residence</div>
                <div class="inv__brand-sub">Iuran Pemeliharaan Lingkungan</div>
            </div>
        </div>

        <div class="inv__title-row">
            <div class="inv__title">Tagihan IPL</div>
            <div class="inv__month-badge">
                {{ \Carbon\Carbon::parse($pembayaran->created_at)->translatedFormat('F Y') }}
            </div>
        </div>
    </div>

    {{-- Perforation --}}
    <div class="inv__perf">
        <div class="inv__perf-line"></div>
    </div>

    {{-- Body --}}
    <div class="inv__body">

        <div class="inv__section-label">Rincian Tagihan</div>

        @php $subtotal = 0; @endphp

        {{-- Keamanan --}}
        <div class="inv__item">
            <div class="inv__item-left">
                <div class="inv__item-icon inv__item-icon--green">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <div class="inv__item-name">Pengelolaan Lingkungan</div>
                    <div class="inv__item-desc">Keamanan & fasilitas umum</div>
                </div>
            </div>
            <div class="inv__item-amount">
                <span class="curr">Rp</span>{{ number_format($pembayaran->keamanan, 0, ',', '.') }}
            </div>
        </div>
        @php $subtotal += $pembayaran->keamanan; @endphp

        {{-- Kebersihan --}}
        <div class="inv__item">
            <div class="inv__item-left">
                <div class="inv__item-icon inv__item-icon--blue">
                    <i class="fas fa-recycle"></i>
                </div>
                <div>
                    <div class="inv__item-name">Pengelolaan Sampah</div>
                    <div class="inv__item-desc">Kebersihan lingkungan</div>
                </div>
            </div>
            <div class="inv__item-amount">
                <span class="curr">Rp</span>{{ number_format($pembayaran->kebersihan, 0, ',', '.') }}
            </div>
        </div>
        @php $subtotal += $pembayaran->kebersihan; @endphp

        {{-- Jatuh tempo --}}
        <div class="inv__item inv__item--due">
            <div class="inv__item-left">
                <div class="inv__item-icon inv__item-icon--orange">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <div>
                    <div class="inv__item-name">Jatuh Tempo</div>
                    <div class="inv__item-desc">Batas akhir pembayaran</div>
                </div>
            </div>
            <div class="inv__item-amount">
                {{ \Carbon\Carbon::parse($pembayaran->tanggal_jatuh_tempo)->format('d/m/Y') }}
            </div>
        </div>

        {{-- Subtotal --}}
        <div class="inv__subtotal">
            <span class="inv__subtotal-label">Subtotal</span>
            <span class="inv__subtotal-val">
                <span class="curr">Rp</span>{{ number_format($subtotal, 0, ',', '.') }}
            </span>
        </div>

        {{-- Grand total --}}
        <div class="inv__total">
            <div>
                <div class="inv__total-label">Total Tagihan</div>
                <div class="inv__total-sub">Sudah termasuk semua biaya</div>
            </div>
            <div class="inv__total-amount">
                <span class="inv__total-curr">IDR</span>
                <span class="inv__total-val">{{ number_format($pembayaran->total, 0, ',', '.') }}</span>
            </div>
        </div>

    </div>

    {{-- Bottom notch --}}
    <div class="inv__notch-bot"></div>

    {{-- Footer --}}
    <div class="inv__footer">
        <p class="inv__footer-note">
            <i class="fas fa-check-circle"></i>
            Terima kasih atas kepercayaan Anda
        </p>
    </div>

</div>

</body>
</html>