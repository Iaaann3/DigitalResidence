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
                    @else  {{-- 'belum terbayar' --}}
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
                    <img src="{{ $iklan->gambar ? asset('storage/'.$iklan->gambar) : asset('images/default.jpg') }}"
                         class="d-block w-100"
                         alt="{{ $iklan->judul ?? 'Iklan' }}"
                         style="max-height:200px; object-fit:cover; border-radius:8px;">
                    <div class="carousel-caption bg-dark bg-opacity-50 rounded p-2 text-start" 
                         style="bottom: 10px; left: 10px; right: 10px;">
                        <h6 class="mb-1">{{ $iklan->judul ?? 'Tidak ada judul' }}</h6>
                        <small>{{ $iklan->deskripsi ? Str::limit($iklan->deskripsi, 50) : 'Tidak ada deskripsi' }}</small>
                    </div>
                </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#iklanCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#iklanCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>

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
            <a href="{{ route('user.keluhan.index') }}" class="service-item">
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
</div>

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

<!-- Modal Pembayaran Midtrans -->
<div class="modal fade" id="pembayaranModal" tabindex="-1" aria-labelledby="pembayaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="pembayaranLabel">
          <i class="fas fa-credit-card me-2"></i> Bayar Tagihan
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="id_tagihan" value="">
        
        <!-- Tambah CSRF token di modal sebagai fallback -->
        <input type="hidden" id="csrf_token_input" value="{{ csrf_token() }}">
        
        <!-- Info Tagihan -->
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

        <!-- Metode Pembayaran -->
        <div class="mb-4">
          <h6 class="mb-2">Pilih Metode Pembayaran:</h6>
          <div class="text-center">
            <button type="button" id="bayarMidtransBtn" class="btn btn-success btn-lg">
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
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="successLabel">
          <i class="fas fa-check-circle me-2"></i> Berhasil
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
        <h5>Pembayaran Berhasil!</h5>
        <p class="text-muted">Tagihan Anda sudah lunas dan akan terupdate secara otomatis.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="window.location.reload();">OK</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
/* CSS styles tetap sama seperti sebelumnya */
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
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 16px;
    padding: 20px;
    color: white;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
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
    color: #28a745;
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
    border-bottom: 2px solid #28a745;
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
    color: #28a745;
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
    color: #28a745;
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
    color: #28a745;
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
    background-color: #28a745;
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
<!-- HANYA SATU SCRIPT Midtrans -->
@if(config('midtrans.client_key'))
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="{{ config('midtrans.client_key') }}"
            id="midtrans-script"></script>
@else
    <div class="alert alert-danger">Midtrans Client Key tidak ditemukan!</div>
@endif

<script>
// Function untuk ambil CSRF token dengan safe check
function getCsrfToken() {
    // Coba dari meta tag dulu
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    if (metaToken && metaToken.getAttribute('content')) {
        return metaToken.getAttribute('content');
    }
    
    // Coba dari input hidden di modal
    const inputToken = document.getElementById('csrf_token_input');
    if (inputToken && inputToken.value) {
        return inputToken.value;
    }
    
    // Coba dari input _token
    const tokenInput = document.querySelector('input[name="_token"]');
    if (tokenInput && tokenInput.value) {
        return tokenInput.value;
    }
    
    console.error('CSRF token tidak ditemukan!');
    return null;
}

document.addEventListener("DOMContentLoaded", function () {
    console.log('DOM loaded, Midtrans available?', typeof window.snap !== 'undefined');
    
    // Print Tata Tertib
    const printBtn = document.getElementById('printTataTertibBtn');
    if (printBtn) {
        printBtn.addEventListener('click', function () {
            const modalBody = document.querySelector('#tataTertibModal .modal-body');
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Tata Tertib Lingkungan</title>
                        <style>
                            body { font-family: Arial, sans-serif; padding: 20px; }
                            h1 { color: #28a745; }
                            ol { line-height: 1.6; }
                        </style>
                    </head>
                    <body>
                        <h1>Tata Tertib Lingkungan</h1>
                        ${modalBody.innerHTML}
                    </body>
                </html>
            `);
            printWindow.document.close();
            setTimeout(() => {
                printWindow.print();
            }, 300);
        });
    }

    // Handle tombol Bayar di modal
    const bayarBtns = document.querySelectorAll('.bayar-home-btn');
    const idTagihanInput = document.getElementById('id_tagihan');
    const displayNominal = document.getElementById('display_nominal');
    const bayarMidtransBtn = document.getElementById('bayarMidtransBtn');

    bayarBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const total = this.dataset.total;
            
            idTagihanInput.value = id;
            
            // Format nominal langsung dari data attribute
            const formattedTotal = new Intl.NumberFormat('id-ID').format(total);
            displayNominal.textContent = 'Rp ' + formattedTotal;
            
            // Enable tombol bayar
            bayarMidtransBtn.disabled = false;
            
            console.log('Tagihan dipilih:', { id, total: formattedTotal });
        });
    });

    // Handle tombol Bayar Midtrans
    bayarMidtransBtn.addEventListener('click', async function () {
        const idTagihan = idTagihanInput.value;
        if (!idTagihan) {
            alert('ID tagihan tidak valid!');
            return;
        }

        // Cek apakah Midtrans Snap.js sudah terload
        if (typeof window.snap === 'undefined') {
            alert('Error: Midtrans payment gateway tidak tersedia. Silakan refresh halaman.');
            console.error('Midtrans snap not loaded');
            return;
        }

        // Ambil CSRF token
        const csrfToken = getCsrfToken();
        if (!csrfToken) {
            alert('Error sistem: CSRF token tidak ditemukan. Silakan refresh halaman.');
            return;
        }

        // Show loading
        const originalText = bayarMidtransBtn.innerHTML;
        bayarMidtransBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
        bayarMidtransBtn.disabled = true;

        console.log('Mengirim request ke gateway untuk tagihan ID:', idTagihan);

        try {
            // AJAX ke gateway Midtrans (GET request tidak perlu CSRF)
            const response = await fetch(`/user/bayar/gateway/${idTagihan}`, {
                method: 'GET',
                headers: { 
                    'Accept': 'application/json'
                    // GET request biasanya tidak butuh X-CSRF-TOKEN
                }
            });
            
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Midtrans response data:', data);
            
            if (data.success && data.snap_token) {
                console.log('Snap token diterima, membuka popup Midtrans...');
                
                // Reset tombol
                bayarMidtransBtn.innerHTML = originalText;
                bayarMidtransBtn.disabled = false;
                
                // Buka popup Midtrans
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        console.log('Pembayaran success:', result);
                        
                        // Update status via AJAX
                        fetch('/user/update-status-tagihan', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ 
                                id: idTagihan, 
                                status: 'pembayaran berhasil' 
                            })
                        })
                        .then(response => response.json())
                        .then(statusData => {
                            console.log('Status update response:', statusData);
                            if (statusData.success) {
                                // Close pembayaran modal
                                const pembayaranModal = bootstrap.Modal.getInstance(document.getElementById('pembayaranModal'));
                                if (pembayaranModal) {
                                    pembayaranModal.hide();
                                }
                                
                                // Show success modal setelah 500ms
                                setTimeout(() => {
                                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                    successModal.show();
                                }, 500);
                            } else {
                                alert('Pembayaran berhasil tapi gagal update status. Silakan refresh halaman.');
                            }
                        })
                        .catch(error => {
                            console.error('Update status error:', error);
                            alert('Pembayaran berhasil tapi ada error. Silakan refresh halaman.');
                        });
                    },
                    onPending: function(result) {
                        console.log('Pembayaran pending:', result);
                        alert('Pembayaran pending. Silakan selesaikan pembayaran di aplikasi bank/e-wallet Anda.');
                        window.location.reload();
                    },
                    onError: function(result) {
                        console.log('Pembayaran error:', result);
                        alert('Pembayaran gagal: ' + (result.status_message || 'Unknown error'));
                        window.location.reload();
                    },
                    onClose: function() {
                        console.log('Popup Midtrans ditutup oleh user');
                        // Tidak perlu reload, biarkan user bisa coba lagi
                    }
                });
            } else {
                alert(data.message || 'Gagal memproses pembayaran. Silakan coba lagi.');
                console.error('Midtrans error response:', data);
                bayarMidtransBtn.innerHTML = originalText;
                bayarMidtransBtn.disabled = false;
            }
        } catch (error) {
            console.error('Fetch error:', error);
            alert('Koneksi error, coba lagi. Error: ' + error.message);
            bayarMidtransBtn.innerHTML = originalText;
            bayarMidtransBtn.disabled = false;
        }
    });

    // Reset tombol ketika modal ditutup
    const pembayaranModal = document.getElementById('pembayaranModal');
    if (pembayaranModal) {
        pembayaranModal.addEventListener('hidden.bs.modal', function () {
            bayarMidtransBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i> Bayar via Midtrans';
            bayarMidtransBtn.disabled = false;
            idTagihanInput.value = '';
            displayNominal.textContent = 'Rp 0';
        });
    }
});
</script>
@endpush