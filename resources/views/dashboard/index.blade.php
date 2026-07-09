@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <h1 class="mb-8 text-[20px] font-semibold text-gray-900">Dashboard</h1>
    <div class="grid grid-cols-1 gap-6 mb-8 xl:grid-cols-3">
        <div class="rounded-[8px] p-6 text-white shadow-md"
            style="background:linear-gradient(90deg,#8E2DE2 0%,#6B14F5 55%,#4A00E0 100%);">
            <div class="mb-5 flex h-11 w-11 items-center justify-center rounded-lg bg-white/15">
                <i class="ri-computer-line text-2xl"></i>
            </div>
            <p class="text-[13px] uppercase tracking-[1px]">Total Pemesanan</p>
            <h2 class="mt-2 text-3xl font-bold">43</h2>
            <p class="mt-5 text-sm text-white/90">Bulan ini</p>
        </div>
        <div class="rounded-[8px] p-6 text-white shadow-md"
            style="background:linear-gradient(90deg,#3B6EEA 0%,#2D5FE0 55%,#244BC5 100%);">
            <div class="mb-5 flex h-11 w-11 items-center justify-center rounded-lg bg-white/15">
                <i class="ri-money-dollar-circle-line text-2xl"></i>
            </div>
            <p class="text-[13px] uppercase tracking-[1px]">Laporan Uang Masuk</p>
            <h2 class="mt-2 text-3xl font-bold">Rp 1,25 M</h2>
            <p class="mt-5 text-sm text-white/90">Bulan ini</p>
        </div>
        <div class="rounded-[8px] p-6 text-white shadow-md"
            style="background:linear-gradient(90deg,#FF8A2B 0%,#FF7A12 55%,#FF6A00 100%);">
            <div class="mb-5 flex h-11 w-11 items-center justify-center rounded-lg bg-white/15">
                <i class="ri-bank-card-line text-2xl"></i>
            </div>
            <p class="text-[13px] uppercase tracking-[1px]">Laporan Uang Keluar</p>
            <h2 class="mt-2 text-3xl font-bold">Rp 850.000</h2>
            <p class="mt-5 text-sm text-white/90">Bulan ini</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between px-8 py-5">
            <h2 class="text-[16px] font-semibold text-gray-800">Data Pesanan Terbaru</h2>
            <a href="#" class="flex items-center gap-1 text-sm font-medium text-[#F59E0B]">
                View All
                <i class="ri-arrow-right-s-line"></i>
            </a>
        </div>
        <table class="w-full">
            <thead class="bg-[#F8F9FB]">
                <tr class="border-y border-gray-200 text-left text-[12px] uppercase tracking-wide text-gray-500">
                    <th class="px-8 py-4">Nama</th>
                    <th class="px-8 py-4">Alamat Pengiriman</th>
                    <th class="px-8 py-4">Supir</th>
                    <th class="px-8 py-4">No. Telepon</th>
                    <th class="px-8 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-gray-700">
                <tr class="border-b border-gray-100">
                    <td class="px-8 py-5 font-medium">Asep Sunandar</td>
                    <td class="px-8 py-5">Jl. Asia Afrika No.10, Bandung</td>
                    <td class="px-8 py-5">Rifa</td>
                    <td class="px-8 py-5">0812-3456-7890</td>
                    <td class="px-8 py-5">
                        <span
                            class="rounded-full bg-green-100 px-3 py-1 text-[11px] font-semibold text-green-700">LUNAS</span>
                    </td>
                </tr>
                <tr class="border-b border-gray-100">
                    <td class="px-8 py-5 font-medium">Anang Parker Ray</td>
                    <td class="px-8 py-5">Jl. Sudirman Kav.45, Bandung</td>
                    <td class="px-8 py-5">Agus</td>
                    <td class="px-8 py-5">0812-9876-5432</td>
                    <td class="px-8 py-5">
                        <span class="rounded-full bg-red-100 px-3 py-1 text-[11px] font-semibold text-red-700">BELUM
                            LUNAS</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-8 py-5 font-medium">Abigail Agbenyo</td>
                    <td class="px-8 py-5">Kawasan Industri Jababeka, Bekasi</td>
                    <td class="px-8 py-5">Dadan</td>
                    <td class="px-8 py-5">0857-1122-3344</td>
                    <td class="px-8 py-5">
                        <span
                            class="rounded-full bg-green-100 px-3 py-1 text-[11px] font-semibold text-green-700">LUNAS</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
