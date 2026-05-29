<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function index()
    {
        // Buat folder jika belum ada
        $backupPath = storage_path('app/backups');
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }
        
        $backupFiles = File::files($backupPath);
        // Urutkan dari yang terbaru
        usort($backupFiles, function($a, $b) {
            return $b->getMTime() - $a->getMTime();
        });
        
        return view('backup.index', compact('backupFiles'));
    }

    public function backupDatabase()
    {
        // Buat folder jika belum ada
        $backupPath = storage_path('app/backups');
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }
        
        $databaseName = env('DB_DATABASE', 'desa_rafi');
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');
        $host = env('DB_HOST', '127.0.0.1');
        
        $backupFile = $backupPath . '/backup_' . date('Y-m-d_H-i-s') . '.sql';
        
        // Buat command mysqldump
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($databaseName),
            escapeshellarg($backupFile)
        );
        
        exec($command, $output, $returnVar);
        
        if ($returnVar === 0 && File::exists($backupFile)) {
            return redirect()->route('backup.index')->with('success', 'Backup database berhasil! File: ' . basename($backupFile));
        } else {
            return redirect()->route('backup.index')->with('error', 'Backup database gagal! Pastikan MySQL terinstall.');
        }
    }

    public function downloadBackup($filename)
    {
        $filePath = storage_path('app/backups/' . $filename);
        
        if (File::exists($filePath)) {
            return response()->download($filePath);
        }
        
        return redirect()->route('backup.index')->with('error', 'File tidak ditemukan!');
    }
    
    public function deleteBackup($filename)
    {
        $filePath = storage_path('app/backups/' . $filename);
        
        if (File::exists($filePath)) {
            File::delete($filePath);
            return redirect()->route('backup.index')->with('success', 'File backup berhasil dihapus!');
        }
        
        return redirect()->route('backup.index')->with('error', 'File tidak ditemukan!');
    }
}