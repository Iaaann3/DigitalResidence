@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Detail Keluhan User</h1>
    <div class="card w-100 mt-2" style="max-width:1200px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Detail Keluhan #{{ $keluhan->id }}</h4>
            <a href="{{ route('admin.keluhan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <div class="card-body pt-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Info Keluhan --}}
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">User:</label>
                    <p class="mb-0">{{ $keluhan->user->name ?? 'Unknown' }}<br>
                    <small class="text-muted">{{ $keluhan->user->email ?? '-' }}</small></p>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tanggal:</label>
                    <p class="mb-0">{{ $keluhan->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Judul:</label>
                    <p class="mb-0">{{ $keluhan->judul }}</p>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Isi:</label>
                    <div class="p-3 border rounded bg-light">
                        {!! nl2br(e($keluhan->isi)) !!}
                    </div>
                </div>

                @if($keluhan->photos && count($keluhan->photos) > 0)
                <div class="col-12">
                    <label class="form-label fw-bold">Foto User ({{ count($keluhan->photos) }}):</label>
                    <div class="row g-2">
                        @foreach($keluhan->photos as $photo)
                        <div class="col-md-4">
                            <div class="card">
                                <img src="{{ Storage::url($photo) }}" class="card-img-top img-fluid" alt="Foto Keluhan" style="height: 200px; object-fit: cover;">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="col-md-6">
                    <label class="form-label fw-bold">Status:</label>
                    <span class="badge {{ $keluhan->status == 'pending' ? 'bg-warning' : ($keluhan->status == 'diproses' ? 'bg-info' : 'bg-success') }}">
                        {{ ucfirst($keluhan->status) }}
                    </span>
                </div>
            </div>

            <hr class="my-4">

            {{-- RIWAYAT BALASAN ADMIN --}}
            <div class="mb-5">
                <h5 class="mb-3 d-flex align-items-center">
                    <i class="fas fa-history me-2"></i>Riwayat Balasan Admin
                    @if($keluhan->balasan && $keluhan->balasan->count() > 0)
                        <span class="badge bg-primary ms-2">{{ $keluhan->balasan->count() }} balasan</span>
                    @endif
                </h5>

                @if($keluhan->balasan && $keluhan->balasan->count() > 0)
                    <div class="timeline">
                        @foreach($keluhan->balasan->sortByDesc('created_at') as $balasan)
                            <div class="timeline-item mb-4">
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>
                                                <i class="fas fa-user-shield me-1"></i>
                                                {{ $balasan->admin->username ?? 'Admin' }}
                                            </strong>
                                            <small class="text-muted ms-2">
                                                {{ $balasan->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                        @if($balasan->photos && is_array($balasan->photos) && count($balasan->photos) > 0)
                                            <span class="badge bg-info">
                                                <i class="fas fa-camera me-1"></i>
                                                {{ count($balasan->photos) }} foto
                                            </span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2">{{ $balasan->pesan }}</p>
                                        
                                        {{-- Foto Bukti Admin --}}
                                        @if($balasan->photos && is_array($balasan->photos) && count($balasan->photos) > 0)
                                            <div class="mt-3">
                                                <small class="text-muted d-block mb-2">Foto bukti:</small>
                                                <div class="row g-2">
                                                    @foreach($balasan->photos as $photo)
                                                        <div class="col-md-3 col-sm-4 col-6">
                                                            @if(Storage::disk('public')->exists($photo))
                                                                <a href="{{ Storage::url($photo) }}" target="_blank" class="d-block">
                                                                    <img src="{{ Storage::url($photo) }}" 
                                                                         class="img-thumbnail rounded" 
                                                                         style="height: 120px; width: 100%; object-fit: cover;"
                                                                         alt="Bukti">
                                                                    <small class="text-center d-block mt-1">Bukti {{ $loop->iteration }}</small>
                                                                </a>
                                                            @else
                                                                <div class="bg-danger text-white p-2 text-center">
                                                                    File tidak ditemukan
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer bg-white">
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            Dibalas {{ $balasan->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <strong>Belum ada balasan</strong>
                                <p class="mb-0">Kirim balasan pertama untuk keluhan ini.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <hr class="my-4">

            {{-- FORM KIRIM BALASAN BARU --}}
            <h5 class="mt-5 mb-3 d-flex align-items-center">
                <i class="fas fa-reply me-2"></i>Kirim Balasan Baru
            </h5>
            
            <form id="replyForm" class="mb-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="keluhan_id" value="{{ $keluhan->id }}">

                <div class="mb-3">
                    <label for="pesan" class="form-label fw-bold">Pesan Balasan <span class="text-danger">*</span></label>
                    <textarea name="pesan" id="pesan" rows="4" class="form-control @error('pesan') is-invalid @enderror" required placeholder="Contoh: Jalan sudah diperbaiki hari ini. Berikut bukti hasil perbaikan...">{{ old('pesan') }}</textarea>
                    @error('pesan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Foto Bukti (Max 10 Foto, Drag & Drop)</label>
                    <div id="dropzone" class="dropzone border border-2 border-dashed rounded p-4 text-center bg-light" style="min-height: 150px; cursor: pointer;">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Drag & drop foto di sini, atau klik untuk pilih (Max 10 Foto, JPG/PNG, 2MB)</p>
                        <input type="file" id="photoInput" name="photos[]" multiple accept="image/*" class="d-none">
                    </div>
                    <small class="text-muted d-block mt-2">Preview akan muncul di bawah setelah pilih foto.</small>
                </div>

                <div id="photoPreview" class="row g-2 mb-3" style="display: none;"></div>
            </form>

            <div class="d-flex justify-content-end gap-2">
                <!-- Update Status Form -->
                <form action="{{ route('admin.keluhan.update.status', $keluhan) }}" method="POST" class="d-inline">
                    @csrf 
                    @method('PATCH')
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">Status:</span>
                        <select name="status" class="form-select" onchange="this.form.submit()" style="width: auto;">
                            <option value="pending" {{ $keluhan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $keluhan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $keluhan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </form>

                <!-- Tombol Kirim -->
                <button type="submit" class="btn btn-primary px-4" id="submitBtn" form="replyForm">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Balasan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-item {
    position: relative;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -25px;
    top: 20px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #0d6efd;
    border: 2px solid white;
    box-shadow: 0 0 0 3px #0d6efd;
}

.card {
    border-left: 3px solid #0d6efd;
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.dropzone:hover {
    background-color: #f8f9fa !important;
    border-color: #0d6efd !important;
}

.badge {
    font-size: 0.8em;
    padding: 0.4em 0.8em;
}

.input-group {
    width: auto;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script detail keluhan ADMIN dengan riwayat');

    const form = document.getElementById('replyForm');
    const submitBtn = document.getElementById('submitBtn');
    const preview = document.getElementById('photoPreview');
    const dropzoneDiv = document.getElementById('dropzone');
    const photoInput = document.getElementById('photoInput');

    let uploadedFiles = [];

    // Pastikan elemen ada
    if (!dropzoneDiv || !photoInput || !preview) {
        console.error('Elemen tidak ditemukan!');
        return;
    }

    // Klik dropzone
    dropzoneDiv.addEventListener('click', function(e) {
        photoInput.click();
    });

    // Drag & Drop Events
    dropzoneDiv.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropzoneDiv.style.backgroundColor = '#e3f2fd';
        dropzoneDiv.style.borderColor = '#2196f3';
    });

    dropzoneDiv.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropzoneDiv.style.backgroundColor = '';
        dropzoneDiv.style.borderColor = '';
    });

    dropzoneDiv.addEventListener('drop', function(e) {
        e.preventDefault();
        dropzoneDiv.style.backgroundColor = '';
        dropzoneDiv.style.borderColor = '';
        processFiles(e.dataTransfer.files);
    });

    // Change file input
    photoInput.addEventListener('change', function(e) {
        processFiles(e.target.files);
    });

    function processFiles(files) {
        const validFiles = Array.from(files).filter(file => {
            if (!file.type.startsWith('image/')) {
                return false;
            }
            if (file.size > 2 * 1024 * 1024) {
                return false;
            }
            return true;
        });

        if (validFiles.length !== files.length) {
            alert('Hanya file gambar JPG/PNG/GIF maksimal 2MB!');
        }

        if (uploadedFiles.length + validFiles.length > 10) {
            alert('Maksimal 10 foto total!');
            return;
        }

        validFiles.forEach((file, index) => {
            uploadedFiles.push(file);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-3 position-relative mb-2';
                col.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail rounded" style="width:100%; height:80px; object-fit:cover;" alt="${file.name}">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle" onclick="removePhoto(${uploadedFiles.length - 1})" style="width:20px; height:20px; font-size:10px; margin:2px;">×</button>
                    <small class="text-center d-block mt-1" style="font-size: 10px;">${file.name.length > 15 ? file.name.substring(0, 12) + '...' : file.name}</small>
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });

        if (uploadedFiles.length > 0) {
            preview.style.display = 'flex';
            preview.classList.add('flex-wrap');
        }
    }

    window.removePhoto = function(index) {
        uploadedFiles.splice(index, 1);
        const cols = preview.querySelectorAll('div');
        if (cols[index]) cols[index].remove();
        if (preview.children.length === 0) preview.style.display = 'none';
    };

    // Tangani submit form
    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();

        const pesan = document.getElementById('pesan').value.trim();
        if (!pesan) {
            alert('Pesan balasan wajib diisi!');
            return;
        }

        const formData = new FormData(form);
        uploadedFiles.forEach((file, index) => {
            formData.append('photos[]', file);
        });

        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
        submitBtn.disabled = true;

        fetch("{{ route('admin.keluhan.reply', $keluhan) }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                alert(data.message || 'Balasan berhasil dikirim!');
                form.reset();
                uploadedFiles = [];
                preview.innerHTML = '';
                preview.style.display = 'none';
                
                // Reload halaman untuk update riwayat
                setTimeout(() => {
                    location.reload();
                }, 1000);
                
            } else {
                alert(data.message || 'Error mengirim!');
            }
        })
        .catch(error => {
            console.error('Submit Error:', error);
            let msg = 'Error mengirim balasan.';
            if (error.message) msg += ' Detail: ' + error.message;
            if (error.errors) msg += ' Validasi: ' + Object.values(error.errors)[0][0];
            alert(msg);
        })
        .finally(() => {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        });
    });
});
</script>
@endpush