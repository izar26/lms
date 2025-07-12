<?php

namespace App\Http\Controllers;

use App\Models\Kursus; // <-- Jangan lupa import
use Illuminate\Http\Request;

class HalamanKursusController extends Controller
{
    /**
     * Menampilkan halaman detail dari sebuah kursus.
     */
    public function show(Kursus $kursu)
{
    $kursu->load(['modul.materi', 'testimoni']); // Tambahkan 'testimoni'
    return view('peserta.kursus.show', ['kursus' => $kursu]);
}
}
