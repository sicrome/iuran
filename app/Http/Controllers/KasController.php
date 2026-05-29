<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isBendahara()) {
            $kas = Kas::with('user')->latest()->paginate(15);
        } else {
            $kas = Kas::with('user')->where('user_id', $user->id)->latest()->paginate(15);
        }
        
        return view('kas.index', compact('kas'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        $wargas = User::where('role_id', 3)->get();
        return view('kas.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        Kas::create($request->all());

        return redirect()->route('kas.index')->with('success', 'Data kas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        $kas = Kas::findOrFail($id);
        $wargas = User::where('role_id', 3)->get();
        return view('kas.edit', compact('kas', 'wargas'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        
        $kas = Kas::findOrFail($id);
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $kas->update($request->all());

        return redirect()->route('kas.index')->with('success', 'Data kas berhasil diupdate!');
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        $kas = Kas::findOrFail($id);
        $kas->delete();

        return redirect()->route('kas.index')->with('success', 'Data kas berhasil dihapus!');
    }
}