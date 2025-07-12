<?php

namespace Database\Seeders;

use App\Models\Role; // Jangan lupa tambahkan ini
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat peran dengan urutan yang kita inginkan
        Role::create(['name' => 'Administrator']); // Akan memiliki id = 1
        Role::create(['name' => 'Instructor']);    // Akan memiliki id = 2
        Role::create(['name' => 'Peserta']);       // Akan memiliki id = 3
    }
}