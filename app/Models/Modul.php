<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    protected $fillable = ['kursus_id', 'judul_modul', 'urutan'];

public function kursus() { return $this->belongsTo(Kursus::class); }
public function materi() { return $this->hasMany(Materi::class)->orderBy('urutan'); }

}
