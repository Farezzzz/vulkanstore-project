<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-[#F8F9FA] text-[#091426] font-sans pb-12">

    <!-- HEADER NAVIGATION -->
    <header class="bg-white border-b border-gray-200 px-6 py-4 md:px-12">
        <div class="flex items-center gap-4">
            <a href="{{ route('pesanan.index') }}" class="flex items-center text-[12px] font-bold text-[#45474C] hover:text-[#091426] transition">
                <i class="ri-arrow-left-line mr-2"></i> KEMBALI
            </a>
            <div class="h-4 w-[1px] bg-gray-300"></div>
            <span class="text-[20px] font-bold text-[#091426]">VulkanStore</span>
        </div>
    </header>

    <!-- MAIN CONTENT CONTAINER -->
    <main class="w-full px-6 md:px-12 mt-8">

        <!-- TITLE BAR WITH STATUS BADGE -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <h1 class="text-[32px] font-bold text-[#091426]">Detail Pesanan</h1>
            
            <div class="flex items-center gap-3">
                <!-- Status Badge Pill -->
                <span class="inline-flex items-center gap-2 rounded-full bg-[#BA1A1A] px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider text-white shadow-sm">
                    <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span> • {{ $pesanan->Status_Pembayaran == 'LUNAS' ? 'LUNAS' : 'MENUNGGU PEMBAYARAN' }}
                </span>
            </div>
        </div>

        <!-- CARD 1: INFORMASI UMUM (Struktur Grid 3 Kolom) -->
        <div class="bg-white border border-gray-200 rounded shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200 flex items-center gap-3">
                <i class="ri-information-line text-[20px] text-gray-400"></i>
                <h2 class="text-[16px] font-bold text-[#091426]">Informasi Umum</h2>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-y-8 gap-x-12">
                    <!-- Baris 1 / Kolom 1 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">ID PESANAN</p>
                        <p class="text-[15px] font-bold text-[#091426]">{{ $pesanan->ID_Pesanan }}</p>
                    </div>
                    <!-- Baris 1 / Kolom 2 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">NAMA PELANGGAN</p>
                        <p class="text-[15px] font-bold text-[#091426]">{{ $pesanan->Nama_Pelanggan }}</p>
                    </div>
                    <!-- Baris 1 / Kolom 3 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">TANGGAL PESANAN</p>
                        <p class="text-[15px] font-bold text-[#091426]">
                            {{ $pesanan->Tanggal ? \Carbon\Carbon::parse($pesanan->Tanggal)->format('d M Y') : '-' }}
                        </p>
                    </div>

                    <!-- Baris 2 / Kolom 1 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">TOTAL BAYAR</p>
                        <p class="text-[26px] font-extrabold text-[#855300] leading-none">
                            Rp {{ number_format($pesanan->Total_Tagihan, 0, ',', '.') }}
                        </p>
                    </div>
                    <!-- Baris 2 / Kolom 2 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">STATUS PEMBAYARAN</p>
                        <div class="flex items-center gap-1.5 mt-1">
                            @if($pesanan->Status_Pembayaran == 'LUNAS')
                                <i class="ri-checkbox-circle-line text-[18px] text-green-600"></i>
                                <span class="text-[14px] font-bold text-green-600">Lunas</span>
                            @else
                                <i class="ri-error-warning-line text-[18px] text-[#DC2626]"></i>
                                <span class="text-[14px] font-bold text-[#DC2626]">Belum Lunas</span>
                            @endif
                        </div>
                    </div>
                    <!-- Baris 2 / Kolom 3 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">ALAMAT PENGIRIMAN</p>
                        <p class="text-[14px] font-medium text-gray-600 leading-relaxed">{{ $pesanan->Alamat }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 2: RINCIAN BARANG -->
        <div class="bg-white border border-gray-200 rounded shadow-sm overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-200 flex items-center gap-3">
                <i class="ri-archive-line text-[20px] text-gray-400"></i>
                <h2 class="text-[16px] font-bold text-[#091426]">Rincian Barang</h2>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F2F4F7] text-[10px] font-bold text-[#45474C] uppercase tracking-wider border-b border-gray-200">
                            <th class="px-8 py-4 w-[40%]">NAMA BARANG</th>
                            <th class="px-8 py-4 text-center w-[15%]">QTY</th>
                            <th class="px-8 py-4 text-center w-[20%]">HARGA SATUAN</th>
                            <th class="px-8 py-4 text-right w-[25%]">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pesanan->detailPesanan as $detail)
                        @php
                            $hargaSatuan = $detail->barang->Harga_Jual ?? 0; 
                            $subtotal = $detail->Kuantitas * $hargaSatuan;
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-8 py-5">
                                <span class="block text-[15px] font-bold text-[#091426] mb-0.5">{{ $detail->barang->Nama_Barang ?? 'Barang Tidak Diketahui' }}</span>
                                <span class="text-[11px] font-semibold text-gray-400">ID: {{ $detail->ID_Barang }}</span>
                            </td>
                            <td class="px-8 py-5 text-[15px] font-bold text-center text-[#091426]">{{ $detail->Kuantitas }}</td>
                            <td class="px-8 py-5 text-[15px] font-medium text-center text-[#45474C]">Rp {{ number_format($hargaSatuan, 0, ',', '.') }}</td>
                            <td class="px-8 py-5 text-[15px] font-bold text-right text-[#091426]">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-8 text-center text-sm font-medium text-gray-500">
                                Tidak ada item barang dalam pesanan ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-[#F9FAFB] border-t border-gray-200">
                            <td colspan="3" class="px-8 py-5 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">
                                TOTAL KESELURUHAN
                            </td>
                            <td class="px-8 py-5 text-right text-[18px] font-bold text-[#091426]">
                                Rp {{ number_format($pesanan->Total_Tagihan, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- TOMBOL AKSI BAWAH -->
        <div class="flex justify-end gap-3 mt-8">
            <form action="{{ route('pesanan.destroy', $pesanan->ID_Pesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="h-[42px] px-6 rounded border border-gray-300 bg-white text-[11px] font-bold uppercase tracking-wider text-gray-600 transition hover:bg-gray-50 shadow-sm">
                    BATALKAN PESANAN
                </button>
            </form>

            @if($pesanan->Status_Pembayaran != 'LUNAS')
            <form action="{{ route('pesanan.update', $pesanan->ID_Pesanan) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="update_pembayaran" value="LUNAS">
                <button type="submit" class="h-[42px] px-6 rounded bg-[#855300] text-[11px] font-bold uppercase tracking-wider text-white transition hover:bg-[#6e4600] shadow-sm">
                    UPDATE STATUS PEMBAYARAN
                </button>
            </form>
            @endif
        </div>
    </main>

</body>
</html>