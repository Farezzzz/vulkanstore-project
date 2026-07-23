@extends('layouts.app')
@section('title', 'Laporan')
@section('content')

    <style>
        @media print {
            /* Sembunyikan navigasi dashboard, tombol aksi, dan modal saat cetak */
            .no-print, aside, nav, header, [class*="sidebar"], [class*="navbar"], .modal-backdrop { 
                display: none !important; 
            }
            body { 
                background: white !important; 
                padding: 40px !important; 
            }
            .print-container { 
                border: none !important; 
                box-shadow: none !important; 
                padding: 0 !important; 
                width: 100% !important;
            }
            
            /* MENETRALKAN WARNA: Memaksa semua teks menjadi hitam/gelap saat dicetak (Monokrom) */
            h1, h3, p, th, td, span, div {
                color: #091426 !important;
            }
            
            /* Memaksa browser mempertahankan garis/border abu-abu tipis pembatas */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>

    {{-- LOGIKA PERHITUNGAN DINAMIS UNTUK RINGKASAN CETAK --}}
    @php
        $totalMasukPeriode = 0;
        $totalKeluarPeriode = 0;
        foreach($bukuKas as $item) {
            $totalMasukPeriode += $item->uang_masuk;
            $totalKeluarPeriode += $item->uang_keluar;
        }
        $saldoAkhirPeriode = $totalMasukPeriode - $totalKeluarPeriode;
    @endphp

    {{-- HANYA DI LAYAR: Judul Halaman Utama --}}
    <div class="mb-6 no-print">
        <h1 class="text-[32px] font-bold text-[#091426]">Laporan</h1>
    </div>

    {{-- HANYA DI PRINT: Kop Surat Resmi --}}
    <div class="hidden print:block text-center mb-8 border-b-2 border-[#091426] pb-4">
        <h1 class="text-3xl font-extrabold uppercase tracking-wider text-[#091426]">Vulkan Store</h1>
        <p class="text-sm text-gray-600 font-medium mt-1">Laporan Rekapitulasi Buku Kas Harian</p>
        <p class="text-xs text-gray-500 mt-2">
            Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}
        </p>
    </div>

    {{-- HANYA DI PRINT: Ringkasan Periode (Summary Cards) --}}
    <div class="hidden print:grid grid-cols-3 gap-4 mb-8">
        <div class="p-4 rounded-[6px] border border-gray-300 bg-white">
            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-500">Total Uang Masuk</p>
            <h3 class="text-lg font-bold text-[#2F9E54] mt-1">Rp {{ number_format($totalMasukPeriode, 0, ',', '.') }}</h3>
        </div>
        <div class="p-4 rounded-[6px] border border-gray-300 bg-white">
            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-500">Total Uang Keluar</p>
            <h3 class="text-lg font-bold text-[#DC2626] mt-1">Rp {{ number_format($totalKeluarPeriode, 0, ',', '.') }}</h3>
        </div>
        <div class="p-4 rounded-[6px] border border-gray-300 bg-white">
            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-500">Saldo Akhir</p>
            <h3 class="text-lg font-bold {{ $saldoAkhirPeriode >= 0 ? 'text-[#2F9E54]' : 'text-[#DC2626]' }} mt-1">
                {{ $saldoAkhirPeriode < 0 ? '-' : '' }}Rp {{ number_format(abs($saldoAkhirPeriode), 0, ',', '.') }}
            </h3>
        </div>
    </div>

    {{-- CONTAINER UTAMA TABEL --}}
    <div class="print-container w-full overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">
        
        {{-- TOOLBAR ACTIONS (Hanya Muncul di Layar Monitor) --}}
        <div class="flex items-center justify-end gap-3 border-b border-gray-100 p-5 no-print">
            <button onclick="window.print()" class="flex h-[38px] items-center justify-center gap-2 rounded bg-[#091426] px-5 text-[13px] font-semibold text-white transition hover:bg-slate-800">
                <i class="ri-printer-line text-lg"></i>
                Cetak
            </button>
            
            <button type="button" onclick="toggleModalDate(true)" class="flex h-[38px] items-center justify-center gap-2 rounded border border-gray-300 bg-white px-4 text-[13px] font-semibold text-[#45474C] transition hover:bg-slate-50">
                <i class="ri-calendar-line text-lg"></i>
                Pilih Tanggal
            </button>
        </div>

        {{-- TABEL DATA UTAMA --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#F8F9FB]">
                    <tr class="border-y border-gray-200 text-[11px] font-extrabold uppercase tracking-widest text-[#6B7280]">
                        <th class="px-6 py-4 w-[25%]">TANGGAL</th>
                        <th class="px-6 py-4 w-[25%]">UANG MASUK</th>
                        <th class="px-6 py-4 w-[25%]">UANG KELUAR</th>
                        <th class="px-6 py-4 w-[25%]">TOTAL</th>
                    </tr>
                </thead>
                <tbody class="text-[13px] font-semibold">
                    @forelse($bukuKas as $item)
                        @php
                            $total = $item->uang_masuk - $item->uang_keluar;
                        @endphp
                        
                        <tr class="border-b border-gray-100 transition hover:bg-slate-50">
                            <td class="px-6 py-4 text-[#45474C]">
                                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 {{ $item->uang_masuk > 0 ? 'text-[#2F9E54]' : 'text-[#45474C] font-medium' }}">
                                Rp {{ number_format($item->uang_masuk, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 {{ $item->uang_keluar > 0 ? 'text-[#DC2626]' : 'text-[#45474C] font-medium' }}">
                                Rp {{ number_format($item->uang_keluar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 {{ $total >= 0 ? 'text-[#2F9E54]' : 'text-[#DC2626]' }}">
                                @if($total < 0)
                                    -Rp {{ number_format(abs($total), 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm font-medium text-gray-500">
                                Tidak ada data transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION (Hanya Muncul di Layar Monitor) --}}
        <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4 no-print">
            <div class="text-[13px] font-medium text-gray-500">
                Menampilkan {{ $bukuKas->firstItem() ?? 0 }} - {{ $bukuKas->lastItem() ?? 0 }} dari {{ $bukuKas->total() }} pesanan
            </div>
            
            @if ($bukuKas->hasPages())
                <div class="flex items-center gap-1">
                    @if ($bukuKas->onFirstPage())
                        <span class="flex h-7 w-7 items-center justify-center rounded text-gray-400 cursor-not-allowed"><i class="ri-arrow-left-s-line text-xl"></i></span>
                    @else
                        <a href="{{ $bukuKas->appends(request()->query())->previousPageUrl() }}" class="flex h-7 w-7 items-center justify-center rounded text-gray-700 hover:bg-gray-100 transition"><i class="ri-arrow-left-s-line text-xl"></i></a>
                    @endif

                    <span class="flex h-7 w-7 items-center justify-center rounded bg-[#091426] text-[12px] font-bold text-white shadow-sm">
                        {{ $bukuKas->currentPage() }}
                    </span>

                    @if ($bukuKas->hasMorePages())
                        <a href="{{ $bukuKas->appends(request()->query())->nextPageUrl() }}" class="flex h-7 w-7 items-center justify-center rounded text-gray-700 hover:bg-gray-100 transition"><i class="ri-arrow-right-s-line text-xl"></i></a>
                    @else
                        <span class="flex h-7 w-7 items-center justify-center rounded text-gray-400 cursor-not-allowed"><i class="ri-arrow-right-s-line text-xl"></i></span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- HANYA DI PRINT: Lembar Pengesahan Tanda Tangan --}}
    <div class="hidden print:block mt-16">
        <div class="flex justify-end">
            <div class="text-center w-[220px]">
                <p class="text-sm text-gray-700">Bandung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="text-sm text-gray-700 mt-1">Mengetahui,</p>
                <div class="h-[80px]"></div>
                <p class="text-sm font-bold text-[#091426] border-b border-gray-400 pb-1">Admin Vulkan Store</p>
            </div>
        </div>
    </div>

    {{-- MODAL DIALOG FILTERS (Hanya Muncul di Layar Monitor) --}}
    <div id="modalDateLaporan" class="modal-backdrop fixed inset-0 z-50 hidden items-center justify-center bg-[#091426]/40 px-4">
        <div class="w-full max-w-[420px] rounded-[8px] bg-white shadow-2xl overflow-hidden transition-all transform scale-95 duration-200">
            
            <div class="px-6 pt-6 pb-4">
                <h3 class="text-[15px] font-bold text-[#091426]">Pilih Tanggal Laporan</h3>
            </div>
            
            <form action="{{ route('laporan.index') }}" method="GET">
                <div class="px-6 pb-6 flex flex-col gap-5">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#45474C]">Tanggal Awal</label>
                        <input type="date" name="start_date" value="{{ $tanggalAwal }}" required
                            class="h-[42px] w-full rounded border border-gray-300 px-4 text-[13px] text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426] bg-white font-medium">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#45474C]">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ $tanggalAkhir }}" required
                            class="h-[42px] w-full rounded border border-gray-300 px-4 text-[13px] text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426] bg-white font-medium">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 px-6 pb-6 bg-white">
                    <button type="button" onclick="toggleModalDate(false)" 
                        class="flex h-[38px] items-center justify-center rounded border border-gray-300 bg-white px-5 text-[12px] font-bold text-[#45474C] transition hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit" 
                        class="flex h-[38px] items-center justify-center rounded bg-[#091426] px-5 text-[12px] font-bold text-white shadow-sm transition hover:bg-slate-800">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModalDate(show) {
            const modal = document.getElementById('modalDateLaporan');
            const innerBox = modal.querySelector('.transform');
            
            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    innerBox.classList.remove('scale-95', 'opacity-0');
                    innerBox.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                innerBox.classList.remove('scale-100', 'opacity-100');
                innerBox.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }, 150);
            }
        }

        document.getElementById('modalDateLaporan').addEventListener('click', function(e) {
            if (e.target === this) toggleModalDate(false);
        });
    </script>
@endsection