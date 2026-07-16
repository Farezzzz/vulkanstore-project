<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-[#091426] font-sans pb-10">

    <header class="bg-white border-b border-gray-200 px-6 py-4 md:px-12">
        <div class="flex items-center gap-4">
            <a href="{{ route('penerimaan.index') }}" class="flex items-center text-[12px] font-bold text-[#45474C] hover:text-[#091426] transition">
                <i class="ri-arrow-left-line mr-2"></i> KEMBALI
            </a>
            <div class="h-4 w-[1px] bg-gray-300"></div>
            <span class="text-[20px] font-bold text-[#091426]">VulkanStore</span>
        </div>
    </header>

    <main class="w-full px-6 md:px-12 mt-8">

        <h1 class="text-[32px] font-bold text-[#091426] mb-8">Detail Penerimaan</h1>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6 p-8">
            <div class="flex items-center gap-3 mb-8">
                <i class="ri-information-line text-[20px]"></i>
                <h2 class="text-[20px] font-semibold">Informasi Umum</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <p class="text-[12px] font-semibold text-[#45474C] uppercase mb-1">ID PENERIMAAN</p>
                    <p class="text-[16px] font-bold">{{ $penerimaan->ID_Penerimaan }}</p>
                </div>
                <div>
                    <p class="text-[12px] font-semibold text-[#45474C] uppercase mb-1">NAMA PEMASOK</p>
                    <p class="text-[16px] font-bold">{{ $penerimaan->pemasok->Nama_Pelanggan ?? $penerimaan->pemasok->Nama_Pemasok }}</p>
                </div>
                <div>
                    <p class="text-[12px] font-semibold text-[#45474C] uppercase mb-1">TANGGAL BARANG MASUK</p>
                    <p class="text-[16px] font-bold flex items-center">
                        {{ \Carbon\Carbon::parse($penerimaan->Tanggal_Masuk)->format('d M Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-[12px] font-semibold text-[#45474C] uppercase mb-1">TOTAL BAYAR</p>
                    <p class="text-[32px] font-bold text-[#855300]">Rp {{ number_format($penerimaan->detailPenerimaan->sum(fn($i) => $i->Kuantitas * $i->Harga_Beli), 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-8 border-b border-gray-100 flex items-center gap-3">
                <i class="ri-list-check text-[20px]"></i>
                <h2 class="text-[20px] font-bold">Rincian Barang</h2>
            </div>

            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-100/50 text-[12px] font-bold text-[#45474C] uppercase">
                        <th class="px-8 py-4">NAMA BARANG</th>
                        <th class="px-8 py-4 text-center">QTY</th>
                        <th class="px-8 py-4 text-right">HARGA SATUAN</th>
                        <th class="px-8 py-4 text-right">SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($penerimaan->detailPenerimaan as $item)
                    <tr>
                        <td class="px-8 py-6">
                            <span class="block text-[16px] font-bold text-[#091426]">{{ $item->barang->Nama_Barang }}</span>
                            <span class="text-[12px] font-semibold text-[#45474C]">ID: {{ $item->ID_Barang }}</span>
                        </td>
                        <td class="px-8 py-6 text-[16px] font-bold text-center">{{ $item->Kuantitas }}</td>
                        <td class="px-8 py-6 text-[16px] font-bold text-right">Rp {{ number_format($item->Harga_Beli, 0, ',', '.') }}</td>
                        <td class="px-8 py-6 text-[16px] font-bold text-right">Rp {{ number_format($item->Kuantitas * $item->Harga_Beli, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="bg-gray-50/50">
                        <td colspan="3" class="px-8 py-6 text-right text-[14px] font-bold text-[#45474C]">TOTAL KESELURUHAN</td>
                        <td class="px-8 py-6 text-[20px] font-bold text-right">Rp {{ number_format($penerimaan->detailPenerimaan->sum(fn($i) => $i->Kuantitas * $i->Harga_Beli), 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
