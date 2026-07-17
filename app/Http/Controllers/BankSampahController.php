<?php

namespace App\Http\Controllers;

use App\Models\BankSampah;
use App\Models\BankSampahWithdrawal;
use App\Models\Warga;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
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
        $wargas = Warga::select('id','name','nik','alamat','no_hp')->orderBy('name')->get();
        return view('bank-sampah.create', ['hargaSampah' => self::HARGA_SAMPAH, 'wargas' => $wargas]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'nullable|exists:warga,id',
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

        // If warga selected, override personal fields from warga record
        if (!empty($validated['warga_id'])) {
            $w = Warga::find($validated['warga_id']);
            if ($w) {
                $validated['nama_nasabah'] = $w->name;
                $validated['nik'] = $w->nik ?? $validated['nik'];
                $validated['alamat'] = $w->alamat ?? $validated['alamat'];
                $validated['no_hp'] = $w->no_hp ?? $validated['no_hp'];
            }
        }

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
        $wargas = Warga::select('id','name','nik','alamat','no_hp')->orderBy('name')->get();
        return view('bank-sampah.edit', compact('bankSampah') + ['hargaSampah' => self::HARGA_SAMPAH, 'wargas' => $wargas]);
    }

    public function update(Request $request, BankSampah $bankSampah)
    {
        $validated = $request->validate([
            'warga_id' => 'nullable|exists:warga,id',
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

        if (!empty($validated['warga_id'])) {
            $w = Warga::find($validated['warga_id']);
            if ($w) {
                $validated['nama_nasabah'] = $w->name;
                $validated['nik'] = $w->nik ?? $validated['nik'];
                $validated['alamat'] = $w->alamat ?? $validated['alamat'];
                $validated['no_hp'] = $w->no_hp ?? $validated['no_hp'];
            }
        }

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
        // Allow partial or full withdrawal. If amount provided, validate and use it.
        $current = (float) $bankSampah->saldo_tabungan;
        if ($current <= 0) {
            return redirect()->route('bank-sampah.show', $bankSampah)->with('error', 'Saldo kosong, tidak ada yang bisa ditarik.');
        }

        $validated = $request->validate([
            'amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $amount = isset($validated['amount']) && $validated['amount'] > 0 ? (float) $validated['amount'] : $current;

        if ($amount > $current) {
            return redirect()->route('bank-sampah.show', $bankSampah)->with('error', 'Jumlah penarikan melebihi saldo.');
        }

        // create withdrawal record
        BankSampahWithdrawal::create([
            'bank_sampah_id' => $bankSampah->id,
            'amount' => $amount,
            'tanggal_penarikan' => now()->toDateString(),
        ]);

        // deduct saldo and update status accordingly
        $bankSampah->saldo_tabungan = $current - $amount;
        if ($bankSampah->saldo_tabungan <= 0) {
            $bankSampah->status = 'Ditarik';
        }
        $bankSampah->save();

        return redirect()->route('bank-sampah.show', $bankSampah)->with('success', 'Penarikan dana berhasil dicatat.');
    }

    /**
     * Show global withdrawals history.
     */
    public function withdrawalsIndex()
    {
        $withdrawals = BankSampahWithdrawal::with('bankSampah')->latest()->paginate(25);
        return view('bank-sampah.withdrawals', compact('withdrawals'));
    }

    /**
     * Export withdrawals as CSV.
     */
    public function exportWithdrawals()
    {
        $rows = BankSampahWithdrawal::with('bankSampah')->latest()->get();

        $filename = 'withdrawals_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $columns = ['id', 'bank_sampah_kode', 'nama_nasabah', 'amount', 'tanggal_penarikan', 'created_at'];

        $callback = function () use ($rows, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($rows as $r) {
                fputcsv($file, [
                    $r->id,
                    $r->bankSampah->kode_nasabah ?? '-',
                    $r->bankSampah->nama_nasabah ?? '-',
                    number_format($r->amount, 2, '.', ''),
                    $r->tanggal_penarikan,
                    $r->created_at,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
