// ========== 6. PENGUMUMAN ==========
Pengumuman::truncate();

$pengumumanData = [
    ['judul' => 'Kerja Bakti Lingkungan', 'isi' => 'Akan dilaksanakan kerja bakti lingkungan pada hari Minggu, 12 Mei 2024 pukul 07.00 WIB. Mohon partisipasi seluruh warga.', 'icon' => '🌿', 'status' => 'aktif'],
    ['judul' => 'Pembayaran Iuran Juni 2024', 'isi' => 'Pembayaran Iuran RT bulan Juni 2024 sudah dibuka. Batas pembayaran tanggal 25 Juni 2024.', 'icon' => '💰', 'status' => 'aktif'],
    ['judul' => 'Rapat Pengurus RT', 'isi' => 'Rapat rutin pengurus RT akan dilaksanakan pada hari Sabtu, 1 Juni 2024 pukul 19.30 WIB di Pos RT.', 'icon' => '📢', 'status' => 'aktif'],
    ['judul' => 'Peringatan HUT RI', 'isi' => 'Akan diadakan lomba dalam rangka HUT RI ke-79. Pendaftaran dibuka sampai 10 Agustus 2024.', 'icon' => '🎉', 'status' => 'aktif'],
    ['judul' => 'Pengumuman Penting', 'isi' => 'Jadwal pemeliharaan listrik akan dilakukan pada tanggal 15 Juni 2024 pukul 09.00-12.00 WIB.', 'icon' => '⚠️', 'status' => 'aktif'],
];

foreach ($pengumumanData as $p) {
    Pengumuman::create([
        'judul' => $p['judul'],
        'isi' => $p['isi'],
        'icon' => $p['icon'],
        'status' => $p['status'],
        'created_by' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}