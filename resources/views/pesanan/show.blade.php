@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('content')

    {{-- TOP NAVIGATION BAR --}}
    <div class="mb-8 flex items-center gap-4 border-b border-gray-200 pb-4 text-[12px] font-bold uppercase tracking-wider text-gray-500">
        <a href="{{ route('pesanan.index') }}" class="flex items-center gap-1.5 transition hover:text-gray-900">
            <i class="ri-arrow-left-line text-sm"></i>
            KEMBALI
        </a>
        <span class="text-gray-300 font-normal">|</span>
        <span class="text-[#091426] text-[15px] font-extrabold tracking-normal normal-case">VulkanStore</span>
    </div>

    {{-- PAGE HEADER & STATUS BADGE --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-extrabold tracking-tight text-[#091426]">Detail Pesanan</h1>
        
        <span class="inline-flex items-center gap-2 rounded-full bg-[#BA1A1A] px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider text-white">
            <span class="h-1.5 w-1.5 rounded-full bg-white"></span> MENUNGGU PEMBAYARAN
        </span>
    </div>

    {{-- KARTU 1: INFORMASI UMUM --}}
    <div class="mb-6 w-full rounded-md border border-gray-200 bg-white shadow-sm">
        <div class="p-6">
            {{-- Header Kartu 1 --}}
            <div class="mb-8 flex items-center gap-2 text-[16px] font-bold text-[#1D2939]">
                <i class="ri-information-line text-[20px]"></i>
                Informasi Umum
            </div>

            {{-- Konten Grid (3 Kolom) --}}
            <div class="grid grid-cols-3 gap-x-8 gap-y-8">
                {{-- Baris 1 --}}
                <div class="flex flex-col">
                    <span class="mb-2 text-[10px] font-bold uppercase tracking-wider text-gray-500">ID PESANAN</span>
                    <span class="text-[14px] font-bold text-[#091426]">{{ $pesanan->ID_Pesanan }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="mb-2 text-[10px] font-bold uppercase tracking-wider text-gray-500">NAMA PELANGGAN</span>
                    <span class="text-[14px] font-bold text-[#091426]">{{ $pesanan->Nama_Pelanggan }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="mb-2 text-[10px] font-bold uppercase tracking-wider text-gray-500">TANGGAL PESANAN</span>
                    <span class="text-[14px] font-medium text-[#1D2939]">
                        {{ $pesanan->Tanggal ? \Carbon\Carbon::parse($pesanan->Tanggal)->format('d M Y') : '-' }}
                    </span>
                </div>

                {{-- Baris 2 --}}
                <div class="flex flex-col justify-center">
                    <span class="mb-2 text-[10px] font-bold uppercase tracking-wider text-gray-500">TOTAL BAYAR</span>
                    <span class="text-[26px] font-extrabold text-[#9A6A23] leading-none">
                        Rp {{ number_format($pesanan->Total_Tagihan, 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex flex-col justify-center">
                    <span class="mb-2 text-[10px] font-bold uppercase tracking-wider text-gray-500">STATUS PEMBAYARAN</span>
                    <div class="flex items-center gap-1.5">
                        @if($pesanan->Status_Pembayaran == 'LUNAS')
                            <i class="ri-checkbox-circle-line text-[18px] text-green-600"></i>
                            <span class="text-[13px] font-bold text-green-600">Lunas</span>
                        @else
                            <i class="ri-error-warning-line text-[18px] text-[#DC2626]"></i>
                            <span class="text-[13px] font-bold text-[#DC2626]">Belum Lunas</span>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col pr-4">
                    <span class="mb-2 text-[10px] font-bold uppercase tracking-wider text-gray-500">ALAMAT PENGIRIMAN</span>
                    <span class="text-[13px] font-medium text-gray-600 leading-relaxed">
                        {{ $pesanan->Alamat }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- KARTU 2: RINCIAN BARANG --}}
    <div class="w-full rounded-md border border-gray-200 bg-[#F9FAFB] shadow-sm mb-6">
        <div class="px-6 py-5 flex items-center gap-2 text-[16px] font-bold text-[#091426]">
            <i class="ri-archive-line text-[20px]"></i>
            Rincian Barang
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="bg-[#EAECEF] border-y border-gray-200 text-[10px] font-bold uppercase tracking-wider text-gray-600">
                        <th class="px-6 py-4 w-[45%]">NAMA BARANG</th>
                        <th class="px-6 py-4 text-center w-[15%]">QTY</th>
                        <th class="px-6 py-4 text-center w-[20%]">HARGA SATUAN</th>
                        <th class="px-6 py-4 text-right w-[20%]">SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody class="text-[13px] divide-y divide-gray-200 bg-white">
                    @forelse($pesanan->detailPesanan as $detail)
                    @php
                        $hargaSatuan = $detail->barang->Harga_Jual ?? 0; 
                        $subtotal = $detail->Kuantitas * $hargaSatuan;
                    @endphp
                    <tr class="transition">
                        <td class="px-6 py-5">
                            <span class="block font-bold text-[#091426] mb-1">{{ $detail->barang->Nama_Barang ?? 'Barang Tidak Diketahui' }}</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">ID: {{ $detail->ID_Barang }}</span>
                        </td>
                        <td class="px-6 py-5 text-center font-bold text-[#091426]">
                            {{ $detail->Kuantitas }}
                        </td>
                        <td class="px-6 py-5 text-center font-medium text-gray-700">
                            Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-5 text-right font-bold text-[#091426]">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-sm font-medium text-gray-500">
                            Tidak ada item barang dalam pesanan ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-[#F9FAFB] border-t-[3px] border-[#45474C]">
                        <td colspan="3" class="px-6 py-5 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            TOTAL KESELURUHAN
                        </td>
                        <td class="px-6 py-5 text-right text-[18px] font-bold text-[#091426]">
                            Rp {{ number_format($pesanan->Total_Tagihan, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- TOMBOL AKSI BAWAH --}}
    <div class="flex justify-end gap-3 mt-8">
        <form action="{{ route('pesanan.destroy', $pesanan->ID_Pesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="h-[42px] px-6 rounded-sm border border-gray-300 bg-white text-[10px] font-bold uppercase tracking-wider text-gray-600 transition hover:bg-gray-50">
                BATALKAN PESANAN
            </button>
        </form>

        <form action="{{ route('pesanan.update', $pesanan->ID_Pesanan) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="update_pembayaran" value="LUNAS">
            <button type="submit" class="h-[42px] px-6 rounded-sm bg-[#875A19] text-[10px] font-bold uppercase tracking-wider text-white transition hover:bg-[#6e4914]">
                UPDATE STATUS PEMBAYARAN
            </button>
        </form>
    </div>

@endsection