<div class="oops-wrapper">
    {{-- Elemen dekorasi --}}
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
        <div class="shape shape-5"></div>
    </div>

    {{-- Konten utama --}}
    <div class="container">
        <div class="phone-stack">
            <div class="phone phone-left"></div>
            <div class="phone phone-main">
                <div class="phone-header">
                    <div class="header-dots">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>
                </div>
                <div class="phone-content">
                    <div class="search-icon">🔍</div>
                    <div class="content-lines">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                </div>
            </div>
            <div class="phone phone-right"></div>
        </div>

        <div class="error-text">
            <h1 class="oops-title">Oops...</h1>
            <p class="error-message">Tidak ada kegiatan ditemukan.</p>
            <a href="{{ url()->previous() }}" class="back-button">Kembali</a>
        </div>
    </div>
</div>

{{-- CSS khusus hanya untuk container ini --}}
<style>
    .oops-wrapper {
        position: relative;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #e8f4f8 0%, #f0f8ff 50%, #e6f3ff 100%);
        border-radius: 16px;
        padding: 40px;
        overflow: hidden;
    }
    .floating-shapes { position: absolute; width: 100%; height: 100%; overflow: hidden; z-index: 1; }
    .shape { position: absolute; animation: float 6s ease-in-out infinite; }
    .shape-1 { top: 15%; left: 20%; width: 40px; height: 40px; background: linear-gradient(45deg, #ff9a9e, #fecfef); border-radius: 50% 20% 50% 20%; animation-delay: 0s; }
    .shape-2 { top: 25%; right: 15%; width: 35px; height: 35px; background: linear-gradient(45deg, #a8edea, #fed6e3); border-radius: 20% 50% 20% 50%; animation-delay: 2s; }
    .shape-3 { bottom: 20%; left: 15%; width: 30px; height: 30px; background: linear-gradient(45deg, #d299c2, #fef9d7); border-radius: 50%; animation-delay: 4s; }
    .shape-4 { top: 60%; right: 25%; width: 25px; height: 25px; background: linear-gradient(45deg, #89f7fe, #66a6ff); border-radius: 20%; animation-delay: 1s; }
    .shape-5 { bottom: 40%; right: 10%; width: 20px; height: 20px; background: linear-gradient(45deg, #ffecd2, #fcb69f); border-radius: 50%; animation-delay: 3s; }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        25% { transform: translateY(-15px) rotate(90deg); }
        50% { transform: translateY(-10px) rotate(180deg); }
        75% { transform: translateY(-20px) rotate(270deg); }
    }

    .container { text-align: center; z-index: 10; position: relative; }
    .phone-stack { position: relative; display: inline-block; margin-bottom: 40px; animation: phoneFloat 4s ease-in-out infinite; }
    .phone { width: 200px; height: 350px; border-radius: 25px; position: relative; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1); overflow: hidden; border: 3px solid #6c7ce0; }
    .phone-main { background: linear-gradient(135deg, #ffc0cb, #ffb3e6); z-index: 3; position: relative; }
    .phone-left { background: linear-gradient(135deg, #a8f0c8, #7fefb3); position: absolute; left: -60px; top: 20px; z-index: 2; transform: rotate(-15deg); }
    .phone-right { background: linear-gradient(135deg, #b3d9ff, #9bc9ff); position: absolute; right: -60px; top: -20px; z-index: 1; transform: rotate(15deg); }
    .phone-header { height: 60px; background: rgba(255, 255, 255, 0.3); display: flex; align-items: center; justify-content: center; border-bottom: 1px solid rgba(255, 255, 255, 0.2); }
    .header-dots { display: flex; gap: 6px; }
    .dot { width: 8px; height: 8px; background: rgba(255, 255, 255, 0.8); border-radius: 50%; }
    .phone-content { padding: 30px 25px; height: calc(100% - 60px); display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .search-icon { width: 50px; height: 50px; background: rgba(255, 255, 255, 0.4); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 24px; color: #6c7ce0; }
    .content-lines { width: 100%; margin-bottom: 30px; }
    .line { height: 8px; background: rgba(255, 255, 255, 0.4); border-radius: 4px; margin-bottom: 8px; }
    .line:nth-child(1) { width: 80%; margin: 0 auto 8px; }
    .line:nth-child(2) { width: 60%; margin: 0 auto 8px; }
    .line:nth-child(3) { width: 90%; margin: 0 auto 8px; }
    .line:nth-child(4) { width: 40%; margin: 0 auto 8px; }
    @keyframes phoneFloat { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }

    .oops-title { font-size: 36px; font-weight: 300; color: #8e9aaf; margin-bottom: 15px; animation: fadeInUp 1s ease-out; }
    .error-message { font-size: 16px; color: #a8b2c8; margin-bottom: 30px; animation: fadeInUp 1s ease-out 0.2s both; }
    .back-button { display: inline-flex; align-items: center; gap: 10px; padding: 12px 30px; background: linear-gradient(135deg, #6c7ce0, #8e94f2); color: white; text-decoration: none; border-radius: 25px; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(108, 124, 224, 0.3); }
    .back-button:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(108, 124, 224, 0.4); }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 768px) {
        .phone { width: 160px; height: 280px; }
        .phone-left, .phone-right { width: 160px; height: 280px; }
        .oops-title { font-size: 28px; }
        .error-message { font-size: 14px; }
    }
</style>
