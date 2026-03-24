@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .page-wrap { font-family: 'Plus Jakarta Sans', sans-serif; width: 100%; }

    .page-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
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
    .data-table tbody td.text-left { text-align: left; color: #64748b; }

    .thumb-wrap {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        overflow: hidden;
        margin: 0 auto;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid #e2e8f0;
    }
    .thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .thumb-wrap i { font-size: 1.5rem; color: #cbd5e1; }

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
    .btn-edit   { background: #fef3c7; color: #b45309; }
    .btn-edit:hover   { background: #fde68a; color: #92400e; }
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; color: #b91c1c; }

    .empty-state { padding: 3rem 1rem; text-align: center; color: #94a3b8; }
    .empty-state i { font-size: 2.5rem; margin-bottom: 0.5rem; display: block; }
    .empty-state p { font-size: 0.9rem; margin: 0; }

    @media(max-width:768px) {
        .page-header, .page-body { padding: 1.2rem; }
        .card-box { padding: 1rem; }
    }
</style>

<div class="page-wrap">
    <div class="page-header">
        <div>
            <h1><i class="bi bi-megaphone me-2"></i>Data Iklan</h1>
            <p>Kelola iklan yang tampil di aplikasi</p>
        </div>
        <a href="{{ route('admin.iklan.create') }}" class="btn-act btn-blue">
            <i class="bi bi-plus-circle"></i> Tambah Iklan
        </a>
    </div>

    <div class="page-body">
        <div class="card-box">
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama User</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($iklans as $iklan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="name-col">{{ $iklan->user->name ?? '-' }}</td>
                                <td class="text-left"><strong>{{ $iklan->judul }}</strong></td>
                                <td class="text-left" style="max-width:220px;">
                                    {{ Str::limit($iklan->deskripsi, 60, '...') }}
                                </td>
                                <td>
                                    <div class="thumb-wrap">
                                        @if($iklan->gambar)
                                            <img src="{{ asset('storage/' . $iklan->gambar) }}"
                                                 alt="{{ $iklan->judul }}"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <i class="bi bi-image" style="display:none;"></i>
                                        @else
                                            <i class="bi bi-image"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('admin.iklan.edit', $iklan->id) }}"
                                           class="btn-sm-act btn-edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.iklan.destroy', $iklan->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus iklan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-sm-act btn-delete">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="bi bi-megaphone"></i>
                                        <p>Belum ada data iklan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($iklans->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $iklans->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection