<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\IuranWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function keuangan()
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isBendahara()) {
            $totalPemasukan = Kas::where('jenis', 'pemasukan')->sum('nominal');
            $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('nominal');
            $transaksi = Kas::with('user')->latest()->paginate(20);
        } else {
            // WARGA: hanya lihat data sendiri
            $totalPemasukan = Kas::where('jenis', 'pemasukan')->where('user_id', $user->id)->sum('nominal');
            $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->where('user_id', $user->id)->sum('nominal');
            $transaksi = Kas::with('user')->where('user_id', $user->id)->latest()->paginate(20);
        }
        
        $saldo = $totalPemasukan - $totalPengeluaran;
        
        return view('laporan.keuangan', compact('totalPemasukan', 'totalPengeluaran', 'saldo', 'transaksi'));
    }

    public function iuran()
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isBendahara()) {
            $iuran = IuranWarga::with('user')->latest()->paginate(20);
            $totalLunas = IuranWarga::where('status', 'lunas')->sum('nominal');
            $totalBelum = IuranWarga::where('status', 'belum')->sum('nominal');
        } else {
            // WARGA: hanya lihat iuran sendiri
            $iuran = IuranWarga::with('user')->where('user_id', $user->id)->latest()->paginate(20);
            $totalLunas = IuranWarga::where('user_id', $user->id)->where('status', 'lunas')->sum('nominal');
            $totalBelum = IuranWarga::where('user_id', $user->id)->where('status', 'belum')->sum('nominal');
        }
        
        return view('laporan.iuran', compact('iuran', 'totalLunas', 'totalBelum'));
    }

    public function kas()
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isBendahara()) {
            $pemasukan = Kas::where('jenis', 'pemasukan')->sum('nominal');
            $pengeluaran = Kas::where('jenis', 'pengeluaran')->sum('nominal');
            $transaksi = Kas::with('user')->latest()->paginate(15);
        } else {
            // WARGA: hanya lihat data sendiri
            $pemasukan = Kas::where('jenis', 'pemasukan')->where('user_id', $user->id)->sum('nominal');
            $pengeluaran = Kas::where('jenis', 'pengeluaran')->where('user_id', $user->id)->sum('nominal');
            $transaksi = Kas::with('user')->where('user_id', $user->id)->latest()->paginate(15);
        }
        
        $saldo = $pemasukan - $pengeluaran;
        
        return view('laporan.kas', compact('pemasukan', 'pengeluaran', 'saldo', 'transaksi'));
    }

    public function export()
    {
        return view('laporan.export');
    }
}