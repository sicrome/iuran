<?php

namespace App\Http\Controllers;

use App\Models\PengurusRt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengurusRtController extends Controller
{
    // HAPUS constructor - tidak pakai middleware di Laravel 13

    public function index()
    {
        $this->authorizeAccess();
        $pengurus = PengurusRt::latest()->paginate(15);
        return view('pengurus.index', compact('pengurus'));
    }

    public function create()
    {
        $this->authorizeAccess();
        return view('pengurus.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAccess();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string',
            'no_telepon' => 'required|string',
            'alamat' => 'required|string',
            'masa_jabatan_mulai' => 'required|integer',
            'masa_jabatan_selesai' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        PengurusRt::create($request->all());

        return redirect()->route('pengurus.index')
            ->with('success', 'Pengurus RT berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $this->authorizeAccess();
        $pengurus = PengurusRt::findOrFail($id);
        return view('pengurus.edit', compact('pengurus'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAccess();
        
        $pengurus = PengurusRt::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string',
            'no_telepon' => 'required|string',
            'alamat' => 'required|string',
            'masa_jabatan_mulai' => 'required|integer',
            'masa_jabatan_selesai' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $pengurus->update($request->all());

        return redirect()->route('pengurus.index')
            ->with('success', 'Pengurus RT berhasil diupdate!');
    }

    public function destroy($id)
    {
        $this->authorizeAccess();
        $pengurus = PengurusRt::findOrFail($id);
        $pengurus->delete();

        return redirect()->route('pengurus.index')
            ->with('success', 'Pengurus RT berhasil dihapus!');
    }

    private function authorizeAccess()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Hanya Admin yang bisa mengakses!');
        }
    }
}