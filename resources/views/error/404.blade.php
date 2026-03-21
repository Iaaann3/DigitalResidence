@extends('layouts.user')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="row text-center py-5 my-5">
        <div class="col-12">
            <!-- Judul Besar Error -->
            <h1 class="display-1 fw-bold text-danger mb-3">404</h1>
            
            <!-- Pesan Error -->
            <h2 class="h3 mb-3">
                <span class="badge bg-danger rounded-pill">Oops!</span> Halaman Tidak Ditemukan
            </h2>
            
            <p class="lead text-muted mx-auto" style="max-width: 500px;">
                Kami mohon maaf, halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau alamatnya salah.
            </p>

            <!-- CTA ke Halaman Utama -->
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg mt-4 rounded-pill shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
            </a>
            
            <!-- Pastikan lo punya icon Bootstrap (bi-arrow-left). Jika tidak, hapus tag <i> -->

        </div>
    </div>
</div>
@endsection