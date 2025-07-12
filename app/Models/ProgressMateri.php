<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressMateri extends Model
{
    use HasFactory;

    protected $table = 'progress_materi';

    protected $fillable = [
        'user_id',
        'materi_id',
        'status',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
