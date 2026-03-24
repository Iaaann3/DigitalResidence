@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .page-wrap { font-family: 'Plus Jakarta Sans', sans-serif; width: 100%; }

    .page-header {
        background: linear-gradient(135deg, #1a5d7a 0%, #171775 100%);
        padding: 1.8rem 2.5rem;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
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

    .alert-box {
        border-radius: 10px;
        padding: 0.9rem 1.2rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
    }
    .alert-box.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
    .alert-box.warning { background: #fffbeb; border: 1px solid #fde68a; color: #b45309; }
    .alert-box.danger  { background: #fff5f5; border: 1px solid #fecaca; color: #dc2626; }
    .alert-box .btn-close-x {
        margin-left: auto; background: none; border: none;
        cursor: pointer; opacity: 0.5; font-size: 1rem; padding: 0; line-height: 1;
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

    .toolbar-left, .toolbar-right { display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap; }

    .import-area {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        background: #f8fafc;
        border: 1.5px dashed #cbd5e1;
        border-radius: 10px;
        padding: 0.5rem 0.9rem;
    }

    .import-area input[type="file"] {
        font-size: 0.82rem;
        color: #475569;
        border: none;
        background: transparent;
        outline: none;
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
    .btn-green  { background: linear-gradient(135deg,#1a7a4a,#25a366); color: #fff; }
    .btn-green:hover  { box-shadow: 0 4px 12px rgba(37,163,102,0.35); color: #fff; }
    .btn-blue   { background: linear-gradient(135deg,#1e40af,#3b82f6); color: #fff; }
    .btn-blue:hover   { box-shadow: 0 4px 12px rgba(59,130,246,0.35); color: #fff; }
    .btn-outline-sl {
        background: #fff; color: #475569;
        border: 1.5px solid #e2e8f0;
    }
    .btn-outline-sl:hover { background: #f1f5f9; color: #1e293b; }

    .search-bar {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    .search-bar input {
        padding: 0.5rem 0.9rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.85rem;
        outline: none;
        background: #f8fafc;
        min-width: 220px;
        transition: all 0.2s;
    }
    .search-bar input:focus { border-color: #2559a3; background: #fff; box-shadow: 0 0 0 3px rgba(37,163,102,0.1); }

    .per-page-wrap { display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #dfe5ed; }
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

    .data-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
    .data-table thead tr {
        background: linear-gradient(135deg,#1a7a4a,#25a366);
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
        white-space: nowrap;
    }
    .data-table tbody td.name-col { font-weight: 600; color: #1e293b; text-align: left; }
    .data-table tbody td.email-col { color: #64748b; font-size: 0.83rem; text-align: left; }

    .badge-role {
        padding: 0.28rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        background: #dbeafe;
        color: #1e40af;
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
    .btn-edit   { background: #fef3c7; color: #b45309; }
    .btn-edit:hover { background: #fde68a; color: #92400e; }
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; color: #b91c1c; }

    .empty-state { padding: 3rem 1rem; text-align: center; color: #94a3b8; }
    .empty-state .icon { font-size: 2.5rem; margin-bottom: 0.5rem; }
    .empty-state p { font-size: 0.9rem; margin: 0; }

    @media(max-width:768px) {
        .page-header, .page-body { padding: 1.2rem; }
        .toolbar { flex-direction: column; align-items: flex-start; }
        .search-bar input { min-width: 160px; }
    }
</style>

<div class="page-wrap">
    <div class="page-header">
        <div>
            <h1>Daftar User</h1>
            <p>Kelola data penghuni Digital Residence</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-act btn-blue">
            + Tambah User
        </a>
    </div>

    <div class="page-body">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert-box success">
                <span>{{ session('success') }}</span>
                <button class="btn-close-x" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert-box warning">
                <span>⚠️</span>
                <span>{{ session('warning') }}</span>
                <button class="btn-close-x" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-box danger">
                <span>❌</span>
                <span>{{ session('error') }}</span>
                <button class="btn-close-x" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert-box danger">
                <span>❌</span>
                <div>
                    <strong>Terdapat kesalahan:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button class="btn-close-x" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        {{-- Import Card --}}
        <div class="card-box">
            <div class="toolbar">
                <div class="toolbar-left">
                    <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                        @csrf
                        <div class="import-area">
                            <input type="file" name="file" accept=".xlsx,.xls" required>
                        </div>
                        <button type="submit" class="btn-act btn-green"> Import Excel</button>
                    </form>
                    <a href="{{ route('admin.users.downloadTemplate') }}" class="btn-act btn-outline-sl">
                        Download Template
                    </a>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card-box">
            <div class="toolbar">
                <div class="per-page-wrap">
                    <span>Tampilkan</span>
                    <form method="GET" action="{{ route('admin.users.index') }}">
                        <select name="per_page" onchange="this.form.submit()">
                            @foreach([5,10,20,50,100] as $size)
                                <option value="{{ $size }}" {{ request('per_page',10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </form>
                    <span>data</span>
                </div>
                <div class="search-bar">
                    <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email / no rumah...">
                        <button type="submit" class="btn-act btn-green">Cari</button>
                        <a href="{{ route('admin.users.index') }}" class="btn-act btn-outline-sl">Reset</a>
                    </form>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No Rumah</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ ($users->currentPage()-1)*$users->perPage() + $loop->iteration }}</td>
                                <td class="name-col">{{ $user->name }}</td>
                                <td><strong>{{ $user->no_rumah }}</strong></td>
                                <td>{{ $user->no_tlp }}</td>
                                <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;">{{ $user->alamat }}</td>
                                <td class="email-col">{{ $user->email }}</td>
                                <td><span class="badge-role">{{ ucfirst($user->role) }}</span></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-sm-act btn-edit">✏️ Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm-act btn-delete"
                                                onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="icon">👤</div>
                                        <p>Belum ada data user</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection