@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Data Kegiatan</h1>
    <div class="card w-100 mt-2" style="max-width:1200px;">
        <div class="card-body">
            <div class="mb-3 text-end">
                <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-success">Tambah Kegiatan</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Deskripsi</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($kegiatans as $kegiatan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kegiatan->nama_kegiatan }}</td>
                                <td>{{ Str::limit($kegiatan->deskripsi, 50, '...') }}</td>
                                <td>{{ $kegiatan->lokasi }}</td>
                                <td>{{ $kegiatan->tanggal }}</td>
                                <td>
                                    @if($kegiatan->gambar)
                                        <img src="{{ asset('storage/'.$kegiatan->gambar) }}" 
                                         alt="{{ $kegiatan->nama_kegiatan }}" 
                                         class="img-thumbnail" 
                                         style="max-width:100px;">
                                             
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.kegiatan.edit', $kegiatan->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                    <form action="{{ route('admin.kegiatan.destroy', $kegiatan->id) }}" 
                                          method="POST" 
                                          class="d-inline-block" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mb-1">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data kegiatan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($kegiatans->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $kegiatans->links() }}
    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection