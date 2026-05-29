<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KasSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        
        DB::table('kas')->truncate();
        
        $users = DB::table('users')->where('role_id', 3)->get();
        
        if ($users->isEmpty()) {
            $this->command->info('Tidak ada user warga');
            Schema::enableForeignKeyConstraints();
            return;
        }
        
        // Pemasukan dari warga
        foreach ($users as $user) {
            DB::table('kas')->insert([
                'user_id' => $user->id,
                'bulan' => 'Mei 2025',
                'jenis' => 'pemasukan',
                'nominal' => 100000,
                'tanggal' => now(),
                'keterangan' => 'Iuran bulan Mei',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Pengeluaran
        $firstUser = $users->first();
        DB::table('kas')->insert([
            'user_id' => $firstUser->id,
            'bulan' => 'Mei 2025',
            'jenis' => 'pengeluaran',
            'nominal' => 150000,
            'tanggal' => now(),
            'keterangan' => 'Beli alat kebersihan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $this->command->info('KasSeeder berhasil');
        
        Schema::enableForeignKeyConstraints();
    }
}