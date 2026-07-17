<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 0.5cm 1cm;
            }

            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                background-color: white !important;
            }

            .shadow-sm, .shadow-lg {
                box-shadow: none !important;
            }

            .rounded, .rounded-full {
                border-radius: 2px !important;
            }
        }
    </style>
</head>
<body class="bg-[#F8F9FA] text-[#091426] font-sans pb-12">

    <header class="bg-white border-b border-gray-200 px-6 py-4 md:px-12 print:hidden">
        <div class="flex items-center gap-4">
            <a href="{{ route('pengiriman.index') }}" class="flex items-center text-[12px] font-bold text-[#45474C] hover:text-[#091426] transition">
                <i class="ri-arrow-left-line mr-2"></i> KEMBALI
            </a>
            <div class="h-4 w-[1px] bg-gray-300"></div>
            <span class="text-[20px] font-bold text-[#091426]">VulkanStore</span>
        </div>
    </header>

    <main class="w-full px-6 md:px-12 mt-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <h1 class="text-[32px] font-bold text-[#091426] print:text-[24px]">Detail Pengiriman</h1>

            <div class="flex items-center gap-3 print:hidden">
                @if($pengiriman->Status_Pengiriman == 'Selesai')
                    <span class="inline-flex items-center gap-2 rounded-full bg-green-100 border border-green-200 px-4 py-1.5 text-[11px] font-extrabold uppercase tracking-wider text-green-700 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span> SELESAI
                    </span>
                @elseif($pengiriman->Status_Pengiriman == 'Dikirim')
                    <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 border border-blue-200 px-4 py-1.5 text-[11px] font-extrabold uppercase tracking-wider text-blue-700 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-600 animate-pulse"></span> SEDANG DIKIRIM
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 rounded-full bg-orange-100 border border-orange-200 px-4 py-1.5 text-[11px] font-extrabold uppercase tracking-wider text-orange-700 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-orange-600 animate-pulse"></span> DISIAPKAN
                    </span>
                @endif

                <button onclick="window.print()" class="flex h-[40px] items-center justify-center gap-2 rounded border border-gray-300 bg-white px-4 text-[12px] font-bold text-[#091426] transition hover:bg-slate-50 shadow-sm hover:border-[#091426] print:hidden">
                    <i class="ri-printer-line text-base"></i>
                    CETAK SURAT JALAN
                </button>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200 flex items-center gap-3 print:py-4">
                <i class="ri-information-line text-[20px] text-gray-400 print:hidden"></i>
                <h2 class="text-[16px] font-bold text-[#091426]">Informasi Umum</h2>
            </div>

            <div class="p-8 print:p-4">
                <div class="grid grid-cols-1 md:grid-cols-3 print:grid-cols-3 gap-y-8 print:gap-y-4 gap-x-12">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">ID PENGIRIMAN</p>
                        <p class="text-[15px] font-bold text-[#091426]">{{ $pengiriman->ID_Pengiriman }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">NAMA PELANGGAN</p>
                        <p class="text-[15px] font-bold text-[#091426]">{{ $pengiriman->pesanan->Nama_Pelanggan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">JARAK TEMPUH</p>
                        <p class="text-[15px] font-bold text-[#091426]">{{ $pengiriman->pesanan->Jarak_Tempuh_Km ?? '0' }} Km</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">ID PESANAN</p>
                        <p class="text-[15px] font-bold text-[#091426]">{{ $pengiriman->ID_Pesanan }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">TANGGAL KIRIM</p>
                        <p class="text-[15px] font-bold text-[#091426]">
                            {{ $pengiriman->Tanggal_Kirim ? \Carbon\Carbon::parse($pengiriman->Tanggal_Kirim)->format('d M Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">ALAMAT PENGIRIMAN</p>
                        <p class="text-[14px] font-medium text-gray-600 leading-relaxed">{{ $pengiriman->pesanan->Alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded shadow-sm overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-200 flex items-center gap-3 print:py-4">
                <i class="ri-archive-line text-[20px] text-gray-400 print:hidden"></i>
                <h2 class="text-[16px] font-bold text-[#091426]">Rincian Barang </h2>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F2F4F7] text-[10px] font-bold text-[#45474C] uppercase tracking-wider border-b border-gray-200">
                            <th class="px-8 py-4 w-[70%]">NAMA BARANG</th>
                            <th class="px-8 py-4 text-center w-[30%]">QTY </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pengiriman->pesanan->detailPesanan as $detail)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-8 py-5">
                                <span class="block text-[15px] font-bold text-[#091426] mb-0.5">{{ $detail->barang->Nama_Barang ?? 'Barang Tidak Diketahui' }}</span>
                                <span class="text-[11px] font-semibold text-gray-400">ID: {{ $detail->ID_Barang }}</span>
                            </td>
                            <td class="px-8 py-5 text-[15px] font-bold text-center text-[#091426]">{{ $detail->Kuantitas }} Unit</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-8 text-center text-sm font-medium text-gray-500">
                                Tidak ada item barang dalam pengiriman ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="hidden print:grid grid-cols-2 gap-28 mt-5 text-center text-sm">
            <div>
                <p class="font-medium text-gray-500 mb-20">Supir Pengirim,</p>
                <p class="font-bold border-b border-gray-400 w-48 mx-auto"></p>
                <p class="text-xs text-gray-400 mt-1">Nama Jelas & TTD</p>
            </div>
            <div>
                <p class="font-medium text-gray-500 mb-20">Penerima,</p>
                <p class="font-bold border-b border-gray-400 w-48 mx-auto"></p>
                <p class="text-xs text-gray-400 mt-1">Nama Jelas & TTD</p>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8 print:hidden">

            @if($pengiriman->Status_Pengiriman == 'Disiapkan')
                <form id="form-kirim" action="{{ route('pengiriman.update', $pengiriman->ID_Pengiriman) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="Status_Pengiriman" value="Dikirim">
                    <button type="button" onclick="konfirmasiAksi('form-kirim', 'Mulai Pengiriman?', 'Status akan diubah menjadi SEDANG DIKIRIM. Berikan Surat Jalan fisik kepada supir.', 'info', 'Ya, Berangkatkan!')" class="h-[42px] px-6 rounded bg-[#855300] text-[11px] font-bold uppercase tracking-wider text-white transition hover:bg-[#6e4600] shadow-sm">
                        UPDATE STATUS PENGIRIMAN
                    </button>
                </form>
            @endif

            @if($pengiriman->Status_Pengiriman == 'Dikirim')
                <form id="form-selesai" action="{{ route('pengiriman.update', $pengiriman->ID_Pengiriman) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="Status_Pengiriman" value="Selesai">
                    <button type="button" onclick="konfirmasiAksi('form-selesai', 'Selesaikan Pengiriman?', 'Pastikan fisik barang sudah sampai dan Surat Jalan bertanda tangan asli sudah diterima kembali.', 'success', 'Ya, Selesai!')" class="h-[42px] px-6 rounded bg-[#855300] text-[11px] font-bold uppercase tracking-wider text-white transition hover:bg-[#6e4600] shadow-sm">
                        TANDAI SELESAI
                    </button>
                </form>
            @endif

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function konfirmasiAksi(formId, title, text, icon, confirmText) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#091426',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmText,
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Aksi Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#091426'
            });
        @endif
    </script>

</body>
</html>
