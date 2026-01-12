@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Edit Iklan</h1>
    <div class="card w-100" style="max-width:800px;">
        <div class="card-body">
            <form action="{{ route('admin.iklan.update', $iklan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_user" class="form-label">Nama User</label>
                    <select name="id_user" id="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                        <option value=""> Pilih User </option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                {{ old('id_user', $iklan->id_user) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_user')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Iklan</label>
                    <input type="text" name="judul" id="judul" 
                        class="form-control @error('judul') is-invalid @enderror" 
                        value="{{ old('judul', $iklan->judul) }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" 
                        class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $iklan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar (Opsional)</label>
                     @if($iklan->gambar)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$iklan->gambar) }}" 
                                 alt="Gambar Iklan" class="img-thumbnail" style="max-height:150px;">
                        </div>
                    @endif
                    <input type="file" name="gambar" id="gambar" 
                        class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.iklan.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update Iklan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
