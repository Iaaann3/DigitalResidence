@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .form-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 0;
        width: 100%;
    }

    .form-header {
        background: linear-gradient(135deg, #1a2f7a 0%, #2551a3 100%);
        padding: 2rem 2.5rem;
        color: white;
    }

    .form-header .breadcrumb-text {
        font-size: 0.72rem;
        opacity: 0.75;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 0.3rem;
    }

    .form-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .form-header p {
        font-size: 0.85rem;
        opacity: 0.8;
        margin: 0.25rem 0 0;
    }

    .form-body {
        background: #f0f4f8;
        padding: 2rem 2.5rem 3rem;
    }

    .form-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

    .alert-custom {
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
        color: #dc2626;
        font-size: 0.875rem;
    }

    .alert-custom ul {
        margin: 0.4rem 0 0 1rem;
        padding: 0;
    }

    .section-title {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #94a3b8;
        margin: 0 0 1.2rem;
        padding-bottom: 0.6rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .field-group {
        margin-bottom: 1.1rem;
    }

    .field-group label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.4rem;
    }

    .field-group .optional-tag {
        font-weight: 400;
        color: #94a3b8;
        font-size: 0.75rem;
        margin-left: 0.3rem;
    }

    .field-group input {
        width: 100%;
        padding: 0.65rem 1rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.2s;
        outline: none;
        box-sizing: border-box;
    }

    .field-group input:focus {
        border-color: #25a366;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,163,102,0.1);
    }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }

    .btn-submit {
        padding: 0.7rem 2rem;
        background: linear-gradient(135deg, #1a3a7a, #2538a3);
        color: white;
        border: none;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(37,163,102,0.35);
    }

    .btn-cancel {
        padding: 0.7rem 1.5rem;
        background: #fff;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #f1f5f9;
        color: #475569;
        text-decoration: none;
    }

    @media (max-width: 576px) {
        .form-header, .form-body { padding: 1.2rem; }
        .form-card { padding: 1.2rem; }
        .field-row { grid-template-columns: 1fr; }
    }
</style>

<div class="form-wrap">
    <div class="form-header">
        <div class="breadcrumb-text">Manajemen User → Edit</div>
        <h1>✏️ Edit User</h1>
        <p>Perbarui informasi data penghuni</p>
    </div>

    <div class="form-body">

        @if ($errors->any())
            <div class="alert-custom">
                <strong>⚠️ Terdapat kesalahan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="section-title">Informasi Pribadi</div>

                <div class="field-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="contoh@email.com" required>
                    </div>
                    <div class="field-group">
                        <label>No Telepon</label>
                        <input type="text" name="no_tlp" value="{{ old('no_tlp', $user->no_tlp) }}" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label>No Rumah</label>
                        <input type="text" name="no_rumah" value="{{ old('no_rumah', $user->no_rumah) }}" placeholder="Contoh: A-12" required>
                    </div>
                    <div class="field-group">
                        <label>Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $user->alamat) }}" placeholder="Alamat lengkap" required>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="section-title">Keamanan Akun</div>

                <div class="field-row">
                    <div class="field-group">
                        <label>Password <span class="optional-tag">(opsional)</span></label>
                        <input type="password" name="password" placeholder="Biarkan kosong jika tidak diubah">
                    </div>
                    <div class="field-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</div>
@endsection