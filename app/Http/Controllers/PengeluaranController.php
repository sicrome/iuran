<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isBendahara()) {
            $pengeluaran = Kas::with('user')
                ->where('jenis', 'pengeluaran')
                ->latest()
                ->paginate(15);
        } else {
            // WARGA: hanya bisa melihat data sendiri
            $pengeluaran = Kas::with('user')
                ->where('jenis', 'pengeluaran')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);
        }
        
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('nominal');
        
        return view('pengeluaran.index', compact('pengeluaran', 'totalPengeluaran'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403, 'Hanya Admin dan Bendahara yang bisa menambah data!');
        }
        $wargas = User::where('role_id', 3)->get();
        return view('pengeluaran.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403, 'Hanya Admin dan Bendahara yang bisa menambah data!');
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        Kas::create([
            'user_id' => $request->user_id,
            'bulan' => $request->bulan,
            'jenis' => 'pengeluaran',
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403, 'Hanya Admin dan Bendahara yang bisa mengedit data!');
        }
        $pengeluaran = Kas::findOrFail($id);
        $wargas = User::where('role_id', 3)->get();
        return view('pengeluaran.edit', compact('pengeluaran', 'wargas'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403, 'Hanya Admin dan Bendahara yang bisa mengupdate data!');
        }
        
        $pengeluaran = Kas::findOrFail($id);
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $pengeluaran->update([
            'user_id' => $request->user_id,
            'bulan' => $request->bulan,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil diupdate!');
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403, 'Hanya Admin dan Bendahara yang bisa menghapus data!');
        }
        $pengeluaran = Kas::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil dihapus!');
    }
}