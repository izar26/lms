@extends('layouts.admin')

@section('title', 'Manajemen Testimoni')

@push('styles')
{{-- CSS untuk uploader gambar dan kartu testimoni --}}
<style>
    .image-uploader-wrapper {
        border: 2px dashed #d1d5db;
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background-color 0.2s;
        position: relative;
    }
    .image-uploader-wrapper:hover {
        border-color: var(--bs-primary);
        background-color: #f3f4f6;
    }
    .image-uploader-wrapper .uploader-icon { font-size: 2.5rem; color: #9ca3af; }
    .image-uploader-wrapper .uploader-text { color: #6b7280; font-weight: 500; }
    .image-uploader-wrapper input[type="file"] {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    #image-preview {
        max-width: 100px;
        border-radius: 50%; /* Preview bulat */
        margin-top: 1rem;
        display: none;
    }

    /* Kartu Testimoni Admin */
    .testimonial-admin-card {
        position: relative;
        border: 1px solid var(--bs-border-color, #e5e7eb);
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .testimonial-admin-card .card-body::before {
        content: '“';
        position: absolute;
        top: 0.5rem;
        left: 1rem;
        font-size: 5rem;
        color: rgba(var(--bs-primary-rgb, 79, 70, 229), 0.07);
        line-height: 1;
        z-index: 0;
    }
    .testimonial-admin-card .card-content {
        position: relative;
        z-index: 1;
    }
    .testimonial-admin-card .dropdown-toggle::after {
        display: none; /* Sembunyikan panah default dropdown */
    }
</style>
@endpush


@section('content')
    {{-- Notifikasi Sukses --}}
    @if(session('sukses'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('sukses') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="row g-4">
        {{-- KOLOM KIRI: FORM TAMBAH TESTIMONI --}}
        <div class="col-lg-5">
            <div class="card shadow-sm sticky-top" style="top: 100px;">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Tambah Testimoni Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.testimoni.store', $kursus->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Peserta</label>
                            <input type="text" name="nama_peserta" class="form-control" required placeholder="Contoh: Siti Aisyah">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" required placeholder="Contoh: Web Developer">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Testimoni</label>
                            <textarea name="testimoni" class="form-control" rows="4" required placeholder="Tuliskan testimoni di sini..."></textarea>
                        </div>
                        <div class="mb-3">
                             <label class="form-label fw-semibold d-block">Foto Peserta (Opsional)</label>
                             <div class="image-uploader-wrapper" id="imageUploader">
                                <i class="bi bi-cloud-arrow-up uploader-icon"></i>
                                <div class="uploader-text">Pilih foto...</div>
                                <input type="file" name="path_foto" id="path_foto" accept="image/*">
                            </div>
                            <div class="text-center">
                                <img id="image-preview" src="#" alt="Preview Foto">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle-fill me-2"></i>Simpan Testimoni</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DAFTAR TESTIMONI --}}
        <div class="col-lg-7">
            <h4 class="fw-bold mb-3">Daftar Testimoni untuk: {{ $kursus->judul }}</h4>
            <div class="vstack gap-3">
                @forelse($kursus->testimoni as $testimoni)
                <div class="card testimonial-admin-card">
                    <div class="card-body">
                        <div class="card-content d-flex">
                            <div class="flex-shrink-0">
                                <img src="{{ $testimoni->path_foto ? Storage::url($testimoni->path_foto) : 'https://ui-avatars.com/api/?name='.urlencode($testimoni->nama_peserta).'&background=4F46E5&color=fff' }}" 
                                     class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-2 fst-italic">"{{ $testimoni->testimoni }}"</p>
                                <h6 class="fw-bold mb-0">{{ $testimoni->nama_peserta }}</h6>
                                <small class="text-muted">{{ $testimoni->pekerjaan }}</small>
                            </div>
                            {{-- Tombol Aksi Dropdown --}}
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form action="{{ route('admin.testimoni.destroy', $testimoni->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus testimoni ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="card">
                    <div class="card-body text-center text-muted">
                        <i class="bi bi-chat-quote fs-2"></i>
                        <p class="mt-2">Belum ada testimoni untuk kursus ini.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- JavaScript untuk live preview --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('path_foto');
        const imagePreview = document.getElementById('image-preview');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush