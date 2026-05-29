<?php

namespace App\Http\Controllers;

use App\Models\DataRt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataRtController extends Controller
{
    public function index()
    {
        $this->authorizeAccess();
        $dataRt = DataRt::first();
        
        if (!$dataRt) {
            // Buat data default dengan SEMUA field terisi
            $dataRt = DataRt::create([
                'nama_rt' => 'RT 01 RW 05',
                'kode_pos' => '12345',
                'kelurahan' => 'Sukamaju',
                'kecamatan' => 'Cilandak',
                'kabupaten' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'alamat_lengkap' => 'Jl. Mawar Indah No. 10, RT 01 RW 05',
                'email' => 'rt01@example.com',
                'no_telepon' => '081234567890',
            ]);
        }
        
        return view('data-rt.index', compact('dataRt'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAccess();
        
        $dataRt = DataRt::findOrFail($id);
        
        $request->validate([
            'nama_rt' => 'required|string',
            'kode_pos' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kabupaten' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'alamat_lengkap' => 'required|string',
            'email' => 'nullable|email',
            'no_telepon' => 'nullable|string'
        ]);

        $dataRt->update($request->all());

        return redirect()->route('data-rt.index')
            ->with('success', 'Data RT berhasil diupdate!');
    }

    private function authorizeAccess()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Hanya Admin yang bisa mengakses!');
        }
    }
}