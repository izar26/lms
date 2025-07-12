<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Nama Aplikasi Anda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* [1] Definisi Font & Warna Global */
        :root {
            --bs-primary: #4F46E5; /* Ungu Modern */
            --bs-primary-rgb: 79, 70, 229;
            --bs-font-sans-serif: 'Plus Jakarta Sans', sans-serif;
            --sidebar-bg: #111827; /* Abu-abu sangat gelap */
            --sidebar-link-color: #9CA3AF; /* Abu-abu untuk link */
            --sidebar-link-hover-bg: #374151; /* Latar saat hover */
            --sidebar-link-active-color: #FFFFFF; /* Putih untuk link aktif */
            --content-bg: #F9FAFB; /* Latar area konten */
        }

        body {
            background-color: var(--content-bg);
            font-family: var(--bs-font-sans-serif);
        }

        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* [2] Styling Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            transition: all 0.3s;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header a {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }
        
        .sidebar-menu-item .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.9rem 1.5rem;
            color: var(--sidebar-link-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-menu-item .sidebar-link:hover {
            background-color: var(--sidebar-link-hover-bg);
            color: white;
        }

        /* State Aktif untuk link sidebar */
        .sidebar-menu-item.active .sidebar-link {
            color: var(--sidebar-link-active-color);
            background-color: var(--bs-primary);
            font-weight: 600;
        }
        
        .sidebar-link i {
            margin-right: 1rem;
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }

        /* [3] Styling Konten Utama */
        .main-content {
            flex-grow: 1;
            padding-left: 260px; /* Lebar yang sama dengan sidebar */
            display: flex;
            flex-direction: column;
        }
        
        .topbar {
            background-color: white;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        main.content {
            padding: 2rem;
        }

    </style>
    @stack('styles')
</head>
<body>

<div class="wrapper">
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="#">AdminPanel</a>
        </div>
        <ul class="sidebar-menu p-0">
            {{-- TIPS: Gunakan helper request()->is() untuk menandai link aktif --}}
            <li class="sidebar-menu-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ request()->is('admin/kursus*') ? 'active' : '' }}">
                <a href="{{ route('admin.kursus.index') }}" class="sidebar-link">
                    <i class="bi bi-journal-richtext"></i>
                    <span>Manajemen Kursus</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
    <a href="{{ route('admin.users.index') }}" class="sidebar-link">
        <i class="bi bi-people-fill"></i>
        <span>Manajemen Pengguna</span>
    </a>
</li>
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-gear-fill"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </aside>

    <div class="main-content">
        <nav class="topbar d-flex justify-content-end">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <strong>{{ Auth::user()->name ?? 'Admin User' }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                    <li><a class="dropdown-item" href="#">Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </div>
        </nav>

        <main class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 fw-bold mb-0">@yield('title')</h1>
                {{-- Bisa untuk breadcrumb atau tombol aksi global --}}
            </div>
            
            {{-- Di sinilah semua konten dari file lain akan ditampilkan --}}
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>