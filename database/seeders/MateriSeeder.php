<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modul;
use App\Models\Materi;
use Faker\Factory as Faker;

class MateriSeeder extends Seeder
{
    /**
     * Jalankan proses seeding database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $modulIds = Modul::pluck('id')->all();

        if (empty($modulIds)) {
            $this->command->warn('Tidak ada modul yang ditemukan. Seeder Materi dilewati.');
            return;
        }

        $youtubeLinks = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Rick Astley - Never Gonna Give You Up (contoh populer untuk testing, bisa diganti)
            'https://www.youtube.com/watch?v=S8pBw4c_d8E', // Contoh tutorial Laravel (placeholder)
            'https://www.youtube.com/watch?v=xvFZjo5PgG0', // Contoh video edukasi sains (placeholder)
            'https://www.youtube.com/watch?v=qpP6vjK6vjA', // Contoh video desain grafis (placeholder)
            'https://www.youtube.com/watch?v=C0DPdy98e4c', // Contoh video pemasaran digital (placeholder)
            'https://www.youtube.com/watch?v=kYI_l88R5-A', // Contoh video pengembangan diri (placeholder)
        ];

        // Array frasa Bahasa Indonesia untuk judul materi
        $judulMateriIndo = [
            'Memahami Konsep',
            'Langkah-langkah Praktis',
            'Studi Kasus: Penerapan',
            'Optimasi dan Perbaikan',
            'Pengenalan Tools',
            'Debugging dan Solusi',
            'Keamanan Data',
            'Fitur Unggulan',
            'Evaluasi Proyek',
            'Tips dan Trik',
            'Diskusi Interaktif',
            'Latihan Mandiri',
            'Penggunaan Lanjutan',
            'Persiapan Implementasi',
            'Tantangan Umum',
            'Meninjau Kembali Dasar',
            'Membangun dari Awal',
            'Teknik Pemecahan Masalah',
            'Berinteraksi dengan API',
            'Pengenalan Paradigma',
        ];

        // Frasa awalan untuk deskripsi materi
        $awalanDeskripsi = [
            'Dalam materi ini, kita akan mempelajari',
            'Materi ini mencakup pembahasan tentang',
            'Anda akan memahami konsep dasar dari',
            'Fokus utama materi ini adalah',
            'Kita akan mendalami topik',
        ];

        // Kata kerja atau frasa yang umum untuk deskripsi
        $aktivitasMateri = [
            'menganalisis', 'membangun', 'mengembangkan', 'memahami', 'mengimplementasikan',
            'menjelaskan', 'menerapkan', 'menyelesaikan masalah', 'mengeksplorasi', 'merancang'
        ];

        foreach ($modulIds as $modulId) {
            $numMateris = mt_rand(4, 8); // Jumlah materi per modul
            $usedMateriTitles = []; // Untuk melacak judul materi yang sudah dipakai per modul

            for ($i = 0; $i < $numMateris; $i++) {
                $uniqueMateriTitle = false;
                $judulMateri = '';
                // Pastikan judul materi unik untuk modul ini
                while (!$uniqueMateriTitle) {
                    $judulMateri = $faker->randomElement($judulMateriIndo) . ' ' . $faker->optional(0.6, '')->word();
                    if (!in_array($judulMateri, $usedMateriTitles)) {
                        $uniqueMateriTitle = true;
                        $usedMateriTitles[] = $judulMateri;
                    }
                }

                Materi::create([
                    'modul_id' => $modulId,
                    'judul_materi' => $judulMateri, // Hanya frasa Indo + kata acak
                    'deskripsi_materi' => $faker->randomElement($awalanDeskripsi) . ' ' . $faker->words(4, true) . '. Anda akan ' . $faker->randomElement($aktivitasMateri) . ' berbagai teknik dan ' . $faker->word() . '. Fokus pada aspek ' . $faker->randomElement(['teknis', 'konseptual', 'praktis']) . ' untuk memastikan pemahaman yang komprehensif.',
                    'link_video' => $faker->randomElement($youtubeLinks),
                    'urutan' => $i + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}