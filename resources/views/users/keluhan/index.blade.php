@extends('layouts.user')

@section('content')
<div class="mobile-container">
    <div class="main-content">
        <h3 class="section-title">Keluhan Saya</h3>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Keluhan --}}
        <form id="keluhanForm" action="{{ route('user.keluhan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Keluhan</label>
                <input type="text" 
                       name="judul" 
                       id="judul" 
                       class="form-control @error('judul') is-invalid @enderror" 
                       placeholder="Contoh: Lampu Jalan Rusak di Gang 5" 
                       value="{{ old('judul') }}" 
                       required>
                @error('judul')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="isi" class="form-label">Deskripsi Keluhan</label>
                <textarea 
                    name="isi" 
                    id="isi" 
                    rows="4" 
                    class="form-control @error('isi') is-invalid @enderror" 
                    placeholder="Jelaskan masalah secara detail...">{{ old('isi') }}</textarea>
                
                @error('isi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Bukti (Max 10 Foto, Drag & Drop)</label>
                <div id="dropzone" class="dropzone border border-2 border-dashed rounded p-4 text-center bg-light" style="min-height: 150px; cursor: pointer;">
                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Drag & drop foto di sini, atau klik untuk pilih (Max 10 Foto, JPG/PNG, 2MB)</p>
                    <input type="file" id="photoInput" name="photos[]" multiple accept="image/*" class="d-none">
                </div>
                <small class="text-muted d-block mt-2">Preview akan muncul di bawah setelah pilih foto.</small>
                @error('photos')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div id="photoPreview" class="row g-2 mb-3" style="display: none;"></div>

            <button type="submit" class="btn btn-danger" id="submitBtn">
                <i class="fas fa-paper-plane me-2"></i>Kirim Keluhan
            </button>
        </form>

        <hr class="my-4">

        {{-- Riwayat Keluhan dengan Balasan --}}
        <h5 class="mb-3">Riwayat Keluhan Anda</h5>
        
        @forelse($keluhans as $item)
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <strong class="text-dark">{{ $item->judul }}</strong>
                        <span class="badge ms-2 {{ $item->status == 'pending' ? 'bg-warning' : ($item->status == 'diproses' ? 'bg-info' : 'bg-success') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <small class="text-muted">{{ $item->created_at->format('d M Y H:i') }}</small>
                </div>
                
                <div class="card-body">
                    {{-- Deskripsi Keluhan --}}
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Deskripsi:</h6>
                        <p class="mb-0">{{ $item->isi }}</p>
                    </div>

                    {{-- Foto Keluhan User --}}
                    @if($item->photos && count($item->photos) > 0)
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Foto Bukti Anda:</h6>
                            <div class="row g-2">
                                @foreach($item->photos as $photo)
                                    <div class="col-4 col-sm-3">
                                        <a href="{{ Storage::url($photo) }}" target="_blank" class="d-block">
                                            <img src="{{ Storage::url($photo) }}" 
                                                 class="img-fluid rounded" 
                                                 style="height: 80px; width: 100%; object-fit: cover;" 
                                                 alt="Foto Keluhan">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Balasan dari Admin --}}
                    @if($item->balasan && count($item->balasan) > 0)
                        <div class="border-start border-3 border-primary ps-3 mt-3 pt-3">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-reply me-2"></i>Balasan dari Admin:
                                <span class="badge bg-primary ms-2">{{ count($item->balasan) }} balasan</span>
                            </h6>
                            
                            @foreach($item->balasan->sortBy('created_at') as $balasan)
                                <div class="mb-3 p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <strong class="text-dark">
                                                <i class="fas fa-user-shield me-1"></i>
                                                {{ $balasan->admin->name ?? 'Administrator' }}
                                            </strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                {{ $balasan->created_at->format('d M Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <p class="mb-2">{{ $balasan->pesan }}</p>
                                    
                                    {{-- Foto Bukti dari Admin --}}
                                    @if($balasan->photos && count($balasan->photos) > 0)
                                        <div class="mt-2">
                                            <small class="text-muted d-block mb-2">
                                                <i class="fas fa-images me-1"></i>Bukti foto:
                                            </small>
                                            <div class="row g-2">
                                                @foreach($balasan->photos as $photo)
                                                    <div class="col-3 col-sm-2">
                                                        <a href="{{ Storage::url($photo) }}" target="_blank" class="d-block">
                                                            <img src="{{ Storage::url($photo) }}" 
                                                                 class="img-thumbnail" 
                                                                 style="height: 60px; width: 100%; object-fit: cover;" 
                                                                 alt="Bukti Perbaikan">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mt-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-3 fa-lg"></i>
                                <div>
                                    <strong>Belum ada balasan</strong>
                                    <p class="mb-0 small">Keluhan Anda sedang diproses oleh admin.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" 
                                class="btn btn-sm btn-outline-secondary me-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#detailKeluhanModal{{ $item->id }}">
                            <i class="fas fa-eye me-1"></i>Detail
                        </button>
                        
                        @if($item->status != 'selesai')
                            <form action="{{ route('user.keluhan.destroy', $item) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus keluhan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Modal Detail Keluhan --}}
            <div class="modal fade" id="detailKeluhanModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Keluhan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <h6>{{ $item->judul }}</h6>
                            <p>{{ $item->isi }}</p>
                            
                            @if($item->photos && count($item->photos) > 0)
                                <h6 class="mt-3">Foto Bukti:</h6>
                                <div class="row g-2">
                                    @foreach($item->photos as $photo)
                                        <div class="col-4">
                                            <a href="{{ Storage::url($photo) }}" target="_blank">
                                                <img src="{{ Storage::url($photo) }}" 
                                                     class="img-fluid rounded" 
                                                     alt="Foto Keluhan">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada keluhan</h5>
                <p class="text-muted">Mulai laporkan keluhan Anda</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if($keluhans->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $keluhans->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('keluhanForm');
    const submitBtn = document.getElementById('submitBtn');
    const preview = document.getElementById('photoPreview');
    const dropzoneDiv = document.getElementById('dropzone');
    const photoInput = document.getElementById('photoInput');

    let uploadedFiles = [];

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

    // File input change
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
            alert('Hanya file gambar JPG/PNG max 2MB yang diizinkan!');
        }

        if (uploadedFiles.length + validFiles.length > 10) {
            alert('Maksimal 10 foto!');
            return;
        }

        validFiles.forEach((file, index) => {
            uploadedFiles.push(file);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-3 position-relative';
                col.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail rounded" style="width:100%; height:80px; object-fit:cover;">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle" onclick="removePhoto(${uploadedFiles.length - 1})" style="width:20px; height:20px; font-size:10px; margin:2px;">×</button>
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });

        if (uploadedFiles.length > 0) {
            preview.style.display = 'flex';
        }
        photoInput.value = '';
    }

    window.removePhoto = function(index) {
        uploadedFiles.splice(index, 1);
        const cols = preview.querySelectorAll('div');
        cols[index].remove();
        if (preview.children.length === 0) {
            preview.style.display = 'none';
        }
    };

    // Submit form dengan AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const judul = document.getElementById('judul').value.trim();
        const isi = document.getElementById('isi').value.trim();
        
        if (!judul || !isi) {
            alert('Judul dan deskripsi harus diisi!');
            return;
        }

        const formData = new FormData(form);
        uploadedFiles.forEach(file => {
            formData.append('photos[]', file);
        });

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
        submitBtn.disabled = true;

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                form.reset();
                uploadedFiles = [];
                preview.innerHTML = '';
                preview.style.display = 'none';
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                alert(data.message || 'Gagal mengirim keluhan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        })
        .finally(() => {
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Keluhan';
            submitBtn.disabled = false;
        });
    });
});
</script>

{{-- CSS Tambahan --}}
<style>
.dropzone:hover {
    background-color: #f8f9fa !important;
    border-color: #0d6efd !important;
}

.border-info {
    border-color: #0dcaf0 !important;
}

.bg-light-blue {
    background-color: #e7f5ff !important;
}

.card {
    border-radius: 10px;
    border: 1px solid #e0e0e0;
}

.card-header {
    border-bottom: 2px solid #f0f0f0;
}

.badge {
    font-size: 0.75em;
    padding: 0.35em 0.65em;
}

.img-thumbnail {
    transition: transform 0.2s;
}

.img-thumbnail:hover {
    transform: scale(1.05);
}

.alert-info {
    background-color: #e7f5ff;
    border-color: #0dcaf0;
    color: #055160;
}
</style>
@endpush
@endsection