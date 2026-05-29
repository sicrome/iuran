<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemasukanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isBendahara()) {
            $pemasukan = Kas::with('user')->where('jenis', 'pemasukan')->latest()->paginate(15);
            $totalPemasukan = Kas::where('jenis', 'pemasukan')->sum('nominal');
        } else {
            // WARGA: hanya lihat data sendiri
            $pemasukan = Kas::with('user')->where('jenis', 'pemasukan')->where('user_id', $user->id)->latest()->paginate(15);
            $totalPemasukan = Kas::where('jenis', 'pemasukan')->where('user_id', $user->id)->sum('nominal');
        }
        
        return view('pemasukan.index', compact('pemasukan', 'totalPemasukan'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403, 'Hanya Admin dan Bendahara yang bisa menambah data!');
        }
        $wargas = User::where('role_id', 3)->get();
        return view('pemasukan.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
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
            'jenis' => 'pemasukan',
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        $pemasukan = Kas::findOrFail($id);
        $wargas = User::where('role_id', 3)->get();
        return view('pemasukan.edit', compact('pemasukan', 'wargas'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        
        $pemasukan = Kas::findOrFail($id);
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $pemasukan->update($request->all());

        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil diupdate!');
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        $pemasukan = Kas::findOrFail($id);
        $pemasukan->delete();

        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil dihapus!');
    }
}