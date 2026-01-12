@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Data Iklan</h1>
    <div class="card w-100 mt-2" style="max-width:1200px;">
        <div class="card-body">
            <div class="mb-3 text-end">
                <a href="{{ route('admin.iklan.create') }}" class="btn btn-success">Tambah Iklan</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($iklans as $iklan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $iklan->user->name ?? '-' }}</td>
                                <td>{{ $iklan->judul }}</td>
                                <td>{{ Str::limit($iklan->deskripsi, 50, '...') }}</td>
                                <td>
                                    @if($iklan->gambar)
                                        <img src="{{ asset('storage/'.$iklan->gambar) }}" 
                                        alt="{{ $iklan->judul }}" 
                                        class="img-thumbnail" 
                                        style="max-width:100px;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.iklan.edit', $iklan->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                    <form action="{{ route('admin.iklan.destroy', $iklan->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus iklan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mb-1">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data iklan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($iklans->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $iklans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
