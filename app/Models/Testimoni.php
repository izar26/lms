<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $fillable = ['kursus_id', 'nama_peserta', 'pekerjaan', 'testimoni', 'path_foto'];

public function kursus()
{
    return $this->belongsTo(Kursus::class);
}
}
