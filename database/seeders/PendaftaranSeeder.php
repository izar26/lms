<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Daftarkan User ID 3 ke Kursus ID 1
    \App\Models\Pendaftaran::create([
        'user_id' => 3,
        'kursus_id' => 1
    ]);
}
}
