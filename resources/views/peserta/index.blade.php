<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peserta</title>
    
    {{-- Bootstrap CSS dari LOKAL --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    {{-- Bootstrap Icons dari CDN (sesuai permintaan) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Fonts & CSS Kustom --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #4F46E5;
            --bs-primary-rgb: 79, 70, 229;
            --bs-font-sans-serif: 'Plus Jakarta Sans', sans-serif;
            --bs-body-bg: #f3f4f6; /* Latar sedikit lebih gelap */
            --bs-border-color: #e5e7eb;
        }

        body {
            font-family: var(--bs-font-sans-serif);
        }

        /* [1] HEADER SELAMAT DATANG YANG BARU */
        .welcome-header {
            background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%);
            border-radius: 1rem;
            padding: 2.5rem;
            color: white;
            margin-bottom: 2.5rem;
        }
        .welcome-header h2 {
            font-weight: 800;
        }

        /* [2] KARTU "KURSUS ANDA" DENGAN EFEK KACA (GLASSMORPHISM) */
        .course-card-enrolled {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            background-size: cover;
            background-position: center;
            aspect-ratio: 4/3;
            display: flex;
            align-items: flex-end; /* Konten menempel di bawah */
            transition: transform 0.3s ease;
        }
        .course-card-enrolled:hover {
            transform: scale(1.03);
        }
        .course-card-enrolled .card-content {
            position: relative;
            z-index: 2;
            padding: 1.25rem;
            width: 100%;
            /* Efek Kaca */
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        .course-card-enrolled h5 {
            font-weight: 700;
        }
        .course-card-enrolled .btn-lanjutkan {
            background-color: white;
            color: var(--bs-dark);
            border: none;
            font-weight: 700;
        }

        /* [3] DESAIN ULANG KARTU "KURSUS LAINNYA" */
        .course-card-other {
            border: 1px solid var(--bs-border-color);
            border-radius: 1rem; /* Sudut lebih tumpul */
            transition: all 0.2s ease-in-out;
            background-color: white;
            display: flex;
            flex-direction: column;
        }
        .course-card-other:hover {
            border-color: var(--bs-primary);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.07);
        }
        .course-card-other .card-img-top {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            height: 160px;
            object-fit: cover;
        }
        .course-card-other .card-body {
            flex-grow: 1; /* Pastikan card-body mengisi sisa ruang */
            display: flex;
            flex-direction: column;
        }
        .course-card-other .card-title {
            font-weight: 700;
        }
        .course-card-other .card-footer {
            background-color: transparent;
            border-top: 1px solid var(--bs-border-color);
            padding-top: 0.75rem;
        }
        .course-card-other .price {
            font-weight: 700;
            color: var(--bs-primary);
        }

        /* [4] EMPTY STATE YANG LEBIH BAIK */
        .empty-state {
            background-color: white;
            border: 2px dashed var(--bs-border-color);
            border-radius: 1rem;
            padding: 3rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/home') }}">
                <i class="bi bi-person-workspace text-primary"></i> Dashboard
            </a>
            <div class="ms-auto dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4F46E5&color=fff&rounded=true&size=32" alt="Avatar" class="me-2">
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        {{-- [1] HEADER SELAMAT DATANG --}}
        <div class="welcome-header">
            <h2 class="display-5">Selamat Datang Kembali!</h2>
            <p class="lead opacity-75 mb-0">Lanjutkan progres belajarmu dan capai tujuanmu hari ini.</p>
        </div>

        {{-- BAGIAN 1: KURSUS YANG SUDAH DIIKUTI --}}
        <h3 class="h4 mb-3 fw-bold">Kursus Anda</h3>
        @if($kursus_diikuti->isEmpty())
            {{-- [4] EMPTY STATE --}}
            <div class="empty-state">
                <i class="bi bi-journal-x fs-1 text-muted"></i>
                <h5 class="mt-3">Anda Belum Memiliki Kursus</h5>
                <p class="text-muted">Jelajahi katalog kami dan temukan kursus yang tepat untuk Anda.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($kursus_diikuti as $kursus)
                <div class="col-md-6 col-lg-4">
                    {{-- [2] KARTU KURSUS ANDA --}}
                    <div class="course-card-enrolled" style="background-image: url('{{ $kursus->path_gambar ? Storage::url($kursus->path_gambar) : 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?fit=crop&w=800&q=80' }}');">
    <div class="card-content">
    <h5 class="card-title text-truncate">{{ $kursus->judul }}</h5>
    
    {{-- PROGRES DINAMIS --}}
    <div class="progress mb-3" role="progressbar" style="height: 6px;">
        <div class="progress-bar bg-light" style="width: {{ $kursus->progres ?? 0 }}%"></div>
    </div>

    {{-- LOGIKA LANJUTKAN BELAJAR --}}
    @php
        $user = auth()->user();
        $materiKursus = $kursus->moduls->flatMap->materi->sortBy('urutan');

        $materiSedang = $materiKursus->first(function($m) use ($user) {
            return $user->progressMateri
                ->where('materi_id', $m->id)
                ->first()?->status === 'sedang';
        });

        $materiPertama = $materiKursus->first();
        $materiTarget = $materiSedang ?? $materiPertama;
    @endphp

    @php
    $user = auth()->user();
    $materiKursus = $kursus->moduls->flatMap->materi->sortBy('urutan')->values(); // pastikan urut & index 0-based

    // 1. Cek materi yang statusnya "sedang"
    $materiSedang = $materiKursus->first(function($m) use ($user) {
        return $user->progressMateri
            ->where('materi_id', $m->id)
            ->first()?->status === 'sedang';
    });

    // 2. Kalau tidak ada, cari materi terakhir yang sudah selesai
    $materiTerakhirSelesai = $materiKursus->filter(function($m) use ($user) {
        return $user->progressMateri
            ->where('materi_id', $m->id)
            ->first()?->status === 'selesai';
    })->last();

    // 3. Ambil materi berikutnya setelah yang selesai terakhir
    $materiBerikutnya = null;
    if ($materiTerakhirSelesai) {
        $index = $materiKursus->search(fn($item) => $item->id === $materiTerakhirSelesai->id);
        $materiBerikutnya = $materiKursus->get($index + 1);
    }

    // 4. Tentukan target
    $materiTarget = $materiSedang ?? $materiBerikutnya ?? $materiKursus->first();
@endphp

@if($materiTarget)
    <a href="{{ route('materi.lanjut', ['kursus' => $kursus->id]) }}?materi_id={{ $materiTarget->id }}"
       class="btn btn-lanjutkan w-100">
       <i class="bi bi-play-fill me-1"></i> Lanjutkan Belajar
    </a> 
    <small class="text-muted d-block mt-1">
    @if($materiSedang)
        Sedang: {{ $materiSedang->judul_materi }}
    @elseif($materiPertama)
        Mulai dari: {{ $materiPertama->judul_materi }}
    @endif
</small>

@else
    <a href="#" class="btn btn-secondary w-100 disabled">Belum Ada Materi</a>
@endif


</div>

</div>

                </div>
                @endforeach
            </div>
        @endif

        {{-- BAGIAN 2: KURSUS LAINNYA (GRID) --}}
        @if(!$kursus_lainnya->isEmpty())
            <h3 class="h4 mt-5 mb-3 fw-bold">Jelajahi Kursus Lainnya</h3>
            <div class="row g-4">
                @foreach($kursus_lainnya as $kursus)
                <div class="col-md-6 col-lg-3 d-flex">
                     {{-- [3] KARTU KURSUS LAINNYA --}}
                    <div class="card course-card-other">
                        <img src="{{ $kursus->path_gambar ? Storage::url($kursus->path_gambar) : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?fit=crop&w=800&q=80' }}" class="card-img-top" alt="{{ $kursus->judul }}">
                        <div class="card-body pb-0">
                            <h6 class="card-title mb-2">{{ $kursus->judul }}</h6>
                            <p class="card-text small text-muted flex-grow-1">{{ Str::limit($kursus->deskripsi, 70) }}</p>
                        </div>
                        <div class="card-footer pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price">Rp {{ number_format($kursus->harga, 0, ',', '.') }}</span>
                                <a href="{{ route('kursus.show', $kursus->id) }}" class="btn btn-outline-primary btn-sm">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </main>

    {{-- Bootstrap JS dari LOKAL --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>