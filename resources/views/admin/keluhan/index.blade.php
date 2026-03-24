@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .page-wrap { font-family: 'Plus Jakarta Sans', sans-serif; width: 100%; }

    .page-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        padding: 1.8rem 2.5rem;
        color: white;
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

    .alert-box {
        border-radius: 10px;
        padding: 0.9rem 1.2rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .alert-box.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
    .alert-box .btn-close-x {
        margin-left: auto; background: none; border: none;
        cursor: pointer; opacity: 0.5; font-size: 1rem; padding: 0;
    }
    .alert-box .btn-close-x:hover { opacity: 1; }

    .toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.2rem;
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
    .search-bar input { min-width: 220px; }
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
    .btn-blue { background: linear-gradient(135deg,#1e40af,#3b82f6); color: #fff; }
    .btn-blue:hover { box-shadow: 0 4px 12px rgba(59,130,246,0.35); color: #fff; }
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
    }
    .data-table tbody td.name-col { font-weight: 600; color: #1e293b; text-align: left; }
    .data-table tbody td.text-left { text-align: left; }

    .badge-status {
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        white-space: nowrap;
    }
    .badge-pending  { background: #fef9c3; color: #b45309; }
    .badge-diproses { background: #dbeafe; color: #1e40af; }
    .badge-selesai  { background: #dcfce7; color: #16a34a; }

    .badge-foto {
        background: #eff6ff;
        color: #3b82f6;
        padding: 0.25rem 0.65rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .date-badge {
        background: #f1f5f9;
        color: #64748b;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.78rem;
        white-space: nowrap;
    }

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
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; color: #b91c1c; }

    .empty-state { padding: 3rem 1rem; text-align: center; color: #94a3b8; }
    .empty-state i { font-size: 2.5rem; margin-bottom: 0.5rem; display: block; }
    .empty-state p { font-size: 0.9rem; margin: 0; }

    @media(max-width:768px) {
        .page-header, .page-body { padding: 1.2rem; }
        .card-box { padding: 1rem; }
        .toolbar { flex-direction: column; align-items: flex-start; }
        .search-bar input { min-width: 150px; }
    }
</style>

<div class="page-wrap">
    <div class="page-header">
        <h1><i class="bi bi-exclamation-circle me-2"></i>Keluhan Warga</h1>
        <p>Daftar keluhan yang masuk dari penghuni</p>
    </div>

    <div class="page-body">

        @if(session('success'))
            <div class="alert-box success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button class="btn-close-x" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        <div class="card-box">
            <div class="toolbar">
                <form method="GET" action="{{ route('admin.keluhan.index') }}" class="search-bar">
                    <input type="text" name="search"
                           placeholder="Cari judul atau nama user..."
                           value="{{ request('search') }}">
                    <select name="status">
                        <option value="all">Semua Status</option>
                        <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                        <option value="diproses"  {{ request('status') == 'diproses'  ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai"   {{ request('status') == 'selesai'   ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <button type="submit" class="btn-act btn-blue">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('admin.keluhan.index') }}" class="btn-act btn-outline-sl">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </form>
            </div>

            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
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
                                <td>{{ $loop->iteration }}</td>
                                <td class="name-col">{{ $keluhan->user->name ?? 'Unknown' }}</td>
                                <td class="text-left">{{ Str::limit($keluhan->judul, 35) }}</td>
                                <td class="text-left" style="max-width:200px;color:#64748b;">
                                    {{ Str::limit($keluhan->isi, 55) }}
                                </td>
                                <td>
                                    @if($keluhan->photos && count($keluhan->photos) > 0)
                                        <span class="badge-foto">
                                            <i class="bi bi-images"></i> {{ count($keluhan->photos) }} foto
                                        </span>
                                    @else
                                        <span style="color:#cbd5e1;font-size:0.8rem;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="date-badge">
                                        {{ $keluhan->created_at->format('d M Y, H:i') }}
                                    </span>
                                </td>
                                <td>
                                    @if($keluhan->status == 'pending')
                                        <span class="badge-status badge-pending">
                                            <i class="bi bi-hourglass-split"></i> Pending
                                        </span>
                                    @elseif($keluhan->status == 'diproses')
                                        <span class="badge-status badge-diproses">
                                            <i class="bi bi-arrow-repeat"></i> Diproses
                                        </span>
                                    @else
                                        <span class="badge-status badge-selesai">
                                            <i class="bi bi-check-circle"></i> Selesai
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('admin.keluhan.show', $keluhan) }}"
                                           class="btn-sm-act btn-detail">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <form action="{{ route('admin.keluhan.destroy', $keluhan) }}"
                                              method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-sm-act btn-delete"
                                                onclick="return confirm('Hapus keluhan? Foto juga ikut terhapus.')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Belum ada keluhan dari warga</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($keluhans->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $keluhans->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection