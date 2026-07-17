<?php

namespace App\Http\Controllers;

use App\Models\BankSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BankSampahController extends Controller
{
    private const HARGA_SAMPAH = [
        'Plastik' => 3000,
        'Kertas' => 1500,
        'Logam' => 5000,
        'Organik' => 500,
        'Kaca' => 1000,
        'Elektronik' => 7000,
    ];

    public function index()
    {
        $bankSampahs = BankSampah::latest()->paginate(15);
        $totalNasabah = BankSampah::count();
        $totalSaldo = BankSampah::sum('saldo_tabungan');
        $totalBerat = BankSampah::sum('berat_sampah');
        $totalPenarikan = BankSampah::where('status', 'Ditarik')->sum('saldo_tabungan');
        return view('bank-sampah.index', compact('bankSampahs', 'totalNasabah', 'totalSaldo', 'totalBerat', 'totalPenarikan'));
    }

    public function create()
    {
        return view('bank-sampah.create', ['hargaSampah' => self::HARGA_SAMPAH]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_nasabah' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'jenis_sampah' => 'required|in:Plastik,Kertas,Logam,Organik,Kaca,Elektronik',
            'berat_sampah' => 'required|numeric|min:0',
            'status' => 'required|in:Tersimpan,Menunggu Timbang,Sudah Diambil,Ditarik',
            'petugas' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_setoran' => 'nullable|date',
        ]);

        $validated['kode_nasabah'] = 'BS-' . strtoupper(Str::random(6));
        $validated['tanggal_setoran'] = $validated['tanggal_setoran'] ?? now();
        $validated['jenis_sampah'] = $validated['jenis_sampah'] ?? 'Belum diklasifikasikan';
        $validated['harga_per_kg'] = self::HARGA_SAMPAH[$validated['jenis_sampah']] ?? 0;
        $validated['saldo_tabungan'] = $validated['berat_sampah'] * $validated['harga_per_kg'];

        BankSampah::create($validated);

        return redirect()->route('bank-sampah.index')
            ->with('success', 'Data Bank Sampah berhasil ditambahkan.');
    }

    public function show(BankSampah $bankSampah)
    {
        return view('bank-sampah.show', compact('bankSampah'));
    }

    public function edit(BankSampah $bankSampah)
    {
        return view('bank-sampah.edit', compact('bankSampah') + ['hargaSampah' => self::HARGA_SAMPAH]);
    }

    public function update(Request $request, BankSampah $bankSampah)
    {
        $validated = $request->validate([
            'nama_nasabah' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'jenis_sampah' => 'required|in:Plastik,Kertas,Logam,Organik,Kaca,Elektronik',
            'berat_sampah' => 'required|numeric|min:0',
            'status' => 'required|in:Tersimpan,Menunggu Timbang,Sudah Diambil,Ditarik',
            'petugas' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_setoran' => 'nullable|date',
        ]);

        $validated['harga_per_kg'] = self::HARGA_SAMPAH[$validated['jenis_sampah']] ?? 0;
        $validated['saldo_tabungan'] = $validated['berat_sampah'] * $validated['harga_per_kg'];

        $bankSampah->update($validated);

        return redirect()->route('bank-sampah.index')
            ->with('success', 'Data Bank Sampah berhasil diperbarui.');
    }

    public function destroy(BankSampah $bankSampah)
    {
        $bankSampah->delete();
        return redirect()->route('bank-sampah.index')
            ->with('success', 'Data Bank Sampah berhasil dihapus.');
    }

    /**
     * Process a withdrawal (tarik dana) for a nasabah.
     */
    public function tarik(Request $request, BankSampah $bankSampah)
    {
        // Simple implementation: mark as 'Ditarik' and set saldo to 0.
        if ($bankSampah->saldo_tabungan <= 0) {
            return redirect()->route('bank-sampah.index')->with('error', 'Saldo kosong, tidak ada yang bisa ditarik.');
        }

        $bankSampah->status = 'Ditarik';
        $bankSampah->saldo_tabungan = 0;
        $bankSampah->save();

        return redirect()->route('bank-sampah.index')->with('success', 'Penarikan dana berhasil diproses.');
    }
}
