@extends('layouts.admin')

@section('title', 'Ubah Kursus: ' . $kursus->judul)

@push('styles')
{{-- CSS ini sama dengan halaman "Tambah Kursus" untuk konsistensi --}}
<style>
    .image-uploader-wrapper {
        border: 2px dashed #d1d5db;
        border-radius: 0.75rem;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background-color 0.2s;
        position: relative;
        background-size: cover;
        background-position: center;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .image-uploader-wrapper:hover {
        border-color: var(--bs-primary);
        background-color: #f3f4f6;
    }
    .image-uploader-wrapper .uploader-content {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
    }
    .image-uploader-wrapper .uploader-icon {
        font-size: 2.5rem;
        color: #9ca3af;
    }
    .image-uploader-wrapper .uploader-text {
        color: #6b7280;
        font-weight: 500;
    }
    .image-uploader-wrapper #path_gambar {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
{{-- Form harus membungkus semua kolom --}}
<form action="{{ route('admin.kursus.update', $kursus->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') {{-- Jangan lupa method PUT untuk update --}}
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
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $kursus->judul) }}" required>
                    </div>
                    <div class="mb-3">
    <label for="instruktur_id" class="form-label fw-semibold">Pilih Instruktur</label>
    <select name="instruktur_id" id="instruktur_id" class="form-select" required>
        <option value="">-- Pilih Instruktur --</option>
        @foreach($instruktors as $instruktur)
            <option value="{{ $instruktur->id }}" 
                {{ old('instruktur_id', $kursus->instruktur_id) == $instruktur->id ? 'selected' : '' }}>
                {{ $instruktur->name }}
            </option>
        @endforeach
    </select>
</div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $kursus->deskripsi) }}</textarea>
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
                            <i class="bi bi-save-fill me-2"></i> Simpan Perubahan
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
                    <h5 class="mb-0 fw-bold">Ubah Gambar Banner</h5>
                </div>
                <div class="card-body">
                    {{-- Uploader yang menampilkan gambar saat ini sebagai latar --}}
                    <div class="image-uploader-wrapper" id="imageUploader" 
                         style="background-image: url('{{ $kursus->path_gambar ? Storage::url($kursus->path_gambar) : '' }}');">
                        
                        <div class="uploader-content">
                            <i class="bi bi-cloud-arrow-up uploader-icon"></i>
                            <div class="uploader-text" id="uploader-text">
                                {{ $kursus->path_gambar ? 'Klik untuk mengubah gambar' : 'Klik atau seret gambar' }}
                            </div>
                        </div>
                        <input class="form-control" type="file" id="path_gambar" name="path_gambar" accept="image/*">
                    </div>
                     <small class="form-text text-muted mt-1 d-block">Kosongkan jika tidak ingin mengubah gambar.</small>
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
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $kursus->harga) }}" required>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="1" id="apakah_eksklusif" name="apakah_eksklusif" {{ old('apakah_eksklusif', $kursus->apakah_eksklusif) ? 'checked' : '' }}>
                        <label class="form-check-label" for="apakah_eksklusif">Kursus Eksklusif?</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
{{-- JavaScript untuk live preview --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('path_gambar');
        const imageUploader = document.getElementById('imageUploader');
        const uploaderText = document.getElementById('uploader-text');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Set gambar baru sebagai background dari uploader
                    imageUploader.style.backgroundImage = `url(${e.target.result})`;
                    // Ubah teks untuk mengindikasikan gambar baru telah dipilih
                    uploaderText.textContent = `Gambar baru: ${file.name}`;
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush