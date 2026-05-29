<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kas;
use App\Models\User;
use App\Models\IuranWarga;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        $wargas = User::where('role_id', 3)->get();
        $firstWarga = $wargas->first();
        
        Kas::truncate();
        IuranWarga::truncate();
        
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
        $tahun = date('Y');
        
        // Pemasukan
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
        
        // Pengeluaran
        $pengeluaran = [
            ['bulan' => 'Januari', 'nominal' => 250000, 'keterangan' => 'Kegiatan Rutin'],
            ['bulan' => 'Februari', 'nominal' => 150000, 'keterangan' => 'Kebersihan'],
            ['bulan' => 'Maret', 'nominal' => 200000, 'keterangan' => 'Perawatan'],
            ['bulan' => 'April', 'nominal' => 100000, 'keterangan' => 'Keamanan'],
            ['bulan' => 'Mei', 'nominal' => 300000, 'keterangan' => 'Kegiatan Rutin'],
        ];
        
        foreach ($pengeluaran as $item) {
            Kas::create([
                'user_id' => $firstWarga->id,
                'bulan' => $item['bulan'] . ' ' . $tahun,
                'jenis' => 'pengeluaran',
                'nominal' => $item['nominal'],
                'tanggal' => date("$tahun-" . (array_search($item['bulan'], $bulanList) + 1) . "-20"),
                'keterangan' => $item['keterangan'],
            ]);
        }
    }
}