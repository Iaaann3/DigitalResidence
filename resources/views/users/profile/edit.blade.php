@extends('layouts.user')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
        }

        .profile-container {
            max-width: 1000px;
            margin: 0 auto 40px auto;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        }

        /* Header Gradient */
        .edit-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 20px 24px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }

        .edit-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Body Form */
        .edit-body {
            padding: 40px 32px 80px 32px;
        }

        .form-label {
            font-weight: 600;
            color: #1e293b;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background: #f1f5f9;
            cursor: not-allowed;
        }

        /* Avatar Preview */
        .avatar-preview {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 24px;
        }

        .avatar-preview .avatar-circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 60px;
            font-weight: 700;
            border: 5px solid white;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Tombol */
        .btn-back,
        .btn-primary {
            padding: 12px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
        }

        .btn-back {
            background: transparent;
            border: 0.5px solid #cbd5e1;
            color: #64748b;
        }

        .btn-back:hover {
            background: #eff6ff;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: #3b82f6;
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        /* Responsive */
        @media (max-width: 767px) {
            .profile-container {
                margin: 0 0 40px 0;
                border-radius: 0;
                box-shadow: none;
            }

            .edit-header {
                padding: 24px 16px;
            }

            .edit-header h2 {
                font-size: 22px;
            }

            .edit-body {
                padding: 32px 20px 100px 20px;
            }

            .avatar-preview {
                width: 120px;
                height: 120px;
            }

            .avatar-preview .avatar-circle {
                font-size: 50px;
            }

            .btn-back,
            .btn-primary {
                font-size: 1.05rem;
                padding: 14px 24px;
            }
        }

        /* Custom Save Confirmation Modal */
        .save-modal {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(10px);
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }

        .modal-content {
            background: white;
            width: 100%;
            max-width: 340px;
            border-radius: 20px;
            padding: 32px 24px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalPop 0.4s ease;
        }

        @keyframes modalPop {
            from {
                opacity: 0;
                transform: scale(0.75) translateY(40px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
        }

        .modal-text {
            font-size: 15.5px;
            color: #64748b;
            line-height: 1.55;
            margin-bottom: 32px;
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
        }

        .modal-btn {
            flex: 1;
            padding: 15px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
        }

        .modal-btn-cancel {
            background: #f1f5f9;
            color: #475569;
        }

        .modal-btn-cancel:hover {
            background: #e2e8f0;
        }

        .modal-btn-save {
            background: #3b82f6;
            color: white;
        }

        .modal-btn-save:hover {
            background: #2563eb;
        }

        @media (max-width: 480px) {
            .modal-content {
                padding: 28px 20px;
            }
        }
    </style>

    <div class="profile-container">
        <!-- Header Gradient -->
        <div class="edit-header">
            <h2>Edit Profil</h2>
        </div>

        <div class="edit-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form id="edit-form" method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Foto Profil -->
                <div class="text-center mb-5">
                    <label class="form-label fw-bold mb-3 d-block">Foto Profil</label>
                    <div class="avatar-preview">
                        <div class="avatar-circle" id="avatar-container">
                            @if($user->profile_photo_path)
                                <img src="{{ Storage::url($user->profile_photo_path) }}" id="preview-img" alt="Foto Profil">
                            @else
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                    </div>
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="form-control form-control-sm w-75 mx-auto mt-3">
                    <small class="text-muted mt-2 d-block">Format: jpg, png, jpeg • Maks 2MB</small>
                    @error('profile_photo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama & Email -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6 form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- No Rumah -->
                <div class="mb-4 form-group">
                    <label class="form-label">No. Rumah</label>
                    <input type="text" class="form-control bg-light" value="{{ $user->no_rumah ?? '-' }}" disabled readonly>
                    <small class="text-muted">Tidak dapat diubah</small>
                </div>

                <!-- No Telepon & Alamat -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6 form-group">
                        <label for="no_tlp" class="form-label">No. Telepon</label>
                        <input type="text" name="no_tlp" id="no_tlp" class="form-control" value="{{ old('no_tlp', $user->no_tlp) }}">
                        @error('no_tlp') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Ubah Password -->
                <div class="mb-5 form-group">
                    <h5 class="fw-bold mb-3">Ubah Password</h5>
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" autocomplete="current-password">
                            @error('current_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
                            @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block">Kosongkan jika tidak ingin mengubah password.</small>
                </div>

                <!-- Tombol -->
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mt-5">
                    <a href="{{ route('user.profile.index') }}" class="btn btn-back w-100 w-md-auto">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="button" id="save-btn" class="btn btn-primary w-100 w-md-auto">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Pop-up Konfirmasi Simpan -->
    <div class="save-modal" id="save-modal">
        <div class="modal-content">
            <h3 class="modal-title">Konfirmasi Perubahan</h3>
            <p class="modal-text">Apakah Anda yakin ingin menyimpan perubahan profil ini?</p>
            
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-cancel" id="cancel-save">Batal</button>
                <button class="modal-btn modal-btn-save" id="confirm-save">Simpan</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Preview Foto
        const input = document.getElementById('profile_photo');
        if (input) {
            input.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (event) => {
                    const container = document.getElementById('avatar-container');
                    container.innerHTML = `<img id="preview-img" src="${event.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
                };
                reader.readAsDataURL(file);
            });
        }

        // Konfirmasi Simpan
        const saveBtn = document.getElementById('save-btn');
        const modal = document.getElementById('save-modal');
        const cancelBtn = document.getElementById('cancel-save');
        const confirmBtn = document.getElementById('confirm-save');
        const form = document.getElementById('edit-form');

        if (saveBtn && modal) {
            saveBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        }

        if (confirmBtn && form) {
            confirmBtn.addEventListener('click', function() {
                form.submit();
            });
        }

        // Klik di luar modal untuk menutup
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush