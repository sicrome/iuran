<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleOnlySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin', 'display_name' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'bendahara', 'display_name' => 'Bendahara', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'warga', 'display_name' => 'Warga', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}