<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Platform Kursus Kami</title>

    {{-- Aset Lokal & CDN --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #4F46E5;
            --bs-primary-rgb: 79, 70, 229;
            --bs-body-font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .hero-section {
            background-color: #f1f3f5;
            padding: 6rem 0;
        }
        .keunggulan-section .icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: rgba(var(--bs-primary-rgb), 0.1);
            display: grid;
            place-items: center;
            margin: 0 auto 1.5rem auto;
        }
        .keunggulan-section .icon-wrapper i {
            font-size: 2.5rem;
            color: var(--bs-primary);
        }
        .course-card-guest {
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            transition: all 0.3s ease;
            background-color: white;
        }
        .course-card-guest:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        }
        .course-card-guest img {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            height: 200px;
            object-fit: cover;
        }
        .testimonial-card-guest {
            background-color: white;
            border: 1px solid #e5e7eb;
            padding: 2.5rem;
            border-radius: 1rem;
            position: relative;
        }
        .testimonial-card-guest::before {
            content: '“';
            position: absolute;
            top: -0.5rem;
            left: 1rem;
            font-size: 6rem;
            color: rgba(var(--bs-primary-rgb), 0.1);
            line-height: 1;
            z-index: 0;
        }
        .testimonial-card-guest .blockquote {
            position: relative;
            z-index: 1;
        }
        .faq-accordion .accordion-item {
            border-radius: 0.5rem !important;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .faq-accordion .accordion-button:not(.collapsed) {
            background-color: rgba(var(--bs-primary-rgb), 0.05);
            color: var(--bs-primary);
            box-shadow: none;
        }
        .footer-dark {
            background-color: #111827;
        }
    </style>
</head>
<body>

<main>
    {{-- 1. HERO SECTION --}}
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-3 fw-bolder">Kuasai Skill Digital, Raih Karir Impianmu</h1>
            <p class="lead col-md-8 mx-auto text-muted mt-3">Platform belajar online dengan kurikulum terstruktur yang dirancang oleh para ahli di industrinya untuk membawamu ke level selanjutnya.</p>
            <div class="d-flex gap-2 justify-content-center mt-4">
                <a href="#kursus" class="btn btn-primary btn-lg px-4">Lihat Katalog Kursus</a>
                <a href="" class="btn btn-outline-secondary btn-lg px-4">Daftar Sekarang</a>
            </div>
        </div>
    </section>

    <div class="container">
        {{-- 2. KEUNGGULAN SECTION --}}
        <section id="keunggulan" class="keunggulan-section py-5 my-5 text-center">
            <div class="row g-5">
                <div class="col-md-4">
                    <div class="icon-wrapper"><i class="bi bi-person-video"></i></div>
                    <h4 class="fw-bold">Instruktur Ahli</h4>
                    <p class="text-muted">Belajar langsung dari para praktisi terbaik yang berpengalaman di bidangnya masing-masing.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon-wrapper"><i class="bi bi-patch-check-fill"></i></div>
                    <h4 class="fw-bold">Sertifikat Terverifikasi</h4>
                    <p class="text-muted">Dapatkan sertifikat resmi setelah menyelesaikan kursus untuk menunjang nilai CV Anda.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon-wrapper"><i class="bi bi-infinity"></i></div>
                    <h4 class="fw-bold">Akses Seumur Hidup</h4>
                    <p class="text-muted">Semua materi kursus dapat Anda akses selamanya, kapan pun dan di mana pun.</p>
                </div>
            </div>
        </section>

        {{-- 3. KURSUS UNGGULAN SECTION --}}
        @if($kursusUnggulan->isNotEmpty())
        <section id="kursus" class="py-5">
            <h2 class="fw-bold mb-5 text-center">Jelajahi Kursus Terpopuler</h2>
            <div class="row g-4">
                @foreach($kursusUnggulan as $kursus)
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
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('kursus.index') }}" class="btn btn-primary btn-lg">Lihat Semua Kursus</a>
            </div>
        </section>
        @endif
    </div>

    {{-- 4. TESTIMONI SECTION --}}
    @if($testimonis->isNotEmpty())
    <section id="testimoni" class="py-5 my-5" style="background-color: #f8f9fa;">
        <div class="container">
            <h2 class="fw-bold mb-5 text-center">Apa Kata Mereka yang Telah Bergabung?</h2>
            <div class="row g-4">
                @foreach($testimonis as $testimoni)
                <div class="col-lg-4">
                    <div class="testimonial-card-guest h-100">
                        <blockquote class="blockquote">
                            <p class="mb-4">"{{ $testimoni->testimoni }}"</p>
                            <footer class="blockquote-footer d-flex align-items-center">
                                <img src="{{ $testimoni->path_foto ? Storage::url($testimoni->path_foto) : 'https://ui-avatars.com/api/?name='.urlencode($testimoni->nama_peserta) }}" alt="Avatar" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <span class="fw-bold">{{ $testimoni->nama_peserta }}</span><br>
                                    <cite>{{ $testimoni->pekerjaan }}</cite>
                                </div>
                            </footer>
                        </blockquote>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    {{-- 5. FINAL CTA SECTION --}}
    <section id="cta-final" class="cta-section text-center text-white py-5" style="background: linear-gradient(45deg, #4338ca, #6366f1);">
        <div class="container">
            <h2 class="display-5 fw-bold">Tunggu Apa Lagi?</h2>
            <p class="lead col-md-8 mx-auto mt-3">Ribuan orang telah membuktikan. Kini giliran Anda untuk memulai perjalanan menuju kesuksesan.</p>
            <a href="" class="btn btn-light btn-lg mt-4 px-5">Daftar Sekarang, Gratis!</a>
        </div>
    </section>
    
    <div class="container">
        {{-- 6. FAQ SECTION --}}
        <section id="faq" class="py-5 my-5">
            <h2 class="fw-bold mb-5 text-center">Pertanyaan yang Sering Diajukan</h2>
            <div class="accordion faq-accordion col-md-8 mx-auto" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1">Bagaimana sistem belajarnya?</button></h2>
                    <div id="q1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">Anda bisa belajar kapan saja dan di mana saja. Semua materi berupa video rekaman yang bisa diakses selamanya setelah Anda membeli kursus.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">Apakah saya akan mendapat sertifikat?</button></h2>
                    <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">Ya, setelah menyelesaikan semua materi dan kuis, Anda akan mendapatkan sertifikat elektronik yang bisa diunduh dan dicantumkan di profil LinkedIn Anda.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3">Bagaimana metode pembayarannya?</button></h2>
                    <div id="q3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">Kami menerima pembayaran melalui transfer bank, kartu kredit, dan dompet digital seperti GoPay, OVO, dan Dana.</div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</main>

{{-- 7. FOOTER --}}
<footer class="footer-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold">Nama Aplikasi Anda</h5>
                <p class="text-white-50">Platform e-learning terpercaya untuk meningkatkan skill dan karir Anda di era digital.</p>
            </div>
            <div class="col-md-2 offset-md-2 mb-3">
                <h5 class="fw-bold">Navigasi</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Kursus</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Tentang</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold">Terhubung Dengan Kami</h5>
                <p class="text-white-50">Dapatkan info terbaru seputar kursus dan promo menarik.</p>
                <div>
                    <a href="#" class="text-white fs-4 me-3"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white fs-4 me-3"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-white fs-4 me-3"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
        <hr class="text-white-50">
        <div class="text-center text-white-50 small">
            Copyright &copy; {{ date('Y') }} Nama Aplikasi Anda. All Rights Reserved.
        </div>
    </div>
</footer>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>