<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isWarga()) {
            $wargas = User::with('role')->where('id', $user->id)->paginate(15);
        } else {
            $wargas = User::with('role')->paginate(15);
        }
        
        return view('warga.index', compact('wargas'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya Admin yang bisa menambah warga!');
        }
        $roles = Role::all();
        return view('warga.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'nik' => 'nullable|string|max:20|unique:users',
            'no_kk' => 'nullable|string|max:20',
            'nama_lengkap' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'no_hp' => 'nullable|string|max:15',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'agama' => 'nullable|string|max:20',
            'status_perkawinan' => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'nullable|string|max:100',
            'rt_rw' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'nama_lengkap' => $request->nama_lengkap,
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'status_perkawinan' => $request->status_perkawinan,
            'pekerjaan' => $request->pekerjaan,
            'rt_rw' => $request->rt_rw,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('warga.index')->with('success', 'Warga berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('warga.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $user = User::findOrFail($id);
        
        $request->validate([
            'nik' => 'nullable|string|max:20|unique:users,nik,' . $id,
            'no_kk' => 'nullable|string|max:20',
            'nama_lengkap' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_hp' => 'nullable|string|max:15',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'agama' => 'nullable|string|max:20',
            'status_perkawinan' => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'nullable|string|max:100',
            'rt_rw' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($request->except('password'));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diupdate!');
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $user = User::findOrFail($id);
        
        if ($user->id == Auth::id()) {
            return redirect()->route('warga.index')->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }
        
        $user->delete();
        
        return redirect()->route('warga.index')->with('success', 'Warga berhasil dihapus!');
    }
}