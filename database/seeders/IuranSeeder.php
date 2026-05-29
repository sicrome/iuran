<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IuranWarga;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class IuranSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        IuranWarga::truncate();
        
        $users = User::where('role_id', 3)->get();
        
        if ($users->isEmpty()) {
            return;
        }
        
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
        $tahun = date('Y');
        
        $iuran = [];
        
        foreach ($users as $user) {
            foreach ($bulanList as $index => $bulan) {
                // 80% sudah lunas, 20% belum
                $status = rand(1, 100) <= 80 ? 'lunas' : 'belum';
                $tanggal_bayar = $status == 'lunas' ? date("$tahun-" . ($index + 1) . "-" . rand(1, 28)) : null;
                
                $iuran[] = [
                    'user_id' => $user->id,
                    'bulan_tahun' => $bulan . ' ' . $tahun,
                    'nominal' => 100000,
                    'status' => $status,
                    'tanggal_bayar' => $tanggal_bayar,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        foreach ($iuran as $i) {
            IuranWarga::create($i);
        }
        
        $this->command->info('IuranSeeder berhasil: ' . count($iuran) . ' data iuran ditambahkan');
        Schema::enableForeignKeyConstraints();
    }
}