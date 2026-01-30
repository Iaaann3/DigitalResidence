@extends('layouts.user')

@section('content')
<div class="container py-4">
    <!-- Judul Halaman -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-success">Payment History</h2>
        <p class="text-muted">Pertahankan riwayat pembayaran anda demi kemajuan Digital Residence.</p>
    </div>

    <!-- Daftar Transaksi -->
    @forelse($pembayarans as $item)
        <div class="card shadow-sm border-0 rounded-4 mb-3" style="max-width:1000px; margin:auto;">
            <div class="card-body d-flex align-items-center">
                <!-- Icon -->
                <div class="me-3">
                    <img src="{{ asset('assets/images/logos/digital.png') }}" alt="icon" width="48" height="48" class="rounded-circle" style="object-fit:cover;">
                </div>

                <!-- Detail Transaksi -->
                <div class="flex-grow-1">
                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d F, Y') }}
                    </small>
                    <h5 class="mb-1 text-success">
                        Rp {{ number_format($item->total, 0, ',', '.') }}
                    </h5>
                    @if($item->status == 'pembayaran berhasil')
                        <span class="text-success">
                            <i class="fas fa-check-circle"></i> Pembayaran Berhasil
                        </span>
                    @elseif($item->dibayar && $item->dibayar->foto)
                        <span class="text-warning">
                            <i class="fas fa-clock"></i> Menunggu Pembayaran
                        </span>
                        @else
                        <span class="text-danger">
                            <i class="fas fa-times-circle"></i> Belum Terbayar
                        </span>
                    @endif
                </div>

                <!-- Nominal IDR -->
                <div class="text-end">
                    <small class="text-muted">IDR</small>
                    <h6 class="fw-bold">Rp {{ number_format($item->total, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center text-muted">
            <p>Belum ada riwayat pembayaran.</p>
        </div>
    @endforelse
</div>
@endsection
