<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Import Auth
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek dulu apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Cek apakah nama peran user sesuai dengan peran yang diizinkan
        if ($request->user()->role->name == $role) {
            // Jika sesuai, lanjutkan permintaan
            return $next($request);
        }

        // Jika tidak sesuai, hentikan dengan halaman error 403 (Forbidden)
        abort(403, 'ANDA TIDAK MEMILIKI AKSES UNTUK HALAMAN INI.');
    }
}