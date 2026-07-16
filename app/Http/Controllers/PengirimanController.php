<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengiriman::with('pesanan');
        if ($request->filled('search')) {
                $query->where('ID_Pesanan', 'like', '%' . $request->search . '%')
                    ->orWhere('ID_Pengiriman', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('status')) {
                $query->where('Status_Pengiriman', $request->status);
            }

        $pengiriman = $query->latest('ID_Pengiriman')->paginate(10)->withQueryString();

        $pesananSiapKirim = Pesanan::where('Status_Pembayaran', 'Lunas')
            ->where('Status_Pesanan', 'Diproses')
            ->where('Metode_Pengiriman', 'Dikirim')
            ->whereNotIn('ID_Pesanan', function($query) {
                $query->select('ID_Pesanan')->from('pengiriman');
            })
            ->get();

        return view('pengiriman.index', [
            'pengiriman' => $pengiriman,
            'pesanan'    => $pesananSiapKirim
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_Pesanan'        => 'required|exists:pesanan,ID_Pesanan',
            'Tanggal_Kirim'     => 'required|date',
            'Status_Pengiriman' => 'required|in:Disiapkan,Dikirim,Selesai',
        ]);

        Pengiriman::create([
            'ID_Pesanan'        => $request->ID_Pesanan,
            'Tanggal_Kirim'     => $request->Tanggal_Kirim,
            'Status_Pengiriman' => $request->Status_Pengiriman,
        ]);

        return redirect()->route('pengiriman.index')->with('success', 'Data pengiriman berhasil dibuat!');
    }


    public function show(string $id)
    {
        $pengiriman = Pengiriman::with(['pesanan.detailPesanan.barang'])->findOrFail($id);
        return view('pengiriman.show', compact('pengiriman'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Status_Pengiriman' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $pengiriman = Pengiriman::with('pesanan')->findOrFail($id);

            $pengiriman->update([
                'Status_Pengiriman' => $request->Status_Pengiriman
            ]);

            if ($request->Status_Pengiriman == 'Selesai' && $pengiriman->pesanan) {
                $pengiriman->pesanan->update([
                    'Status_Pesanan' => 'Selesai'
                ]);
            }

            DB::commit();

            return redirect()->route('pengiriman.index', $id)->with('success', 'Status pengiriman berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }
}
