<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimoni; // Pastikan model Testimoni sudah ada
use App\Models\Kursus;    // Pastikan model Kursus sudah ada
use Faker\Factory as Faker;

class TestimoniSeeder extends Seeder
{
    /**
     * Jalankan proses seeding database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua ID kursus yang ada di database
        $kursusIds = Kursus::pluck('id')->all();

        // Jika tidak ada kursus yang ditemukan, seeder testimoni dilewati
        if (empty($kursusIds)) {
            $this->command->warn('Tidak ada kursus yang ditemukan. Seeder Testimoni dilewati.');
            return;
        }

        // Array frasa Bahasa Indonesia untuk testimoni agar lebih natural
        $frasaTestimoni = [
            'Sangat direkomendasikan! Kursusnya sangat membantu saya memahami ',
            'Materi yang disampaikan mudah dicerna dan sangat relevan untuk ',
            'Saya sangat senang bisa bergabung di kursus ini. Instrukturnya ',
            'Pengalaman belajar yang luar biasa! Saya mendapatkan banyak ilmu baru tentang ',
            'Kursus ini membuka wawasan saya tentang ',
            'Tidak menyesal ikut kursus ini. Penjelasannya detail dan ',
            'Benar-benar mengubah cara pandang saya terhadap ',
            'Saya tidak pernah menyangka bisa menguasai ',
            'Terima kasih atas ilmu yang bermanfaat ini. Saya jadi lebih ',
            'Materi interaktif dan contoh kasusnya sangat membantu dalam '
        ];

        // Array contoh URL foto profil dummy
        $fotoProfil = [
            'https://randomuser.me/api/portraits/men/1.jpg',
            'https://randomuser.me/api/portraits/women/2.jpg',
            'https://randomuser.me/api/portraits/men/3.jpg',
            'https://randomuser.me/api/portraits/women/4.jpg',
            'https://randomuser.me/api/portraits/men/5.jpg',
            'https://randomuser.me/api/portraits/women/6.jpg',
            'https://randomuser.me/api/portraits/men/7.jpg',
            'https://randomuser.me/api/portraits/women/8.jpg',
            'https://randomuser.me/api/portraits/men/9.jpg',
            'https://randomuser.me/api/portraits/women/10.jpg',
        ];

        for ($i = 0; $i < 15; $i++) { // Membuat 15 data testimoni dummy
            Testimoni::create([
                'kursus_id' => $faker->randomElement($kursusIds), // Pilih ID kursus secara acak
                'nama_peserta' => $faker->name('male' || 'female'), // Nama peserta acak
                'pekerjaan' => $faker->jobTitle(), // Pekerjaan acak
                // Testimoni menggabungkan frasa Indo dan kata acak
                'testimoni' => $faker->randomElement($frasaTestimoni) . $faker->words(mt_rand(5, 10), true) . '. ' . $faker->sentence(mt_rand(4, 7), true) . ' Saya sangat merekomendasikan kursus ini!',
                'path_foto' => $faker->randomElement($fotoProfil), // Pilih foto acak dari array
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}