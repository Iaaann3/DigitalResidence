@extends('layouts.user')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Exo+2:wght@300;400;500;600&display=swap');

    :root {
        --navy:        #050D1A;
        --navy-mid:    #0A1628;
        --navy-card:   #0D1F3C;
        --blue-bright: #00AAFF;
        --blue-glow:   #0077CC;
        --blue-deep:   #003A6E;
        --cyan:        #00E5FF;
        --white:       #FFFFFF;
        --muted:       #7A9FBF;
        --pixel-blue:  #1A6FD4;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    .dr-cs {
        font-family: 'Exo 2', sans-serif;
        background: var(--navy);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        padding: 48px 20px 80px;
    }

    /* Animated grid background */
    .dr-cs::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(37, 121, 163, 0) 1px, transparent 1px),
            linear-gradient(90deg, rgba(29, 96, 129, 0.04) 1px, transparent 1px);
        background-size: 48px 48px;
        animation: gridPan 24s linear infinite;
        z-index: 0;
    }
    @keyframes gridPan {
        from { background-position: 0 0; }
        to   { background-position: 48px 48px; }
    }

    /* Radial glow center */
    .dr-cs::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 55% at 50% 40%, rgba(0,120,220,0.18) 0%, transparent 70%);
        z-index: 0;
        pointer-events: none;
    }

    /* Floating orbs */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(70px);
        opacity: 0.2;
        pointer-events: none;
        z-index: 0;
    }
    .orb-1 { width: 320px; height: 320px; background: var(--blue-bright); top: -80px; left: -80px; animation: floatOrb 14s ease-in-out infinite; }
    .orb-2 { width: 240px; height: 240px; background: var(--cyan); bottom: -60px; right: -60px; animation: floatOrb 18s ease-in-out infinite reverse; }
    .orb-3 { width: 180px; height: 180px; background: var(--blue-glow); top: 40%; left: 5%; animation: floatOrb 11s ease-in-out infinite 3s; }

    @keyframes floatOrb {
        0%, 100% { transform: translate(0,0); }
        33%       { transform: translate(24px,-18px); }
        66%       { transform: translate(-16px,20px); }
    }

    /* Scan-line overlay */
    .scanline {
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(
            180deg,
            transparent, transparent 3px,
            rgba(0,170,255,0.015) 3px, rgba(0,170,255,0.015) 4px
        );
        z-index: 1;
        pointer-events: none;
    }

    /* Content */
    .dr-content {
        position: relative;
        z-index: 10;
        text-align: center;
        max-width: 700px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Logo */
    .dr-logo {
        width: 120px;
        height: 120px;
        object-fit: contain;
        margin-bottom: 20px;
        animation: fadeDown 0.7s ease both, floatLogo 5s ease-in-out 0.7s infinite;
        filter: drop-shadow(0 0 20px rgba(0,170,255,0.55));
    }
    @keyframes floatLogo {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-8px); }
    }

    /* Badge */
    .dr-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(0,170,255,0.4);
        background: rgba(0,170,255,0.08);
        color: var(--blue-bright);
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        padding: 6px 20px;
        border-radius: 100px;
        margin-bottom: 28px;
        animation: fadeDown 0.7s ease 0.15s both;
        backdrop-filter: blur(4px);
    }
    .dr-badge .dot {
        width: 6px; height: 6px;
        background: var(--cyan);
        border-radius: 50%;
        box-shadow: 0 0 8px var(--cyan);
        animation: pulseDot 1.3s ease-in-out infinite;
    }
    @keyframes pulseDot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.3; transform: scale(0.6); }
    }

    /* House scene */
    .house-scene {
        width: 360px;
        max-width: 92vw;
        margin-bottom: 16px;
        animation: fadeUp 0.9s ease 0.3s both;
        filter: drop-shadow(0 0 28px rgba(0,170,255,0.35));
    }

    .win-glow  { animation: winPulse 3s ease-in-out infinite; }
    .win-glow-2{ animation: winPulse 3s ease-in-out 1.5s infinite; }
    @keyframes winPulse {
        0%, 100% { opacity: 1; }
        50%       { opacity: 0.35; }
    }

    .wifi-ring { animation: wifiPing 2.4s ease-out infinite; transform-origin: 50% 100%; }
    .wifi-ring:nth-child(2) { animation-delay: 0.6s; }
    .wifi-ring:nth-child(3) { animation-delay: 1.2s; }
    @keyframes wifiPing {
        0%   { opacity: 0; transform: scale(0.4); }
        40%  { opacity: 0.9; }
        100% { opacity: 0; transform: scale(1.1); }
    }

    .pixel-float { animation: pixelDrift 4s ease-in-out infinite; }
    .pixel-float:nth-child(2) { animation-delay: 0.8s; }
    .pixel-float:nth-child(3) { animation-delay: 1.6s; }
    .pixel-float:nth-child(4) { animation-delay: 2.4s; }
    @keyframes pixelDrift {
        0%, 100% { transform: translateY(0); opacity: 0.7; }
        50%       { transform: translateY(-12px); opacity: 1; }
    }

    .data-stream { animation: streamFlow 3s linear infinite; }
    @keyframes streamFlow {
        from { stroke-dashoffset: 200; }
        to   { stroke-dashoffset: 0; }
    }

    /* Title */
    .dr-title {
        font-family: 'Orbitron', sans-serif;
        font-size: clamp(1.7rem, 5.5vw, 2.8rem);
        font-weight: 900;
        color: var(--white);
        line-height: 1.15;
        margin-bottom: 18px;
        animation: fadeUp 0.8s ease 0.45s both;
        text-shadow: 0 0 30px rgba(0,170,255,0.3);
    }
    .dr-title .accent {
        background: linear-gradient(90deg, var(--blue-bright), var(--cyan));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Desc */
    .dr-desc {
        font-size: 0.97rem;
        line-height: 1.75;
        color: var(--muted);
        max-width: 500px;
        margin: 0 auto 32px;
        font-weight: 300;
        animation: fadeUp 0.8s ease 0.6s both;
    }
    .dr-desc strong { color: var(--blue-bright); font-weight: 600; }

    /* Feature cards */
    .feature-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-bottom: 36px;
        animation: fadeUp 0.8s ease 0.75s both;
    }
    .feat-card {
        display: flex;
        align-items: center;
        gap: 9px;
        background: rgba(13,31,60,0.7);
        border: 1px solid rgba(0,170,255,0.18);
        border-radius: 10px;
        padding: 9px 16px;
        font-size: 0.82rem;
        color: #B8D4E8;
        font-weight: 500;
        backdrop-filter: blur(6px);
        transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
        cursor: default;
    }
    .feat-card:hover {
        border-color: var(--blue-bright);
        transform: translateY(-3px);
        box-shadow: 0 0 18px rgba(0,170,255,0.2);
        color: var(--white);
    }
    .feat-card .icon { font-size: 1.05rem; }

    /* CTA */
    .dr-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, var(--blue-glow), var(--blue-bright));
        color: var(--white);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        padding: 14px 32px;
        border-radius: 8px;
        transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
        box-shadow: 0 0 24px rgba(0,170,255,0.35), 0 4px 16px rgba(0,0,0,0.3);
        animation: fadeUp 0.8s ease 0.9s both;
        position: relative;
        overflow: hidden;
    }
    .dr-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
        opacity: 0;
        transition: opacity 0.2s;
    }
    .dr-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 0 36px rgba(0,170,255,0.55), 0 8px 24px rgba(0,0,0,0.4);
        filter: brightness(1.12);
        color: var(--white);
        text-decoration: none;
    }
    .dr-cta:hover::before { opacity: 1; }

    /* Progress */
    .progress-section {
        margin-top: 40px;
        width: 100%;
        max-width: 420px;
        animation: fadeUp 0.8s ease 1.05s both;
    }
    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: var(--muted);
        margin-bottom: 8px;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .progress-label span:last-child {
        color: var(--blue-bright);
        font-family: 'Orbitron', sans-serif;
        font-size: 0.7rem;
    }
    .progress-track {
        background: rgba(0,170,255,0.1);
        border: 1px solid rgba(0,170,255,0.15);
        border-radius: 100px;
        height: 8px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, var(--blue-glow), var(--blue-bright), var(--cyan));
        border-radius: 100px;
        animation: fillBar 2.2s ease 1.3s forwards;
        box-shadow: 0 0 10px var(--blue-bright);
    }
    @keyframes fillBar { to { width: 72%; } }

    /* Footer note */
    .dr-footer-note {
        margin-top: 28px;
        font-size: 0.75rem;
        color: rgba(122,159,191,0.5);
        letter-spacing: 0.06em;
        animation: fadeUp 0.8s ease 1.2s both;
    }

    /* Shared keyframes */
    @keyframes fadeDown {
        from { opacity: 0; transform: translateY(-18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="dr-cs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="scanline"></div>

    <div class="dr-content">
        <!-- Badge -->
        <div class="dr-badge">
            <span class="dot"></span>
            Fitur Segera Hadir — Digital Residence
        </div>

        <!-- House SVG Scene -->
        <svg class="house-scene" viewBox="0 0 360 230" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="roofGr" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#1A6FD4"/>
                    <stop offset="100%" stop-color="#0A3E7A"/>
                </linearGradient>
                <linearGradient id="wallGr" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#0D1F3C"/>
                    <stop offset="100%" stop-color="#081529"/>
                </linearGradient>
                <linearGradient id="swipeGr" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#0077CC"/>
                    <stop offset="100%" stop-color="#00AAFF"/>
                </linearGradient>
                <filter id="glowBlue">
                    <feDropShadow dx="0" dy="0" stdDeviation="5" flood-color="#00AAFF" flood-opacity="0.7"/>
                </filter>
                <filter id="glowSoft">
                    <feDropShadow dx="0" dy="4" stdDeviation="8" flood-color="#00AAFF" flood-opacity="0.25"/>
                </filter>
            </defs>

            <!-- Ground -->
            <rect x="0" y="192" width="360" height="38" fill="#1a396b"/>
            <line x1="0" y1="192" x2="360" y2="192" stroke="#00AAFF" stroke-width="1" opacity="0.3"/>

            <!-- Walkway -->
            <polygon points="162,192 198,192 210,230 150,230" fill="#0A1628" opacity="0.8"/>
            <line x1="180" y1="196" x2="180" y2="228" stroke="#00AAFF" stroke-width="1" stroke-dasharray="5,5" opacity="0.25"/>

            <!-- Pixel bits (left) -->
            <g class="pixel-float"><rect x="62" y="105" width="8" height="8" rx="1" fill="#1A6FD4" opacity="0.9"/></g>
            <g class="pixel-float"><rect x="74" y="95" width="6" height="6" rx="1" fill="#00AAFF" opacity="0.7"/></g>
            <g class="pixel-float"><rect x="54" y="88" width="10" height="10" rx="1" fill="#0077CC" opacity="0.8"/></g>
            <g class="pixel-float"><rect x="80" y="112" width="6" height="6" rx="1" fill="#00E5FF" opacity="0.6"/></g>
            <rect x="65" y="78" width="5" height="5" rx="1" fill="#1A6FD4" opacity="0.35"/>
            <rect x="48" y="100" width="6" height="6" rx="1" fill="#0077CC" opacity="0.35"/>

            <!-- Data stream lines -->
            <path class="data-stream" d="M75,140 Q100,130 120,140" stroke="#00AAFF" stroke-width="1.5" fill="none" stroke-dasharray="6,6" opacity="0.35" stroke-linecap="round"/>
            <path class="data-stream" d="M240,130 Q270,120 298,135" stroke="#00AAFF" stroke-width="1.5" fill="none" stroke-dasharray="6,6" opacity="0.35" stroke-linecap="round" style="animation-delay:1.2s"/>

            <!-- Wifi signal (right of house, matching logo) -->
            <g transform="translate(290, 90)">
                <path class="wifi-ring" d="M-28,22 Q0,-8 28,22" stroke="#00AAFF" stroke-width="2.5" fill="none" stroke-linecap="round" opacity="0.9"/>
                <path class="wifi-ring" d="M-17,15 Q0,0 17,15" stroke="#00E5FF" stroke-width="2.5" fill="none" stroke-linecap="round" opacity="0.9"/>
                <path class="wifi-ring" d="M-8,9 Q0,4 8,9" stroke="#FFFFFF" stroke-width="2.5" fill="none" stroke-linecap="round" opacity="0.9"/>
                <circle cx="0" cy="22" r="3.5" fill="#00AAFF" filter="url(#glowBlue)"/>
            </g>

            <!-- MAIN HOUSE -->
            <g filter="url(#glowSoft)">
                <!-- Walls -->
                <rect x="100" y="118" width="160" height="74" rx="4" fill="url(#wallGr)" stroke="#1A3A6E" stroke-width="1.5"/>
                <!-- Circuit detail lines on wall -->
                <line x1="108" y1="140" x2="128" y2="140" stroke="#00AAFF" stroke-width="0.7" opacity="0.18"/>
                <line x1="108" y1="148" x2="120" y2="148" stroke="#00AAFF" stroke-width="0.7" opacity="0.18"/>
                <line x1="232" y1="140" x2="252" y2="140" stroke="#00AAFF" stroke-width="0.7" opacity="0.18"/>

                <!-- Roof -->
                <polygon points="92,120 180,64 268,120" fill="url(#roofGr)" stroke="#1A6FD4" stroke-width="1.5"/>
                <polygon points="92,120 180,64 268,120" fill="none" stroke="#00AAFF" stroke-width="0.5" opacity="0.35"/>

                <!-- Chimney -->
                <rect x="208" y="74" width="14" height="36" rx="2" fill="#0A1E38" stroke="#1A3A6E" stroke-width="1"/>
                <rect x="205" y="72" width="20" height="6" rx="2" fill="#1A3A6E" stroke="#1A6FD4" stroke-width="1"/>
                <!-- Pixel smoke from chimney -->
                <g class="pixel-float"><rect x="210" y="60" width="5" height="5" rx="1" fill="#1A6FD4" opacity="0.5"/></g>
                <g class="pixel-float"><rect x="215" y="51" width="4" height="4" rx="1" fill="#00AAFF" opacity="0.35"/></g>
                <g class="pixel-float"><rect x="207" y="44" width="6" height="6" rx="1" fill="#0077CC" opacity="0.25"/></g>

                <!-- Door -->
                <rect x="158" y="146" width="44" height="46" rx="3" fill="#050D1A" stroke="#1A3A6E" stroke-width="1.5"/>
                <rect x="158" y="146" width="44" height="46" rx="3" fill="none" stroke="#00AAFF" stroke-width="0.7" opacity="0.4"/>
                <path d="M158,152 Q180,132 202,152" fill="#050D1A" stroke="#1A6FD4" stroke-width="1"/>
                <rect x="163" y="155" width="16" height="18" rx="2" fill="#0D1F3C" opacity="0.9"/>
                <rect x="182" y="155" width="16" height="18" rx="2" fill="#0D1F3C" opacity="0.9"/>
                <!-- Smart lock -->
                <rect x="170" y="178" width="20" height="8" rx="2" fill="#0D1F3C" stroke="#00AAFF" stroke-width="0.8"/>
                <circle cx="180" cy="182" r="2" fill="#00AAFF" class="win-glow" filter="url(#glowBlue)"/>
                <!-- Step -->
                <rect x="150" y="192" width="60" height="5" rx="2" fill="#0A1628" stroke="#1A3A6E" stroke-width="1"/>

                <!-- Left window -->
                <rect x="110" y="130" width="36" height="30" rx="3" fill="#071A30" stroke="#1A3A6E" stroke-width="1.5"/>
                <rect class="win-glow" x="110" y="130" width="36" height="30" rx="3" fill="#003A6E" opacity="0.55"/>
                <line x1="128" y1="130" x2="128" y2="160" stroke="#1A6FD4" stroke-width="1"/>
                <line x1="110" y1="145" x2="146" y2="145" stroke="#1A6FD4" stroke-width="1"/>
                <rect x="110" y="130" width="36" height="30" rx="3" fill="none" stroke="#00AAFF" stroke-width="0.6" opacity="0.5"/>
                <rect x="108" y="159" width="40" height="5" rx="2" fill="#0A1628" stroke="#1A3A6E" stroke-width="1"/>

                <!-- Right window -->
                <rect x="214" y="130" width="36" height="30" rx="3" fill="#071A30" stroke="#1A3A6E" stroke-width="1.5"/>
                <rect class="win-glow-2" x="214" y="130" width="36" height="30" rx="3" fill="#003A6E" opacity="0.55"/>
                <line x1="232" y1="130" x2="232" y2="160" stroke="#1A6FD4" stroke-width="1"/>
                <line x1="214" y1="145" x2="250" y2="145" stroke="#1A6FD4" stroke-width="1"/>
                <rect x="214" y="130" width="36" height="30" rx="3" fill="none" stroke="#00AAFF" stroke-width="0.6" opacity="0.5"/>
                <rect x="212" y="159" width="40" height="5" rx="2" fill="#0A1628" stroke="#1A3A6E" stroke-width="1"/>

                <!-- Dormer/roof window -->
                <polygon points="167,88 180,76 193,88" fill="#1A3A6E" stroke="#1A6FD4" stroke-width="1"/>
                <rect x="170" y="87" width="20" height="16" rx="2" fill="#071A30" stroke="#1A3A6E" stroke-width="1"/>
                <rect class="win-glow" x="170" y="87" width="20" height="16" rx="2" fill="#003A6E" opacity="0.6"/>
                <rect x="170" y="87" width="20" height="16" rx="2" fill="none" stroke="#00AAFF" stroke-width="0.6" opacity="0.55"/>

                <!-- Swipe wave like the logo -->
                <path d="M88,183 Q145,170 180,178 Q215,186 272,173" stroke="url(#swipeGr)" stroke-width="2.5" fill="none" stroke-linecap="round" opacity="0.65"/>
                <path d="M93,189 Q148,179 180,184 Q216,190 270,180" stroke="#00AAFF" stroke-width="1" fill="none" stroke-linecap="round" opacity="0.2"/>
            </g>

            <!-- Digital fence -->
            <g opacity="0.5">
                <line x1="87" y1="167" x2="87" y2="192" stroke="#1A6FD4" stroke-width="2" stroke-linecap="round"/>
                <line x1="73" y1="171" x2="73" y2="192" stroke="#1A6FD4" stroke-width="2" stroke-linecap="round"/>
                <line x1="59" y1="174" x2="59" y2="192" stroke="#1A6FD4" stroke-width="2" stroke-linecap="round"/>
                <line x1="56" y1="177" x2="90" y2="173" stroke="#1A6FD4" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="273" y1="167" x2="273" y2="192" stroke="#1A6FD4" stroke-width="2" stroke-linecap="round"/>
                <line x1="287" y1="171" x2="287" y2="192" stroke="#1A6FD4" stroke-width="2" stroke-linecap="round"/>
                <line x1="301" y1="174" x2="301" y2="192" stroke="#1A6FD4" stroke-width="2" stroke-linecap="round"/>
                <line x1="270" y1="173" x2="304" y2="177" stroke="#1A6FD4" stroke-width="1.5" stroke-linecap="round"/>
            </g>
            <!-- IoT node dots on fence -->
            <circle cx="87" cy="173" r="3" fill="#00AAFF" opacity="0.8" class="win-glow" filter="url(#glowBlue)"/>
            <circle cx="273" cy="173" r="3" fill="#00AAFF" opacity="0.8" class="win-glow-2" filter="url(#glowBlue)"/>

            <!-- Corner star dots -->
            <circle cx="28" cy="28" r="1.5" fill="#00AAFF" opacity="0.5" class="win-glow"/>
            <circle cx="332" cy="20" r="2" fill="#00E5FF" opacity="0.4" class="win-glow-2"/>
            <circle cx="16" cy="158" r="1.5" fill="#00AAFF" opacity="0.35" class="win-glow"/>
            <circle cx="345" cy="152" r="1.5" fill="#00AAFF" opacity="0.4" class="win-glow-2"/>
        </svg>

        <!-- Title -->
        <h1 class="dr-title">
            Fitur IPL <span class="accent">Digital</span><br>Segera Hadir!
        </h1>

        <!-- Description -->
        <p class="dr-desc">
            Tim <strong>Digital Residence</strong> sedang mengembangkan fitur pembayaran <strong>Iuran Pemeliharaan Lingkungan</strong> yang terintegrasi penuh. Kelola tagihan warga, lacak pembayaran, dan pantau hunian Anda secara real-time.
        </p>

        <!-- CTA -->
        <a href="{{ url('/') }}" class="dr-cta">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6-.354.353.708.708L3 7.207V13.5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5V7.207l.354.354.708-.708L8.354 1.146zM13 7.207V13.5a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5V7.207L8 1.561l5 5.646z"/>
            </svg>
            Kembali ke Halaman Utama
        </a>
        <p class="dr-footer-note">© {{ date('Y') }} Digital Residence — Smart Living Platform</p>

    </div>
</div>
@endsection