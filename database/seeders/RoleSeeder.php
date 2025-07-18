<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insertOrIgnore([
    [
        'id' => 1,
        'name' => 'Administrator',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'id' => 2,
        'name' => 'Instructor',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'id' => 3,
        'name' => 'Peserta',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
]);

    }
}
