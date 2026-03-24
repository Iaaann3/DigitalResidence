@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .page-wrap { font-family: 'Plus Jakarta Sans', sans-serif; width: 100%; }

    .page-header {
        background: linear-gradient(135deg, #1e40af 0%, #3bf6ea 100%);
        padding: 1.8rem 2.5rem;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; margin: 0; }
    .page-header p  { font-size: 0.85rem; opacity: 0.8; margin: 0.2rem 0 0; }

    .page-body { background: #f0f4f8; padding: 2rem 2.5rem 3rem; }

    .card-box {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.2rem;
    }
    .toolbar-left, .toolbar-right { display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap; }

    .per-page-wrap { display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #64748b; }
    .per-page-wrap select {
        padding: 0.4rem 0.7rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.85rem;
        outline: none;
        background: #f8fafc;
        cursor: pointer;
    }

    .search-bar { display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; }
    .search-bar input, .search-bar select {
        padding: 0.5rem 0.9rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.85rem;
        outline: none;
        background: #f8fafc;
        transition: all 0.2s;
    }
    .search-bar input { min-width: 200px; }
    .search-bar input:focus, .search-bar select:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }

    .btn-act {
        padding: 0.5rem 1.1rem;
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.83rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.18s;
        white-space: nowrap;
    }
    .btn-act:hover { transform: translateY(-1px); text-decoration: none; }
    .btn-blue  { background: linear-gradient(135deg,#1e40af,#3b82f6); color: #fff; }
    .btn-blue:hover  { box-shadow: 0 4px 12px rgba(59,130,246,0.35); color: #fff; }
    .btn-outline-sl { background: #fff; color: #475569; border: 1.5px solid #e2e8f0; }
    .btn-outline-sl:hover { background: #f1f5f9; color: #1e293b; }

    .data-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
    .data-table thead tr {
        background: linear-gradient(135deg,#1e40af,#3b82f6);
        color: white;
    }
    .data-table thead th {
        padding: 0.85rem 1rem;
        font-weight: 600;
        font-size: 0.78rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        white-space: nowrap;
        text-align: center;
    }
    .data-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
    .data-table tbody tr:hover { background: #f8fafc; }
    .data-table tbody td {
        padding: 0.85rem 1rem;
        color: #374151;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }
    .data-table tbody td.name-col { font-weight: 600; color: #1e293b; text-align: left; }

    .badge-status {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .badge-belum { background: #fee2e2; color: #dc2626; }
    .badge-lunas { background: #dcfce7; color: #16a34a; }

    .action-btns { display: inline-flex; gap: 0.4rem; }
    .btn-sm-act {
        padding: 0.35rem 0.8rem;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .btn-sm-act:hover { transform: translateY(-1px); text-decoration: none; }
    .btn-detail { background: #dbeafe; color: #1e40af; }
    .btn-detail:hover { background: #bfdbfe; color: #1e3a8a; }
    .btn-warning-soft { background: #fef3c7; color: #b45309; }
    .btn-warning-soft:hover { background: #fde68a; }
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; color: #b91c1c; }

    .amount-col { font-weight: 600; color: #1e40af; }

    .empty-state { padding: 3rem 1rem; text-align: center; color: #94a3b8; }
    .empty-state i { font-size: 2.5rem; margin-bottom: 0.5rem; display: block; }
    .empty-state p { font-size: 0.9rem; margin: 0; }

    /* Modal */
    .modal-header-blue { background: linear-gradient(135deg,#1e40af,#3b82f6); color: white; }
    .modal-header-blue .btn-close { filter: invert(1); }
    .info-list { list-style: none; padding: 0; margin: 0; }
    .info-list li {
        padding: 0.6rem 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
        display: flex;
        justify-content: space-between;
    }
    .info-list li:last-child { border-bottom: none; }
    .info-list li span:first-child { color: #64748b; }
    .info-list li span:last-child { font-weight: 600; color: #1e293b; }

    @media(max-width:768px) {
        .page-header, .page-body { padding: 1.2rem; }
        .card-box { padding: 1rem; }
        .toolbar { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="page-wrap">
    <div class="page-header">
        <div>
            <h1><i class="bi bi-credit-card me-2"></i>Data Pembayaran IPL</h1>
            <p>Periode: {{ now()->format('F Y') }}</p>
        </div>
        <form action="{{ route('admin.pembayaran.generate') }}" method="POST">
            @csrf
            <button type="submit" class="btn-act btn-blue">
                <i class="bi bi-plus-circle"></i> Generate Tagihan Bulan Ini
            </button>
        </form>
    </div>

    <div class="page-body">

        <div class="card-box">
            <div class="toolbar">
                <div class="toolbar-left">
                    <div class="per-page-wrap">
                        <span>Tampilkan</span>
                        <form method="GET" action="{{ route('admin.pembayaran.index') }}">
                            <select name="per_page" onchange="this.form.submit()">
                                @foreach([5,10,20,50,100] as $size)
                                    <option value="{{ $size }}" {{ request('per_page',10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </select>
                        </form>
                        <span>data</span>
                    </div>
                </div>
                <div class="toolbar-right">
                    <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="search-bar">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / no rumah...">
                        <select name="status">
                            <option value="">Semua Status</option>
                            <option value="belum terbayar" {{ request('status')=='belum terbayar'?'selected':'' }}>Belum Terbayar</option>
                            <option value="pembayaran berhasil" {{ request('status')=='pembayaran berhasil'?'selected':'' }}>Sudah Terbayar</option>
                        </select>
                        <button type="submit" class="btn-act btn-blue"><i class="bi bi-search"></i> Cari</button>
                        <a href="{{ route('admin.pembayaran.index') }}" class="btn-act btn-outline-sl"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
                    </form>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama User</th>
                            <th>No Rumah</th>
                            <th>Keamanan</th>
                            <th>Kebersihan</th>
                            <th>Tgl Tagihan</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $pembayaran)
                            <tr>
                                <td>{{ ($data->currentPage()-1)*$data->perPage() + $loop->iteration }}</td>
                                <td class="name-col">{{ $pembayaran->user->name ?? '-' }}</td>
                                <td><strong>{{ $pembayaran->user->no_rumah ?? '-' }}</strong></td>
                                <td>Rp {{ number_format($pembayaran->keamanan,0,',','.') }}</td>
                                <td>Rp {{ number_format($pembayaran->kebersihan,0,',','.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('d-m-Y') }}</td>
                                <td>
                                    @if($pembayaran->status == 'belum terbayar')
                                        <span class="badge-status badge-belum">
                                            <i class="bi bi-x-circle"></i> Belum Terbayar
                                        </span>
                                    @else
                                        <span class="badge-status badge-lunas">
                                            <i class="bi bi-check-circle"></i> Lunas
                                        </span>
                                    @endif
                                </td>
                                <td class="amount-col">Rp {{ number_format($pembayaran->total,0,',','.') }}</td>
                                <td>
                                    <div class="action-btns">
                                        @if($pembayaran->dibayar && $pembayaran->dibayar->foto)
                                            <button type="button" class="btn-sm-act btn-detail"
                                                data-bs-toggle="modal" data-bs-target="#showModal{{ $pembayaran->id }}">
                                                <i class="bi bi-eye"></i> Detail
                                            </button>
                                        @endif

                                        @if($pembayaran->status == 'pembayaran berhasil')
                                            <form action="{{ route('admin.pembayaran.destroyPembayaran', $pembayaran->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-sm-act btn-delete"
                                                    onclick="return confirm('Yakin hapus seluruh data pembayaran ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @elseif($pembayaran->dibayar && $pembayaran->dibayar->foto)
                                            <form action="{{ route('admin.pembayaran.destroyDibayar', $pembayaran->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-sm-act btn-warning-soft"
                                                    onclick="return confirm('Hapus bukti pembayaran? Status akan kembali belum bayar.')">
                                                    <i class="bi bi-trash"></i> Hapus Bukti
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            @if($pembayaran->dibayar && $pembayaran->dibayar->foto)
                                <div class="modal fade" id="showModal{{ $pembayaran->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;">
                                            <div class="modal-header modal-header-blue">
                                                <h5 class="modal-title fw-bold">
                                                    <i class="bi bi-receipt me-2"></i>Detail Pembayaran — {{ $pembayaran->user->name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.pembayaran.update', $pembayaran->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="row g-4">
                                                        <div class="col-md-6">
                                                            <ul class="info-list">
                                                                <li>
                                                                    <span><i class="bi bi-person me-1"></i> Nama</span>
                                                                    <span>{{ $pembayaran->user->name }}</span>
                                                                </li>
                                                                <li>
                                                                    <span><i class="bi bi-house me-1"></i> No Rumah</span>
                                                                    <span>{{ $pembayaran->user->no_rumah }}</span>
                                                                </li>
                                                                <li>
                                                                    <span><i class="bi bi-calendar-x me-1"></i> Jatuh Tempo</span>
                                                                    <span>{{ \Carbon\Carbon::parse($pembayaran->tanggal_jatuh_tempo)->format('d-m-Y') }}</span>
                                                                </li>
                                                                <li>
                                                                    <span><i class="bi bi-cash me-1"></i> Total Tagihan</span>
                                                                    <span>Rp {{ number_format($pembayaran->total,0,',','.') }}</span>
                                                                </li>
                                                                <li>
                                                                    <span><i class="bi bi-toggle-on me-1"></i> Status</span>
                                                                    <span>
                                                                        <select name="status" style="padding:0.3rem 0.6rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.83rem;outline:none;">
                                                                            <option value="belum terbayar" {{ $pembayaran->status == 'belum terbayar' ? 'selected' : '' }}>Belum Terbayar</option>
                                                                            <option value="pembayaran berhasil" {{ $pembayaran->status == 'pembayaran berhasil' ? 'selected' : '' }}>Pembayaran Berhasil</option>
                                                                        </select>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6 text-center">
                                                            <p class="fw-semibold mb-2" style="font-size:0.85rem;color:#64748b;">
                                                                <i class="bi bi-image me-1"></i> Bukti Pembayaran
                                                            </p>
                                                            <img src="{{ asset('storage/' . $pembayaran->dibayar->foto) }}"
                                                                 class="img-fluid rounded shadow-sm" alt="Bukti"
                                                                 style="max-height:240px;object-fit:contain;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="border-top:1px solid #f1f5f9;">
                                                    <button type="button" class="btn-act btn-outline-sl" data-bs-dismiss="modal">
                                                        <i class="bi bi-x"></i> Tutup
                                                    </button>
                                                    <button type="submit" class="btn-act btn-blue">
                                                        <i class="bi bi-check2"></i> Update Status
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Belum ada data pembayaran untuk bulan ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($data->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $data->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection