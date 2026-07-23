<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Filter Tanggal (Default: Awal bulan ini sampai akhir bulan ini)
        $tanggalAwal = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // 2. Query Uang Masuk (Pesanan Lunas)
        $pemasukan = DB::table('pesanan')
            ->select('tanggal as date', DB::raw('SUM(total_tagihan) as uang_masuk'), DB::raw('0 as uang_keluar'))
            ->where('status_pembayaran', 'Lunas')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->groupBy('tanggal');

        // 3. Query Uang Keluar (Penerimaan Barang)
        $pengeluaran = DB::table('penerimaan')
            ->select('tanggal_masuk as date', DB::raw('0 as uang_masuk'), DB::raw('SUM(total_biaya) as uang_keluar'))
            ->whereBetween('tanggal_masuk', [$tanggalAwal, $tanggalAkhir])
            ->groupBy('tanggal_masuk');

        // 4. Penggabungan (UNION) & Grouping Tanggal yang Sama
        $bukuKas = DB::table(DB::raw("({$pemasukan->toSql()} UNION ALL {$pengeluaran->toSql()}) as merged"))
            ->mergeBindings($pemasukan)
            ->mergeBindings($pengeluaran)
            ->select('date', DB::raw('SUM(uang_masuk) as uang_masuk'), DB::raw('SUM(uang_keluar) as uang_keluar'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->paginate(10);

        // 5. Lempar data ke View Laporan
        return view('laporan.index', compact('bukuKas', 'tanggalAwal', 'tanggalAkhir'));
    }
}