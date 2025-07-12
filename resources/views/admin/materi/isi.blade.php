@extends('layouts.admin')

@section('title', 'Isi Konten Materi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Isi Konten Materi</h1>
            <h5 class="text-muted fw-normal mb-0">Untuk materi: {{ $materi->judul_materi }}</h5>
        </div>
        {{-- BARIS INI YANG DIUBAH --}}
        <a href="{{ route('admin.kurikulum.index', $materi->modul->kursus_id) }}" class="btn btn-secondary">
            « Kembali ke Kurikulum
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            {{-- Menampilkan error validasi jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form untuk mengedit konten materi --}}
            <form action="{{ route('admin.materi.isi.update', $materi->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Method spoofing karena form HTML tidak mendukung PUT --}}

                {{-- Field Judul Materi --}}
                <div class="mb-3">
                    <label for="judul_materi" class="form-label">Judul Materi</label>
                    <input type="text" class="form-control @error('judul_materi') is-invalid @enderror" id="judul_materi" name="judul_materi" value="{{ old('judul_materi', $materi->judul_materi) }}" required>
                    @error('judul_materi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Deskripsi Materi --}}
                <div class="mb-3">
                    <label for="deskripsi_materi" class="form-label">Deskripsi / Konten Teks</label>
                    <textarea class="form-control @error('deskripsi_materi') is-invalid @enderror" id="deskripsi_materi" name="deskripsi_materi" rows="10">{{ old('deskripsi_materi', $materi->deskripsi_materi) }}</textarea>
                    <small class="form-text text-muted">Deskripsi ini akan tampil sebagai konten teks dari materi. Anda bisa menggunakan HTML di sini jika diperlukan.</small>
                    @error('deskripsi_materi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Field Link Video --}}
                <div class="mb-3">
                    <label for="link_video" class="form-label">Link Video (YouTube, Vimeo, dll)</label>
                    <input type="url" class="form-control @error('link_video') is-invalid @enderror" id="link_video" name="link_video" value="{{ old('link_video', $materi->link_video) }}" placeholder="https://www.youtube.com/watch?v=xxxx">
                     @error('link_video')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- Opsional: Jika Anda ingin menggunakan Rich Text Editor seperti TinyMCE --}}
@push('scripts')
{{-- 
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#deskripsi_materi',
            plugins: 'code table lists link image',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | link image'
        });
    </script>
--}}
@endpush