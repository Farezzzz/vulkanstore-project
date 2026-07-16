<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\DetailPenerimaan;
use App\Models\Pemasok;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penerimaan::with('pemasok');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ID_Penerimaan', 'like', "%{$search}%")
                ->orWhereHas('pemasok', function($qPemasok) use ($search) {
                    $qPemasok->where('Nama_Pemasok', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('kategori')) {
            $query->whereHas('pemasok', function($q) use ($request) {
                $q->where('Kategori_Pemasok', $request->kategori);
            });
        }

        $penerimaan = $query->latest('Tanggal_Masuk')->paginate(10)->withQueryString();
        $pemasok = Pemasok::all();
        $barang = Barang::all();

        return view('penerimaan.index', compact('penerimaan', 'pemasok', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_Pemasok' => 'required|exists:pemasok,ID_Pemasok',
            'Tanggal_Masuk' => 'required|date',
            'barang' => 'required|array',
            'barang.*.ID_Barang' => 'required|exists:barang,ID_Barang',
            'barang.*.Kuantitas' => 'required|integer|min:1',
            'barang.*.Harga_Beli' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();
            $totalBiaya = 0;
            foreach ($request->barang as $item) {$totalBiaya += ($item['Kuantitas'] *$item['Harga_Beli']);
            }

            $penerimaan = Penerimaan::create([
                'ID_Pemasok' => $request->ID_Pemasok,
                'ID_Pengguna' => auth()->ID_Pengguna ?? 1,
                'Tanggal_Masuk' => $request->Tanggal_Masuk,
                'Total_Biaya' => $totalBiaya,
            ]);

            foreach ($request->barang as$item) {
                DetailPenerimaan::create([
                    'ID_Penerimaan' => $penerimaan->ID_Penerimaan,
                    'ID_Barang' => $item['ID_Barang'],
                    'Kuantitas' => $item['Kuantitas'],
                    'Harga_Beli' => $item['Harga_Beli'],
                ]);

                Barang::where('ID_Barang', $item['ID_Barang'])->increment('Stok_Tersedia',$item['Kuantitas']);
            }

            DB::commit();

            return redirect()->route('penerimaan.index')->with('success', 'Penerimaan berhasil dicatat dan Stok otomatis bertambah!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $penerimaan = Penerimaan::with(['pemasok', 'pengguna', 'detailPenerimaan.barang'])->findOrFail($id);

        return view('penerimaan.detail', compact('penerimaan'));
    }
}
