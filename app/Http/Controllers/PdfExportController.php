<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\IuranWarga;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PdfExportController extends Controller
{
    public function keuangan()
    {
        $totalPemasukan = Kas::where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;
        $transaksi = Kas::with('user')->latest()->get();
        
        $pdf = Pdf::loadView('exports.keuangan-pdf', compact('totalPemasukan', 'totalPengeluaran', 'saldo', 'transaksi'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan_keuangan_' . date('Y-m-d') . '.pdf');
    }

    public function iuran()
    {
        $iuran = IuranWarga::with('user')->get();
        $totalLunas = IuranWarga::where('status', 'lunas')->sum('nominal');
        $totalBelum = IuranWarga::where('status', 'belum')->sum('nominal');
        
        $pdf = Pdf::loadView('exports.iuran-pdf', compact('iuran', 'totalLunas', 'totalBelum'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan_iuran_' . date('Y-m-d') . '.pdf');
    }

    public function kas()
    {
        $pemasukan = Kas::where('jenis', 'pemasukan')->sum('nominal');
        $pengeluaran = Kas::where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $pemasukan - $pengeluaran;
        $transaksi = Kas::with('user')->latest()->get();
        
        $pdf = Pdf::loadView('exports.kas-pdf', compact('pemasukan', 'pengeluaran', 'saldo', 'transaksi'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('buku_kas_' . date('Y-m-d') . '.pdf');
    }
}