<?php

namespace Database\Seeders;

use App\Models\User; // <-- Jangan lupa import
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- Jangan lupa import

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Pengguna Administrator
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@kursus.com',
            'password' => Hash::make('password'),
            'role_id' => 1 // ID untuk Administrator
        ]);

        // 2. Membuat Pengguna Instructor
        User::create([
            'name' => 'Instructor User',
            'email' => 'instructor@kursus.com',
            'password' => Hash::make('password'),
            'role_id' => 2 // ID untuk Instructor
        ]);

        // 3. Membuat Pengguna Peserta
        User::create([
            'name' => 'Peserta User',
            'email' => 'peserta@kursus.com',
            'password' => Hash::make('password'),
            'role_id' => 3 // ID untuk Peserta
        ]);
    }
}