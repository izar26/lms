@extends('layouts.admin')

@section('title', 'Manajemen Kursus')

{{-- Menambahkan style khusus untuk halaman ini --}}
@push('styles')
<style>
    /* Mengatur layout utama agar lebih rapi */
    .management-panel {
        display: flex;
        gap: 2rem; /* Jarak antar kolom */
    }

    /* [1] Kustomisasi Daftar Kursus (Kolom Kiri) */
    .course-list-card .card-header {
        background-color: transparent;
        border-bottom: 1px solid #e5e7eb;
    }

    .course-list .list-group-item {
        border-radius: 0.5rem !important;
        margin-bottom: 0.5rem;
        border: 1px solid #e5e7eb;
        font-weight: 600;
        transition: all 0.2s ease-in-out;
    }
    
    .course-list .list-group-item:not(.active):hover {
        background-color: #f9fafb;
        border-color: var(--bs-primary);
        color: var(--bs-primary);
        transform: translateX(4px);
    }

    .course-list .list-group-item.active {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        box-shadow: 0 4px 15px rgba(var(--bs-primary-rgb), 0.25);
    }
    
    /* [2] Panel Aksi yang Lebih Modern (Kolom Kanan) */
    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .action-card {
        display: flex;
        align-items: flex-start;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        transition: all 0.2s ease-in-out;
        color: var(--bs-dark);
        text-decoration: none;
    }

    .action-card:hover {
        border-color: var(--bs-primary);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transform: translateY(-4px);
    }

    .action-card .icon-wrapper {
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        border-radius: 0.5rem;
        display: grid;
        place-items: center;
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
        margin-right: 1rem;
    }

    .action-card .icon-wrapper i {
        font-size: 1.5rem;
    }

    .action-card h6 {
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .action-card p {
        font-size: 0.875rem;
        color: #6B7280;
        line-height: 1.4;
    }

    /* [3] Zona Berbahaya (Danger Zone) */
    .danger-zone {
        border: 1px solid #fecaca; /* Merah muda */
        background-color: #fef2f2; /* Merah sangat muda */
        border-radius: 0.75rem;
        padding: 1.5rem;
    }
    .danger-zone h6 {
        color: #b91c1c; /* Merah tua */
        font-weight: 700;
    }
    .danger-zone p {
        color: #dc2626; /* Merah */
    }

    /* [4] Tampilan Placeholder yang Lebih Baik */
    .placeholder-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 400px;
        text-align: center;
        background-color: #f9fafb;
        border: 2px dashed #e5e7eb;
        border-radius: 1rem;
    }
</style>
@endpush

@section('content')
    <div class="row">
        {{-- KOLOM KIRI: DAFTAR SEMUA KURSUS --}}
        <div class="col-lg-4">
            <div class="card course-list-card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Daftar Kursus</h5>
                    <a href="{{ route('admin.kursus.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </a>
                </div>
                <div class="card-body">
                    <div class="list-group course-list">
                        @forelse ($daftar_kursus as $item)
                            <a href="{{ route('admin.kursus.index', ['pilih' => $item->id]) }}"
   class="list-group-item list-group-item-action {{ isset($kursus_terpilih) && $kursus_terpilih->id == $item->id ? 'active' : '' }}">
    {{ $item->judul }}
</a>

                        @empty
                            <p class="text-muted text-center">Belum ada kursus.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: PANEL AKSI ATAU PLACEHOLDER --}}
        <div class="col-lg-8">
            @if (isset($kursus_terpilih))
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Panel Manajemen: <span class="fw-bold text-primary">{{ $kursus_terpilih->judul }}</span></h5>
                    </div>
                    <div class="card-body p-4">
                        <h6 class="text-muted fw-bold text-uppercase small mb-3">Aksi Umum</h6>
                        <div class="action-grid mb-4">
                            <a href="{{ route('admin.kursus.edit', $kursus_terpilih->id) }}" class="action-card">
                                <div class="icon-wrapper"><i class="bi bi-pencil-square"></i></div>
                                <div>
                                    <h6>Ubah Detail</h6>
                                    <p class="mb-0">Edit judul, deskripsi, harga, dan gambar utama kursus.</p>
                                </div>
                            </a>
                            <a href="{{ route('admin.kurikulum.index', $kursus_terpilih->id) }}" class="action-card">
                                <div class="icon-wrapper"><i class="bi bi-list-columns-reverse"></i></div>
                                <div>
                                    <h6>Kelola Kurikulum</h6>
                                    <p class="mb-0">Atur modul dan materi pembelajaran video untuk kursus ini.</p>
                                </div>
                            </a>
                            <a href="{{ route('admin.testimoni.index', $kursus_terpilih->id) }}" class="action-card">
                                <div class="icon-wrapper"><i class="bi bi-chat-square-quote"></i></div>
                                <div>
                                    <h6>Kelola Testimoni</h6>
                                    <p class="mb-0">Tambah atau hapus testimoni dari para peserta.</p>
                                </div>
                            </a>
                            <a href="{{ route('admin.kursus.peserta', $kursus_terpilih->id) }}" class="action-card">
    <div class="icon-wrapper"><i class="bi bi-people-fill"></i></div>
    <div>
        <h6>Lihat Peserta</h6>
        <p class="mb-0">Tampilkan siapa saja yang sudah mendaftar kursus ini.</p>
    </div>
</a>


                        </div>
                        
                        {{-- [3] ZONA BERBAHAYA (DANGER ZONE) --}}
                        <div class="danger-zone mt-5">
                            <h6>Zona Berbahaya</h6>
                            <p class="small">Aksi berikut tidak dapat dibatalkan. Pastikan Anda benar-benar yakin.</p>
                            <form action="{{ route('admin.kursus.destroy', $kursus_terpilih->id) }}" method="POST" onsubmit="return confirm('ANDA YAKIN INGIN MENGHAPUS KURSUS \'{{ $kursus_terpilih->judul }}\' SECARA PERMANEN?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash-fill me-2"></i> Hapus Kursus Ini
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
            @else
                {{-- [4] Tampilan Placeholder yang Lebih Baik --}}
                <div class="placeholder-card">
                     <i class="bi bi-journal-richtext" style="font-size: 5rem; color: #d1d5db;"></i>
                     <h4 class="mt-4 fw-bold" style="color: #4b5563;">Manajemen Kursus</h4>
                     <p class="text-muted">Pilih sebuah kursus dari daftar di kiri untuk memulai,<br>atau buat kursus baru.</p>
                     <a href="{{ route('admin.kursus.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-lg me-1"></i> Buat Kursus Baru
                    </a>
                </div>
            @endif
            
        </div>
    </div>
@endsection