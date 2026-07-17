<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::query();

            if ($request->filled('search')) {
                $query->where('Nama_Pelanggan', 'like', '%' . $request->search . '%')
                    ->orWhere('ID_Pesanan', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('status')) {
                $query->where('Status_Pesanan', $request->status)
                    ->orWhere('Status_Pembayaran', $request->status);
            }

        $pesanan = $query->with('detailPesanan')->latest('ID_Pesanan')->paginate(10)->withQueryString();
        $barangList = Barang::where('Stok_Tersedia', '>', 0)->get();

        return view('pesanan.index', compact('pesanan', 'barangList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nama_Pelanggan'    => 'required|string|max:255',
            'Tanggal'           => 'required|date',
            'Alamat'            => 'required|string',
            'Jarak_Tempuh_Km'   => 'required|numeric|min:0.1',
            'barang'            => 'required|array|min:1',
            'barang.*.ID_Barang'=> 'required|exists:barang,ID_Barang',
            'barang.*.Kuantitas'=> 'required|integer|min:1',
        ], [
            'barang.required' => 'Keranjang pesanan tidak boleh kosong!',
        ]);

        DB::beginTransaction();
        try {
            $totalTagihan = 0;
            $itemsData = [];

            foreach ($request->barang as $item) {
                $barangDb = Barang::lockForUpdate()->findOrFail($item['ID_Barang']);

                if ($barangDb->Stok_Tersedia < $item['Kuantitas']) {
                    throw new Exception("Stok barang {$barangDb->Nama_Barang} tidak mencukupi (Sisa: {$barangDb->Stok_Tersedia}).");
                }

                $totalTagihan += ($barangDb->Harga_Jual * $item['Kuantitas']);

                $itemsData[] = [
                    'barang_model' => $barangDb,
                    'kuantitas'    => $item['Kuantitas']
                ];
            }
            $metode = 'Dikirim';
            $max_jarak = 0;

            if ($totalTagihan < 3000000) {
                $metode = 'Diambil Sendiri';
            } else {
                if ($totalTagihan <= 7000000) {
                    $max_jarak = 10;
                } elseif ($totalTagihan <= 15000000) {
                    $max_jarak = 20;
                } elseif ($totalTagihan <= 25000000) {
                    $max_jarak = 30;
                } elseif ($totalTagihan <= 35000000) {
                    $max_jarak = 40;
                } else {
                    $max_jarak = 50;
                }

                if ($request->Jarak_Tempuh_Km > $max_jarak) {
                    $metode = 'Diambil Sendiri';
                }
            }
            $pesanan = Pesanan::create([
                'ID_Pengguna'       => Auth::check() ? Auth::id() : 1,
                'Nama_Pelanggan'    => $request->Nama_Pelanggan,
                'Alamat'            => $request->Alamat,
                'Tanggal'           => $request->Tanggal,
                'Total_Tagihan'     => $totalTagihan,
                'Jarak_Tempuh_Km'   => $request->Jarak_Tempuh_Km,
                'Status_Pesanan'    => 'Diproses',
                'Status_Pembayaran' => 'Belum Lunas',
                'Metode_Pengiriman' => $metode
            ]);

            foreach ($itemsData as $data) {
                DetailPesanan::create([
                    'ID_Pesanan' => $pesanan->ID_Pesanan,
                    'ID_Barang'  => $data['barang_model']->ID_Barang,
                    'Kuantitas'  => $data['kuantitas'],
                ]);

                $data['barang_model']->decrement('Stok_Tersedia', $data['kuantitas']);
            }
            DB::commit();

            return redirect()->route('pesanan.index')->with('success', 'Pesanan baru berhasil ditambahkan!');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(string $id)
    {
        $pesanan = Pesanan::with('detailPesanan.barang')->findOrFail($id);
        return view('pesanan.show', compact('pesanan'));
    }

    public function edit(string $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('pesanan.edit', compact('pesanan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Status_Pesanan'    => 'required|string',
            'Status_Pembayaran' => 'required|string',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'Status_Pesanan'    => $request->Status_Pesanan,
            'Status_Pembayaran' => $request->Status_Pembayaran,
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {

    }
}
