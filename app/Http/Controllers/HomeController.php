<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kursus;
use App\Models\Testimoni;


class HomeController extends Controller
{

public function index()
{
    // Ambil 3 kursus teratas (bisa diubah sesuai logika Anda)
    $kursusUnggulan = Kursus::orderBy('created_at', 'desc')->take(3)->get();
    
    // Ambil 3 testimoni teratas
    $testimonis = Testimoni::orderBy('created_at', 'desc')->take(3)->get();

    return view('welcome', [
        'kursusUnggulan' => $kursusUnggulan,
        'testimonis' => $testimonis
    ]);
}
}
