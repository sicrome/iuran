<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\PengurusRtController;
use App\Http\Controllers\DataRtController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\JenisIuranController;
use App\Http\Controllers\PdfExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// PEMASUKAN & PENGELUARAN
Route::resource('pemasukan', PemasukanController::class)->middleware('auth');
Route::resource('pengeluaran', PengeluaranController::class)->middleware('auth');

// MASTER DATA
Route::resource('warga', WargaController::class)->middleware('auth');
Route::resource('iuran', IuranController::class)->middleware('auth');
Route::resource('pengurus', PengurusRtController::class)->middleware('auth');
Route::resource('data-rt', DataRtController::class)->middleware('auth');

// LAPORAN
Route::get('/laporan/keuangan', [LaporanController::class, 'keuangan'])
    ->middleware('auth')->name('laporan.keuangan');
Route::get('/laporan/iuran', [LaporanController::class, 'iuran'])
    ->middleware('auth')->name('laporan.iuran');
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

// ============ PEMBAYARAN ONLINE ============
Route::resource('pembayaran', PembayaranController::class)->middleware('auth');
Route::get('/pembayaran/verify/{id}', [PembayaranController::class, 'verify'])->middleware('auth')->name('pembayaran.verify');
Route::post('/pembayaran/confirm/{id}', [PembayaranController::class, 'confirm'])->middleware('auth')->name('pembayaran.confirm');

// EXPORT EXCEL
Route::get('/export/keuangan', [ExportController::class, 'exportKeuangan'])->middleware('auth')->name('export.keuangan');
Route::get('/export/iuran', [ExportController::class, 'exportIuran'])->middleware('auth')->name('export.iuran');

// EXPORT PDF
Route::get('/export/pdf/keuangan', [PdfExportController::class, 'keuangan'])->middleware('auth')->name('export.pdf.keuangan');
Route::get('/export/pdf/iuran', [PdfExportController::class, 'iuran'])->middleware('auth')->name('export.pdf.iuran');
Route::get('/export/pdf/kas', [PdfExportController::class, 'kas'])->middleware('auth')->name('export.pdf.kas');

// JENIS IURAN
Route::resource('jenis-iuran', JenisIuranController::class)->middleware('auth');

// VERIFIKASI IURAN (dari IuranController)
Route::get('/iuran/verify/{id}', [IuranController::class, 'verify'])->middleware('auth')->name('iuran.verify');
Route::post('/iuran/process-verify/{id}', [IuranController::class, 'processVerify'])->middleware('auth')->name('iuran.processVerify');

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