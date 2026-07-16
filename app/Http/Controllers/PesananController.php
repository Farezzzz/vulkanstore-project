<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index(Request $request)
    {
    $query = Pesanan::query(); 

    // Filter Berdasarkan Pencarian Nama Pelanggan
    if ($request->filled('search')) {
        $query->where('Nama_Pelanggan', 'like', '%' . $request->search . '%');
    }

    // Filter Berdasarkan Status Pesanan
    if ($request->filled('status_pesanan')) {
        $query->where('Status_Pesanan', $request->status_pesanan);
    }

    // Filter Berdasarkan Status Pembayaran
    if ($request->filled('status_pembayaran')) {
        $query->where('Status_Pembayaran', $request->status_pembayaran);
    }

    // Ambil data dengan pagination
    $pesanan = $query->latest('ID_Pesanan')->paginate(5);
    $barangList = \App\Models\Barang::all(); 

    return view('pesanan.index', compact('pesanan', 'barangList'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'Nama_Pelanggan'    => 'required|string|max:255',
        'Tanggal'           => 'required|date',
        'Alamat'            => 'required|string',
        'Jarak_Tempuh_Km'   => 'required|numeric',
        'ID_Barang'         => 'required|exists:barang,ID_Barang',
        'Kuantitas'         => 'required|integer|min:1',
    ]);

    $barang = \App\Models\Barang::findOrFail($request->ID_Barang);
    
    // Asumsi nama kolom harga di tabel barang lu adalah Harga_Jual (sesuaikan jika namanya 'Harga')
    $totalTagihan = $barang->Harga_Jual * $request->Kuantitas; 

    $pesanan = Pesanan::create([
        'ID_Pengguna'       => auth()->id() ?? 1,
        'Nama_Pelanggan'    => $request->Nama_Pelanggan,
        'Alamat'            => $request->Alamat,
        'Tanggal'           => $request->Tanggal,
        'Total_Tagihan'     => $totalTagihan,
        'Jarak_Tempuh_Km'   => $request->Jarak_Tempuh_Km,
        'Status_Pesanan'    => 'DIPROSES', 
        'Status_Pembayaran' => 'BELUM LUNAS'
    ]);

    // DI SINI PERUBAHANNYA: Hanya masukkan kolom yang ada di $fillable Model DetailPesanan
    DetailPesanan::create([
        'ID_Pesanan' => $pesanan->ID_Pesanan,
        'ID_Barang'  => $request->ID_Barang,
        'Kuantitas'  => $request->Kuantitas,
    ]);

    $barang->decrement('Stok_Tersedia', $request->Kuantitas);

    return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil ditambahkan!');
    }       

    public function show(string $id)
    {

        $pesanan = Pesanan::with('detailPesanan.barang')->findOrFail($id);

        return view('pesanan.show', compact('pesanan'));
    }

    public function edit(string $id)
    {
        // Menampilkan halaman edit pesanan (opsional, biasanya untuk update status)
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
        DB::beginTransaction();

        try {
            $pesanan = Pesanan::findOrFail($id);

            foreach ($pesanan->detailPesanan as $detail) {
                $barang = Barang::find($detail->ID_Barang);
                if ($barang) {
                    $barang->increment('Stok_Tersedia', $detail->Kuantitas);
                }
            }

            DetailPesanan::where('ID_Pesanan', $id)->delete();


            $pesanan->delete();

            DB::commit();

            return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus dan stok barang telah dikembalikan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pesanan.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}