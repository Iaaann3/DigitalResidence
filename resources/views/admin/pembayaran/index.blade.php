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
    <h1 class="mb-4 text-center">Data Pembayaran</h1>

    <div class="card w-100 mt-2" style="max-width:1200px;">
        <div class="card-body">

            {{-- Tombol Create Semua User --}}
            <div class="d-flex justify-content-end mb-3">
                <form action="{{ route('admin.pembayaran.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        + Create Semua User
                    </button>
                </form>
            </div>

            {{-- Filter jumlah data --}}
            <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="d-flex align-items-center mb-3">
                <label class="me-2">Tampilkan</label>
                <select name="per_page" class="form-select me-2" style="width:auto;" onchange="this.form.submit()">
                    @foreach([5,10,20,50,100] as $size)
                        <option value="{{ $size }}" {{ request('per_page',10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
                <label>data</label>
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
            </form>

            {{-- Form Pencarian --}}
            <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="d-flex mb-3 gap-2" style="max-width:600px;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama / no rumah...">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="belum terbayar" {{ request('status')=='belum terbayar'?'selected':'' }}>Belum Terbayar</option>
                    <option value="pembayaran berhasil" {{ request('status')=='pembayaran berhasil'?'selected':'' }}>Pembayaran Berhasil</option>
                </select>
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Reset</a>
            </form>

            {{-- Tabel Pembayaran --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>#</th>
                            <th>Nama User</th>
                            <th>No Rumah</th>
                            <th>Keamanan</th>
                            <th>Kebersihan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Bukti Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $pembayaran)
                            <tr>
                                <td>{{ ($data->currentPage()-1)*$data->perPage() + $loop->iteration }}</td>
                                <td>{{ $pembayaran->user->name ?? '-' }}</td>
                                <td>{{ $pembayaran->user->no_rumah ?? '-' }}</td>
                                <td>Rp {{ number_format($pembayaran->keamanan,0,',','.') }}</td>
                                <td>Rp {{ number_format($pembayaran->kebersihan,0,',','.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('d-m-Y') }}</td>
                                <td>
                                    @if($pembayaran->status == 'belum terbayar')
                                        <span class="badge bg-danger">Belum Terbayar</span>
                                    @else
                                        <span class="badge bg-success">Pembayaran Berhasil</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($pembayaran->total,0,',','.') }}</td>

                                {{-- Tombol Show Modal --}}
                                <td>
                                    @if($pembayaran->dibayar && $pembayaran->dibayar->foto)
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#showModal{{ $pembayaran->id }}">
                                            Show
                                        </button>
                                    @else
                                        <span class="text-danger fw-bold">Belum ada foto</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td>
                                    <div class="aksi-buttons">
                                        @if($pembayaran->status == 'pembayaran berhasil')
                                            <form action="{{ route('admin.pembayaran.destroyPembayaran', $pembayaran->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pembayaran ini beserta datanya?')">
                                                    Hapus Pembayaran
                                                </button>
                                            </form>
                                        @elseif($pembayaran->dibayar && $pembayaran->dibayar->foto)
                                            
                                            <form action="{{ route('admin.pembayaran.destroyDibayar', $pembayaran->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Yakin ingin menghapus bukti bayar ini?')">
                                                    Hapus Bukti
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal --}}
                            @if($pembayaran->dibayar && $pembayaran->dibayar->foto)
                                <div class="modal fade" id="showModal{{ $pembayaran->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title">Detail & Update Pembayaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.pembayaran.update', $pembayaran->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <ul class="list-group text-start">
                                                                <li class="list-group-item"><strong>Nama:</strong> {{ $pembayaran->user->name }}</li>
                                                                <li class="list-group-item"><strong>No Rumah:</strong> {{ $pembayaran->user->no_rumah }}</li>
                                                                <li class="list-group-item"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pembayaran->tanggal_jatuh_tempo)->format('d-m-Y') }}</li>
                                                                <li class="list-group-item"><strong>Total:</strong> Rp {{ number_format($pembayaran->total, 0, ',', '.') }}</li>
                                                                <li class="list-group-item"><strong>Bank:</strong> {{ $pembayaran->dibayar->rekening->bank_name }}</li>
                                                                <li class="list-group-item"><strong>No Rekening:</strong> {{ $pembayaran->dibayar->rekening->number }}</li>
                                                                <li class="list-group-item"><strong>Status:</strong>
                                                                    <select name="status" class="form-select">
                                                                        <option value="belum terbayar" {{ $pembayaran->status=='belum terbayar'?'selected':'' }}>Belum Terbayar</option>
                                                                        <option value="pembayaran berhasil" {{ $pembayaran->status=='pembayaran berhasil'?'selected':'' }}>Pembayaran Berhasil</option>
                                                                    </select>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6 text-center">
                                                            <p><strong>Bukti Pembayaran</strong></p>
                                                            <img src="{{ asset('storage/'.$pembayaran->dibayar->foto) }}" class="img-fluid rounded shadow" alt="Bukti Pembayaran">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update Pembayaran</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada data pembayaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($data->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $data->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
