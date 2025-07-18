<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kursus: {{ $kursus->judul }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* [1] FONT & WARNA DASAR MODERN */
        :root {
            --bs-primary: #4F46E5; /* Warna ungu modern sebagai pengganti biru */
            --bs-primary-rgb: 79, 70, 229;
            --bs-secondary: #6B7280;
            --bs-light: #F9FAFB;
            --bs-dark: #1F2937;
            --bs-font-sans-serif: 'Plus Jakarta Sans', sans-serif; /* Font baru yang lebih fresh */
        }

        body {
            background-color: #F9FAFB; /* Sedikit abu-abu, lebih nyaman di mata */
            color: #374151;
        }

        /* [2] HERO BANNER YANG LEBIH DRAMATIS */
        .hero-banner {
            background-size: cover;
            background-position: center;
            color: white;
            position: relative;
            padding: 8rem 0; /* Padding lebih besar */
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            /* Gradasi lebih elegan dari warna solid */
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.4));
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-content .badge {
            background-color: #FBBF24 !important; /* Warna kuning lebih hangat */
            font-weight: 600;
            padding: .5em 1em;
            letter-spacing: 0.5px;
        }
        .hero-content h1 {
            font-weight: 800; /* Super bold */
        }

        /* [3] NAVBAR YANG BERSIH */
        #navbarDetail {
            background-color: white;
            transition: all 0.3s ease-in-out;
        }
        #navbarDetail .nav-link {
            font-weight: 600;
            color: #4B5563;
            transition: color 0.2s;
        }
        #navbarDetail .nav-link:hover,
        #navbarDetail .nav-link.active {
            color: var(--bs-primary); /* Warna utama saat aktif/hover */
        }

        /* [4] KONTEN UTAMA DENGAN SPACING LEBIH BAIK */
        .section-title {
            font-weight: 700;
            color: var(--bs-dark);
            margin-bottom: 1.5rem;
        }

        /* [5] ACCORDION (KURIKULUM) YANG LEBIH CLEAN */
        .accordion-item {
            border: 1px solid #E5E7EB;
            border-radius: 0.5rem !important; /* Sudut lebih tumpul */
            margin-bottom: 1rem;
            overflow: hidden; /* Penting untuk radius */
        }
        .accordion-button {
            font-weight: 600;
            color: var(--bs-dark);
        }
        .accordion-button:not(.collapsed) {
            background-color: rgba(var(--bs-primary-rgb), 0.05); /* Warna latar saat terbuka */
            color: var(--bs-primary);
            box-shadow: none;
        }
        .accordion-button:focus {
            box-shadow: none;
        }
        /* Mengganti ikon panah default */
        .accordion-button::after {
            font-family: 'bootstrap-icons';
            content: "\f282"; /* Icon: plus-lg */
            font-size: 1rem;
            background-image: none;
            transition: transform 0.2s ease-in-out;
            font-weight: bold;
        }
        .accordion-button:not(.collapsed)::after {
            content: "\f463"; /* Icon: dash-lg */
            transform: none; /* Tidak perlu di-rotate */
        }
        .accordion-body .list-group-item {
            border: none;
            padding-left: 0;
        }
        .accordion-body .bi-play-circle-fill {
            color: var(--bs-primary);
        }

        /* [6] KARTU TESTIMONI YANG LEBIH ELEGAN */
        .card-testimoni {
            background-color: white;
            border: 1px solid #E5E7EB;
            padding: 2rem;
            border-radius: 0.75rem;
            position: relative;
        }
        .card-testimoni::before {
            content: '“'; /* Tanda kutip besar */
            position: absolute;
            top: -0.5rem;
            left: 1rem;
            font-size: 5rem;
            color: rgba(var(--bs-primary-rgb), 0.1);
            line-height: 1;
            z-index: 0;
        }
        .card-testimoni blockquote {
            position: relative;
            z-index: 1;
        }
        .card-testimoni .blockquote-footer {
            margin-top: 1rem;
            font-weight: 600;
        }

        /* [7] KARTU DAFTAR (CTA) YANG MENONJOL */
        .card-sticky-daftar {
            border: none;
            border-radius: 0.75rem; /* Sudut lebih tumpul */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }
        .card-sticky-daftar:hover {
            transform: translateY(-5px); /* Efek hover naik sedikit */
        }
        .card-sticky-daftar .btn-primary {
            /* Sedikit efek shadow pada tombol */
            box-shadow: 0 4px 15px rgba(var(--bs-primary-rgb), 0.35);
            padding: 0.75rem 1rem;
            font-weight: 700;
        }
        .card-sticky-daftar .list-unstyled i {
            color: var(--bs-primary);
        }
    </style>
</head>

<body data-bs-spy="scroll" data-bs-target="#navbarDetail" data-bs-offset="100">

    {{-- BAGIAN 1: HERO BANNER DENGAN GAMBAR KURSUS --}}
    <header class="hero-banner" style="background-image: url('{{ $kursus->path_gambar ? Storage::url($kursus->path_gambar) : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop' }}');">
        <div class="hero-overlay"></div>
        <div class="container hero-content text-center">
            @if($kursus->apakah_eksklusif)
                <span class="badge mb-3">EXCLUSIVE</span>
            @endif
            <h1 class="display-4">{{ $kursus->judul }}</h1>
            <p class="lead fs-4 mb-0 opacity-75">Sebuah kursus oleh {{ $kursus->nama_instruktur }}</p>
        </div>
    </header>

    {{-- BAGIAN 2: NAVBAR SCROLL YANG STICKY --}}
    <nav id="navbarDetail" class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ Auth::check() ? route('home') : route('welcome') }}">
    <i class="bi bi-arrow-left me-2"></i>Kembali
</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#deskripsi">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kurikulum">Kurikulum</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimoni">Testimoni</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- BAGIAN 3: KONTEN UTAMA HALAMAN --}}
    <main class="container py-5">
        <div class="row gx-lg-5">
            {{-- KOLOM KIRI (DETAIL KURSUS) --}}
            <div class="col-lg-8">
                <section id="deskripsi" class="mb-5">
                    <h2 class="section-title">Tentang Kursus Ini</h2>
                    <p class="fs-5">{{ $kursus->deskripsi }}</p>
                </section>

                <section id="kurikulum" class="mb-5">
                    <h2 class="section-title">Apa yang Akan Anda Pelajari?</h2>
                    <div class="accordion" id="accordionKurikulum">
                        @forelse ($kursus->modul as $modul)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ !$loop->first ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#modul-{{ $modul->id }}">
                                    <span class="fw-bold me-2">Modul {{ $loop->iteration }}:</span> {{ $modul->judul_modul }}
                                </button>
                            </h2>
                            <div id="modul-{{ $modul->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#accordionKurikulum">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush">
                                        @forelse ($modul->materi as $materi)
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-play-circle-fill me-3 fs-5"></i>
                                            <span>{{ $materi->judul_materi }}</span>
                                        </li>
                                        @empty
                                        <li class="list-group-item text-muted">Belum ada materi untuk modul ini.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-secondary">Kurikulum untuk kursus ini belum tersedia.</div>
                        @endforelse
                    </div>
                </section>

                @if($kursus->testimoni->isNotEmpty())
                <section id="testimoni" class="mb-5">
                    <h2 class="section-title">Apa Kata Mereka?</h2>
                    @foreach($kursus->testimoni as $testimoni)
                    <div class="card card-testimoni mb-4">
                        <blockquote class="blockquote mb-0">
                            <p class="fs-5">"{{ $testimoni->testimoni }}"</p>
                            <footer class="blockquote-footer">{{ $testimoni->nama_peserta }}, <cite>{{ $testimoni->pekerjaan }}</cite></footer>
                        </blockquote>
                    </div>
                    @endforeach
                </section>
                @endif
            </div>

            {{-- KOLOM KANAN (KARTU PENDAFTARAN STICKY) --}}
            

            <div class="col-lg-4">
                <aside class="card card-sticky-daftar position-sticky" style="top: 100px;">
                    <div class="card-body p-4">
                        <p class="card-text display-6 fw-bold mb-3">Rp {{ number_format($kursus->harga, 0, ',', '.') }}</p>
                        <div class="d-grid mb-4">
                            <form action="{{ route('kursus.daftar', $kursus->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary btn-lg w-100">
        <i class="bi bi-rocket-launch me-2"></i>Daftar Kursus Ini
    </button>
</form>

                        </div>
                        <ul class="list-unstyled text-secondary">
                            <li class="mb-2 d-flex align-items-center"><i class="bi bi-camera-video fs-5 me-3"></i>Akses Video Selamanya</li>
                            <li class="mb-2 d-flex align-items-center"><i class="bi bi-file-earmark-text fs-5 me-3"></i>Materi & E-Book</li>
                            <li class="mb-2 d-flex align-items-center"><i class="bi bi-patch-check fs-5 me-3"></i>Sertifikat Kelulusan</li>
                            <li class="mb-2 d-flex align-items-center"><i class="bi bi-whatsapp fs-5 me-3"></i>Grup Diskusi Premium</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </main>
    
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} Nama Perusahaan Anda. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>