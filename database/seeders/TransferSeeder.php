<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class TransferSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Transfer::truncate();
        
        $users = User::where('role_id', 3)->get();
        
        if ($users->count() < 2) {
            return;
        }
        
        $transfers = [];
        
        // Buat beberapa transfer antar warga
        for ($i = 0; $i < 10; $i++) {
            $from = $users->random();
            $to = $users->where('id', '!=', $from->id)->random();
            
            $transfers[] = [
                'from_user_id' => $from->id,
                'to_user_id' => $to->id,
                'nominal' => rand(50000, 500000),
                'tanggal' => date('Y-m-d', strtotime('-' . rand(1, 30) . ' days')),
                'keterangan' => 'Transfer antar warga',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        foreach ($transfers as $t) {
            Transfer::create($t);
        }
        
        $this->command->info('TransferSeeder berhasil: ' . count($transfers) . ' transfer ditambahkan');
        Schema::enableForeignKeyConstraints();
    }
}