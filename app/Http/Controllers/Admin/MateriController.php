<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Modul; // Pastikan model Modul di-import jika belum
use Illuminate\Http\Request;

class MateriController extends Controller
{
    /**
     * Menampilkan form untuk mengisi/mengedit konten materi.
     * Menggunakan Route-Model Binding untuk mendapatkan objek $materi secara otomatis.
     */
    public function isi(Materi $materi)
    {
        // Mengirim data materi ke view 'admin.materi.isi'
        return view('admin.materi.isi', compact('materi'));
    }

    /**
     * Menyimpan perubahan konten materi ke database.
     */
    public function updateIsi(Request $request, Materi $materi)
    {
        // 1. Validasi input dari form
        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'deskripsi_materi' => 'nullable|string',
            'link_video' => 'nullable|url', // Memastikan format URL valid
        ]);

        // 2. Update data di database
        $materi->judul_materi = $request->judul_materi;
        $materi->deskripsi_materi = $request->deskripsi_materi;
        $materi->link_video = $request->link_video;
        // Anda juga bisa menambahkan field 'urutan' di form jika diperlukan
        // $materi->urutan = $request->urutan;

        $materi->save(); // Simpan perubahan

        // 3. Redirect kembali ke halaman manajemen kurikulum
        // Kita perlu mengambil ID kursus dari relasi: Materi -> Modul -> Kursus
        $kursusId = $materi->modul->kursus_id;

        return redirect()->route('admin.kurikulum.index', $kursusId)
                         ->with('sukses', 'Konten materi "' . $materi->judul_materi . '" berhasil diperbarui.');
    }

    /**
     * Menyimpan materi baru (judulnya saja) dari halaman kurikulum.
     * (Fungsi ini mungkin sudah Anda miliki, disertakan untuk kelengkapan)
     */
    public function store(Request $request, Modul $modul)
    {
        $request->validate(['judul_materi' => 'required|string|max:255']);

        $modul->materi()->create([
            'judul_materi' => $request->judul_materi,
            // Nilai default lainnya akan diisi oleh database
        ]);

        return back()->with('sukses', 'Materi baru berhasil ditambahkan.');
    }

    /**
     * Mengupdate judul materi dari modal di halaman kurikulum.
     * (Fungsi ini mungkin sudah Anda miliki, disertakan untuk kelengkapan)
     */
    public function update(Request $request, Materi $materi)
    {
        $request->validate(['judul_materi' => 'required|string|max:255']);
        $materi->update($request->only('judul_materi'));
        return back()->with('sukses', 'Judul materi berhasil diubah.');
    }

    /**
     * Menghapus materi dari modal di halaman kurikulum.
     * (Fungsi ini mungkin sudah Anda miliki, disertakan untuk kelengkapan)
     */
    public function destroy(Materi $materi)
    {
        $materi->delete();
        return back()->with('sukses', 'Materi berhasil dihapus.');
    }

    
}
