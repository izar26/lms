<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Nama Aplikasi Anda</title>

    {{-- CDN Tetap Digunakan untuk Kemudahan --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #4F46E5;
            --bs-primary-rgb: 79, 70, 229;
            --bs-font-sans-serif: 'Plus Jakarta Sans', sans-serif;
            --sidebar-bg: #1F2937; /* Warna abu-biru gelap */
            --sidebar-link-color: #9CA3AF;
            --sidebar-link-hover-bg: #374151;
            --sidebar-link-active-color: #FFFFFF;
            --content-bg: #F9FAFB;
            --border-color: #e5e7eb;
        }
        body {
            background-color: var(--content-bg);
            font-family: var(--bs-font-sans-serif);
        }
        .wrapper { display: flex; width: 100%; }

        /* [1] PENYESUAIAN SIDEBAR */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            transition: width 0.3s ease; /* Transisi untuk collapse */
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }
        .sidebar-header {
            padding: 1.25rem; text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-header a {
            color: white; font-size: 1.5rem;
            font-weight: 700; text-decoration: none;
        }
        .sidebar-menu { list-style: none; padding: 1rem 0.75rem; flex-grow: 1; }
        .sidebar-menu-item .sidebar-link {
            display: flex; align-items: center;
            padding: 0.75rem 1rem; color: var(--sidebar-link-color);
            text-decoration: none; font-weight: 500;
            transition: all 0.2s ease; border-radius: 0.5rem;
        }
        .sidebar-menu-item .sidebar-link:hover {
            background-color: var(--sidebar-link-hover-bg);
            color: white;
        }
        /* Style Active yang lebih halus */
        .sidebar-menu-item.active .sidebar-link {
            color: var(--sidebar-link-active-color);
            background-color: var(--bs-primary);
            font-weight: 600;
        }
        .sidebar-link i {
            margin-right: 1rem; font-size: 1.2rem;
            width: 20px; text-align: center;
        }
        .sidebar-footer {
             padding: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* [2] LOGIKA SIDEBAR COLLAPSE */
        .sidebar.collapsed {
            width: 88px; /* Lebar saat diciutkan */
        }
        .sidebar.collapsed .sidebar-header .brand-text,
        .sidebar.collapsed .sidebar-link span {
            display: none; /* Sembunyikan teks */
        }
        .sidebar.collapsed .sidebar-link {
            justify-content: center; /* Ikon jadi di tengah */
        }
        .sidebar.collapsed .sidebar-link i {
            margin-right: 0;
        }
        .main-content {
            flex-grow: 1;
            padding-left: 260px; /* Default padding */
            transition: padding-left 0.3s ease; /* Transisi untuk konten */
        }
        .main-content.sidebar-collapsed {
            padding-left: 88px; /* Padding saat sidebar diciutkan */
        }

        /* [3] PENYESUAIAN TOPBAR & KONTEN */
        .topbar {
            background-color: white; padding: 0.75rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        .topbar .avatar {
            width: 36px; height: 36px;
        }
        main.content { padding: 2rem; }
        /* Style global untuk card di dalam konten */
        .card {
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px 0 rgba(0,0,0,0.07), 0 1px 2px 0 rgba(0,0,0,0.05);
            border-radius: 0.75rem;
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="wrapper">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#">
                <i class="bi bi-rocket-launch-fill"></i> <span class="brand-text">AdminPanel</span>
            </a>
        </div>
        <ul class="sidebar-menu p-0">
            <li class="sidebar-menu-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link"><i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span></a>
            </li>
            <li class="sidebar-menu-item {{ request()->is('admin/kursus*') ? 'active' : '' }}">
                <a href="{{ route('admin.kursus.index') }}" class="sidebar-link"><i class="bi bi-journal-richtext"></i> <span>Manajemen Kursus</span></a>
            </li>
            <li class="sidebar-menu-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}" class="sidebar-link"><i class="bi bi-people-fill"></i> <span>Manajemen Pengguna</span></a>
            </li>
        </ul>
    </aside>

    <div class="main-content" id="main-content">
        <nav class="topbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-light me-3" id="sidebar-toggle"><i class="bi bi-list"></i></button>
                {{-- <div class="input-group d-none d-md-flex">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Cari sesuatu...">
                </div> --}}
            </div>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'A') }}&background=4F46E5&color=fff&rounded=true" alt="Avatar" class="avatar me-2">
                    <strong class="d-none d-sm-block">{{ Auth::user()->name ?? 'Admin User' }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small shadow border-0">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle me-2"></i>Profil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-0">@yield('title')</h1>
                    @yield('breadcrumb')
                </div>
                @yield('action-button')
            </div>
            
            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
{{-- [4] JAVASCRIPT UNTUK TOGGLE SIDEBAR --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebar-toggle');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('sidebar-collapsed');
        });
    });
</script>
@stack('scripts')
</body>
</html>