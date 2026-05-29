<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kas;
use App\Models\User;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Memulai InitialDataSeeder...');

        // ========== 1. HAPUS DATA LAMA ==========
        Kas::truncate();
        Pengumuman::truncate();

        // ========== 2. PASTIKAN USER ADMIN ADA ==========
        $admin = User::where('role_id', 1)->first();
        if (!$admin) {
            $this->command->info('Membuat user admin...');
            $admin = User::create([
                'name' => 'Admin Kas RT',
                'email' => 'admin@kasrt.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
            ]);
        }

        // ========== 3. AMBIL ATAU BUAT USER WARGA ==========
        $wargas = User::where('role_id', 3)->get();
        if ($wargas->isEmpty()) {
            $this->command->info('Membuat 10 warga...');
            for ($i = 1; $i <= 10; $i++) {
                User::create([
                    'name' => 'Warga ' . $i,
                    'email' => 'warga' . $i . '@kasrt.com',
                    'password' => Hash::make('password'),
                    'role_id' => 3,
                ]);
            }
            $wargas = User::where('role_id', 3)->get();
        }

        // ========== 4. BUAT DATA PEMASUKAN (6 BULAN) ==========
        $this->command->info('Membuat data pemasukan...');
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
        $tahun = date('Y');

        foreach ($wargas as $warga) {
            foreach ($bulanList as $index => $bulan) {
                Kas::create([
                    'user_id' => $warga->id,
                    'bulan' => $bulan . ' ' . $tahun,
                    'jenis' => 'pemasukan',
                    'nominal' => 100000,
                    'tanggal' => date("$tahun-" . ($index + 1) . "-15"),
                    'keterangan' => 'Iuran bulan ' . $bulan,
                ]);
            }
        }

        // ========== 5. BUAT DATA PENGELUARAN ==========
        $this->command->info('Membuat data pengeluaran...');
        $firstWarga = $wargas->first();
        $pengeluaranData = [
            ['bulan' => 'Januari', 'kategori' => 'Kegiatan Rutin', 'nominal' => 250000],
            ['bulan' => 'Februari', 'kategori' => 'Kebersihan', 'nominal' => 150000],
            ['bulan' => 'Maret', 'kategori' => 'Perawatan', 'nominal' => 200000],
            ['bulan' => 'April', 'kategori' => 'Keamanan', 'nominal' => 100000],
            ['bulan' => 'Mei', 'kategori' => 'Kegiatan Rutin', 'nominal' => 300000],
            ['bulan' => 'Juni', 'kategori' => 'Kebersihan', 'nominal' => 120000],
        ];

        foreach ($pengeluaranData as $item) {
            Kas::create([
                'user_id' => $firstWarga->id,
                'bulan' => $item['bulan'] . ' ' . $tahun,
                'jenis' => 'pengeluaran',
                'nominal' => $item['nominal'],
                'tanggal' => date("$tahun-" . (array_search($item['bulan'], $bulanList) + 1) . "-20"),
                'keterangan' => $item['kategori'],
            ]);
        }

        // ========== 6. BUAT PENGUMUMAN ==========
        $this->command->info('Membuat pengumuman...');
        
        $pengumumanData = [
            [
                'judul' => 'Kerja Bakti Lingkungan',
                'isi' => 'Akan dilaksanakan kerja bakti lingkungan pada hari Minggu, 12 Mei 2024 pukul 07.00 WIB. Mohon partisipasi seluruh warga.',
                'status' => 'aktif',
            ],
            [
                'judul' => 'Pembayaran Iuran Juni 2024',
                'isi' => 'Pembayaran Iuran RT bulan Juni 2024 sudah dibuka. Batas pembayaran tanggal 25 Juni 2024.',
                'status' => 'aktif',
            ],
            [
                'judul' => 'Rapat Pengurus RT',
                'isi' => 'Rapat rutin pengurus RT akan dilaksanakan pada hari Sabtu, 1 Juni 2024 pukul 19.30 WIB di Pos RT.',
                'status' => 'aktif',
            ],
        ];

        foreach ($pengumumanData as $p) {
            Pengumuman::create([
                'judul' => $p['judul'],
                'isi' => $p['isi'],
                'status' => $p['status'],
                'created_by' => $admin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('InitialDataSeeder Selesai!');
        $this->command->info('- Pemasukan: ' . (count($wargas) * 6) . ' transaksi');
        $this->command->info('- Pengeluaran: ' . count($pengeluaranData) . ' transaksi');
        $this->command->info('- Pengumuman: ' . count($pengumumanData) . ' pengumuman');
    }
}