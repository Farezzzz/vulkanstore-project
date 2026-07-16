@extends('layouts.app')
@section('title', 'Data Pengiriman')
@section('content')

    {{-- BREADCRUMBS --}}
    <div class="mb-2 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
        TRANSAKSI <span class="mx-2">></span> <span class="text-[#091426]">PENGIRIMAN</span>
    </div>

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-[32px] font-bold text-[#091426]">Data Pengiriman</h1>

        <button onclick="modal_tambah.showModal()" class="flex h-[40px] items-center justify-center gap-2 rounded bg-[#091426] px-5 text-[12px] font-semibold text-white shadow-sm transition hover:bg-slate-800">
            <i class="ri-add-line text-lg"></i>
            Tambah Pengiriman
        </button>
    </div>

    {{-- NOTIFIKASI ERROR / BERHASIL --}}
    @if ($errors->any())
        <div class="mb-4 rounded bg-red-100 p-4 text-sm text-red-600 border border-red-200">
            <strong>Gagal menyimpan data:</strong>
            <ul class="list-disc pl-5 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div id="toast-success" class="toast toast-top toast-end z-50 mt-16 transition-opacity duration-500">
            <div class="alert alert-success flex items-center gap-2 rounded bg-green-500 px-6 py-4 text-white shadow-lg">
                <i class="ri-checkbox-circle-line text-2xl"></i>
                <div>
                    <h3 class="font-bold text-[14px]">Berhasil!</h3>
                    <div class="text-[12px]">{{ session('success') }}</div>
                </div>
            </div>
        </div>

        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 5000);
        </script>
        @endif

    {{-- CONTAINER UTAMA --}}
    <div class="w-full overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">
        
        {{-- SEARCH & FILTER BAR --}}
        <div class="px-6 py-5">
            <form action="{{ route('pengiriman.index') }}" method="GET" class="flex w-full items-center justify-between">
                
                {{-- Sisi Kiri: Input Search & Reset --}}
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pengiriman..." class="h-[38px] w-[320px] rounded border border-gray-300 pl-10 pr-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('pengiriman.index') }}" class="flex h-[38px] items-center rounded bg-red-100 px-4 text-[12px] font-bold text-red-600 transition hover:bg-red-200">Reset</a>
                    @endif
                </div>

                {{-- Sisi Kanan: Tombol Filter --}}
                <div class="flex items-center gap-3">
                    <button type="button" class="flex h-[38px] items-center gap-2 rounded border border-gray-300 bg-white px-4 text-[12px] font-semibold text-[#45474C] transition hover:bg-slate-50">
                        <i class="ri-filter-3-line text-base"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- TABEL DATA PENGIRIMAN --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left">
                <thead class="bg-[#F8F9FB]">
                    <tr class="border-y border-gray-200 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
                        <th class="px-6 py-4">ID_PENGIRIMAN</th>
                        <th class="px-6 py-4">ID_PESANAN</th>
                        <th class="px-6 py-4">NAMA_PEMESAN</th>
                        <th class="px-6 py-4 w-[250px]">ALAMAT</th>
                        <th class="px-6 py-4">TANGGAL KIRIM</th>
                        <th class="px-6 py-4">STATUS PENGIRIMAN</th>
                        <th class="px-6 py-4 text-center w-[100px]">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-[14px]">
                    @forelse($pengiriman as $item)
                    <tr class="border-b border-gray-100 transition hover:bg-slate-50">
                        <td class="px-6 py-5 font-bold text-[#091426]">{{ $item->ID_Pengiriman }}</td>
                        <td class="px-6 py-5 text-[#45474C]">{{ $item->ID_Pesanan }}</td>
                        <td class="px-6 py-5 text-[#45474C]">{{ $item->pesanan->Nama_Pelanggan ?? '-' }}</td>
                        <td class="px-6 py-5 text-[#45474C] truncate max-w-[250px]" title="{{ $item->pesanan->Alamat ?? '-' }}">
                            {{ $item->pesanan->Alamat ?? '-' }}
                        </td>
                        <td class="px-6 py-5 text-[#45474C]">
                            {{ $item->Tanggal_Kirim ? \Carbon\Carbon::parse($item->Tanggal_Kirim)->format('d M, H:i') : '-' }}
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $statusClass = 'bg-gray-100 text-gray-700'; 
                                if ($item->Status_Pengiriman == 'DISIAPKAN') {
                                    $statusClass = 'bg-[#FFE8D6] text-[#D06915]'; 
                                } elseif ($item->Status_Pengiriman == 'SEDANG DIKIRIM') {
                                    $statusClass = 'bg-[#E1EDFF] text-[#407BFF]';
                                } elseif ($item->Status_Pengiriman == 'SELESAI') {
                                    $statusClass = 'bg-[#E3F5E7] text-[#2F9E54]';
                                }
                            @endphp
                            <span class="px-2.5 py-1 rounded-sm text-[10px] font-extrabold uppercase tracking-wide {{ $statusClass }}">
                                {{ $item->Status_Pengiriman }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center">
                                <a href="{{ route('pengiriman.show', $item->ID_Pengiriman) }}" class="text-gray-500 transition hover:text-[#091426]" title="Detail Pengiriman">
                                    <i class="ri-information-line text-[20px]"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-sm font-medium text-gray-500">
                            Data transaksi pengiriman tidak ditemukan!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="border-t border-gray-200 px-6 py-4">
            {{ $pengiriman->withQueryString()->links() }}
        </div>
    </div>

    {{-- MODAL TAMBAH PENGIRIMAN --}}
    <dialog id="modal_tambah" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-0 shadow-lg max-w-[450px]">
            {{-- Header Modal --}}
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-[16px] font-bold text-[#091426]">Tambah Pengiriman Baru</h3>
            </div>
            
            <form action="{{ route('pengiriman.store') }}" method="POST">
                @csrf
                
                {{-- Body Modal --}}
                <div class="p-6 space-y-5">
                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">ID Pesanan</label>
                        <select name="ID_Pesanan" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426] bg-white appearance-none">
                            <option value="" disabled selected hidden>Pilih ID Pesanan</option>
                            @foreach($pesanan as $p)
                                <option value="{{ $p->ID_Pesanan }}">{{ $p->ID_Pesanan }} - {{ $p->Nama_Pelanggan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Tanggal Kirim</label>
                        <input type="date" name="Tanggal_Kirim" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>

                    {{-- Default Status --}}
                    <input type="hidden" name="Status_Pengiriman" value="DISIAPKAN">
                </div>

                {{-- Footer Modal --}}
                <div class="bg-[#F8F9FA] px-6 py-4 flex justify-end gap-3 border-t border-gray-100">
                    <button type="button" onclick="modal_tambah.close()" class="h-[40px] rounded border border-gray-300 px-6 text-[12px] font-semibold text-[#45474C] transition hover:bg-gray-50">Batal</button>
                    <button type="submit" class="h-[40px] rounded bg-[#091426] px-6 text-[12px] font-semibold text-white transition hover:bg-slate-800">Simpan Data</button>
                </div>
            </form>
        </div>
    </dialog>

@endsection