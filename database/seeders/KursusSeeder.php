<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kursus;
use App\Models\User;
use Faker\Factory as Faker;

class KursusSeeder extends Seeder
{
    /**
     * Jalankan proses seeding database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $instrukturId = User::where('id', 3)->value('id');

        if (!$instrukturId) {
            $this->command->warn('Instruktur dengan ID 3 tidak ditemukan. Seeder Kursus dilewati.');
            return;
        }

        $gambarKursus = [
            'https://source.unsplash.com/random/800x600?coding',
            'https://source.unsplash.com/random/800x600?language',
            'https://source.unsplash.com/random/800x600?design',
            'https://source.unsplash.com/random/800x600?marketing',
            'https://source.unsplash.com/random/800x600?business',
            'https://source.unsplash.com/random/800x600?photography',
            'https://source.unsplash.com/random/800x600?cooking',
            'https://source.unsplash.com/random/800x600?music',
        ];

        // Array judul kursus yang lebih spesifik dalam Bahasa Indonesia
        $judulKursusIndonesia = [
            'Kursus Lengkap Web Development',
            'Mahir Desain Grafis dengan Figma',
            'Belajar Bahasa Inggris untuk Bisnis',
            'Dasar-dasar Fotografi Digital Profesional',
            'Strategi Pemasaran Digital Modern',
            'Pengembangan Aplikasi Mobile Android',
            'Analisis Data dengan Python',
            'Manajemen Proyek Agile',
            'Teknik Penulisan Kreatif',
            'Belajar Public Speaking Efektif',
        ];

        // Kata-kata atau frasa tambahan untuk deskripsi yang lebih umum
        $keteranganTambahan = [
            'secara komprehensif', 'dengan mudah', 'dari nol', 'hingga mahir', 'di era digital ini',
            'dengan studi kasus', 'melalui praktik langsung', 'untuk meningkatkan karir Anda',
            'dengan pendekatan interaktif', 'berdasarkan standar industri'
        ];

        for ($i = 0; $i < 10; $i++) {
            Kursus::create([
                'judul' => $faker->unique()->randomElement($judulKursusIndonesia),
                'instruktur_id' => $instrukturId,
                // Deskripsi diubah agar tidak menggunakan 'verb'
                'deskripsi' => 'Dapatkan pemahaman mendalam tentang ' . $faker->words(3, true) . '. Kursus ini dirancang untuk membantu Anda menguasai keterampilan baru dan mengembangkan potensi Anda ' . $faker->randomElement($keteranganTambahan) . '. Pelajari teori dan praktik terbaik dalam ' . $faker->words(4, true) . ' melalui studi kasus nyata dan proyek praktis. Cocok untuk ' . $faker->randomElement(['pemula', 'tingkat menengah', 'profesional']) . ' yang ingin meningkatkan karir di bidang ' . $faker->word() . '.',
                'path_gambar' => $faker->randomElement($gambarKursus),
                'apakah_eksklusif' => $faker->boolean(30),
                'harga' => $faker->boolean(70) ? $faker->numberBetween(150000, 1500000) : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}