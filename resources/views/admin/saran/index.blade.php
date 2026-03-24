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
    .page-header p { font-size: 0.85rem; opacity: 0.8; margin: 0.2rem 0 0; }

    .page-body { background: #f0f4f8; padding: 2rem 2.5rem 3rem; }

    .card-box {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

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
    .data-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    .data-table tbody tr:hover { background: #f8fafc; }
    .data-table tbody td {
        padding: 0.85rem 1rem;
        color: #374151;
        text-align: center;
        vertical-align: middle;
    }
    .data-table tbody td.name-col { font-weight: 600; color: #1e293b; text-align: left; }
    .data-table tbody td.email-col { color: #64748b; font-size: 0.83rem; }
    .data-table tbody td.isi-col { text-align: left; max-width: 240px; color: #475569; }

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
    .empty-state .icon { font-size: 2.5rem; margin-bottom: 0.5rem; }
    .empty-state p { font-size: 0.9rem; margin: 0; }

    @media(max-width:768px) {
        .page-header, .page-body { padding: 1.2rem; }
        .card-box { padding: 1rem; }
    }
</style>

<div class="page-wrap">
    <div class="page-header">
        <h1>💬 Saran & Kritik</h1>
        <p>Masukan dari penghuni Digital Residence</p>
    </div>

    <div class="page-body">
        <div class="card-box">
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Isi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kritiks as $saran)
                            <tr>
                                <td>{{ $kritiks->firstItem() + $loop->index }}</td>
                                <td class="name-col">{{ $saran->user->name ?? '-' }}</td>
                                <td class="email-col">{{ $saran->user->email ?? '-' }}</td>
                                <td class="isi-col">{{ Str::limit($saran->isi, 60, '...') }}</td>
                                <td><span class="date-badge">{{ $saran->created_at->format('d M Y, H:i') }}</span></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('admin.saran.show', $saran->id) }}" class="btn-sm-act btn-detail">
                                            🔍 Detail
                                        </a>
                                        <form action="{{ route('admin.saran.destroy', $saran->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm-act btn-delete">🗑️ Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="icon">💬</div>
                                        <p>Belum ada saran & kritik masuk</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($kritiks->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $kritiks->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection