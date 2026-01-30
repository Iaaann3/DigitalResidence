@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Daftar Keluhan User</h1>
    <div class="card w-100 mt-2" style="max-width:1200px;">
        <div class="card-header">
            <h4 class="card-title mb-0">Daftar Keluhan User</h4>
        </div>
        <div class="card-body pt-4">
            {{-- Search & Filter --}}
            <form method="GET" class="mb-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari judul atau nama user..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="all">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <a href="{{ route('admin.keluhan.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-danger">
                        <tr>
                            <th>User</th>
                            <th>Judul</th>
                            <th>Isi</th>
                            <th>Foto</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keluhans as $keluhan)
                        <tr>
                            <td>{{ $keluhan->user->name ?? 'Unknown' }}</td>
                            <td>{{ Str::limit($keluhan->judul, 30) }}</td>
                            <td>{{ Str::limit($keluhan->isi, 50) }}</td>
                            <td>
                                @if($keluhan->photos && count($keluhan->photos) > 0)
                                    <span class="badge bg-info">{{ count($keluhan->photos) }} foto</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $keluhan->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge {{ $keluhan->status == 'pending' ? 'bg-warning' : ($keluhan->status == 'diproses' ? 'bg-info' : 'bg-success') }}">
                                    {{ ucfirst($keluhan->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.keluhan.show', $keluhan) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                <form action="{{ route('admin.keluhan.destroy', $keluhan) }}" method="POST" class="d-inline ms-1">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus keluhan? Foto juga ikut terhapus.')" title="Hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada keluhan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($keluhans->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $keluhans->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection