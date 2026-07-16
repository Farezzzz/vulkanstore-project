@extends('layouts.app')
@section('title', 'Data Pesanan')
@section('content')

    {{-- BREADCRUMBS --}}
    <div class="mb-2 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
        TRANSAKSI <span class="mx-2">></span> <span class="text-[#091426]">PEMESANAN</span>
    </div>

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-[32px] font-bold text-[#091426]">Data Pesanan</h1>

        <button onclick="openTambahModal()" class="flex h-[40px] w-[163px] items-center justify-center gap-2 rounded bg-[#091426] text-[12px] font-semibold text-white shadow-sm transition hover:bg-slate-800">
            <i class="ri-add-line text-lg"></i>
            Tambah Pesanan
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

    @if (session('success'))
        <div class="mb-4 rounded bg-green-100 p-4 text-sm text-green-600 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- CONTAINER UTAMA --}}
    <div class="w-full overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">
        
        {{-- SEARCH & FILTER BAR --}}
        <div class="px-6 py-5">
            <form action="{{ route('pesanan.index') }}" method="GET" class="flex w-full items-center justify-between">
                
                {{-- Sisi Kiri: Input Search & Reset --}}
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID atau Nama Pelanggan..." class="h-[38px] w-[320px] rounded border border-gray-300 pl-10 pr-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('pesanan.index') }}" class="flex h-[38px] items-center rounded bg-red-100 px-4 text-[12px] font-bold text-red-600 transition hover:bg-red-200">Reset</a>
                    @endif
                </div>

                {{-- Sisi Kanan: Tombol Filter Simpel Sesuai Gambar --}}
                <div class="flex items-center gap-3">
                    <button type="button" class="flex h-[38px] items-center gap-2 rounded border border-gray-300 bg-white px-4 text-[12px] font-semibold text-[#45474C] transition hover:bg-slate-50">
                        <i class="ri-filter-3-line text-base"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- TABEL DATA PESANAN --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left">
                <thead class="bg-[#F8F9FB]">
                    <tr class="border-y border-gray-200 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
                        <th class="px-6 py-4 w-[100px]">ID</th>
                        <th class="px-6 py-4">Nama Pelanggan</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Total Tagihan</th>
                        <th class="px-6 py-4 text-center w-[100px]">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-[14px]">
                    @forelse($pesanan as $item)
                    <tr class="border-b border-gray-100 transition hover:bg-slate-50">
                        <td class="px-6 py-5 font-semibold text-[#45474C]">{{ $item->ID_Pesanan }}</td>
                        <td class="px-6 py-5 font-semibold text-[#45474C]">{{ $item->Nama_Pelanggan }}</td>
                        <td class="px-6 py-5 font-semibold text-[#45474C]">
                            {{ $item->Tanggal ? \Carbon\Carbon::parse($item->Tanggal)->format('d M, H:i') : '-' }}
                        </td>
                        <td class="px-6 py-5 font-semibold text-[#45474C]">
                            Rp {{ number_format($item->Total_Tagihan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center">
                                <a href="{{ route('pesanan.show', $item->ID_Pesanan) }}" class="text-gray-500 transition hover:text-[#091426]" title="Detail Pesanan">
                                    <i class="ri-information-line text-[20px]"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm font-medium text-gray-500">
                            Data transaksi pesanan tidak ditemukan!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="border-t border-gray-200 px-6 py-4">
            {{ $pesanan->withQueryString()->links() }}
        </div>
    </div>

    {{-- MODAL TAMBAH PESANAN (MULTI-STEP DIALOG) --}}
    <dialog id="modal_tambah" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-6 shadow-lg max-w-[480px]">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Tambah Pesanan Baru</h3>
            
            <form action="{{ route('pesanan.store') }}" method="POST" id="form_tambah_pesanan">
                @csrf
                
                {{-- STEP 1: INFORMASI PELANGGAN --}}
                <div id="step_1" class="space-y-4">
                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Nama Pelanggan</label>
                        <input type="text" id="input_nama" name="Nama_Pelanggan" placeholder="Masukkan nama pelanggan" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>

                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Tanggal Pesanan</label>
                        <input type="date" id="input_tanggal" name="Tanggal" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>

                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Alamat Lengkap</label>
                        <textarea id="input_alamat" name="Alamat" rows="3" placeholder="Masukkan alamat pengiriman" required class="w-full rounded border border-slate-300 p-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]"></textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Jarak Tempuh (km)</label>
                        <input type="number" id="input_jarak" name="Jarak_Tempuh_Km" placeholder="Contoh: 15" min="0" step="0.1" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>

                    {{-- Footer Step 1 --}}
                    <div class="flex justify-end gap-3 border-t border-gray-100 pt-4 mt-6">
                        <button type="button" onclick="modal_tambah.close()" class="h-[40px] rounded border border-gray-300 px-6 text-[12px] font-semibold text-[#45474C] transition hover:bg-gray-50">Batal</button>
                        <button type="button" onclick="goToStep2()" class="h-[40px] rounded bg-[#091426] px-6 text-[12px] font-semibold text-white transition hover:bg-slate-800">Selanjutnya</button>
                    </div>
                </div>

                {{-- STEP 2: DETAIL BARANG --}}
                <div id="step_2" class="space-y-4 hidden">
                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Barang</label>
                        <select name="ID_Barang" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426] bg-white">
                            <option value="" disabled selected hidden>Pilih atau masukan nama barang</option>
                            @foreach($barangList as $barang)
                                <option value="{{ $barang->ID_Barang }}">{{ $barang->Nama_Barang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Kuantitas</label>
                        <input type="number" name="Kuantitas" placeholder="Contoh: 10" min="1" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>

                    <div>
                        <button type="button" class="flex w-full h-[41px] items-center justify-center gap-2 rounded bg-[#091426] text-[12px] font-semibold text-white transition hover:bg-slate-800">
                            <i class="ri-add-line text-base"></i>
                            Tambah Barang Penerimaan
                        </button>
                    </div>

                    {{-- Footer Step 2 --}}
                    <div class="flex justify-end gap-3 border-t border-gray-100 pt-4 mt-6">
                        <button type="button" onclick="goToStep1()" class="h-[40px] rounded border border-gray-300 px-6 text-[12px] font-semibold text-[#45474C] transition hover:bg-gray-50">Batal</button>
                        <button type="submit" class="h-[40px] rounded bg-[#091426] px-6 text-[12px] font-semibold text-white transition hover:bg-slate-800">Simpan Data</button>
                    </div>
                </div>

            </form>
        </div>
    </dialog>

    {{-- JAVASCRIPT --}}
    <script>
        function openTambahModal() {
            document.getElementById('step_2').classList.add('hidden');
            document.getElementById('step_1').classList.remove('hidden');
            modal_tambah.showModal();
        }

        function goToStep2() {
            const nama = document.getElementById('input_nama').value;
            const tanggal = document.getElementById('input_tanggal').value;
            const alamat = document.getElementById('input_alamat').value;
            const jarak = document.getElementById('input_jarak').value;

            if(nama && tanggal && alamat && jarak) {
                document.getElementById('step_1').classList.add('hidden');
                document.getElementById('step_2').classList.remove('hidden');
            } else {
                document.getElementById('form_tambah_pesanan').reportValidity();
            }
        }

        function goToStep1() {
            document.getElementById('step_2').classList.add('hidden');
            document.getElementById('step_1').classList.remove('hidden');
        }
    </script>

@endsection