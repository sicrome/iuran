<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\IuranWarga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // JIKA WARGA, TAMPILKAN DASHBOARD KHUSUS WARGA
        if ($user->isWarga()) {
            return $this->wargaDashboard($user);
        }
        
        // ========== DASHBOARD ADMIN & BENDAHARA ==========
        $totalPemasukan = Kas::where('jenis', 'pemasukan')->sum('nominal') ?? 0;
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('nominal') ?? 0;
        $saldo = $totalPemasukan - $totalPengeluaran;
        $totalWarga = User::where('role_id', 3)->count() ?? 0;
        
        $bulanIni = date('F Y');
        $totalTagihan = $totalWarga * 100000;
        $totalTerkumpul = IuranWarga::where('status', 'lunas')->sum('nominal') ?? 0;
        $persentase = $totalTagihan > 0 ? round(($totalTerkumpul / $totalTagihan) * 100) : 0;
        
        $belumLunas = IuranWarga::where('status', 'belum')->count();
        $menungguVerifikasi = IuranWarga::where('verifikasi_status', 'pending')->count();
        
        // Grafik
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
        $pemasukanData = [];
        $pengeluaranData = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulanKe = 5 - $i;
            $pemasukanData[$bulanKe] = Kas::where('jenis', 'pemasukan')
                ->whereMonth('tanggal', date('m', strtotime("-$i months")))
                ->whereYear('tanggal', date('Y', strtotime("-$i months")))
                ->sum('nominal') ?? 0;
            $pengeluaranData[$bulanKe] = Kas::where('jenis', 'pengeluaran')
                ->whereMonth('tanggal', date('m', strtotime("-$i months")))
                ->whereYear('tanggal', date('Y', strtotime("-$i months")))
                ->sum('nominal') ?? 0;
        }
        
        $kategoriPengeluaran = Kas::where('jenis', 'pengeluaran')
            ->select('keterangan', DB::raw('SUM(nominal) as total'))
            ->groupBy('keterangan')
            ->get();
        
        return view('dashboard', compact(
            'totalPemasukan', 'totalPengeluaran', 'saldo', 'totalWarga',
            'belumLunas', 'menungguVerifikasi', 'totalTagihan', 'totalTerkumpul', 'persentase',
            'bulanLabels', 'pemasukanData', 'pengeluaranData', 'kategoriPengeluaran'
        ));
    }
    
    // ========== DASHBOARD KHUSUS WARGA ==========
    private function wargaDashboard($user)
    {
        // Total sudah bayar
        $totalSudahBayar = IuranWarga::where('user_id', $user->id)
            ->where('status', 'lunas')
            ->sum('nominal') ?? 0;
        
        $totalTransaksiLunas = IuranWarga::where('user_id', $user->id)
            ->where('status', 'lunas')
            ->count();
        
        // Total belum bayar
        $totalBelumBayar = IuranWarga::where('user_id', $user->id)
            ->where('status', 'belum')
            ->sum('nominal') ?? 0;
        
        $totalTagihanBelum = IuranWarga::where('user_id', $user->id)
            ->where('status', 'belum')
            ->count();
        
        // Tagihan belum lunas
        $tagihanBelumLunas = IuranWarga::with('user')
            ->where('user_id', $user->id)
            ->where('status', 'belum')
            ->orderBy('bulan_tahun', 'asc')
            ->get();
        
        // Riwayat pembayaran (5 terbaru)
        $riwayatPembayaran = IuranWarga::with('user')
            ->where('user_id', $user->id)
            ->where('status', 'lunas')
            ->orderBy('tanggal_bayar', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard-warga', compact(
            'user',
            'totalSudahBayar',
            'totalTransaksiLunas',
            'totalBelumBayar',
            'totalTagihanBelum',
            'tagihanBelumLunas',
            'riwayatPembayaran'
        ));
    }
}