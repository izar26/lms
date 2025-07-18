{{-- Ini adalah halaman baru untuk menampilkan SEMUA kursus --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Kursus</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bs-primary: #4F46E5;
            --bs-primary-rgb: 79, 70, 229;
            --bs-body-font-family: 'Plus Jakarta Sans', sans-serif;
            --bs-body-bg: #f8f9fa;
        }
        /* (Anda bisa copy-paste style .course-card-guest dari halaman welcome ke sini) */
        .course-card-guest {
            border: 1px solid #e5e7eb; border-radius: 1rem;
            transition: all 0.3s ease; background-color: white;
        }
        .course-card-guest:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        }
        .course-card-guest img {
            border-top-left-radius: 1rem; border-top-right-radius: 1rem;
            height: 200px; object-fit: cover;
        }
    </style>
</head>
<body>
    <header class="py-5 bg-light border-bottom">
        <div class="container text-center">
            <h1 class="display-4 fw-bolder">Katalog Kursus</h1>
            <p class="lead text-muted">Temukan kursus yang tepat untuk meningkatkan skill Anda.</p>
        </div>
    </header>
    
    <main class="container py-5">
        <div class="row g-4">
            @forelse($semuaKursus as $kursus)
                <div class="col-md-6 col-lg-4">
                    <div class="card course-card-guest h-100">
                        <img src="{{ $kursus->path_gambar ? Storage::url($kursus->path_gambar) : 'https://via.placeholder.com/400x250.png?text=Gambar+Kursus' }}" class="card-img-top" alt="{{ $kursus->judul }}">
                        <div class="card-body d-flex flex-column">
                            @if($kursus->apakah_eksklusif)
                                <span class="badge bg-primary align-self-start mb-2">EKSKLUSIF</span>
                            @endif
                            <h5 class="card-title fw-bold flex-grow-1">{{ $kursus->judul }}</h5>
                            <p class="card-text text-muted small mb-2">Oleh: {{ $kursus->instruktur->name ?? 'Instruktur' }}</p>
                            <h4 class="fw-bolder text-primary mb-3">Rp {{ number_format($kursus->harga, 0, ',', '.') }}</h4>
                            <a href="{{ route('kursus.show', $kursus->id) }}" class="btn btn-outline-primary mt-auto">Lihat Detail Kursus</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">Saat ini belum ada kursus yang tersedia.</div>
                </div>
            @endforelse
        </div>
        
        {{-- Tombol Pagination --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $semuaKursus->links() }}
        </div>
    </main>

    {{-- Anda bisa include footer dari halaman welcome di sini --}}

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>