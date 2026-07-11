@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <h1 class="mb-8 text-[24px] font-bold text-[#091426]">Dashboard</h1>

    <div class="mb-10 grid w-full grid-cols-1 gap-6 xl:grid-cols-3">

        <div class="flex min-h-[190px] w-full flex-col justify-between rounded-[8px] p-6 shadow-md"
            style="background:linear-gradient(90deg,#8E2DE2 0%,#6B14F5 55%,#4A00E0 100%);">
            <div>
                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-lg bg-white/15">
                    <i class="ri-computer-line text-2xl text-white"></i>
                </div>
                <p class="text-[12px] font-semibold uppercase tracking-wide text-white">Total Pemesanan</p>
                <h2 class="mt-1 text-[30px] font-bold text-white">43</h2>
            </div>
            <p class="text-[14px] font-medium text-white/90">Bulan ini</p>
        </div>

        <div class="flex min-h-[190px] w-full flex-col justify-between rounded-[8px] p-6 shadow-md"
            style="background:linear-gradient(90deg,#3B6EEA 0%,#2D5FE0 55%,#244BC5 100%);">
            <div>
                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-lg bg-white/15">
                    <i class="ri-money-dollar-circle-line text-2xl text-white"></i>
                </div>
                <p class="text-[12px] font-semibold uppercase tracking-wide text-white">Laporan Uang Masuk</p>
                <h2 class="mt-1 text-[30px] font-bold text-white">Rp 1.25M</h2>
            </div>
            <p class="text-[14px] font-medium text-white/90">Bulan ini</p>
        </div>

        <div class="flex min-h-[190px] w-full flex-col justify-between rounded-[8px] p-6 shadow-md"
            style="background:linear-gradient(90deg,#FF8A2B 0%,#FF7A12 55%,#FF6A00 100%);">
            <div>
                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-lg bg-white/15">
                    <i class="ri-bank-card-line text-2xl text-white"></i>
                </div>
                <p class="text-[12px] font-semibold uppercase tracking-wide text-white">Laporan Uang Keluar</p>
                <h2 class="mt-1 text-[30px] font-bold text-white">Rp 850.000</h2>
            </div>
            <p class="text-[14px] font-medium text-white/90">Bulan ini</p>
        </div>
    </div>

    <div class="w-full overflow-x-auto rounded-[8px] border border-gray-200 bg-white shadow-sm">
        <div class="flex min-w-[700px] items-center justify-between px-6 py-5">
            <h2 class="text-[14px] font-normal text-[#091426]">Data Pesanan Terbaru</h2>
            <a href="#" class="flex items-center gap-1 text-[12px] font-semibold text-[#F59E0B] transition hover:opacity-80">
                View All
                <i class="ri-arrow-right-s-line"></i>
            </a>
        </div>

        <table class="w-full min-w-[700px] text-left">
            <thead class="bg-[#F8F9FB]">
                <tr class="border-y border-gray-200 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
                    <th class="px-6 py-4">NAME</th>
                    <th class="whitespace-nowrap px-6 py-4">ALAMAT PENGIRIMAN</th>
                    <th class="whitespace-nowrap px-6 py-4">NO TELP</th>
                    <th class="whitespace-nowrap px-6 py-4">STATUS PEMBAYARAN</th>
                </tr>
            </thead>
            <tbody class="text-[14px] text-gray-700">
                <tr class="border-b border-gray-100 transition hover:bg-slate-50">
                    <td class="px-6 py-5 font-semibold text-[#091426]">Asep Sunandar</td>
                    <td class="px-6 py-5">Jl. Asia Afrika No. 10, Bandung</td>
                    <td class="px-6 py-5">0812-3456-7890</td>
                    <td class="px-6 py-5">
                        <span class="rounded bg-gray-100 px-3 py-1.5 text-[11px] font-bold text-[#45474C] outline outline-1 outline-gray-300">LUNAS</span>
                    </td>
                </tr>
                <tr class="border-b border-gray-100 transition hover:bg-slate-50">
                    <td class="px-6 py-5 font-semibold text-[#091426]">Anang Parker Ray</td>
                    <td class="px-6 py-5">Jl. Sudirman Kav. 45, Bandung</td>
                    <td class="px-6 py-5">0812-9876-5432</td>
                    <td class="px-6 py-5">
                        <span class="rounded bg-gray-100 px-3 py-1.5 text-[11px] font-bold text-[#45474C] outline outline-1 outline-gray-300">BELUM LUNAS</span>
                    </td>
                </tr>
                <tr class="transition hover:bg-slate-50">
                    <td class="px-6 py-5 font-semibold text-[#091426]">Abigail Agbenyo</td>
                    <td class="px-6 py-5">Kawasan Industri Jababeka, Bekasi</td>

                    <td class="px-6 py-5">0857-1122-3344</td>
                    <td class="px-6 py-5">
                        <span class="rounded bg-gray-100 px-3 py-1.5 text-[11px] font-bold text-[#45474C] outline outline-1 outline-gray-300">LUNAS</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
