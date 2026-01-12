@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Edit Pengumuman</h1>
    <div class="card w-100" style="max-width:800px;">
        <div class="card-body">
            <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" name="judul" id="judul" 
                           class="form-control @error('judul') is-invalid @enderror" 
                           value="{{ old('judul', $pengumuman->judul) }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isi" class="form-label">Isi</label>
                    <textarea name="isi" id="isi" rows="5" 
                              class="form-control @error('isi') is-invalid @enderror" required>{{ old('isi', $pengumuman->isi) }}</textarea>
                    @error('isi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" 
                           class="form-control @error('tanggal') is-invalid @enderror" 
                           value="{{ old('tanggal', $pengumuman->tanggal) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Pengumuman</label>
                    @if($pengumuman->gambar)
                        <div class="mb-3 text-center">
                            <img src="{{ asset('storage/'.$pengumuman->gambar) }}" 
                                 alt="Foto Pengumuman" 
                                 class="img-thumbnail" 
                                 style="max-height: 250px;">
                        </div>
                    @endif
                    <input type="file" name="gambar" id="gambar" 
                           class="form-control @error('gambar') is-invalid @enderror" 
                           accept="image/*">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">* Biarkan kosong jika tidak ingin mengganti foto</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update Pengumuman</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
