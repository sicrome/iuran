<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\PengurusRtController;
use App\Http\Controllers\DataRtController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\ProgramDesaController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\BankSampahController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\SuratMenyuratController;
use App\Http\Controllers\RondaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\KwitansiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
Route::get('/layanan', [DashboardController::class, 'layanan'])
    ->middleware(['auth'])
    ->name('layanan');

// PEMASUKAN & PENGELUARAN
Route::resource('pemasukan', PemasukanController::class)->middleware('auth');
Route::resource('pengeluaran', PengeluaranController::class)->middleware('auth');
Route::resource('program-desa/kas', KasController::class)->middleware('auth')->names('kas');
Route::get('kas/{kas}/kwitansi', [KwitansiController::class, 'cetak'])->middleware('auth')->name('kwitansi.cetak');
Route::get('/iuran', [IuranController::class, 'index'])->middleware('auth')->name('iuran.index');
Route::get('/iuran/buat', [IuranController::class, 'create'])->middleware('auth')->name('iuran.create');
Route::post('/iuran', [IuranController::class, 'store'])->middleware('auth')->name('iuran.store');
Route::post('/iuran/generate', [IuranController::class, 'generate'])->middleware('auth')->name('iuran.generate');
Route::get('/iuran/{iuran}/bayar', [IuranController::class, 'bayar'])->middleware('auth')->name('iuran.bayar');
Route::post('/iuran/{iuran}/bayar', [IuranController::class, 'kirimPembayaran'])->middleware('auth')->name('iuran.kirim-pembayaran');
Route::get('/validasi-transfer', [PembayaranController::class, 'index'])->middleware('auth')->name('pembayaran.index');
Route::post('/validasi-transfer/{pembayaran}/terima', [PembayaranController::class, 'terima'])->middleware('auth')->name('pembayaran.terima');
Route::post('/validasi-transfer/{pembayaran}/tolak', [PembayaranController::class, 'tolak'])->middleware('auth')->name('pembayaran.tolak');

// MASTER DATA
Route::resource('warga', WargaController::class)->middleware('auth');
Route::resource('pengurus', PengurusRtController::class)->middleware('auth');
Route::resource('data-rt', DataRtController::class)->middleware('auth');

// LAPORAN
Route::get('/laporan/kas', [LaporanController::class, 'kas'])
    ->middleware('auth')->name('laporan.kas');

// BACKUP DATA
Route::get('/backup', [BackupController::class, 'index'])->middleware('auth')->name('backup.index');
Route::post('/backup/database', [BackupController::class, 'backupDatabase'])->middleware('auth')->name('backup.database');
Route::get('/backup/download/{filename}', [BackupController::class, 'downloadBackup'])->middleware('auth')->name('backup.download');
Route::get('/backup/delete/{filename}', [BackupController::class, 'deleteBackup'])->middleware('auth')->name('backup.delete');

// KATEGORI
Route::resource('kategori', KategoriController::class)->middleware('auth');

// PENGUMUMAN
Route::resource('pengumuman', PengumumanController::class)->middleware('auth');
Route::get('/pengumuman/toggle/{id}', [PengumumanController::class, 'toggleStatus'])->middleware('auth')->name('pengumuman.toggle');

// PROGRAM DESA
Route::middleware('auth')->prefix('program-desa')->group(function () {
    Route::get('/', [ProgramDesaController::class, 'index'])->name('program-desa.index');
    // URL kompatibilitas untuk formulir Bank Sampah versi awal.
    Route::post('/bank-sampah', [BankSampahController::class, 'store'])->name('program-desa.bank-sampah.store');
    Route::match(['GET', 'POST'], '/{slug}', [ProgramDesaController::class, 'show'])->name('program-desa.show');
});

// PROGRAM DESA MODULES (Full CRUD)
Route::resource('bank-sampah', BankSampahController::class)->middleware('auth');
// Tarik dana (penarikan) untuk nasabah bank sampah
Route::post('bank-sampah/{bank_sampah}/tarik', [BankSampahController::class, 'tarik'])->middleware('auth')->name('bank-sampah.tarik');
// Riwayat penarikan (global) + export
Route::get('bank-sampah-withdrawals', [BankSampahController::class, 'withdrawalsIndex'])->middleware('auth')->name('bank-sampah.withdrawals.index');
Route::get('bank-sampah-withdrawals/export', [BankSampahController::class, 'exportWithdrawals'])->middleware('auth')->name('bank-sampah.withdrawals.export');
Route::resource('umkm', UmkmController::class)->middleware('auth');
Route::resource('surat-menyurat', SuratMenyuratController::class)->middleware('auth');
Route::resource('ronda', RondaController::class)->middleware('auth');
Route::resource('kegiatan', KegiatanController::class)->middleware('auth');
Route::resource('aspirasi', AspirasiController::class)->middleware('auth');

// POSYANDU
Route::middleware('auth')->prefix('posyandu')->name('posyandu.')->group(function () {
    Route::get('/peserta', [PosyanduController::class, 'pesertaIndex'])->name('peserta.index');
    Route::get('/peserta/create', [PosyanduController::class, 'pesertaCreate'])->name('peserta.create');
    Route::post('/peserta', [PosyanduController::class, 'pesertaStore'])->name('peserta.store');
    Route::get('/peserta/{peserta}', [PosyanduController::class, 'pesertaShow'])->name('peserta.show');
    Route::get('/peserta/{peserta}/edit', [PosyanduController::class, 'pesertaEdit'])->name('peserta.edit');
    Route::put('/peserta/{peserta}', [PosyanduController::class, 'pesertaUpdate'])->name('peserta.update');
    Route::delete('/peserta/{peserta}', [PosyanduController::class, 'pesertaDestroy'])->name('peserta.destroy');

    Route::get('/jadwal', [PosyanduController::class, 'jadwalIndex'])->name('jadwal.index');
    Route::get('/jadwal/create', [PosyanduController::class, 'jadwalCreate'])->name('jadwal.create');
    Route::post('/jadwal', [PosyanduController::class, 'jadwalStore'])->name('jadwal.store');
    Route::get('/jadwal/{jadwal}/edit', [PosyanduController::class, 'jadwalEdit'])->name('jadwal.edit');
    Route::put('/jadwal/{jadwal}', [PosyanduController::class, 'jadwalUpdate'])->name('jadwal.update');
    Route::delete('/jadwal/{jadwal}', [PosyanduController::class, 'jadwalDestroy'])->name('jadwal.destroy');

    Route::get('/pemeriksaan', [PosyanduController::class, 'pemeriksaanIndex'])->name('pemeriksaan.index');
    Route::get('/pemeriksaan/create', [PosyanduController::class, 'pemeriksaanCreate'])->name('pemeriksaan.create');
    Route::post('/pemeriksaan', [PosyanduController::class, 'pemeriksaanStore'])->name('pemeriksaan.store');
    Route::get('/pemeriksaan/{pemeriksaan}', [PosyanduController::class, 'pemeriksaanShow'])->name('pemeriksaan.show');
    Route::delete('/pemeriksaan/{pemeriksaan}', [PosyanduController::class, 'pemeriksaanDestroy'])->name('pemeriksaan.destroy');

    Route::get('/imunisasi', [PosyanduController::class, 'imunisasiIndex'])->name('imunisasi.index');
    Route::get('/imunisasi/create', [PosyanduController::class, 'imunisasiCreate'])->name('imunisasi.create');
    Route::post('/imunisasi', [PosyanduController::class, 'imunisasiStore'])->name('imunisasi.store');
    Route::delete('/imunisasi/{imunisasi}', [PosyanduController::class, 'imunisasiDestroy'])->name('imunisasi.destroy');

    Route::get('/laporan', [PosyanduController::class, 'laporan'])->name('laporan');
});

// REDIRECT
Route::get('/transfer', function () {
    return redirect()->route('pemasukan.index');
})->middleware('auth')->name('transfer.index');

// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
