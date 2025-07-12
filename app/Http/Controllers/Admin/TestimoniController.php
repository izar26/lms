<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index(Kursus $kursu)
    {
        $kursu->load('testimoni');
        return view('admin.testimoni.index', ['kursus' => $kursu]);
    }

    public function store(Request $request, Kursus $kursu)
    {
        $data = $request->validate([
            'nama_peserta' => 'required|string',
            'pekerjaan' => 'required|string',
            'testimoni' => 'required|string',
            'path_foto' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('path_foto')) {
            $path = $request->file('path_foto')->store('public/foto-testimoni');
            $data['path_foto'] = str_replace('public/', '', $path);
        }

        $kursu->testimoni()->create($data);
        return back()->with('sukses', 'Testimoni berhasil ditambahkan.');
    }

    public function destroy(Testimoni $testimoni)
    {
        if ($testimoni->path_foto) {
            Storage::delete('public/' . $testimoni->path_foto);
        }
        $testimoni->delete();
        return back()->with('sukses', 'Testimoni berhasil dihapus.');
    }
}