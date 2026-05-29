<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::with('creator')->latest()->paginate(10);
        return view('pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        return view('pengumuman.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'icon' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'icon' => $request->icon ?? '📢',
            'status' => $request->status,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $pengumuman = Pengumuman::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'icon' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $pengumuman->update($request->all());

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diupdate!');
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
    
    public function toggleStatus($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->status = $pengumuman->status == 'aktif' ? 'nonaktif' : 'aktif';
        $pengumuman->save();
        
        return redirect()->route('pengumuman.index')->with('success', 'Status pengumuman berhasil diubah!');
    }
}