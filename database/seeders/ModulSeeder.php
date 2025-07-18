<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kursus;
use App\Models\Modul;
use Faker\Factory as Faker;

class ModulSeeder extends Seeder
{
    /**
     * Jalankan proses seeding database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $kursusIds = Kursus::pluck('id')->all();

        if (empty($kursusIds)) {
            $this->command->warn('Tidak ada kursus yang ditemukan. Seeder Modul dilewati.');
            return;
        }

        // Array frasa Bahasa Indonesia untuk judul modul yang lebih natural
        $judulModulIndo = [
            'Pengantar Singkat',
            'Konsep Dasar',
            'Implementasi Awal',
            'Teknik Lanjutan',
            'Studi Kasus Praktis',
            'Optimalisasi dan Performa',
            'Manajemen Proyek',
            'Analisis Data',
            'Strategi Efektif',
            'Membangun Portofolio',
            'Penyelesaian Masalah',
            'Dasar-dasar Keamanan',
            'Eksplorasi Fitur Baru',
            'Memahami Ekosistem',
            'Persiapan Ujian',
            'Tips dan Trik',
            'Integrasi Sistem',
            'Pengantar Mendalam',
            'Tinjauan Umum',
            'Kesimpulan dan Langkah Selanjutnya',
        ];

        foreach ($kursusIds as $kursusId) {
            $numModuls = mt_rand(3, 7); // Setiap kursus memiliki 3-7 modul
            $usedTitles = []; // Untuk melacak judul yang sudah dipakai per kursus

            for ($i = 0; $i < $numModuls; $i++) {
                $uniqueTitle = false;
                $judulModul = '';
                // Pastikan judul modul unik untuk kursus ini
                while (!$uniqueTitle) {
                    $judulModul = $faker->randomElement($judulModulIndo) . ' ' . $faker->optional(0.5, '')->word();
                    if (!in_array($judulModul, $usedTitles)) {
                        $uniqueTitle = true;
                        $usedTitles[] = $judulModul;
                    }
                }

                Modul::create([
                    'kursus_id' => $kursusId,
                    'judul_modul' => $judulModul, // Hanya judul dari array + kata acak, tanpa 'Modul X:'
                    'urutan' => $i + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}