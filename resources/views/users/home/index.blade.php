@extends('layouts.user')

@section('content')
<div class="mobile-container"
     x-data="{ loading: true }"
     x-init="setTimeout(() => loading = false, Math.random() * 600 + 1200)">

    <!-- Header Section + Balance Card -->
    <div class="header-section">
        <template x-if="loading">
            <div class="skeleton">
                <div class="skeleton-item skeleton-avatar"></div>
                <div class="skeleton-item" style="height:16px; width:140px; margin:0 auto 4px;"></div>
                <div class="skeleton-item" style="height:24px; width:80%; margin:0 auto 20px;"></div>

                <div class="balance-card" style="background:#e5e5e5; height:160px; margin-top:20px; border-radius:16px;">
                    <div style="padding:24px;">
                        <div class="skeleton-item" style="height:16px; width:100px; margin-bottom:12px;"></div>
                        <div class="skeleton-item" style="height:36px; width:180px; margin-bottom:16px;"></div>
                        <div class="skeleton-item" style="height:16px; width:140px; margin-bottom:12px;"></div>
                        <div class="skeleton-item" style="height:40px; width:140px; border-radius:9999px; margin:0 auto;"></div>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="!loading">
            <div>
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="greeting-text">Selamat datang</div>
                <h1 class="user-name">{{ Auth::user()->name ?? 'User' }}</h1>

                <div class="balance-card">
                    <div class="balance-info">
                        <div>
                            <p class="balance-label">Tagihan</p>
                            <h2 class="balance-amount">
                                Rp {{ number_format($tagihan->total ?? 0, 0, ',', '.') }}
                            </h2>
                            <a href="{{ route('user.pembayaran.index') }}" class="balance-detail">
                                klik & cek riwayat
                            </a>
                        </div>

                        @if($tagihan)
                            @if($tagihan->status == 'menunggu verifikasi')
                                <button class="topup-btn" disabled style="background-color: #ffc107; color: #000;">
                                    <i class="fas fa-clock me-1"></i> Menunggu Konfirmasi
                                </button>
                            @elseif($tagihan->status == 'pembayaran berhasil')
                                <button class="topup-btn" disabled style="background-color: #28a745;">
                                    <i class="fas fa-check me-1"></i> Lunas
                                </button>
                            @elseif($tagihan->status == 'gagal')
                                <button type="button" class="topup-btn bayar-home-btn"
                                        data-id="{{ $tagihan->id }}"
                                        data-total="{{ $tagihan->total }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#pembayaranModal">
                                    <i class="fas fa-redo me-1"></i> Bayar Ulang
                                </button>
                            @else
                                <button type="button" class="topup-btn bayar-home-btn"
                                        data-id="{{ $tagihan->id }}"
                                        data-total="{{ $tagihan->total }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#pembayaranModal">
                                    Bayar
                                </button>
                            @endif
                        @else
                            <button class="topup-btn" disabled>
                                Tidak ada tagihan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </template>
    </div>

    <div class="main-content">

        <!-- Cek Tagihan Button -->
        <template x-if="loading">
            <div class="skeleton" style="margin: 0 0 24px 0;">
                <div class="skeleton-item" style="height:52px; border-radius:12px;"></div>
            </div>
        </template>
        <template x-if="!loading">
            @if($tagihan)
                <a href="{{ route('user.pembayaran.detail', $tagihan->id) }}" class="check-bill-btn">
                    <i class="fas fa-file-invoice"></i>
                    Cek Tagihan Anda
                </a>
            @endif
        </template>

        <!-- Iklan Carousel -->
        {{-- Taruh di @push('styles') --}}
<style>
.iklan-wrap {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    height: 200px;
    background: #111;
}
.iklan-track {
    display: flex;
    height: 100%;
    transition: transform .45s cubic-bezier(.4, 0, .2, 1);
}
.iklan-slide {
    min-width: 100%;
    height: 100%;
    position: relative;
    flex-shrink: 0;
}
.iklan-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.iklan-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.72) 0%, rgba(0,0,0,.18) 55%, transparent 100%);
}

/* Badge label atas kiri */
.iklan-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255,255,255,.18);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    border: 0.5px solid rgba(255,255,255,.28);
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 100px;
    letter-spacing: .3px;
}

/* Caption bawah */
.iklan-body {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 12px 14px 38px;
}
.iklan-title {
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    line-height: 1.35;
    margin: 0 0 3px;
    text-shadow: 0 1px 6px rgba(0,0,0,.5);
}
.iklan-desc {
    font-size: 11px;
    color: rgba(255,255,255,.75);
    line-height: 1.4;
    margin: 0;
}

/* Dots */
.iklan-dots-wrap {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 5px;
    z-index: 10;
}
.iklan-d {
    height: 5px;
    width: 5px;
    border-radius: 100px;
    background: rgba(255,255,255,.35);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: width .3s ease, background .3s ease;
}
.iklan-d.on {
    width: 20px;
    background: #fff;
}

/* Arrow nav */
.iklan-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    background: rgba(255,255,255,.15);
    border: 0.5px solid rgba(255,255,255,.25);
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background .2s;
}
.iklan-arrow:hover { background: rgba(255,255,255,.3); }
.iklan-arrow.prev { left: 10px; }
.iklan-arrow.next { right: 10px; }

/* Progress bar bawah */
.iklan-progress {
    position: absolute;
    bottom: 0; left: 0;
    height: 2px;
    background: rgba(255,255,255,.65);
    border-radius: 0 2px 2px 0;
    transition: width .1s linear;
}
</style>

{{-- HTML --}}
@if($iklans->count() > 0)
<div class="iklan-wrap my-4" id="iklanWrap">
    <div class="iklan-track" id="iklanTrack">
        @foreach($iklans as $iklan)
        <div class="iklan-slide">
            <img src="{{ $iklan->gambar ? asset('storage/'.$iklan->gambar) : asset('images/default.jpg') }}"
                 alt="{{ $iklan->judul ?? 'Iklan' }}">
            <div class="iklan-overlay"></div>
            @if($iklan->kategori ?? false)
            <span class="iklan-badge">{{ $iklan->kategori }}</span>
            @endif
            <div class="iklan-body">
                @if($iklan->judul)
                <p class="iklan-title">{{ $iklan->judul }}</p>
                @endif
                @if($iklan->deskripsi)
                <p class="iklan-desc">{{ Str::limit($iklan->deskripsi, 60) }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <button class="iklan-arrow prev" id="iklanPrev">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <button class="iklan-arrow next" id="iklanNext">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>

    <div class="iklan-dots-wrap" id="iklanDots"></div>
    <div class="iklan-progress" id="iklanProgress"></div>
</div>
@endif

{{-- Taruh di @push('scripts') --}}
<script>
(function () {
    const wrap     = document.getElementById('iklanWrap');
    if (!wrap) return;
    const track    = document.getElementById('iklanTrack');
    const dotsWrap = document.getElementById('iklanDots');
    const progress = document.getElementById('iklanProgress');
    const slides   = track.querySelectorAll('.iklan-slide');
    const total    = slides.length;
    const INTERVAL = 3500;
    let cur = 0, prog, progVal = 0, paused = false;

    // Buat dots dinamis
    slides.forEach((_, i) => {
        const d = document.createElement('button');
        d.className = 'iklan-d' + (i === 0 ? ' on' : '');
        d.onclick = () => goTo(i);
        dotsWrap.appendChild(d);
    });

    function updateDots() {
        dotsWrap.querySelectorAll('.iklan-d').forEach((d, i) => {
            d.className = 'iklan-d' + (i === cur ? ' on' : '');
        });
    }

    function goTo(n) {
        cur = (n + total) % total;
        track.style.transform = `translateX(-${cur * 100}%)`;
        updateDots();
        resetProgress();
    }

    function resetProgress() {
        clearInterval(prog);
        progVal = 0;
        progress.style.width = '0%';
        if (!paused) startProgress();
    }

    function startProgress() {
        prog = setInterval(() => {
            progVal += 100 / (INTERVAL / 100);
            progress.style.width = Math.min(progVal, 100) + '%';
            if (progVal >= 100) goTo(cur + 1);
        }, 100);
    }

    document.getElementById('iklanPrev').onclick = () => goTo(cur - 1);
    document.getElementById('iklanNext').onclick = () => goTo(cur + 1);

    // Pause on hover
    wrap.addEventListener('mouseenter', () => { paused = true; clearInterval(prog); });
    wrap.addEventListener('mouseleave', () => { paused = false; startProgress(); });

    // Swipe support
    let touchX = 0;
    wrap.addEventListener('touchstart', e => { touchX = e.touches[0].clientX; }, { passive: true });
    wrap.addEventListener('touchend', e => {
        const diff = touchX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 40) goTo(cur + (diff > 0 ? 1 : -1));
    }, { passive: true });

    startProgress();
})();
</script>

        <!-- Info dan Layanan -->
        <h3 class="section-title">Info dan Layanan</h3>

        <template x-if="loading">
            <div class="service-grid skeleton">
                @for($i = 1; $i <= 5; $i++)
                <div class="service-item">
                    <div class="skeleton-item" style="width:48px; height:48px; border-radius:50%; margin:0 auto 8px;"></div>
                    <div class="skeleton-item" style="height:14px; width:70%; margin:0 auto;"></div>
                </div>
                @endfor
            </div>
        </template>
        <template x-if="!loading">
            <div class="service-grid">
                <a href="{{ route('user.pengumuman.index') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-file-alt"></i></div>
                    <div class="service-label">Pengumuman</div>
                </a>
                <a href="{{ route('user.saran.index') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-clock"></i></div>
                    <div class="service-label">Saran & Kritik</div>
                </a>
                <a href="javascript:;" class="service-item" data-bs-toggle="modal" data-bs-target="#tataTertibModal">
                    <div class="service-icon"><i class="fas fa-info-circle"></i></div>
                    <div class="service-label">Tata Tertib</div>
                </a>
                <a href="{{ route('user.keluhan.index') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-question-circle"></i></div>
                    <div class="service-label">Keluhan</div>
                </a>
                <a href="{{ route('user.kegiatan.index') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-exchange-alt"></i></div>
                    <div class="service-label">Kegiatan</div>
                </a>
            </div>
        </template>

        <!-- Layanan Populer -->
        <h3 class="section-title">Layanan Populer</h3>

        <template x-if="loading">
            <div class="service-grid skeleton">
                @for($i = 1; $i <= 9; $i++)
                <div class="service-item">
                    <div class="skeleton-item" style="width:48px; height:48px; border-radius:50%; margin:0 auto 8px;"></div>
                    <div class="skeleton-item" style="height:14px; width:80%; margin:0 auto;"></div>
                </div>
                @endfor
            </div>
        </template>
        <template x-if="!loading">
            <div class="service-grid">
                <a href="{{ route('user.error.coming-soon') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-mobile-alt"></i></div>
                    <div class="service-label">Pulsa</div>
                </a>
                <a href="{{ route('user.error.coming-soon') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-wifi"></i></div>
                    <div class="service-label">Paket Data</div>
                </a>
                <a href="{{ route('user.error.coming-soon') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-receipt"></i></div>
                    <div class="service-label">Pascabayar</div>
                </a>
                <a href="{{ route('user.error.coming-soon') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-bolt"></i></div>
                    <div class="service-label">Token Listrik</div>
                </a>
                <a href="{{ route('user.error.coming-soon') }}" class="service-item">
                    <div class="service-icon"><i class="fab fa-google-pay"></i></div>
                    <div class="service-label">Top up GoPay</div>
                </a>
                <a href="{{ route('user.error.coming-soon') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-wallet"></i></div>
                    <div class="service-label">Top up DANA</div>
                </a>
                <a href="{{ route('user.error.coming-soon') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-credit-card"></i></div>
                    <div class="service-label">Top up OVO</div>
                </a>
                <a href="{{ route('user.error.coming-soon') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-bolt"></i></div>
                    <div class="service-label">Tagihan Listrik</div>
                </a>
                <a href="{{ route('user.error.coming-soon') }}" class="service-item">
                    <div class="service-icon"><i class="fas fa-tv"></i></div>
                    <div class="service-label">Internet & TV Kabel</div>
                </a>
            </div>
        </template>

        <!-- Informasi Terkini / Pengumuman -->
        <div class="info-section">
            <div class="info-header">
                <h3 class="section-title">Informasi Terkini</h3>
                <a href="{{ route('user.pengumuman.index') }}" class="view-all-link">Lihat Semua</a>
            </div>

            <template x-if="loading">
                <div>
                    @for($i = 1; $i <= 3; $i++)
                    <div class="news-item" style="padding: 12px 0; border-bottom: 1px solid #eee;">
                        <div class="news-image skeleton-item" style="width:60px; height:60px; flex-shrink:0;"></div>
                        <div class="news-content">
                            <div class="skeleton-item" style="height:16px; width:85%; margin-bottom:8px;"></div>
                            <div class="skeleton-item" style="height:14px; width:100%; margin-bottom:6px;"></div>
                            <div class="skeleton-item" style="height:12px; width:65%;"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </template>

            <template x-if="!loading">
                @forelse($pengumuman as $item)
                    <div class="news-item">
                        <div class="news-image">
                            @if($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}"
                                     alt="{{ $item->judul }}"
                                     style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                            @endif
                        </div>
                        <div class="news-content">
                            <h6>{{ $item->judul }}</h6>
                            <p>{{ Str::limit($item->isi, 60, '...') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada pengumuman terbaru.</p>
                @endforelse
            </template>
        </div>

    </div>
</div>

<!-- Tata Tertib Modal -->
<div class="modal fade" id="tataTertibModal" tabindex="-1" aria-labelledby="tataTertibLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 rounded-4 overflow-hidden shadow">

      <!-- Header -->
      <div class="modal-header border-0 px-4 py-3" style="background: #185FA5;">
        <div class="d-flex align-items-center gap-2">
          <div class="d-flex align-items-center justify-content-center rounded-2 me-1"
               style="width:32px;height:32px;background:rgba(255,255,255,0.15);">
            <i class="fas fa-file-alt text-white" style="font-size:14px;"></i>
          </div>
          <div>
            <h5 class="modal-title mb-0 text-white fw-medium" id="tataTertibLabel">Tata Tertib Lingkungan</h5>
            <small class="text-white-50">Peraturan wajib dipatuhi seluruh warga</small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white opacity-75" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <!-- Body -->
      <div class="modal-body px-4 pt-4 pb-2">

        <!-- Info banner -->
        <div class="d-flex align-items-start gap-2 rounded-3 p-3 mb-4"
             style="background:#EBF4FF; border:0.5px solid #B5D4F4;">
          <i class="fas fa-info-circle mt-1" style="font-size:13px;color:#185FA5;flex-shrink:0;"></i>
          <p class="mb-0 small" style="color:#185FA5;">
            Patuhi peraturan berikut demi kenyamanan dan ketertiban bersama.
          </p>
        </div>

        <!-- Rules list -->
        <div class="d-flex flex-column gap-2">

          <!-- Rules 1–6: default style -->
          <div class="d-flex align-items-start gap-3 rounded-3 p-3" style="background:#F8F9FA;border:0.5px solid #E0E0DD;">
            <span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-medium"
                  style="width:22px;height:22px;min-width:22px;background:#185FA5;color:#fff;font-size:11px;">1</span>
            <p class="mb-0 small">Jaga kebersihan lingkungan dan tidak membuang sampah sembarangan.</p>
          </div>

          <div class="d-flex align-items-start gap-3 rounded-3 p-3" style="background:#F8F9FA;border:0.5px solid #E0E0DD;">
            <span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-medium"
                  style="width:22px;height:22px;min-width:22px;background:#185FA5;color:#fff;font-size:11px;">2</span>
            <p class="mb-0 small">Patuhi jadwal pengangkutan sampah dan gunakan tempat sampah yang tersedia.</p>
          </div>

          <div class="d-flex align-items-start gap-3 rounded-3 p-3" style="background:#F8F9FA;border:0.5px solid #E0E0DD;">
            <span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-medium"
                  style="width:22px;height:22px;min-width:22px;background:#185FA5;color:#fff;font-size:11px;">3</span>
            <p class="mb-0 small">Dilarang melakukan aktivitas yang mengganggu ketertiban umum.</p>
          </div>

          <div class="d-flex align-items-start gap-3 rounded-3 p-3" style="background:#F8F9FA;border:0.5px solid #E0E0DD;">
            <span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-medium"
                  style="width:22px;height:22px;min-width:22px;background:#185FA5;color:#fff;font-size:11px;">4</span>
            <p class="mb-0 small">Parkir kendaraan di tempat yang ditentukan dan tidak menghalangi akses.</p>
          </div>

          <div class="d-flex align-items-start gap-3 rounded-3 p-3" style="background:#F8F9FA;border:0.5px solid #E0E0DD;">
            <span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-medium"
                  style="width:22px;height:22px;min-width:22px;background:#185FA5;color:#fff;font-size:11px;">5</span>
            <p class="mb-0 small">Pemilik hewan peliharaan bertanggung jawab atas kebersihan dan perilaku hewan.</p>
          </div>

          <div class="d-flex align-items-start gap-3 rounded-3 p-3" style="background:#F8F9FA;border:0.5px solid #E0E0DD;">
            <span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-medium"
                  style="width:22px;height:22px;min-width:22px;background:#185FA5;color:#fff;font-size:11px;">6</span>
            <p class="mb-0 small">Pemasangan pengumuman atau iklan wajib mendapat izin dari pengelola.</p>
          </div>

          <!-- Rule 7: warning highlight -->
          <div class="d-flex align-items-start gap-3 rounded-3 p-3"
               style="background:#FFFBEB;border:0.5px solid #FAC775;">
            <span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-medium"
                  style="width:22px;height:22px;min-width:22px;background:#BA7517;color:#fff;font-size:11px;">7</span>
            <p class="mb-0 small" style="color:#854F0B;">
              Pelanggaran tata tertib dapat dikenakan sanksi sesuai ketentuan pengelola.
            </p>
          </div>

        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer border-0 px-4 py-3" style="background:#F8F9FA;">
        <button type="button"  class="btn btn-sm text-white fw-medium"
                style="background:#185FA5;border:none;" data-bs-dismiss="modal">Saya Mengerti</button>
        </button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Pembayaran Midtrans -->
<div class="modal fade" id="pembayaranModal" tabindex="-1" aria-labelledby="pembayaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="pembayaranLabel">
          <i class="fas fa-credit-card me-2"></i> Bayar Tagihan
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_tagihan" value="">
        <input type="hidden" id="csrf_token_input" value="{{ csrf_token() }}">

        <div class="alert alert-info mb-3">
          <h6><i class="fas fa-info-circle me-2"></i>Detail Tagihan</h6>
          <div class="d-flex justify-content-between mb-1">
            <span>Nominal:</span>
            <strong id="display_nominal">Rp 0</strong>
          </div>
          <div class="d-flex justify-content-between">
            <span>Status:</span>
            <span class="badge bg-warning">Belum Dibayar</span>
          </div>
          <small class="text-muted d-block mt-2">
            Pembayaran via Midtrans (kartu kredit/debit, transfer bank, e-wallet)
          </small>
        </div>

        <div class="mb-4">
          <h6 class="mb-2">Pilih Metode Pembayaran:</h6>
          <div class="text-center">
            <button type="button" id="bayarMidtransBtn" class="btn btn-primary btn-lg">
              <i class="fas fa-credit-card me-2"></i> Bayar Sekarang
            </button>
          </div>
          <small class="text-muted d-block mt-2 text-center">
            Kartu kredit/debit, transfer bank, e-wallet (GoPay, OVO, DANA)
          </small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="successLabel">
          <i class="fas fa-check-circle me-2"></i> Berhasil
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-check-circle fa-3x text-primary mb-3"></i>
        <h5>Pembayaran Berhasil!</h5>
        <p class="text-muted">Tagihan Anda sudah lunas dan akan terupdate secara otomatis.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="window.location.reload();">OK</button>
      </div>
    </div>
  </div>
</div>
 

@endsection

@push('styles')
<style>
.mobile-container {
    max-width: 480px;
    margin: 0 auto;
    padding: 16px;
    background: #f8f9fa;
    min-height: 100vh;
}

.header-section {
    text-align: center;
    margin-bottom: 24px;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    margin: 0 auto 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: white;
}

.greeting-text {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 4px;
}

.user-name {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.balance-card {
    background: linear-gradient(135deg, #2846a7 0%, #2055c9 100%);
    border-radius: 16px;
    padding: 20px;
    color: white;
    box-shadow: 0 4px 12px rgba(40, 51, 167, 0.2);
}

.balance-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.balance-label {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 4px;
}

.balance-amount {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 8px;
}

.balance-detail {
    color: rgba(255, 255, 255, 0.8);
    font-size: 12px;
    text-decoration: underline;
    cursor: pointer;
}

.topup-btn {
    background: white;
    color: #2839a7;
    border: none;
    padding: 10px 20px;
    border-radius: 24px;
    font-weight: bold;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s;
}

.topup-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.topup-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.main-content {
    padding-bottom: 80px;
}

.check-bill-btn {
    display: block;
    background: #007bff;
    color: white;
    text-align: center;
    padding: 14px;
    border-radius: 12px;
    margin-bottom: 20px;
    text-decoration: none;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(0,123,255,0.2);
}

.section-title {
    font-size: 18px;
    font-weight: bold;
    margin: 24px 0 16px;
    color: #333;
    padding-bottom: 8px;
    border-bottom: 2px solid #283ba7;
}

.service-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.service-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: #333;
    padding: 16px 8px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: all 0.3s;
}

.service-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    color: #283da7;
}

.service-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #286ca7;
    margin-bottom: 8px;
}

.service-label {
    font-size: 12px;
    text-align: center;
    font-weight: 500;
}

.info-section {
    background: white;
    border-radius: 16px;
    padding: 20px;
    margin-top: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.info-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.view-all-link {
    font-size: 12px;
    color: #284aa7;
    text-decoration: none;
    font-weight: 500;
}

.news-item {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.news-item:last-child {
    border-bottom: none;
}

.news-image {
    width: 60px;
    height: 60px;
    flex-shrink: 0;
    border-radius: 8px;
    overflow: hidden;
    background: #f8f9fa;
}

.news-content {
    flex: 1;
}

.news-content h6 {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 4px;
    color: #333;
}

.news-content p {
    font-size: 12px;
    color: #6c757d;
    margin: 0;
}

.carousel-indicators {
    position: static;
    margin-top: 12px;
}

.carousel-indicators button {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #ccc;
    border: none;
    margin: 0 4px;
}

.carousel-indicators button.active {
    background-color: #2844a7;
}

.alert {
    border-radius: 8px;
    border: none;
    font-size: 12px;
}

.alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
    border-left: 4px solid #17a2b8;
}

/* ── Skeleton Styles ──────────────────────────────────────── */
.skeleton {
    position: relative;
    overflow: hidden;
    background: #f8f9fa;
}

.skeleton-item {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 8px;
}

@keyframes shimmer {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.skeleton-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: 0 auto 12px;
}

/* Responsive */
@media (max-width: 480px) {
    .service-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    .service-item {
        padding: 12px 6px;
    }
    .service-icon {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
    .balance-amount {
        font-size: 24px;
    }
    .topup-btn {
        padding: 8px 16px;
        font-size: 13px;
    }
}
</style>
@endpush

@push('scripts')
@if(config('midtrans.client_key'))
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"
            id="midtrans-script"></script>
@else
    <div class="alert alert-danger">Midtrans Client Key tidak ditemukan!</div>
@endif

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
// CSRF helper tetap
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta) return meta.getAttribute('content');
    const input = document.getElementById('csrf_token_input');
    if (input) return input.value;
    const tokenInput = document.querySelector('input[name="_token"]');
    if (tokenInput) return tokenInput.value;
    console.error('CSRF token tidak ditemukan');
    return null;
}

document.addEventListener("DOMContentLoaded", function () {

    // Print Tata Tertib tetap
    document.getElementById('printTataTertibBtn')?.addEventListener('click', function () {
        const modalBody = document.querySelector('#tataTertibModal .modal-body');
        const win = window.open('', '_blank', 'width=800,height=600');
        win.document.write(`
            <html><head><title>Tata Tertib Lingkungan</title><style>body{font-family:Arial,sans-serif;padding:20px;} h1{color:#28a745;} ol{line-height:1.6;}</style></head>
            <body><h1>Tata Tertib Lingkungan</h1>${modalBody.innerHTML}</body></html>
        `);
        win.document.close();
        setTimeout(() => win.print(), 400);
    });

    // ── SET VALUE INPUT & NOMINAL SAAT TOMBOL BAYAR DIKLIK ────────────────
    // Pakai delegation supaya jalan meski tombol muncul belakangan (setelah skeleton)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.bayar-home-btn');
        if (!btn) return;

        const id    = btn.dataset.id;
        const total = btn.dataset.total;

        console.log('Tombol Bayar diklik → ID:', id, 'Total:', total);

        if (!id || !total) {
            console.warn('Data ID/Total hilang di tombol!');
            alert('Tagihan tidak valid (ID atau nominal hilang)');
            return;
        }

        const idInput     = document.getElementById('id_tagihan');
        const nominalDisp = document.getElementById('display_nominal');
        const bayarBtn    = document.getElementById('bayarMidtransBtn');

        idInput.value = id;
        const formatted = new Intl.NumberFormat('id-ID').format(total);
        nominalDisp.textContent = 'Rp ' + formatted;
        bayarBtn.disabled = false;

        // Bootstrap akan handle buka modal karena sudah ada data-bs-toggle & data-bs-target
        // Tidak perlu manual bootstrap.Modal.show()
    });

    // ── BAYAR SEKARANG (klik di modal) ─────────────────────────────────────
    const bayarBtn = document.getElementById('bayarMidtransBtn');

    bayarBtn?.addEventListener('click', async function () {
        const id = document.getElementById('id_tagihan').value?.trim();

        if (!id || !/^\d+$/.test(id)) {
            alert('ID tagihan tidak valid atau belum dipilih!');
            return;
        }

        if (typeof window.snap === 'undefined') {
            alert('Midtrans Snap tidak tersedia. Refresh halaman.');
            return;
        }

        const csrf = getCsrfToken();
        if (!csrf) return alert('CSRF token hilang. Refresh halaman.');

        const original = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
        this.disabled = true;

        try {
            const res = await fetch(`/user/bayar/gateway/${id}`, {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });

            if (!res.ok) throw new Error(`HTTP error ${res.status}`);

            const data = await res.json();

            if (data.success && data.snap_token) {
                window.snap.pay(data.snap_token, {
                    onSuccess: async (result) => {
                        await fetch('/user/update-status-tagihan', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify({ id, status: 'pembayaran berhasil' })
                        });

                        bootstrap.Modal.getInstance(document.getElementById('pembayaranModal'))?.hide();
                        setTimeout(() => new bootstrap.Modal(document.getElementById('successModal')).show(), 400);
                    },
                    onPending:  () => { alert('Pembayaran pending'); location.reload(); },
                    onError:    (err) => { alert('Gagal: ' + (err.status_message || 'error')); location.reload(); },
                    onClose:    () => { }
                });
            } else {
                alert(data.message || 'Gagal memproses pembayaran');
            }
        } catch (err) {
            alert('Koneksi error: ' + err.message);
        } finally {
            this.innerHTML = original;
            this.disabled = false;
        }
    });

    // Reset modal
    document.getElementById('pembayaranModal')?.addEventListener('hidden.bs.modal', function () {
        bayarBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i> Bayar Sekarang';
        bayarBtn.disabled = true;
        document.getElementById('id_tagihan').value = '';
        document.getElementById('display_nominal').textContent = 'Rp 0';
    });
});
</script>
@endpush
