@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Data Pengumuman</h1>
    <div class="card w-100 mt-2" style="max-width:1200px;">
        <div class="card-body">
            <div class="mb-3 text-end">
                <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-success">Tambah Pengumuman</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Isi</th>
                            <th>Tanggal</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($pengumumans as $pengumuman)
                            <tr>
                                <td>{{ $loop->iteration + ($pengumumans->currentPage()-1) * $pengumumans->perPage() }}</td>
                                <td>{{ $pengumuman->judul }}</td>
                                <td>{{ Str::limit($pengumuman->isi, 50, '...') }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengumuman->tanggal)->format('d-m-Y') }}</td>
                                <td>
                                    @if($pengumuman->gambar)
                                        <img src="{{ asset('storage/'.$pengumuman->gambar) }}"
                                            alt="{{ $pengumuman->judul }}" class="img-thumbnail" style="max-width:100px;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                    <form action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mb-1">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada pengumuman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
               <div class="d-flex justify-content-center mt-3">
               {{ $pengumumans->links() }}
               </div>
             
            </div>
        </div>
    </div>
</div>
@endsection
