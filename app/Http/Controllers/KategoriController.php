<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Category::latest()->paginate(10);
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pemasukan,pengeluaran',
        ]);

        Category::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $kategori = Category::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $kategori = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pemasukan,pengeluaran',
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $kategori = Category::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}