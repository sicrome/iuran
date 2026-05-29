<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        
        DB::table('users')->truncate();
        
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin Kas RT',
            'email' => 'admin@kasrt.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Bendahara
        DB::table('users')->insert([
            'name' => 'Bendahara Kas RT',
            'email' => 'bendahara@kasrt.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Warga
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => 'Warga ' . $i,
                'email' => 'warga' . $i . '@kasrt.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'no_kk' => 'KK-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'no_rumah' => 'No. ' . $i,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('UserSeeder berhasil');
        
        Schema::enableForeignKeyConstraints();
    }
}