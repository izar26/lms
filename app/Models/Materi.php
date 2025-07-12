<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = ['modul_id', 'judul_materi', 'deskripsi_materi', 'link_video', 'urutan'];

public function modul() { return $this->belongsTo(Modul::class); }

public function progress()
{
    return $this->hasMany(ProgressMateri::class);
}

}
