@extends('layouts.user')

@section('content')
<style>
    /* Background dan body styling */
    body {
        background: linear-gradient(135deg, #e8f4f8 0%, #f0f8ff 50%, #e6f3ff 100%);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    /* Floating background shapes */
    .floating-shapes { 
        position: fixed; 
        width: 100%; 
        height: 100%; 
        overflow: hidden; 
        z-index: 1; 
        top: 0;
        left: 0;
        pointer-events: none;
    }
    
    .shape { 
        position: absolute; 
        animation: float 8s ease-in-out infinite; 
        opacity: 0.6;
        will-change: transform;
    }
    
    .shape-1 { top: 10%; left: 15%; width: 50px; height: 50px; background: linear-gradient(45deg, #ff9a9e, #fecfef); border-radius: 50% 20% 50% 20%; animation-delay: 0s; }
    .shape-2 { top: 20%; right: 10%; width: 45px; height: 45px; background: linear-gradient(45deg, #a8edea, #fed6e3); border-radius: 20% 50% 20% 50%; animation-delay: 2s; }
    .shape-3 { bottom: 15%; left: 10%; width: 40px; height: 40px; background: linear-gradient(45deg, #d299c2, #fef9d7); border-radius: 50%; animation-delay: 4s; }
    .shape-4 { top: 50%; right: 20%; width: 35px; height: 35px; background: linear-gradient(45deg, #89f7fe, #66a6ff); border-radius: 20%; animation-delay: 1s; }
    .shape-5 { bottom: 30%; right: 5%; width: 30px; height: 30px; background: linear-gradient(45deg, #ffecd2, #fcb69f); border-radius: 50%; animation-delay: 3s; }
    .shape-6 { top: 35%; left: 5%; width: 38px; height: 38px; background: linear-gradient(45deg, #a8c8ec, #7faaff); border-radius: 30% 70% 30% 70%; animation-delay: 1.5s; }
    .shape-7 { top: 75%; left: 25%; width: 42px; height: 42px; background: linear-gradient(45deg, #ffc3a0, #ffab7d); border-radius: 40% 60% 40% 60%; animation-delay: 2.5s; }
    .shape-8 { bottom: 50%; right: 35%; width: 32px; height: 32px; background: linear-gradient(45deg, #c3a8ff, #b399f5); border-radius: 50%; animation-delay: 3.5s; }
    
    @keyframes float { 
        0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); opacity: 0.6; } 
        25% { transform: translateY(-20px) rotate(90deg) scale(1.1); opacity: 0.8; } 
        50% { transform: translateY(-15px) rotate(180deg) scale(0.9); opacity: 0.4; } 
        75% { transform: translateY(-25px) rotate(270deg) scale(1.05); opacity: 0.7; } 
    }

    /* Content wrapper */
    .content-wrapper {
        position: relative;
        z-index: 10;
        min-height: 100vh;
        padding: 40px 0;
    }

    /* Main container */
    .detail-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
        animation: slideInUp 1s ease-out;
    }

    .detail-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        padding: 2rem;
        overflow: hidden;
        animation: fadeInScale 1.2s ease-out;
    }

    .detail-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #1f2937, #4f46e5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
    }

    .image-container {
        margin-bottom: 1.5rem;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .detail-image {
        width: 100%;
        height: 350px;
        object-fit: cover;
        transition: transform 0.6s ease, filter 0.6s ease;
        border-radius: 16px;
    }

    .image-container:hover .detail-image {
        transform: scale(1.05);
        filter: brightness(1.1) saturate(1.2);
    }

    .description-text {
        font-size: 1rem;
        color: #374151;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        text-align: justify;
    }

    .info-section {
        background: #f9fafb;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1rem;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        font-weight: 600;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .back-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-card { padding: 1.5rem; }
        .detail-title { font-size: 1.6rem; }
        .detail-image { height: 220px; }
        .description-text { font-size: 0.95rem; }
        .back-button { padding: 10px 16px; font-size: 0.9rem; }
        .shape { opacity: 0.3; width: 20px !important; height: 20px !important; }
    }

    @media (max-width: 480px) {
        .detail-title { font-size: 1.4rem; }
        .detail-image { height: 180px; }
        .description-text { font-size: 0.9rem; }
        .back-button { width: 100%; justify-content: center; }
    }

    /* Animations */
    @keyframes slideInUp { from {opacity:0;transform:translateY(40px);} to {opacity:1;transform:translateY(0);} }
    @keyframes fadeInScale { from {opacity:0;transform:scale(0.95);} to {opacity:1;transform:scale(1);} }
</style>

<div class="floating-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="shape shape-4"></div>
    <div class="shape shape-5"></div>
    <div class="shape shape-6"></div>
    <div class="shape shape-7"></div>
    <div class="shape shape-8"></div>
</div>

<div class="content-wrapper">
    <div class="detail-container">
        <div class="detail-card">
            <h1 class="detail-title">📢 Detail Pengumuman</h1>

            @if($pengumuman->gambar)
                <div class="image-container">
                    <img src="{{ asset('storage/'.$pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}" class="detail-image">
                </div>
            @endif

            <h2 class="text-xl font-semibold text-gray-900 mb-3">
                {{ ucfirst($pengumuman->judul) }}
            </h2>

            <div class="description-text">
                {{ $pengumuman->isi }}
            </div>

            <div class="info-section">
                <div class="info-item">
                    <span>📅 {{ \Carbon\Carbon::parse($pengumuman->tanggal)->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            <a href="{{ route('user.pengumuman.index') }}" class="back-button">
                ⬅️ Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const shapes = document.querySelectorAll('.shape');
    document.addEventListener('mousemove', function(e) {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        shapes.forEach((shape, index) => {
            const speed = (index + 1) * 0.2;
            const x = (mouseX - 0.5) * speed * 30;
            const y = (mouseY - 0.5) * speed * 30;
            shape.style.transform = `translate(${x}px, ${y}px)`;
        });
    });
});
</script>
@endsection