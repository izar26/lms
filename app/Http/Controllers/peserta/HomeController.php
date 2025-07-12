<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller; // <-- TAMBAHKAN BARIS INI
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Kursus; // <-- Tambahkan juga ini untuk relasi

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    // Ambil user yang sedang login
    $user = Auth::user();

    // 1. Ambil semua kursus yang SUDAH diikuti oleh user
    $kursus_diikuti = $user->kursus;

    // 2. Ambil ID dari kursus yang sudah diikuti
    $id_kursus_diikuti = $kursus_diikuti->pluck('id');

    // 3. Ambil kursus lainnya (yang BELUM diikuti)
    $kursus_lainnya = \App\Models\Kursus::whereNotIn('id', $id_kursus_diikuti)->latest()->get();

    // Kirim kedua data tersebut ke view
    return view('peserta.index', compact('kursus_diikuti', 'kursus_lainnya'));
}
}