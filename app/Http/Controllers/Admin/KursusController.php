<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KursusController extends Controller
{
    public function index(Request $request)
{
    $daftar_kursus = Kursus::all();

    $kursus_terpilih = null;
    if ($request->has('pilih')) {
        $kursus_terpilih = Kursus::find($request->get('pilih'));
    }

    return view('admin.kursus.index', compact('daftar_kursus', 'kursus_terpilih'));
}


    public function show(Kursus $kursu)
{
    $kursu->load(['peserta', 'instruktur']);

    $users = User::whereHas('role', function ($q) {
        $q->where('name', 'Peserta');
    })->get();

    return view('admin.kursus.peserta', compact('kursu', 'users'));
}

    public function create()
    {
        $instruktors = User::whereHas('role', function ($q) {
            $q->where('name', 'Instructor');
        })->get();

        return view('admin.kursus.create', compact('instruktors'));
    }

    public function store(Request $request)
    {
        $data_tervalidasi = $request->validate([
    'judul' => 'required|string|max:255',
    'instruktur_id' => 'required|exists:users,id', // ✅ tambahkan ini
    'deskripsi' => 'required|string',
    'harga' => 'required|numeric',
    'path_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'apakah_eksklusif' => 'nullable',
]);


        if ($request->hasFile('path_gambar')) {
            $path_gambar = $request->file('path_gambar')->store('public/gambar-kursus');
            $data_tervalidasi['path_gambar'] = str_replace('public/', '', $path_gambar);
        }

        $data_tervalidasi['apakah_eksklusif'] = $request->has('apakah_eksklusif');

        Kursus::create($data_tervalidasi);

        return redirect()->route('admin.kursus.index')->with('sukses', 'Kursus baru berhasil ditambahkan.');
    }

    public function edit(Kursus $kursu)
    {
        $instruktors = User::whereHas('role', function ($q) {
            $q->where('name', 'Instructor');
        })->get();

        return view('admin.kursus.edit', [
            'kursus' => $kursu,
            'instruktors' => $instruktors
        ]);
    }

    public function update(Request $request, Kursus $kursu)
    {
        $data_tervalidasi = $request->validate([
            'judul' => 'required|string|max:255',
            'instruktur_id' => 'required|exists:users,id',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'path_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'apakah_eksklusif' => 'nullable',
        ]);

        if ($request->hasFile('path_gambar')) {
            if ($kursu->path_gambar) {
                Storage::delete('public/' . $kursu->path_gambar);
            }

            $path_gambar = $request->file('path_gambar')->store('public/gambar-kursus');
            $data_tervalidasi['path_gambar'] = str_replace('public/', '', $path_gambar);
        }

        $data_tervalidasi['apakah_eksklusif'] = $request->has('apakah_eksklusif');

        $kursu->update($data_tervalidasi);

        return redirect()->route('admin.kursus.index')->with('sukses', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Kursus $kursu)
    {
        if ($kursu->path_gambar) {
            Storage::delete('public/' . $kursu->path_gambar);
        }

        $kursu->delete();

        return redirect()->route('admin.kursus.index')->with('sukses', 'Kursus berhasil dihapus.');
    }

    public function peserta(Kursus $kursu)
{
    $kursu->load('peserta');

    // Ambil semua user yang punya role 'Peserta' dan belum mendaftar kursus ini
    $users = User::whereHas('role', function ($query) {
        $query->where('name', 'Peserta');
    })
    ->whereDoesntHave('kursus', function ($query) use ($kursu) {
        $query->where('kursus_id', $kursu->id);
    })
    ->get();

    return view('admin.kursus.peserta', compact('kursu', 'users'));
}


public function tambahPeserta(Request $request, Kursus $kursu)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $kursu->peserta()->attach($request->user_id);

    return back()->with('success', 'Peserta berhasil ditambahkan.');
}

public function hapusPeserta(Kursus $kursu, User $user)
{
    $kursu->peserta()->detach($user->id);

    return back()->with('success', 'Peserta berhasil dihapus.');
}




}
