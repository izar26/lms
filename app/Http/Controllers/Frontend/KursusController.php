<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use Illuminate\Support\Facades\Auth;

class KursusController extends Controller
{
    public function daftar(Kursus $kursus)
    {
        $user = Auth::user();

        // Cek apakah user sudah terdaftar
        if ($kursus->peserta()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'Kamu sudah terdaftar di kursus ini.');
        }

        // Tambahkan user ke kursus
        $kursus->peserta()->attach($user->id);

        return back()->with('sukses', 'Berhasil mendaftar kursus.');
    }
}
