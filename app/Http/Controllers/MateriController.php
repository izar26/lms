<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kursus;
use App\Models\Materi;
use App\Models\ProgressMateri;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function lanjut(Request $request, Kursus $kursus)
    {
        $user = Auth::user();

        // Pastikan user sudah daftar kursus ini
        if (!$user->kursusDiikuti->contains($kursus->id)) {
            return redirect()->route('home')->with('error', 'Kamu belum terdaftar di kursus ini.');
        }

        // Ambil semua modul yang ada di kursus ini
        $moduls = $kursus->moduls()->with(['materi' => function($q) {
            $q->orderBy('urutan');
        }])->orderBy('urutan')->get();

        // Tentukan materi aktif
        $materiId = $request->query('materi_id');
        $materi = null;

        foreach ($moduls as $modul) {
            foreach ($modul->materi as $m) {
                if ($materiId && $m->id == $materiId) {
                    $materi = $m;
                    break 2;
                }
            }
        }

        // Default materi pertama
        if (!$materi) {
            $materi = $moduls->first()?->materi->first();
        }

        if (!$materi) {
            return redirect()->back()->with('warning', 'Belum ada materi.');
        }

        // 🔒 Cek akses materi berdasarkan progres
        $urutanMateri = $materi->urutan;
        $materiSebelumnya = $materi->modul->materi
            ->where('urutan', '<', $urutanMateri);

        foreach ($materiSebelumnya as $m) {
            $cek = ProgressMateri::where('user_id', $user->id)
                ->where('materi_id', $m->id)
                ->where('status', 'selesai')
                ->first();
            if (!$cek) {
                return redirect()->back()->with('error', 'Selesaikan materi sebelumnya terlebih dahulu.');
            }
        }

        // Tandai materi sedang diakses (hanya jika belum pernah akses)
        $progress = ProgressMateri::where('user_id', $user->id)
            ->where('materi_id', $materi->id)
            ->first();

        if (!$progress) {
            ProgressMateri::create([
                'user_id' => $user->id,
                'materi_id' => $materi->id,
                'status' => 'sedang'
            ]);
        }

        // Materi berikutnya dari modul yang sama
        $materiBerikutnya = $materi->modul->materi
            ->where('urutan', '>', $materi->urutan)
            ->sortBy('urutan')
            ->first();

        return view('peserta.materi.lanjutkan', compact('kursus', 'moduls', 'materi', 'materiBerikutnya'));
    }

    public function selesaikan(Materi $materi)
    {
        $user = auth()->user()->load('kursusDiikuti');

        if (!$user->kursusDiikuti->contains($materi->modul->kursus_id)) {
            return redirect()->back()->with('error', 'Akses ditolak: kamu belum terdaftar di kursus ini.');
        }

        $progress = ProgressMateri::where('user_id', $user->id)
            ->where('materi_id', $materi->id)
            ->first();

        if ($progress) {
            $progress->status = 'selesai';
            $progress->save();
        } else {
            ProgressMateri::create([
                'user_id' => $user->id,
                'materi_id' => $materi->id,
                'status' => 'selesai'
            ]);
        }

        return redirect()->back()->with('success', 'Materi ditandai selesai!');
    }
}
