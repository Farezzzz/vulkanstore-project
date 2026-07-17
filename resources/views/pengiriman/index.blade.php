@extends('layouts.app')
@section('title', 'Data Pengiriman')
@section('content')

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-[32px] font-bold text-[#091426]">Data Pengiriman</h1>

        <button onclick="modal_tambah.showModal()" class="flex h-[40px] items-center justify-center gap-2 rounded bg-[#091426] px-5 text-[12px] font-semibold text-white shadow-sm transition hover:bg-slate-800">
            <i class="ri-add-line text-lg"></i>
            Tambah Pengiriman
        </button>
    </div>

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

    {{-- CONTAINER --}}
    <div class="w-full overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">

        <div class="px-6 py-5">
            <form action="{{ route('pengiriman.index') }}" method="GET" class="flex w-full items-center justify-between">

                <div class="flex items-center gap-4">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID Pengiriman atau Pesanan..." class="h-[38px] w-[320px] rounded border border-gray-300 pl-10 pr-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('pengiriman.index') }}" class="flex h-[38px] items-center rounded bg-red-100 px-4 text-[12px] font-bold text-red-600 transition hover:bg-red-200">Reset</a>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <select name="status" onchange="this.form.submit()" class="h-[38px] cursor-pointer rounded border border-gray-300 px-4 text-[12px] font-semibold text-[#45474C] outline-none">
                        <option value="">Filter</option>
                        <option value="Disiapkan" {{ request('status') == 'Disiapkan' ? 'selected' : '' }}>Disiapkan</option>
                        <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- TABEL DATA PENGIRIMAN --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] text-left">
                <thead class="bg-[#F8F9FB]">
                    <tr class="border-y border-gray-200 text-[11px] font-semibold uppercase tracking-wider text-[#45474C]">
                        <th class="px-6 py-4 w-[10%]">ID_PENGIRIMAN</th>
                        <th class="px-6 py-4 w-[10%]">ID_PESANAN</th>
                        <th class="px-6 py-4 w-[20%]">NAMA_PELANGGAN</th>
                        <th class="px-6 py-4 max-w-[250px]">ALAMAT</th>
                        <th class="px-6 py-4 w-[15%]">TANGGAL_KIRIM</th>
                        <th class="px-6 py-4 text-center w-[15%]">STATUS_PENGIRIMAN</th>
                        <th class="px-6 py-4 text-center w-[10%]">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-[13px]">
                    @forelse ($pengiriman as $item)
                    <tr class="border-b border-gray-100 transition hover:bg-slate-50">
                        <td class="px-6 py-5 font-semibold text-[#091426]">{{ $item->ID_Pengiriman }}</td>
                        <td class="px-6 py-5 font-semibold text-[#091426]">#{{ $item->ID_Pesanan }}</td>
                        <td class="px-6 py-5 font-semibold text-[#091426]">{{ $item->pesanan->Nama_Pelanggan ?? '-' }}</td>

                        <td class="px-6 py-5 text-[#091426] font-medium truncate max-w-[250px]" title="{{ $item->pesanan->Alamat ?? '-' }}">
                            {{ $item->pesanan->Alamat ?? '-' }}
                        </td>

                        <td class="px-6 py-5 text-[#091426] font-medium">
                            {{ $item->Tanggal_Kirim ? \Carbon\Carbon::parse($item->Tanggal_Kirim)->format('d M Y') : '-' }}
                        </td>

                        <td class="px-6 py-5 text-center">
                            @if($item->Status_Pengiriman == 'Disiapkan')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-orange-50 border border-orange-200 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-orange-600">
                                    DISIAPKAN
                                </span>
                            @elseif($item->Status_Pengiriman == 'Dikirim')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 border border-blue-200 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-blue-600">
                                    SEDANG DIKIRIM
                                </span>
                            @elseif($item->Status_Pengiriman == 'Selesai')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 border border-green-200 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-green-600">
                                    SELESAI
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 border border-gray-200 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-gray-600">
                                    {{ $item->Status_Pengiriman }}
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center">
                                <a href="{{ route('pengiriman.show', $item->ID_Pengiriman) }}" class="text-gray-400 transition hover:text-[#091426]" title="Detail Pengiriman">
                                    <i class="ri-information-line text-[22px]"></i>
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
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-[16px] font-bold text-[#091426]">Tambah Pengiriman Baru</h3>
                <button onclick="modal_tambah.close()" class="text-gray-400 hover:text-red-500 transition"><i class="ri-close-line text-xl"></i></button>
            </div>

            <form id="form-tambah" action="{{ route('pengiriman.store') }}" method="POST" onsubmit="return validasiFormPengiriman(event)">
                @csrf
                <div class="p-6 space-y-5">

                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Pesanan Siap Kirim</label>
                        <select name="ID_Pesanan" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426] bg-white">
                            <option value="" disabled selected hidden>Pilih ID Pesanan...</option>

                            @forelse ($pesanan as $p)
                                <option value="{{ $p->ID_Pesanan }}">
                                    ID: {{ $p->ID_Pesanan }} - {{ $p->Nama_Pelanggan }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada pesanan yang siap dikirim!</option>
                            @endforelse

                        </select>

                        @if($pesanan->isEmpty())
                            <p class="text-[11px] text-orange-600 mt-1"><i class="ri-error-warning-line"></i> Hanya pesanan Lunas yang muncul di sini.</p>
                        @endif
                    </div>

                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Jadwal Tanggal Kirim</label>
                        <input type="date" name="Tanggal_Kirim" value="{{ date('Y-m-d') }}" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>

                    <input type="hidden" name="Status_Pengiriman" value="Disiapkan">
                </div>

                <div class="bg-[#F8F9FA] px-6 py-4 flex justify-end gap-3 border-t border-gray-100">
                    <button type="button" onclick="modal_tambah.close()" class="h-[40px] rounded border border-gray-300 px-6 text-[12px] font-semibold text-[#45474C] transition hover:bg-gray-50">Batal</button>

                    <button type="submit" {{ $pesanan->isEmpty() ? 'disabled' : '' }} class="h-[40px] rounded bg-[#091426] px-6 text-[12px] font-semibold text-white transition hover:bg-slate-800 disabled:bg-gray-400 disabled:cursor-not-allowed">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validasiFormPengiriman(event) {
            const form = event.target;
            const idPesanan = form.elements['ID_Pesanan'].value;
            const tanggalKirim = form.elements['Tanggal_Kirim'].value;

            if (!idPesanan) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilihan Kosong!',
                    text: 'Silakan pilih ID Pesanan terlebih dahulu.',
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah')
                });
                return false;
            }

            if (!tanggalKirim) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Tanggal Kosong!',
                    text: 'Silakan tentukan Jadwal Tanggal Kirim pengiriman.',
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah')
                });
                return false;
            }

            return true;
        }
    </script>

@endsection
