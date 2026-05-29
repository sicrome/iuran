<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\IuranWarga;
use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data dari IuranWarga (bukan Pembayaran)
        if ($user->isAdmin() || $user->isBendahara()) {
            $pembayaran = IuranWarga::with('user')
                ->whereIn('verifikasi_status', ['pending', 'diterima', 'ditolak'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $pembayaran = IuranWarga::with('user')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }
        
        $totalPending = IuranWarga::where('verifikasi_status', 'pending')->count();
        $totalDiterima = IuranWarga::where('verifikasi_status', 'diterima')->count();
        
        return view('pembayaran.index', compact('pembayaran', 'totalPending', 'totalDiterima'));
    }

    public function create()
    {
        return view('pembayaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan_tahun' => 'required|string',
            'jenis_iuran' => 'required|string',
            'nominal' => 'required|numeric|min:0',
            'metode' => 'nullable|string',
            'tanggal_bayar' => 'required|date',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        $path = $request->file('bukti_pembayaran')->store('bukti_iuran', 'public');

        // Simpan ke IuranWarga (bukan Pembayaran terpisah)
        IuranWarga::create([
            'user_id' => Auth::id(),
            'bulan_tahun' => $request->bulan_tahun,
            'nominal' => $request->nominal,
            'status' => 'belum',
            'verifikasi_status' => 'pending',
            'tanggal_bayar' => $request->tanggal_bayar,
            'keterangan' => $request->keterangan,
            'bukti_pembayaran' => $path,
        ]);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dikirim, menunggu konfirmasi admin!');
    }

    public function verify($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        
        $pembayaran = IuranWarga::findOrFail($id);
        return view('pembayaran.verify', compact('pembayaran'));
    }

    public function confirm(Request $request, $id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        
        $pembayaran = IuranWarga::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'alasan_tolak' => 'required_if:status,ditolak|nullable|string'
        ]);
        
        if ($request->status == 'diterima') {
            $pembayaran->update([
                'status' => 'lunas',
                'verifikasi_status' => 'diterima',
                'tanggal_verifikasi' => now(),
                'diverifikasi_oleh' => Auth::id()
            ]);
            
            // Tambahkan ke kas pemasukan
            Kas::create([
                'user_id' => $pembayaran->user_id,
                'bulan' => $pembayaran->bulan_tahun,
                'jenis' => 'pemasukan',
                'nominal' => $pembayaran->nominal,
                'tanggal' => now(),
                'keterangan' => 'Pembayaran iuran - ' . $pembayaran->bulan_tahun,
            ]);
            
            $message = 'Pembayaran diterima dan sudah lunas!';
        } else {
            $pembayaran->update([
                'verifikasi_status' => 'ditolak',
                'alasan_tolak' => $request->alasan_tolak,
                'tanggal_verifikasi' => now(),
                'diverifikasi_oleh' => Auth::id()
            ]);
            $message = 'Pembayaran ditolak!';
        }
        
        return redirect()->route('pembayaran.index')->with('success', $message);
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        
        $pembayaran = IuranWarga::findOrFail($id);
        
        if ($pembayaran->bukti_pembayaran) {
            Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
        }
        
        $pembayaran->delete();
        
        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran dihapus!');
    }
}