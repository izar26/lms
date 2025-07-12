<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Modul;
use App\Models\Materi; // <-- Jangan lupa tambahkan model Materi
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    // Menampilkan halaman manajemen kurikulum untuk satu kursus
    public function index(Kursus $kursu)
    {
        // Eager load relasi modul dan materi untuk efisiensi query
        $kursu->load('modul.materi');
        return view('admin.kurikulum.index', ['kursus' => $kursu]);
    }

    //== CRUD MODUL ==//

    // Menyimpan modul baru (Create)
    public function storeModul(Request $request, Kursus $kursu)
    {
        $request->validate(['judul_modul' => 'required|string|max:255']);
        $kursu->modul()->create($request->all());
        return back()->with('sukses', 'Modul baru berhasil ditambahkan.');
    }

    // Mengupdate modul (Update)
    public function updateModul(Request $request, Modul $modul)
    {
        $request->validate(['judul_modul' => 'required|string|max:255']);
        $modul->update($request->all());
        return back()->with('sukses', 'Modul berhasil diperbarui.');
    }

    // Menghapus modul (Delete)
    public function destroyModul(Modul $modul)
    {
        // Pastikan untuk menghapus materi terkait jika ada (bisa di-handle dengan cascading delete di database)
        $modul->delete();
        return back()->with('sukses', 'Modul berhasil dihapus.');
    }


    //== CRUD MATERI ==//

    // Menyimpan materi baru (Create)
    public function storeMateri(Request $request, Modul $modul)
{
    $request->validate([
        'judul_materi' => 'required|string|max:255',
        'konten' => 'nullable|string',
    ]);

    // Cari urutan terakhir
    $lastUrutan = $modul->materi()->max('urutan') ?? -1;

    $modul->materi()->create([
        'judul_materi' => $request->judul_materi,
        'konten' => $request->konten,
        'urutan' => $lastUrutan + 1,
    ]);

    return back()->with('sukses', 'Materi baru berhasil ditambahkan dengan urutan otomatis.');
}


    // Menghapus materi (Delete)
    public function destroyMateri(Materi $materi)
    {
        $materi->delete();
        return back()->with('sukses', 'Materi berhasil dihapus.');
    }
}