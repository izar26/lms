<?php

// app/Http/Controllers/KursusController.php

namespace App\Http\Controllers;

use App\Models\Kursus;
use Illuminate\Http\Request;

class KursusController extends Controller
{
    // Method untuk menampilkan semua kursus
    public function index()
    {
        // Ambil semua data kursus dengan pagination (9 per halaman)
        $semuaKursus = Kursus::orderBy('created_at', 'desc')->paginate(9);

        return view('kursus.index', compact('semuaKursus'));
    }
}
