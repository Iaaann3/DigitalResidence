@extends('layouts.user')

@section('content')
<div class="mobile-container">
    <!-- Header Section -->
    <div class="header-section">
        <div class="profile-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="greeting-text">Selamat datang</div>
        <h1 class="user-name">{{ Auth::user()->name ?? 'User' }}</h1>

        <!-- Balance Card -->
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
            @if($tagihan->dibayar && $tagihan->dibayar->foto)
                <button class="topup-btn" disabled style="background-color: #ffc107; color: #000;">
                    <i class="fas fa-clock me-1"></i> Menunggu Konfirmasi
                </button>
                <!-- <div class="alert alert-warning mt-2 p-2" style="font-size: 12px; margin: 5px 0;">
                    <i class="fas fa-info-circle me-1"></i>
                    Bukti pembayaran Anda sedang diverifikasi oleh admin
                </div> -->
            @elseif($tagihan->status == 'berhasil dibayar')
                <button class="topup-btn" disabled style="background-color: #28a745;">
                    <i class="fas fa-check me-1"></i> Lunas
                </button>
            @else
                <button type="button" 
                    class="topup-btn bayar-home-btn" 
                    data-id="{{ $tagihan->id }}" 
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
    
    <!-- Main Content -->
    <div class="main-content">

        @if($tagihan)
            <a href="{{ route('user.pembayaran.detail', $tagihan->id) }}" class="check-bill-btn">
                <i class="fas fa-file-invoice"></i>
                Cek Tagihan Anda
            </a>
        @endif

        
        <!-- Iklan Carousel Section -->
       @if($iklans->count() > 0)
<div id="iklanCarousel" class="carousel slide my-4" data-bs-ride="carousel">
    <div class="carousel-inner rounded shadow">

        @foreach($iklans as $key => $iklan)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            {{-- Gambar --}}
            <img src="{{ $iklan->gambar ? asset('storage/'.$iklan->gambar) : asset('images/default.jpg') }}"
     class="d-block w-100"
     alt="{{ $iklan->judul ?? 'Iklan' }}"
     style="max-height:200px; object-fit:cover; border-radius:8px;">

            {{-- Caption --}}
            <div class="carousel-caption bg-dark bg-opacity-50 rounded p-2 text-start" 
                 style="bottom: 10px; left: 10px; right: 10px;">
                <h6 class="mb-1">{{ $iklan->judul ?? 'Tidak ada judul' }}</h6>
                <small>{{ $iklan->deskripsi ? Str::limit($iklan->deskripsi, 50) : 'Tidak ada deskripsi' }}</small>
            </div>
        </div>
        @endforeach

    </div>

    {{-- Kontrol carousel --}}
    <button class="carousel-control-prev" type="button" data-bs-target="#iklanCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#iklanCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Next</span>
    </button>

    {{-- Indicators --}}
    <div class="carousel-indicators mt-2">
        @foreach($iklans as $key => $iklan)
        <button type="button" data-bs-target="#iklanCarousel" data-bs-slide-to="{{ $key }}" 
                class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" 
                aria-label="Slide {{ $key + 1 }}"></button>
        @endforeach
    </div>
</div>
@endif

        <!-- Services Section -->
        <h3 class="section-title">Info dan Layanan</h3>
        <div class="service-grid">
            <!-- <a href="#" class="service-item">
                <div class="service-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="service-label">Surat</div>
            </a> -->
            <a href="{{ route('user.pengumuman.index') }}" class="service-item">
                <div class="service-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="service-label">Pengumuman</div>
            </a>
            <a href="{{ route('user.saran.index') }}" class="service-item">
                <div class="service-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="service-label">Saran & Kritik</div>
            </a>
            <a href="javascript:;" class="service-item" data-bs-toggle="modal" data-bs-target="#tataTertibModal">
                <div class="service-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="service-label">Tata Tertib</div>
            </a>

            <a href="#" class="service-item">
                <div class="service-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="service-label">Keluhan</div>
            </a>
            <a href="{{ route('user.kegiatan.index') }}" class="service-item">
                <div class="service-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="service-label">Kegiatan</div>
            </a>
            <!-- <a href="#" class="service-item" style="grid-column: 2;">
                <div class="service-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="service-label">Bazaar</div>
            </a> -->
        </div>

        <h3 class="section-title">Layanan Populer</h3>
<div class="service-grid">
    <a href="#" class="service-item">
        <div class="service-icon"><i class="fas fa-mobile-alt"></i></div>
        <div class="service-label">Pulsa</div>
    </a>
    <a href="#" class="service-item">
        <div class="service-icon"><i class="fas fa-wifi"></i></div>
        <div class="service-label">Paket Data</div>
    </a>
    
    <a href="#" class="service-item">
        <div class="service-icon"><i class="fas fa-receipt"></i></div>
        <div class="service-label">Pascabayar</div>
    </a>
    <a href="#" class="service-item">
        <div class="service-icon"><i class="fas fa-bolt"></i></div>
        <div class="service-label">Token Listrik</div>
    </a>
    
    <a href="#" class="service-item">
        <div class="service-icon"><i class="fab fa-google-pay"></i></div>
        <div class="service-label">Top up GoPay</div>
    </a>
    <a href="#" class="service-item">
        <div class="service-icon"><i class="fas fa-wallet"></i></div>
        <div class="service-label">Top up DANA</div>
    </a>
    <a href="#" class="service-item">
        <div class="service-icon"><i class="fas fa-credit-card"></i></div>
        <div class="service-label">Top up OVO</div>
    </a>
    <a href="#" class="service-item">
        <div class="service-icon"><i class="fas fa-bolt"></i></div>
        <div class="service-label">Tagihan Listrik</div>
    </a>
    <a href="#" class="service-item">
        <div class="service-icon"><i class="fas fa-tv"></i></div>
        <div class="service-label">Internet & TV Kabel</div>
    </a>
</div>

        <!-- News Section -->
       <div class="info-section">
            <div class="info-header">
                <h3 class="section-title">Informasi Terkini</h3>
                <a href="{{ route('user.pengumuman.index') }}" class="view-all-link">Lihat Semua</a>
            </div>

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
        </div>
</div>
@endsection

<!-- Tata Tertib Modal -->
<div class="modal fade" id="tataTertibModal" tabindex="-1" aria-labelledby="tataTertibLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="tataTertibLabel"><i class="fas fa-gavel me-2"></i> Tata Tertib Lingkungan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <div class="modal-body">
        <p class="mb-3 text-muted">Berikut adalah peraturan dan tata tertib yang harus dipatuhi demi kenyamanan bersama:</p>
        <ol style="padding-left: 20px;">
          <li>Menjaga kebersihan lingkungan dan tidak membuang sampah sembarangan.</li>
          <li>Patuh terhadap jadwal pengangkutan sampah dan gunakan tempat sampah yang disediakan.</li>
          <li>Dilarang melakukan aktivitas yang mengganggu ketertiban umum.</li>
          <li>Kendaraan parkir di tempat yang telah ditentukan dan tidak menghalangi akses.</li>
          <li>Pemilik hewan peliharaan bertanggung jawab atas kebersihan dan perilaku hewan.</li>
          <li>Setiap pemasangan pengumuman/iklan harus seizin pengelola.</li>
          <li>Pelanggaran tata tertib dapat dikenakan sanksi sesuai ketentuan pengelola.</li>
        </ol>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" id="printTataTertibBtn" class="btn btn-success">
          <i class="fas fa-print me-1"></i> Cetak
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Pembayaran -->
<div class="modal fade" id="pembayaranModal" tabindex="-1" aria-labelledby="pembayaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formPembayaran" action="{{ route('user.bayar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="pembayaranLabel">
            <i class="fas fa-credit-card me-2"></i> Upload Bukti Pembayaran Pembayaran
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id_tagihan" id="id_tagihan">

           <!-- Info Pembayaran -->
          <div class="alert alert-info mb-3">
            <h6><i class="fas fa-info-circle me-2"></i>Informasi Pembayaran</h6>
            <p class="mb-2">Silakan transfer sesuai nominal tagihan ke salah satu rekening di bawah ini:</p>
            <small class="text-muted">Setelah transfer, upload bukti pembayaran untuk verifikasi admin.</small>
          </div>

            <div class="mb-3">
                <label class="form-label">Pilih Rekening Tujuan</label>
                <select class="form-select" id="rekeningSelect" name="rekening_id" required>
                    <option value="">Pilih Bank</option>
                    @foreach($rekenings as $rek)
                        <option value="{{ $rek->id }}" data-number="{{ $rek->number }}">
                            {{ $rek->bank_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Rekening</label>
                <input type="text" id="noRekening" class="form-control" readonly>
            </div>

          <div class="mb-3">
            <label for="bukti_pembayaran" class="form-label">Upload Bukti Transfer</label>
            <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*" required>
            <small class="text-muted">Format: JPG/PNG, max 2MB</small>
          </div>
           <div class="alert alert-warning">
            <small><i class="fas fa-exclamation-triangle me-1"></i>
              Setelah upload bukti pembayaran, status tagihan akan berubah menjadi "Menunggu Konfirmasi" dan akan diverifikasi oleh admin dalam 1x24 jam.
            </small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" id="submitBtn">Upload Bukti</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="successLabel">
          <i class="fas fa-check-circle me-2"></i> Berhasil
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
        <h5>Bukti Pembayaran Berhasil Dikirim</h5>
        <p class="text-muted">Terima kasih! Bukti pembayaran Anda sedang diverifikasi oleh admin. Kami akan menginformasikan hasilnya dalam 1x24 jam.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="window.location.reload();">Tutup</button>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
.alert {
    border-radius: 8px;
    border: none;
    font-size: 12px;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
    border-left: 4px solid #ffc107;
}

.alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
    border-left: 4px solid #17a2b8;
}

/* Carousel Animation */
@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

/* Pause animation on hover */
.carousel-track:hover {
    animation-play-state: paused;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .carousel-item {
        min-width: 250px;
        margin-right: 12px;
    }
    
    .member-card {
        padding: 12px;
    }
    
    .member-text h6 {
        font-size: 13px;
    }
    
    .member-text p {
        font-size: 10px;
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const selectBank = document.querySelector('select[name="rekening_id"]');
    const noRekening = document.getElementById("noRekening");

    selectBank.addEventListener("change", function () {
      const selectedOption = this.options[this.selectedIndex];
      const number = selectedOption.getAttribute("data-number");
      noRekening.value = number ? number : "";
    });
  });



// Print Tata Tertib
document.addEventListener('DOMContentLoaded', function () {
  const printBtn = document.getElementById('printTataTertibBtn');
  if (printBtn) {
    printBtn.addEventListener('click', function () {
      const modalBody = document.querySelector('#tataTertibModal .modal-body');
      const printWindow = window.open('', '_blank', 'width=800,height=600');
      printWindow.document.write('<html><head><title>Tata Tertib</title></head><body>');
      printWindow.document.write(modalBody.innerHTML);
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      setTimeout(() => {
        printWindow.print();
      }, 300);
    });
  }
});

// Handle pembayaran modal
document.addEventListener('DOMContentLoaded', function () {
    const bayarBtns = document.querySelectorAll('.bayar-home-btn');
    const formPembayaran = document.getElementById('formPembayaran');
    const tagihanInput = document.getElementById('id_tagihan');
    const submitBtn = document . getElementById('submitBtn');

    bayarBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            tagihanInput.value = id;
        });
    });
});


// Carousel click handlers (optional)
document.addEventListener('DOMContentLoaded', function() {
    const memberCards = document.querySelectorAll('.member-card');
    
    memberCards.forEach(card => {
        card.addEventListener('click', function() {
            const cardType = this.classList.contains('promo-card') ? 'promo' :
                           this.classList.contains('info-card') ? 'info' :
                           this.classList.contains('event-card') ? 'event' : 'member';
            
            // You can add specific actions here based on card type
            console.log('Clicked on:', cardType);
            
            // Example: Show different modals or navigate to different pages
            switch(cardType) {
                case 'promo':
                    // Handle promo card click
                    break;
                case 'info':
                    // Handle info card click  
                    break;
                case 'event':
                    // Handle event card click
                    break;
                default:
                    // Handle member card click
                    break;
            }
        });
    });
});
</script>
@endpush