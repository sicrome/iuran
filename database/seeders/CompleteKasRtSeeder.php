<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kas;
use App\Models\User;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use App\Models\Pengumuman;
use App\Models\DataRt;
use App\Models\PengurusRt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CompleteKasRtSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Memulai CompleteKasRtSeeder...');
        
        // ========== 1. BUAT ROLES ==========
        $this->command->info('Membuat roles...');
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin', 'display_name' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'bendahara', 'display_name' => 'Bendahara', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'warga', 'display_name' => 'Warga', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // ========== 2. BUAT USER ADMIN & BENDAHARA ==========
        $this->command->info('Membuat user admin dan bendahara...');
        User::updateOrCreate(
            ['email' => 'admin@kasrt.com'],
            ['name' => 'Admin Kas RT', 'password' => Hash::make('password'), 'role_id' => 1]
        );
        User::updateOrCreate(
            ['email' => 'bendahara@kasrt.com'],
            ['name' => 'Bendahara Kas RT', 'password' => Hash::make('password'), 'role_id' => 2]
        );
        
        // ========== 3. DATA RT ==========
        $this->command->info('Membuat data RT...');
        DataRt::updateOrCreate(
            ['id' => 1],
            [
                'nama_rt' => 'RT 01 RW 05',
                'kode_pos' => '12345',
                'kelurahan' => 'Sukamaju',
                'kecamatan' => 'Cilandak',
                'kabupaten' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'alamat_lengkap' => 'Jl. Mawar Indah No. 10, RT 01 RW 05, Jakarta Selatan',
                'email' => 'rt01@kasrt.com',
                'no_telepon' => '081234567890',
            ]
        );
        
        // ========== 4. PENGURUS RT ==========
        $this->command->info('Membuat pengurus RT...');
        PengurusRt::truncate();
        $pengurus = [
            ['nama' => 'Slamet Riyadi', 'jabatan' => 'Ketua RT', 'no_telepon' => '081234567891', 'alamat' => 'Jl. Mawar No. 1', 'masa_jabatan_mulai' => 2022, 'masa_jabatan_selesai' => 2026, 'status' => 'aktif'],
            ['nama' => 'Sri Mulyani', 'jabatan' => 'Sekretaris', 'no_telepon' => '081234567892', 'alamat' => 'Jl. Mawar No. 5', 'masa_jabatan_mulai' => 2022, 'masa_jabatan_selesai' => 2026, 'status' => 'aktif'],
            ['nama' => 'Ahmad Subagyo', 'jabatan' => 'Bendahara', 'no_telepon' => '081234567893', 'alamat' => 'Jl. Melati No. 3', 'masa_jabatan_mulai' => 2022, 'masa_jabatan_selesai' => 2026, 'status' => 'aktif'],
            ['nama' => 'Rina Wati', 'jabatan' => 'Seksi Kebersihan', 'no_telepon' => '081234567894', 'alamat' => 'Jl. Kenanga No. 2', 'masa_jabatan_mulai' => 2023, 'masa_jabatan_selesai' => 2027, 'status' => 'aktif'],
            ['nama' => 'Joko Susilo', 'jabatan' => 'Seksi Keamanan', 'no_telepon' => '081234567895', 'alamat' => 'Jl. Anggrek No. 4', 'masa_jabatan_mulai' => 2023, 'masa_jabatan_selesai' => 2027, 'status' => 'aktif'],
        ];
        foreach ($pengurus as $p) {
            PengurusRt::create($p);
        }
        
        // ========== 5. BUAT 102 WARGA ==========
$this->command->info('Membuat 102 warga...');
User::where('role_id', 3)->delete();

$namaDepan = ['Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Guntur', 'Hana', 'Irfan', 'Jihan', 'Kiki', 'Lina', 'Maman', 'Nina', 'Oki', 'Putri', 'Qori', 'Rina', 'Siti', 'Tono', 'Umi', 'Vina', 'Wawan', 'Xena', 'Yudi', 'Zaki'];
$namaBelakang = ['Santoso', 'Wijaya', 'Kusuma', 'Pratiwi', 'Hidayat', 'Ningsih', 'Ramadhan', 'Fitriani', 'Hakim', 'Sari', 'Maulana', 'Aminah', 'Prabowo', 'Utami', 'Nugroho'];

for ($i = 1; $i <= 102; $i++) {
    $nama = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
    $nik = '32' . rand(100000000000, 999999999999);
    $noHp = '0812' . rand(10000000, 99999999);
    $jenisKelamin = $i % 2 == 0 ? 'Perempuan' : 'Laki-laki';
    $rt = rand(1, 15);
    $rw = rand(1, 5);
    $rtRw = str_pad($rt, 2, '0', STR_PAD_LEFT) . '/' . str_pad($rw, 2, '0', STR_PAD_LEFT);
    
    User::create([
        'name' => $nama,
        'email' => 'warga' . $i . '@kasrt.com',
        'password' => Hash::make('password'),
        'role_id' => 3,
        'nik' => $nik,
        'no_hp' => $noHp,
        'jenis_kelamin' => $jenisKelamin,
        'rt_rw' => $rtRw,
        'no_kk' => 'KK-' . str_pad($i, 5, '0', STR_PAD_LEFT),
        'no_rumah' => 'No. ' . $i,
        'status' => 'aktif',
    ]);
}
        
        $wargas = User::where('role_id', 3)->get();
        $firstWarga = $wargas->first();
        
        // ========== 6. HAPUS DATA LAMA ==========
        Kas::truncate();
        IuranWarga::truncate();
        
        // ========== 7. BUAT DATA PEMASUKAN ==========
        $this->command->info('Membuat data pemasukan...');
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahun = date('Y');
        
        foreach ($wargas as $warga) {
            for ($bulanKe = 1; $bulanKe <= 12; $bulanKe++) {
                Kas::create([
                    'user_id' => $warga->id,
                    'bulan' => $bulanList[$bulanKe - 1] . ' ' . $tahun,
                    'jenis' => 'pemasukan',
                    'nominal' => 100000,
                    'tanggal' => date("$tahun-$bulanKe-15"),
                    'keterangan' => 'Iuran bulan ' . $bulanList[$bulanKe - 1],
                ]);
            }
        }
        
        // ========== 8. BUAT DATA PENGELUARAN ==========
        $this->command->info('Membuat data pengeluaran...');
        $pengeluaranData = [
            ['bulan' => 'Januari', 'kategori' => 'Kegiatan Rutin', 'nominal' => 250000],
            ['bulan' => 'Februari', 'kategori' => 'Kebersihan', 'nominal' => 150000],
            ['bulan' => 'Maret', 'kategori' => 'Perawatan', 'nominal' => 200000],
            ['bulan' => 'April', 'kategori' => 'Keamanan', 'nominal' => 100000],
            ['bulan' => 'Mei', 'kategori' => 'Kegiatan Rutin', 'nominal' => 300000],
            ['bulan' => 'Juni', 'kategori' => 'Kebersihan', 'nominal' => 120000],
            ['bulan' => 'Juli', 'kategori' => 'Kegiatan Rutin', 'nominal' => 280000],
            ['bulan' => 'Agustus', 'kategori' => 'Perawatan', 'nominal' => 180000],
            ['bulan' => 'September', 'kategori' => 'Keamanan', 'nominal' => 130000],
            ['bulan' => 'Oktober', 'kategori' => 'Kegiatan Rutin', 'nominal' => 320000],
            ['bulan' => 'November', 'kategori' => 'Kebersihan', 'nominal' => 140000],
            ['bulan' => 'Desember', 'kategori' => 'Kegiatan Rutin', 'nominal' => 400000],
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
        
        // ========== 9. BUAT DATA IURAN WARGA ==========
        $this->command->info('Membuat data iuran warga...');
        foreach ($wargas as $warga) {
            for ($bulanKe = 1; $bulanKe <= 12; $bulanKe++) {
                $bulan = $bulanList[$bulanKe - 1];
                $status = rand(1, 100) <= 80 ? 'lunas' : 'belum';
                IuranWarga::create([
                    'user_id' => $warga->id,
                    'bulan_tahun' => $bulan . ' ' . $tahun,
                    'nominal' => 100000,
                    'status' => $status,
                    'verifikasi_status' => $status == 'lunas' ? 'diterima' : 'pending',
                    'tanggal_bayar' => $status == 'lunas' ? date("$tahun-$bulanKe-15") : null,
                ]);
            }
        }
        
        // ========== 10. BUAT JENIS IURAN ==========
        $this->command->info('Membuat jenis iuran...');
        JenisIuran::truncate();
        $jenisIuran = [
            ['nama' => 'Iuran Warga', 'icon' => '💰', 'nominal_default' => 100000, 'denda_per_hari' => 5000, 'batas_tanggal' => 25, 'status' => 'aktif'],
            ['nama' => 'Iuran Kebersihan', 'icon' => '🧹', 'nominal_default' => 50000, 'denda_per_hari' => 3000, 'batas_tanggal' => 20, 'status' => 'aktif'],
            ['nama' => 'Iuran Keamanan', 'icon' => '🛡️', 'nominal_default' => 30000, 'denda_per_hari' => 3000, 'batas_tanggal' => 20, 'status' => 'aktif'],
        ];
        foreach ($jenisIuran as $item) {
            JenisIuran::create($item);
        }
        
        // ========== 11. BUAT PENGUMUMAN (setelah user admin ada) ==========
        $this->command->info('Membuat pengumuman...');
        $admin = User::where('email', 'admin@kasrt.com')->first();
        Pengumuman::truncate();
        $pengumuman = [
            ['judul' => 'Kerja Bakti Lingkungan', 'isi' => 'Akan dilaksanakan kerja bakti pada Minggu, 12 Mei 2024', 'status' => 'aktif'],
            ['judul' => 'Pembayaran Iuran', 'isi' => 'Batas pembayaran iuran tanggal 25 setiap bulan', 'status' => 'aktif'],
            ['judul' => 'Rapat RT', 'isi' => 'Rapat rutin pengurus RT Sabtu, 1 Juni 2024', 'status' => 'aktif'],
        ];
        foreach ($pengumuman as $p) {
            Pengumuman::create([
                'judul' => $p['judul'],
                'isi' => $p['isi'],
                'status' => $p['status'],
                'created_by' => $admin->id,
            ]);
        }
        
        $totalPemasukan = Kas::where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('nominal');
        
        $this->command->info('========================================');
        $this->command->info('CompleteKasRtSeeder SELESAI!');
        $this->command->info('Total Warga: ' . User::where('role_id', 3)->count());
        $this->command->info('Total Pemasukan: Rp ' . number_format($totalPemasukan, 0, ',', '.'));
        $this->command->info('Total Pengeluaran: Rp ' . number_format($totalPengeluaran, 0, ',', '.'));
        $this->command->info('Saldo Kas: Rp ' . number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.'));
    }
}