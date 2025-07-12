<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $materi->judul_materi }} - {{ $kursus->judul }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
            --bs-success: #16a34a;
            --bs-success-rgb: 22, 163, 74;
            --bs-body-bg: #f1f3f5;
            --sidebar-bg: #ffffff;
            --border-color: #e9ecef;
            --font-sans-serif: 'Plus Jakarta Sans', sans-serif;
        }
        body { font-family: var(--font-sans-serif); }
        .player-wrapper { display: flex; height: 100vh; }
        .curriculum-sidebar {
            width: 380px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .curriculum-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            flex-shrink: 0;
        }
        .curriculum-body { flex-grow: 1; overflow-y: auto; }
        .module-header {
            background: none; border: none; padding: 1rem 1.5rem;
            width: 100%; text-align: left; font-weight: 700;
            color: #343a40; display: flex; justify-content: space-between; align-items: center;
        }
        .module-header::after {
            content: '\f282'; font-family: 'bootstrap-icons';
            transition: transform 0.2s ease-in-out;
        }
        .module-header:not(.collapsed)::after { transform: rotate(45deg); }
        .material-link {
            display: flex; align-items: flex-start;
            padding: 0.8rem 1.5rem 0.8rem 2.5rem;
            text-decoration: none; color: #495057;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s;
        }
        .material-link:hover { background-color: var(--bs-body-bg); }
        .material-link.locked { color: #adb5bd; pointer-events: none; }
        .material-link.active {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
            color: var(--bs-primary); font-weight: 600;
            border-right: 3px solid var(--bs-primary);
        }
        .material-link.completed { color: var(--bs-success); }
        .material-link .icon { margin-right: 1rem; margin-top: 0.1rem; }
        .main-content-wrapper { flex-grow: 1; height: 100vh; display: flex; flex-direction: column; }
        .player-header {
            background-color: white; padding: 0.75rem 2rem;
            border-bottom: 1px solid var(--border-color);
            flex-shrink: 0;
        }
        .content-body { flex-grow: 1; overflow-y: auto; padding: 2rem; }
        .video-wrapper {
            position: relative; padding-bottom: 56.25%; height: 0;
            overflow: hidden; border-radius: 1rem; background-color: #000;
        }
        .video-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        .description-box {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
        }
        .curriculum-sidebar {
    width: 380px; /* Atur lebar sidebar di sini */
    flex-shrink: 0; /* PENTING: Mencegah sidebar menyusut */
    background-color: var(--sidebar-bg);
    border-right: 1px solid var(--border-color);
    display: flex;
    flex-direction: column;
    height: 100%;
}
.material-link.active {
    background-color: #e9f5ff;
    font-weight: 600;
    border-left: 4px solid #0d6efd;
}

.material-link.completed {
    color: #198754;
}

.material-link.locked {
    pointer-events: none;
    opacity: 0.6;
}

    </style>
</head>
<body>

<div class="player-wrapper">
    {{-- Sidebar Kurikulum --}}
    <aside class="curriculum-sidebar">
        <div class="curriculum-header">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-arrow-left me-2"></i> Dashboard
            </a>
        </div>
        <div class="curriculum-body p-0">
    <div class="accordion accordion-flush" id="modulAccordion">
        @foreach($moduls as $modul)
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed module-header" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#modul-{{ $modul->id }}">
                        {{ $modul->judul_modul }}
                    </button>
                </h2>
                <div id="modul-{{ $modul->id }}"
                     class="accordion-collapse collapse {{ $materi->modul_id == $modul->id ? 'show' : '' }}"
                     data-bs-parent="#modulAccordion">
                    <div class="accordion-body p-0">
                        @foreach($modul->materi->sortBy('urutan') as $m)
                            @php
                                $user = auth()->user();
                                $currentProgress = $user->progressMateri->where('materi_id', $m->id)->first();
                                $isSelesai = $currentProgress?->status === 'selesai';
                                $isActive = $m->id == $materi->id;

                                // Cek apakah terkunci:
                                $materiSebelumnya = $modul->materi
                                    ->where('urutan', '<', $m->urutan);

                                $isTerkunci = false;
                                foreach ($materiSebelumnya as $prev) {
                                    $cek = $user->progressMateri->where('materi_id', $prev->id)->first();
                                    if (!$cek || $cek->status !== 'selesai') {
                                        $isTerkunci = true;
                                        break;
                                    }
                                }
                            @endphp

                            <a href="{{ !$isTerkunci ? route('materi.lanjut', ['kursus' => $kursus->id]) . '?materi_id=' . $m->id : '#' }}"
                               class="material-link d-flex align-items-center gap-2 py-2 px-3
                               {{ $isActive ? 'active' : '' }}
                               {{ $isSelesai ? 'completed' : '' }}
                               {{ $isTerkunci ? 'locked text-muted' : '' }}"
                               style="text-decoration: none;">
                                <span class="icon">
                                    @if($isSelesai)
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    @elseif($isActive)
                                        <i class="bi bi-play-circle-fill text-primary"></i>
                                    @elseif($isTerkunci)
                                        <i class="bi bi-lock-fill"></i>
                                    @else
                                        <i class="bi bi-circle"></i>
                                    @endif
                                </span>
                                <span>{{ $m->judul_materi }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

    </aside>

    {{-- Konten Utama --}}
    <div class="main-content-wrapper">
        {{-- Header dengan Progress Bar --}}
        @php
    // Ambil semua materi dari kursus melalui relasi modul → materi
    $materiKursus = $kursus->moduls->flatMap->materi;

    $totalMateri = $materiKursus->count();
    $materiSelesai = auth()->user()->progressMateri
        ->whereIn('materi_id', $materiKursus->pluck('id'))
        ->where('status', 'selesai')
        ->count();

    $persentaseSelesai = $totalMateri > 0 ? round(($materiSelesai / $totalMateri) * 100) : 0;
@endphp

<header class="player-header d-flex justify-content-between align-items-center">
    <div class="w-50">
        <h6 class="mb-1 small text-muted">Progress Anda</h6>
        <div class="progress" style="height: 10px;">
            <div class="progress-bar bg-success" style="width: {{ $persentaseSelesai }}%;"></div>
        </div>
    </div>
    <div class="text-end">
        <h5 class="fw-bold mb-0">{{ $kursus->judul }}</h5>
        <small class="text-muted">Oleh: {{ $kursus->nama_instruktur }}</small>
    </div>
</header>


        <main class="content-body">
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
    <div id="toastSuccess" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <div id="toastError" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

            <h2 class="fw-bold mb-3">{{ $materi->judul_materi }}</h2>

            @if($materi->link_video)
    @php
        $embedUrl = '';
        $videoUrl = $materi->link_video;

        if (strpos($videoUrl, 'youtube.com/watch') !== false) {
            $parts = parse_url($videoUrl);
            if (isset($parts['query'])) {
                parse_str($parts['query'], $query);
                if (isset($query['v'])) {
                    $embedUrl = 'https://www.youtube.com/embed/' . $query['v'];
                }
            }
        } elseif (strpos($videoUrl, 'youtu.be') !== false) {
            $pathParts = explode('/', parse_url($videoUrl, PHP_URL_PATH));
            $videoId = end($pathParts);
            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
        }
    @endphp

    <div class="video-wrapper mb-4 shadow">
        @if($embedUrl)
            <iframe 
                src="{{ $embedUrl }}" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                allowfullscreen>
            </iframe>
        @else
            <div class="alert alert-danger">Format URL Video tidak valid. Harap gunakan link dari YouTube.</div>
        @endif
    </div>
@endif

            <div class="description-box">
                <h5 class="fw-bold mb-3">Deskripsi Materi</h5>
                {!! $materi->deskripsi_materi ? nl2br(e($materi->deskripsi_materi)) : '<p class="text-muted">Deskripsi belum tersedia.</p>' !!}
            </div>
            
            {{-- Navigasi Bawah --}}
            <hr class="my-4">
            <div class="d-flex justify-content-between align-items-center">
    @php
$isSelesai = \App\Models\ProgressMateri::where('user_id', auth()->id())
    ->where('materi_id', $materi->id)
    ->where('status', 'selesai')
    ->exists();
@endphp

<form action="{{ route('materi.selesai', $materi->id) }}" method="POST">
    @csrf
    <button class="btn {{ $isSelesai ? 'btn-outline-success' : 'btn-success' }}" {{ $isSelesai ? 'disabled' : '' }}>
        @if($isSelesai)
            <i class="bi bi-check-all"></i> Sudah Selesai
        @else
            <i class="bi bi-check-lg"></i> Tandai Selesai
        @endif
    </button>
</form>


    @php
    $isSelesai = \App\Models\ProgressMateri::where('user_id', auth()->id())
        ->where('materi_id', $materi->id)
        ->where('status', 'selesai')
        ->exists();
@endphp

@if($materiBerikutnya && $isSelesai)
    <a href="{{ route('materi.lanjut', ['kursus' => $kursus->id]) }}?materi_id={{ $materiBerikutnya->id }}"
       class="btn btn-primary">
        Lanjut Materi Berikutnya <i class="bi bi-arrow-right"></i>
    </a>
@endif
</div>

        </main>
    </div>
</div>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        @if(session('success'))
            let toastEl = document.getElementById('toastSuccess');
            let toast = new bootstrap.Toast(toastEl);
            toast.show();
        @endif

        @if(session('error'))
            let toastEl = document.getElementById('toastError');
            let toast = new bootstrap.Toast(toastEl);
            toast.show();
        @endif
    });
</script>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>