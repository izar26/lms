<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    // Kolom yang disembunyikan saat serialisasi
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting data otomatis
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: Setiap user punya satu role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relasi: User sebagai peserta bisa mengikuti banyak kursus.
     */
    public function kursus()
{
    return $this->belongsToMany(Kursus::class, 'pendaftarans')
                ->withTimestamps(); // Tambahkan juga ini
}


    /**
     * Relasi: User sebagai instruktur bisa mengampu banyak kursus.
     */
    public function kursusDiampu()
    {
        return $this->hasMany(Kursus::class, 'instruktur_id');
    }

    public function kursusDiikuti()
{
    return $this->belongsToMany(Kursus::class, 'pendaftarans', 'user_id', 'kursus_id')->withTimestamps();
}


public function progressMateri()
{
    return $this->hasMany(ProgressMateri::class);
}


}
