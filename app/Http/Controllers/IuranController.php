<?php

namespace App\Http\Controllers;

use App\Models\IuranWarga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IuranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isBendahara()) {
            $iuran = IuranWarga::with('user')->latest()->paginate(15);
        } else {
            $iuran = IuranWarga::with('user')->where('user_id', $user->id)->latest()->paginate(15);
        }
        
        $totalLunas = IuranWarga::where('status', 'lunas')->sum('nominal');
        $totalBelum = IuranWarga::where('status', 'belum')->sum('nominal');
        $pendingVerifikasi = IuranWarga::where('verifikasi_status', 'pending')->count();
        
        return view('iuran.index', compact('iuran', 'totalLunas', 'totalBelum', 'pendingVerifikasi'));
    }

    public function create()
    {
        $this->authorizeAccess();
        $wargas = User::where('role_id', 3)->get();
        return view('iuran.create', compact('wargas'));
    }

    // ========== LANGKAH 1: STORE METHOD (HARUS VERIFIKASI) ==========
    public function store(Request $request)
    {
        $this->authorizeAccess();
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'tahun' => 'required|string',
            'nominal' => 'required|numeric|min:0',
            'tanggal_bayar' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $bulan_tahun = $request->bulan . ' ' . $request->tahun;

        // Upload bukti jika ada
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_iuran', 'public');
        }

        // Status selalu "belum" sampai diverifikasi
        // Verifikasi status = "pending"
        IuranWarga::create([
            'user_id' => $request->user_id,
            'bulan_tahun' => $bulan_tahun,
            'nominal' => $request->nominal,
            'status' => 'belum',  // BELUM LUNAS sampai diverifikasi
            'verifikasi_status' => 'pending', // MENUNGGU VERIFIKASI
            'tanggal_bayar' => $request->tanggal_bayar,
            'keterangan' => $request->keterangan,
            'bukti_pembayaran' => $buktiPath,
        ]);

        return redirect()->route('iuran.index')
            ->with('success', 'Data iuran berhasil ditambahkan! Menunggu verifikasi admin.');
    }

    public function edit($id)
    {
        $this->authorizeAccess();
        $iuran = IuranWarga::findOrFail($id);
        $wargas = User::where('role_id', 3)->get();
        return view('iuran.edit', compact('iuran', 'wargas'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAccess();
        
        $iuran = IuranWarga::findOrFail($id);
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan_tahun' => 'required|string',
            'nominal' => 'required|numeric|min:0',
            'status' => 'required|in:lunas,belum',
            'tanggal_bayar' => 'nullable|date'
        ]);

        $iuran->update($request->all());

        return redirect()->route('iuran.index')
            ->with('success', 'Data iuran berhasil diupdate!');
    }

    // VERIFIKASI PEMBAYARAN
    public function verify($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        
        $iuran = IuranWarga::findOrFail($id);
        return view('iuran.verify', compact('iuran'));
    }

    public function processVerify(Request $request, $id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        
        $iuran = IuranWarga::findOrFail($id);
        
        $request->validate([
            'action' => 'required|in:terima,tolak',
            'alasan_tolak' => 'required_if:action,tolak|nullable|string'
        ]);
        
        if ($request->action == 'terima') {
            $iuran->update([
                'status' => 'lunas',
                'verifikasi_status' => 'diterima',
                'tanggal_verifikasi' => now(),
                'diverifikasi_oleh' => Auth::id()
            ]);
            $message = 'Pembayaran iuran diterima dan sudah lunas!';
        } else {
            $iuran->update([
                'verifikasi_status' => 'ditolak',
                'alasan_tolak' => $request->alasan_tolak,
                'tanggal_verifikasi' => now(),
                'diverifikasi_oleh' => Auth::id()
            ]);
            $message = 'Pembayaran iuran ditolak. Silakan hubungi admin.';
        }
        
        return redirect()->route('iuran.index')->with('success', $message);
    }

    public function destroy($id)
    {
        $this->authorizeAccess();
        $iuran = IuranWarga::findOrFail($id);
        
        if ($iuran->bukti_pembayaran) {
            Storage::disk('public')->delete($iuran->bukti_pembayaran);
        }
        
        $iuran->delete();

        return redirect()->route('iuran.index')
            ->with('success', 'Data iuran berhasil dihapus!');
    }

    private function authorizeAccess()
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isBendahara()) {
            abort(403, 'Hanya Admin dan Bendahara yang bisa mengakses!');
        }
    }
}