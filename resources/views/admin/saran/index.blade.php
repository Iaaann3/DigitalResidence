@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Data Saran & Kritik</h1>
    <div class="card w-100 mt-2" style="max-width:1200px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Isi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($kritiks as $saran)
                            <tr>
                                <td>{{ $kritiks->firstItem() + $loop->index }}</td>
                                <td>{{ $saran->user->name ?? '-' }}</td>
                                <td>{{ $saran->user->email ?? '-' }}</td>
                                <td>{{ Str::limit($saran->isi, 50, '...') }}</td>
                                <td>{{ $saran->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <!-- Tombol detail -->
                                    <a href="{{ route('admin.saran.show', $saran->id) }}" 
                                       class="btn btn-sm btn-info text-white">
                                        Detail
                                    </a>

                                    <!-- Tombol hapus -->
                                    <form action="{{ route('admin.saran.destroy', $saran->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data saran & kritik</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($kritiks->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $kritiks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
