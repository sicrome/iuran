<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kas;
use App\Models\User;
use App\Models\IuranWarga;
use App\Models\Pengumuman;
use App\Models\JenisIuran;
use Illuminate\Support\Facades\Hash;

class FullDataSeeder extends Seeder
{
    public function run(): void
    {
        // ========== 1. BUAT USER ADMIN & BENDAHARA ==========
        User::updateOrCreate(
            ['email' => 'admin@kasrt.com'],
            ['name' => 'Admin Kas RT', 'password' => Hash::make('password'), 'role_id' => 1]
        );
        
        User::updateOrCreate(
            ['email' => 'bendahara@kasrt.com'],
            ['name' => 'Bendahara Kas RT', 'password' => Hash::make('password'), 'role_id' => 2]
        );
        
        // ========== 2. BUAT 10 WARGA ==========
        for ($i = 1; $i <= 10; $i++) {
            User::updateOrCreate(
                ['email' => "warga$i@kasrt.com"],
                ['name' => "Warga $i", 'password' => Hash::make('password'), 'role_id' => 3]
            );
        }
        
        $wargas = User::where('role_id', 3)->get();
        $firstWarga = $wargas->first();
        
        // ========== 3. HAPUS DATA LAMA ==========
        Kas::truncate();
        IuranWarga::truncate();
        
        // ========== 4. BUAT DATA PEMASUKAN (IURAN 6 BULAN TERAKHIR) ==========
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
        
        // ========== 6. BUAT DATA IURAN WARGA ==========
        foreach ($wargas as $warga) {
            foreach ($bulanList as $index => $bulan) {
                $status = ($index <= 3) ? 'lunas' : (rand(1, 100) <= 70 ? 'lunas' : 'belum');
                IuranWarga::create([
                    'user_id' => $warga->id,
                    'bulan_tahun' => $bulan . ' ' . $tahun,
                    'nominal' => 100000,
                    'status' => $status,
                    'verifikasi_status' => $status == 'lunas' ? 'diterima' : 'pending',
                    'tanggal_bayar' => $status == 'lunas' ? date("$tahun-" . ($index + 1) . "-" . rand(5, 25)) : null,
                ]);
            }
        }
        
        // ========== 7. BUAT JENIS IURAN ==========
        JenisIuran::truncate();
        $jenisIuran = [
            ['nama' => 'Iuran Warga', 'icon' => '💰', 'nominal_default' => 100000, 'denda_per_hari' => 5000, 'batas_tanggal' => 25, 'status' => 'aktif'],
            ['nama' => 'Iuran Kebersihan', 'icon' => '🧹', 'nominal_default' => 50000, 'denda_per_hari' => 3000, 'batas_tanggal' => 20, 'status' => 'aktif'],
            ['nama' => 'Iuran Keamanan', 'icon' => '🛡️', 'nominal_default' => 30000, 'denda_per_hari' => 3000, 'batas_tanggal' => 20, 'status' => 'aktif'],
        ];
        foreach ($jenisIuran as $item) {
            JenisIuran::create($item);
        }
        
        $this->command->info('FullDataSeeder selesai!');
        $this->command->info('- Total Pemasukan: ' . Kas::where('jenis', 'pemasukan')->sum('nominal'));
        $this->command->info('- Total Pengeluaran: ' . Kas::where('jenis', 'pengeluaran')->sum('nominal'));
        $this->command->info('- Total Warga: ' . User::where('role_id', 3)->count());
    }
}