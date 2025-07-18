<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan semua seeder dari sini.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
        $this->call(KursusSeeder::class);
        $this->call(ModulSeeder::class);
        $this->call(MateriSeeder::class);
        $this->call(TestimoniSeeder::class);
    }
}
