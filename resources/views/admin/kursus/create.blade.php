@extends('layouts.admin')

@section('title', 'Tambah Kursus Baru')

@push('styles')
{{-- Menambahkan CSS khusus untuk halaman ini --}}
<style>
    /* [1] Uploader Gambar yang Lebih Baik */
    .image-uploader-wrapper {
        border: 2px dashed #d1d5db;
        border-radius: 0.75rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background-color 0.2s;
        position: relative;
    }
    .image-uploader-wrapper:hover {
        border-color: var(--bs-primary);
        background-color: #f3f4f6;
    }
    .image-uploader-wrapper .uploader-icon {
        font-size: 3rem;
        color: #9ca3af;
    }
    .image-uploader-wrapper .uploader-text {
        color: #6b7280;
        font-weight: 500;
    }
    /* Sembunyikan input file asli */
    .image-uploader-wrapper #path_gambar {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    /* Style untuk preview gambar */
    #image-preview {
        max-width: 100%;
        max-height: 250px; /* Batasi tinggi preview */
        border-radius: 0.5rem;
        margin-top: 1rem;
        display: none; /* Sembunyikan secara default */
    }
</style>
@endpush


@section('content')
{{-- Form harus diletakkan membungkus semua kolom --}}
<form action="{{ route('admin.kursus.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        {{-- KOLOM KIRI: DETAIL UTAMA KURSUS --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Detail Kursus</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Kursus</label>
                        <input type="text" class="form-control" id="judul" name="judul" required placeholder="Contoh: Belajar Laravel dari Dasar">
                    </div>
                    <div class="mb-3">
    <label for="instruktur_id" class="form-label fw-semibold">Pilih Instruktur</label>
    <select name="instruktur_id" id="instruktur_id" class="form-select" required>
        <option value="">-- Pilih Instruktur --</option>
        @foreach($instruktors as $instruktur)
            <option value="{{ $instruktur->id }}" {{ old('instruktur_id') == $instruktur->id ? 'selected' : '' }}>
                {{ $instruktur->name }}
            </option>
        @endforeach
    </select>
</div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required placeholder="Jelaskan secara singkat tentang kursus ini..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: GAMBAR, PENGATURAN & AKSI --}}
        <div class="col-lg-4">
            {{-- Kartu untuk Aksi/Tombol --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                         <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i> Simpan Kursus
                        </button>
                        <a href="{{ route('admin.kursus.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i> Batal
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kartu untuk Gambar Banner --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Gambar Banner</h5>
                </div>
                <div class="card-body">
                    {{-- [1] Uploader Gambar Modern --}}
                    <div class="image-uploader-wrapper" id="imageUploader">
                        <i class="bi bi-cloud-arrow-up uploader-icon"></i>
                        <div class="uploader-text">Klik atau seret gambar ke sini</div>
                        <input class="form-control" type="file" id="path_gambar" name="path_gambar" accept="image/*">
                    </div>
                    {{-- Preview Gambar --}}
                    <img id="image-preview" src="#" alt="Preview Gambar">
                </div>
            </div>

            {{-- Kartu untuk Pengaturan Tambahan --}}
            <div class="card shadow-sm">
                 <div class="card-header">
                    <h5 class="mb-0 fw-bold">Pengaturan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="harga" class="form-label fw-semibold">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="harga" name="harga" required placeholder="50000">
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="1" id="apakah_eksklusif" name="apakah_eksklusif">
                        <label class="form-check-label" for="apakah_eksklusif">Kursus Eksklusif?</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
{{-- Menambahkan JavaScript khusus untuk halaman ini --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageUploader = document.getElementById('imageUploader');
        const fileInput = document.getElementById('path_gambar');
        const imagePreview = document.getElementById('image-preview');

        // Fungsi untuk menampilkan preview
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block'; // Tampilkan elemen img
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush