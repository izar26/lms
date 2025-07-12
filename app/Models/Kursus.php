<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    use HasFactory;

    // Memberitahu Laravel nama tabel yang kita gunakan
    protected $table = 'kursus';

    // Daftar kolom yang boleh diisi
    protected $fillable = [
        'judul',
        'instruktur_id',
        'deskripsi',
        'path_gambar',
        'apakah_eksklusif',
        'harga',
    ];

    public function peserta()
{
    return $this->belongsToMany(User::class, 'pendaftarans')
                ->withTimestamps()
                ->withPivot('created_at');
}


public function modul()
{
    return $this->hasMany(Modul::class)->orderBy('urutan');
}

public function testimoni()
{
    return $this->hasMany(Testimoni::class);
}

public function instruktur()
{
    return $this->belongsTo(User::class, 'instruktur_id');
}

public function kurikulum()
{
    return $this->hasMany(Kurikulum::class);
}

public function moduls()
{
    return $this->hasMany(\App\Models\Modul::class)->orderBy('urutan');
}
}

