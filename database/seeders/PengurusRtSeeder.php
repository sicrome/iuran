<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengurusRt;
use Illuminate\Support\Facades\Schema;

class PengurusRtSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        PengurusRt::truncate();
        
        $pengurus = [
            [
                'nama' => 'Bapak Slamet Riyadi',
                'jabatan' => 'Ketua RT',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Mawar No. 1 RT 01/01',
                'masa_jabatan_mulai' => 2022,
                'masa_jabatan_selesai' => 2026,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Ibu Sri Mulyani',
                'jabatan' => 'Sekretaris',
                'no_telepon' => '081234567891',
                'alamat' => 'Jl. Mawar No. 5 RT 01/01',
                'masa_jabatan_mulai' => 2022,
                'masa_jabatan_selesai' => 2026,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Bapak Ahmad Subagyo',
                'jabatan' => 'Bendahara',
                'no_telepon' => '081234567892',
                'alamat' => 'Jl. Melati No. 3 RT 01/01',
                'masa_jabatan_mulai' => 2022,
                'masa_jabatan_selesai' => 2026,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Ibu Rina Wati',
                'jabatan' => 'Seksi Kebersihan',
                'no_telepon' => '081234567893',
                'alamat' => 'Jl. Kenanga No. 2 RT 01/01',
                'masa_jabatan_mulai' => 2023,
                'masa_jabatan_selesai' => 2027,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Bapak Joko Susilo',
                'jabatan' => 'Seksi Keamanan',
                'no_telepon' => '081234567894',
                'alamat' => 'Jl. Anggrek No. 4 RT 01/01',
                'masa_jabatan_mulai' => 2023,
                'masa_jabatan_selesai' => 2027,
                'status' => 'aktif',
            ],
        ];
        
        foreach ($pengurus as $p) {
            PengurusRt::create($p);
        }
        
        $this->command->info('PengurusRtSeeder berhasil: ' . count($pengurus) . ' pengurus ditambahkan');
        Schema::enableForeignKeyConstraints();
    }
}