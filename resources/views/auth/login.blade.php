@extends('layouts.app')

{{-- Menambahkan CSS kustom khusus untuk halaman login --}}
@push('styles')
<style>
    /* Mengatur ulang body dan html untuk layout fullscreen */
    html, body {
        height: 100%;
        overflow: hidden; /* Mencegah scroll pada layout utama */
    }
    body {
        background-color: #f3f4f6;
        font-family: 'Plus Jakarta Sans', sans-serif; /* Mengasumsikan font ini sudah ada di layouts.app */
    }
    
    /* Menghapus padding default dari container bawaan layouts.app jika ada */
    .container {
        max-width: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* [1] Wrapper utama untuk layout dua kolom */
    .login-wrapper {
        display: flex;
        height: 100vh;
        width: 100vw;
    }

    /* [2] Kolom Kiri untuk Branding */
    .login-branding {
        width: 50%;
        background: linear-gradient(45deg, #4f46e5, #818cf8);
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 3rem;
        text-align: center;
    }
    .login-branding .logo {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }
    .login-branding .tagline {
        font-size: 1.25rem;
        opacity: 0.8;
    }
    
    /* Sembunyikan kolom branding di layar kecil */
    @media (max-width: 992px) {
        .login-branding {
            display: none;
        }
    }

    /* [3] Kolom Kanan untuk Form */
    .login-form-wrapper {
        width: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        background-color: white;
        overflow-y: auto; /* Aktifkan scroll hanya di kolom form jika perlu */
    }

    @media (max-width: 992px) {
        .login-form-wrapper {
            width: 100%;
        }
    }

    .login-form-container {
        width: 100%;
        max-width: 450px; /* Lebar maksimal form */
    }

    /* [4] Styling Form yang Lebih Modern */
    .form-control {
        padding: 0.9rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
    }
    .form-control:focus {
        border-color: var(--bs-primary, #4f46e5);
        box-shadow: 0 0 0 3px rgba(var(--bs-primary-rgb, 79, 70, 229), 0.2);
    }
    .input-group-text {
        background-color: #e9ecef;
        border: 1px solid #d1d5db;
        border-right: none;
        border-top-left-radius: 0.5rem;
        border-bottom-left-radius: 0.5rem;
    }
    .input-group .form-control {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    .btn-primary {
        padding: 0.9rem 1.5rem;
        font-weight: 600;
        border-radius: 0.5rem;
        background-color: var(--bs-primary, #4f46e5);
        border: none;
        box-shadow: 0 4px 15px rgba(var(--bs-primary-rgb, 79, 70, 229), 0.25);
    }

</style>
@endpush

@section('content')
<div class="login-wrapper">
    {{-- [2] KOLOM KIRI UNTUK BRANDING --}}
    <div class="login-branding">
        {{-- Ganti dengan logo Anda --}}
        <div class="logo">
            <i class="bi bi-rocket-launch-fill"></i> YourApp
        </div>
        <p class="tagline">Masuk untuk melanjutkan dan meraih mimpimu.</p>
    </div>

    {{-- [3] KOLOM KANAN UNTUK FORM --}}
    <div class="login-form-wrapper">
        <div class="login-form-container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Selamat Datang Kembali</h2>
                <p class="text-muted">Silakan masuk menggunakan akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Input Email dengan Ikon --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">{{ __('Alamat Email') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="contoh@email.com">
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Input Password dengan Ikon --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                     <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password">
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                {{-- Opsi Remember Me & Lupa Password --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Ingat Saya') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link btn-sm" href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif
                </div>

                {{-- Tombol Login Full-Width --}}
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Masuk Sekarang') }}
                    </button>
                </div>
                
                {{-- Link ke Halaman Registrasi --}}
                <p class="text-center text-muted">
                    Belum punya akun? <a href="">Daftar di sini</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection