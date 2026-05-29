<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\IuranWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function exportKeuangan()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan_keuangan_' . date('Y-m-d') . '.csv"',
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Nama', 'Jenis', 'Nominal', 'Keterangan']);
            
            $transaksi = Kas::with('user')->get();
            foreach ($transaksi as $item) {
                fputcsv($file, [
                    $item->tanggal,
                    $item->user->name,
                    $item->jenis,
                    $item->nominal,
                    $item->keterangan
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportIuran()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan_iuran_' . date('Y-m-d') . '.csv"',
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Warga', 'Bulan/Tahun', 'Nominal', 'Status', 'Tanggal Bayar']);
            
            $iuran = IuranWarga::with('user')->get();
            foreach ($iuran as $item) {
                fputcsv($file, [
                    $item->user->name,
                    $item->bulan_tahun,
                    $item->nominal,
                    $item->status,
                    $item->tanggal_bayar
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}