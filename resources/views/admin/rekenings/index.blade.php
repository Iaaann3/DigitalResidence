@extends('layouts.admin')

@section('content')

<style>
    .table td, .table th {
        white-space: nowrap;
        vertical-align: middle;
    }
    .aksi-buttons {
        display: inline-flex;
        gap: 6px;
    }
</style>

<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Data Rekening</h1>

    <div class="card w-100 mt-2" style="max-width:1200px;">
        <div class="card-body">

            {{-- Tombol Tambah Rekening --}}
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.rekenings.create') }}" class="btn btn-success">
                    + Tambah Rekening
                </a>
            </div>

            {{-- Filter jumlah data --}}
            <form method="GET" action="{{ route('admin.rekenings.index') }}" class="d-flex align-items-center mb-3">
                <label class="me-2">Tampilkan</label>
                <select name="per_page" class="form-select me-2" style="width:auto;" onchange="this.form.submit()">
                    @foreach([5,10,20,50,100] as $size)
                        <option value="{{ $size }}" {{ request('per_page',10) == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
                <label>data</label>
                <input type="hidden" name="search" value="{{ request('search') }}">
            </form>

            {{-- Form Pencarian --}}
            <form action="{{ route('admin.rekenings.index') }}" method="GET" class="d-flex mb-3 gap-2" style="max-width:600px;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                       placeholder="Cari bank / nomor rekening...">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('admin.rekenings.index') }}" class="btn btn-secondary">Reset</a>
            </form>

            {{-- Tabel Rekening --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>#</th>
                            <th>Bank</th>
                            <th>Nomor Rekening</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekenings as $rekening)
                            <tr>
                                <td>{{ ($rekenings->currentPage()-1)*$rekenings->perPage() + $loop->iteration }}</td>
                                <td>{{ $rekening->bank_name }}</td>
                                <td>{{ $rekening->number }}</td>
                                <td>
                                    <div class="aksi-buttons">
                                        <a href="{{ route('admin.rekenings.edit', $rekening->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.rekenings.destroy', $rekening->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin hapus rekening ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada rekening</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($rekenings->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $rekenings->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
