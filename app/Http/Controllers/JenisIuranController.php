<?php

namespace App\Http\Controllers;

use App\Models\JenisIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisIuranController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        // Cek apakah data kosong, jika ya buat data default
        if (JenisIuran::count() == 0) {
            $defaultData = [
                ['nama' => 'Iuran Keamanan', 'icon' => '🛡️', 'nominal_default' => 15000, 'denda_per_hari' => 5000, 'batas_tanggal' => 15, 'status' => 'aktif'],
                ['nama' => 'Iuran Kebersihan', 'icon' => '🧹', 'nominal_default' => 50000, 'denda_per_hari' => 5000, 'batas_tanggal' => 20, 'status' => 'aktif'],
                ['nama' => 'Iuran Warga', 'icon' => '💰', 'nominal_default' => 100000, 'denda_per_hari' => 5000, 'batas_tanggal' => 25, 'status' => 'aktif'],
                ['nama' => 'Iuran Sosial', 'icon' => '🤝', 'nominal_default' => 20000, 'denda_per_hari' => 3000, 'batas_tanggal' => 25, 'status' => 'aktif'],
            ];
            
            foreach ($defaultData as $data) {
                JenisIuran::create($data);
            }
        }
        
        $jenisIuran = JenisIuran::latest()->paginate(10);
        return view('jenis-iuran.index', compact('jenisIuran'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        return view('jenis-iuran.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'nominal_default' => 'required|numeric|min:0',
            'denda_per_hari' => 'required|numeric|min:0',
            'batas_tanggal' => 'required|integer|between:1,31',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        JenisIuran::create($request->all());

        return redirect()->route('jenis-iuran.index')
            ->with('success', 'Jenis iuran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $jenisIuran = JenisIuran::findOrFail($id);
        return view('jenis-iuran.edit', compact('jenisIuran'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $jenisIuran = JenisIuran::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'nominal_default' => 'required|numeric|min:0',
            'denda_per_hari' => 'required|numeric|min:0',
            'batas_tanggal' => 'required|integer|between:1,31',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $jenisIuran->update($request->all());

        return redirect()->route('jenis-iuran.index')
            ->with('success', 'Jenis iuran berhasil diupdate!');
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $jenisIuran = JenisIuran::findOrFail($id);
        $jenisIuran->delete();

        return redirect()->route('jenis-iuran.index')
            ->with('success', 'Jenis iuran berhasil dihapus!');
    }
}