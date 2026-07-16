<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- SweetAlert2 CDN untuk pop-up konfirmasi berjenjang -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-[#F8F9FA] text-[#091426] font-sans pb-12">

    <!-- HEADER NAVIGATION -->
    <header class="bg-white border-b border-gray-200 px-6 py-4 md:px-12">
        <div class="flex items-center gap-4">
            <a href="{{ route('pengiriman.index') }}" class="flex items-center text-[12px] font-bold text-[#45474C] hover:text-[#091426] transition">
                <i class="ri-arrow-left-line mr-2"></i> KEMBALI
            </a>
            <div class="h-4 w-[1px] bg-gray-300"></div>
            <span class="text-[20px] font-bold text-[#091426]">VulkanStore</span>
        </div>
    </header>

    <!-- MAIN CONTENT CONTAINER -->
    <main class="w-full px-6 md:px-12 mt-8">

        <!-- TITLE BAR WITH STATUS & ACTION -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <h1 class="text-[32px] font-bold text-[#091426]">Detail Pengiriman</h1>
            
            <div class="flex items-center gap-3">
                <!-- Status Badge Pill -->
                <span class="inline-flex items-center gap-2 rounded-full bg-[#1D2939] px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider text-white shadow-sm">
                    <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span> • {{ $pengiriman->Status_Pengiriman ?? 'DISIAPKAN' }}
                </span>
                
                <!-- Cetak Surat Jalan Button -->
                <button type="button" class="h-[38px] px-4 rounded border border-gray-300 bg-white text-[11px] font-bold uppercase tracking-wider text-[#091426] hover:bg-gray-50 transition shadow-sm">
                    CETAK SURAT JALAN
                </button>
            </div>
        </div>

        <!-- CARD 1: INFORMASI UMUM (Struktur Grid 3 Kolom Sesuai Gambar) -->
        <div class="bg-white border border-gray-200 rounded shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200 flex items-center gap-3">
                <i class="ri-information-line text-[20px] text-gray-400"></i>
                <h2 class="text-[16px] font-bold text-[#091426]">Informasi Umum</h2>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-y-8 gap-x-12">
                    <!-- Baris 1 / Kolom 1 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">ID PENGIRIMAN</p>
                        <p class="text-[15px] font-bold text-[#091426]">{{ $pengiriman->ID_Pengiriman }}</p>
                    </div>
                    <!-- Baris 1 / Kolom 2 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">NAMA PELANGGAN</p>
                        <p class="text-[15px] font-bold text-[#091426]">{{ $pengiriman->pesanan->Nama_Pelanggan ?? '-' }}</p>
                    </div>
                    <!-- Baris 1 / Kolom 3 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">JARAK TEMPUH</p>
                        <p class="text-[15px] font-bold text-[#091426]">{{ $pengiriman->pesanan->Jarak_Tempuh_Km ?? '0' }} Km</p>
                    </div>

                    <!-- Baris 2 / Kolom 1 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">ID PESANAN</p>
                        <p class="text-[15px] font-bold text-[#091426]">{{ $pengiriman->ID_Pesanan }}</p>
                    </div>
                    <!-- Baris 2 / Kolom 2 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">TANGGAL KIRIM</p>
                        <p class="text-[15px] font-bold text-[#091426]">
                            {{ $pengiriman->Tanggal_Kirim ? \Carbon\Carbon::parse($pengiriman->Tanggal_Kirim)->format('d M Y') : '-' }}
                        </p>
                    </div>
                    <!-- Baris 2 / Kolom 3 -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">ALAMAT PENGIRIMAN</p>
                        <p class="text-[14px] font-medium text-gray-600 leading-relaxed">{{ $pengiriman->pesanan->Alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 2: RINCIAN BARANG (Struktur Tabel Sesuai Gambar) -->
        <div class="bg-white border border-gray-200 rounded shadow-sm overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-200 flex items-center gap-3">
                <i class="ri-inbox-line text-[20px] text-gray-400"></i>
                <h2 class="text-[16px] font-bold text-[#091426]">Rincian Barang</h2>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F2F4F7] text-[10px] font-bold text-[#45474C] uppercase tracking-wider border-b border-gray-200">
                            <th class="px-8 py-4 w-[60%]">NAMA BARANG</th>
                            <th class="px-8 py-4 text-center w-[20%]">QTY</th>
                            <th class="px-8 py-4 text-right w-[20%]">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if($pengiriman->pesanan && $pengiriman->pesanan->detailPesanan)
                            @forelse($pengiriman->pesanan->detailPesanan as $item)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-5">
                                    <span class="block text-[15px] font-bold text-[#091426] mb-0.5">{{ $item->barang->Nama_Barang ?? '-' }}</span>
                                    <span class="text-[11px] font-semibold text-gray-400">ID: {{ $item->ID_Barang }}</span>
                                </td>
                                <td class="px-8 py-5 text-[15px] font-bold text-center text-[#091426]">{{ $item->Kuantitas }}</td>
                                <td class="px-8 py-5 text-[15px] font-medium text-right text-gray-400">-</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-8 text-center text-sm font-medium text-gray-500">
                                    Tidak ada rincian data barang.
                                </td>
                            </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="3" class="px-8 py-8 text-center text-sm font-medium text-gray-500">
                                    Data pesanan tidak ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LOGIKA BERJENJANG AUTOMATION STATUS -->
        @php
            $currentStatus = strtoupper($pengiriman->Status_Pengiriman ?? 'DISIAPKAN');
            $nextStatus = null;

            if ($currentStatus === 'DISIAPKAN') {
                $nextStatus = 'DIKIRIM';
            } elseif (in_array($currentStatus, ['DIKIRIM', 'DIANTAR', 'DIANTARKAN'])) {
                $nextStatus = 'SELESAI';
            }
        @endphp

        <!-- UPDATE STATUS BUTTON ACTION -->
        @if($nextStatus)
            <div class="flex justify-end mt-8">
                <button type="button" onclick="confirmUpdateStatus('{{ $currentStatus }}', '{{ $nextStatus }}')" 
                    class="h-[42px] px-6 rounded bg-[#855300] text-[11px] font-bold uppercase tracking-wider text-white transition hover:bg-[#6e4600] shadow-sm">
                    UPDATE STATUS PENGIRIMAN
                </button>

                <!-- Hidden form pengirim request PUT linear -->
                <form id="form-update-status" action="{{ route('pengiriman.updateStatus', $pengiriman->ID_Pengiriman) }}" method="POST" class="hidden">
                    @csrf 
                    @method('PUT')
                </form>
            </div>
        @endif
    </main>

    <!-- SWEETALERT POP-UP HANDLING INTERACTION -->
    <script>
        function confirmUpdateStatus(current, next) {
            Swal.fire({
                title: 'Perbarui Status Pengiriman?',
                html: `Apakah Anda yakin ingin mengubah status dari <b class="text-[#855300]">${current}</b> menjadi <b class="text-green-600">${next}</b>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#855300',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Perbarui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-update-status').submit();
                }
            });
        }
    </script>
</body>
</html>