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
    .page-header .breadcrumb-text {
        font-size: 0.72rem;
        opacity: 0.75;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 0.3rem;
    }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; margin: 0; }
    .page-header p  { font-size: 0.85rem; opacity: 0.8; margin: 0.25rem 0 0; }

    .page-body { background: #f0f4f8; padding: 2rem 2.5rem 3rem; }

    .card-box {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2rem;
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
    .alert-box.danger  { background: #fff5f5; border: 1px solid #fecaca; color: #dc2626; }
    .alert-box.info    { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; }
    .alert-box .btn-close-x {
        margin-left: auto; background: none; border: none;
        cursor: pointer; opacity: 0.5; font-size: 1rem; padding: 0;
    }
    .alert-box .btn-close-x:hover { opacity: 1; }

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

    .field-group { margin-bottom: 1.2rem; }
    .field-group label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.4rem;
    }
    .field-group small { font-size: 0.75rem; color: #94a3b8; margin-top: 0.3rem; display: block; }

    .input-wrap {
        display: flex;
        align-items: center;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        background: #f8fafc;
        transition: all 0.2s;
    }
    .input-wrap:focus-within {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .input-prefix {
        padding: 0.65rem 1rem;
        background: #f1f5f9;
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 600;
        border-right: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }
    .input-wrap input {
        flex: 1;
        border: none;
        padding: 0.65rem 1rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        color: #1e293b;
        background: transparent;
        outline: none;
    }
    .input-wrap input[readonly] {
        color: #94a3b8;
        cursor: not-allowed;
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
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
    }

    .btn-act {
        padding: 0.7rem 1.8rem;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
    }
    .btn-act:hover { transform: translateY(-1px); text-decoration: none; }
    .btn-blue { background: linear-gradient(135deg,#1e40af,#3b82f6); color: #fff; }
    .btn-blue:hover { box-shadow: 0 6px 16px rgba(59,130,246,0.35); color: #fff; }
    .btn-cancel { background: #fff; color: #64748b; border: 1.5px solid #e2e8f0; }
    .btn-cancel:hover { background: #f1f5f9; color: #475569; }

    @media(max-width:768px) {
        .page-header, .page-body { padding: 1.2rem; }
        .card-box { padding: 1.2rem; }
        .field-row { grid-template-columns: 1fr; }
    }
</style>

<div class="page-wrap">
    <div class="page-header">
        <div class="breadcrumb-text">Pengaturan &rarr; Biaya Pembayaran</div>
        <h1><i class="bi bi-gear me-2"></i>Atur Biaya Pembayaran</h1>
        <p>Periode: {{ now()->format('F Y') }}</p>
    </div>

    <div class="page-body">

        @if(session('success'))
            <div class="alert-box success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button class="btn-close-x" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-box danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ session('error') }}</span>
                <button class="btn-close-x" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert-box info">
                <i class="bi bi-info-circle-fill"></i>
                <span>{{ session('info') }}</span>
                <button class="btn-close-x" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        <form action="{{ route('admin.biaya_setting.store') }}" method="POST">
            @csrf

            <div class="card-box">
                <div class="section-title">Nominal Biaya</div>

                <div class="field-row">
                    <div class="field-group">
                        <label><i class="bi bi-shield-check me-1"></i> Biaya Keamanan</label>
                        <div class="input-wrap">
                            <span class="input-prefix">Rp</span>
                            <input type="number" name="keamanan" value="{{ old('keamanan') }}" placeholder="0" required>
                        </div>
                        <small>Iuran keamanan per bulan per rumah</small>
                    </div>
                    <div class="field-group">
                        <label><i class="bi bi-stars me-1"></i> Biaya Kebersihan</label>
                        <div class="input-wrap">
                            <span class="input-prefix">Rp</span>
                            <input type="number" name="kebersihan" value="{{ old('kebersihan') }}" placeholder="0" required>
                        </div>
                        <small>Iuran kebersihan per bulan per rumah</small>
                    </div>
                </div>
            </div>

            <div class="card-box">
                <div class="section-title">Jadwal Tagihan</div>

                <div class="field-row">
                    <div class="field-group">
                        <label><i class="bi bi-calendar-event me-1"></i> Tanggal Tagih</label>
                        <div class="input-wrap">
                            <span class="input-prefix"><i class="bi bi-calendar3"></i></span>
                            <input type="date" value="{{ $tanggal_tagih->format('Y-m-d') }}" readonly>
                        </div>
                        <small><i class="bi bi-info-circle me-1"></i>Otomatis tanggal 5 setiap bulan</small>
                    </div>
                    <div class="field-group">
                        <label><i class="bi bi-calendar-x me-1"></i> Tanggal Jatuh Tempo</label>
                        <div class="input-wrap">
                            <span class="input-prefix"><i class="bi bi-calendar3"></i></span>
                            <input type="date" value="{{ $tanggal_jatuh_tempo->format('Y-m-d') }}" readonly>
                        </div>
                        <small><i class="bi bi-info-circle me-1"></i>Otomatis tanggal 20 setiap bulan</small>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.biaya_setting.index') }}" class="btn-act btn-cancel">
                    <i class="bi bi-x"></i> Batal
                </a>
                <button type="submit" class="btn-act btn-blue">
                    <i class="bi bi-save"></i> Simpan Pengaturan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection