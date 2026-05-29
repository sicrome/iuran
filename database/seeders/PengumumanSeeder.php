<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengumumans')->insert([
            [
                'judul' => 'Kerja Bakti Lingkungan',
                'isi' => 'Akan dilaksanakan kerja bakti lingkungan pada hari Minggu, 12 Mei 2024 pukul 07.00 WIB. Mohon partisipasi seluruh warga.',
                'icon' => '🌿',
                'status' => 'aktif',
                'tanggal_mulai' => '2024-05-01',
                'tanggal_selesai' => '2024-05-20',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pembayaran Iuran Mei 2024',
                'isi' => 'Pembayaran Iuran RT bulan Mei 2024 sudah dibuka. Terima kasih kepada warga yang sudah membayar.',
                'icon' => '💰',
                'status' => 'aktif',
                'tanggal_mulai' => '2024-05-01',
                'tanggal_selesai' => '2024-05-31',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Rapat Pengurus RT',
                'isi' => 'Rapat rutin pengurus RT akan dilaksanakan pada hari Sabtu, 4 Mei 2024 pukul 19.30 WIB di Pos RT.',
                'icon' => '📢',
                'status' => 'aktif',
                'tanggal_mulai' => '2024-05-01',
                'tanggal_selesai' => '2024-05-05',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}