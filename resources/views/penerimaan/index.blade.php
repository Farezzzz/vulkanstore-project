@extends('layouts.app')
@section('title', 'Data Penerimaan')
@section('content')
    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-[32px] font-bold text-[#091426]">Data Penerimaan</h1>
        <button onclick="modal_tambah.showModal()" class="flex h-[40px] w-[163px] items-center justify-center gap-2 rounded bg-[#091426] text-[12px] font-semibold text-white shadow-sm transition hover:bg-slate-800">
            <i class="ri-add-line text-lg"></i>
            Tambah Penerimaan
        </button>
    </div>

    {{-- Container--}}
    <div class="w-full overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">

        <div class="px-6 py-5">
            <form action="{{ route('penerimaan.index') }}" method="GET" class="flex w-full items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID Penerimaan atau Nama Pemasok..." class="h-[38px] w-[320px] rounded border border-gray-300 pl-10 pr-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>

                    @if(request('search'))
                        <a href="{{ route('penerimaan.index') }}" class="flex h-[38px] items-center rounded bg-red-100 px-4 text-[12px] font-bold text-red-600 transition hover:bg-red-200">Reset</a>
                    @endif
                </div>
                <select name="kategori" onchange="this.form.submit()" class="h-[38px] cursor-pointer rounded border border-gray-300 px-4 text-[12px] font-semibold text-[#45474C] outline-none">
                    <option value="">Filter</option>
                    <option value="INTERNAL (DIVISI VULKANISIR)" {{ request('kategori') == 'INTERNAL (DIVISI VULKANISIR)' ? 'selected' : '' }}>Internal</option>
                    <option value="EXTERNAL" {{ request('kategori') == 'EXTERNAL' ? 'selected' : '' }}>External</option>
                </select>
            </form>
        </div>

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

        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left">
                <thead class="bg-[#F8F9FB]">
                    <tr class="border-y border-gray-200 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
                        <th class="px-6 py-4 w-[10%]">ID</th>
                        <th class="px-6 py-4 w-[15%]">NAMA_PEMASOK</th>
                        <th class="px-6 py-4 w-[30%]">KATEGORI_PEMASOK</th>
                        <th class="px-6 py-4 w-[20%]">TANGGAL_MASUK</th>
                        <th class="px-6 py-4 w-[15%]">TOTAL_BIAYA</th>
                        <th class="px-6 py-4 w-[10%] text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-[14px]">
                    @forelse($penerimaan as $item)
                    <tr class="border-b border-gray-100 transition hover:bg-slate-50">
                        <td class="px-6 py-5 font-semibold text-[#45474C]">{{ $item->ID_Penerimaan }}</td>
                        <td class="px-6 py-5 font-semibold text-[#091426]">{{ $item->pemasok->Nama_Pemasok ?? '-' }}</td>
                        <td class="px-6 py-5 font-semibold text-[#091426]">{{ $item->pemasok->Kategori_Pemasok ?? '-' }}</td>
                        <td class="px-6 py-5 text-[#45474C]">{{ \Carbon\Carbon::parse($item->Tanggal_Masuk)->format('d M Y') }}</td>
                        <td class="px-6 py-5 font-semibold text-[#091426]">Rp {{ number_format($item->Total_Biaya, 0, ',', '.') }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('penerimaan.show', $item->ID_Penerimaan) }}" class="text-gray-500 transition hover:text-[#091426]">
                                    <i class="ri-information-line text-[20px]"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm font-medium text-gray-500">
                            Data penerimaan belum tersedia!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between">
            <span class="text-[14px] text-[#45474C]">
                Menampilkan {{ $penerimaan->firstItem() ?? 0 }} - {{ $penerimaan->lastItem() ?? 0 }} dari {{ $penerimaan->total() }} penerimaan
            </span>
            <div>
                {{ $penerimaan->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <dialog id="modal_tambah" class="modal">
        <div class="modal-box w-[448px] max-w-lg rounded-[8px] bg-white p-6 shadow-lg">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Tambah Penerimaan Baru</h3>

            <form action="{{ route('penerimaan.store') }}" method="POST">
                @csrf

                {{-- STEP 1 --}}
                <div id="step-1">
                    <div class="mb-4">
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Nama Pemasok</label>
                        <select name="ID_Pemasok" id="ID_Pemasok" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426]">
                            <option value="" disabled selected>Pilih pemasok...</option>
                            @foreach($pemasok as $sup)
                                <option value="{{ $sup->ID_Pemasok }}">{{ $sup->Nama_Pemasok }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-8">
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Tanggal Masuk</label>
                        <input type="date" name="Tanggal_Masuk" id="Tanggal_Masuk" value="{{ date('Y-m-d') }}" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426]">
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="modal_tambah.close()" class="h-[38px] rounded border border-gray-300 px-5 text-[12px] font-medium text-[#091426] hover:bg-gray-50">Batal</button>
                        <button type="button" onclick="goToStep2(event)" class="h-[38px] rounded bg-[#091426] px-5 text-[12px] font-medium text-white hover:bg-slate-800">Selanjutnya</button>
                    </div>
                </div>

                {{-- STEP 2 --}}
                <div id="step-2" class="hidden">
                    <div class="mb-4">
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Barang</label>
                        <select id="input_barang" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426]">
                            <option value="" disabled selected>Pilih barang...</option>
                            @foreach($barang as $brg)
                                <option value="{{ $brg->ID_Barang }}" data-nama="{{ $brg->Nama_Barang }}">
                                    {{ $brg->Nama_Barang }} (Stok: {{ $brg->Stok_Tersedia }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <div class="w-1/3">
                            <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Kuantitas</label>
                            <input type="number" id="input_kuantitas" placeholder="10" min="1"
                                class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm outline-none focus:border-[#091426]">
                        </div>
                        <div class="w-2/3">
                            <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Harga Beli/Unit</label>
                            <input type="number" id="input_harga" placeholder="150000" min="0"
                                class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm outline-none focus:border-[#091426]">
                        </div>
                    </div>

                    <button type="button" onclick="tambahBarang()" class="mb-4 flex h-[38px] w-full items-center justify-center rounded bg-[#091426] text-[12px] font-bold text-white transition hover:bg-slate-800">
                        <i class="ri-add-line mr-2 text-[16px]"></i> Tambah Barang Penerimaan
                    </button>

                    <div id="keranjang_list" class="mb-6 max-h-[150px] overflow-y-auto hidden"></div>

                    <div class="flex justify-end gap-3 border-t border-gray-200 pt-4">
                        <button type="button" onclick="goToStep1()" class="h-[38px] rounded border border-gray-300 px-5 text-[12px] font-medium text-[#091426] hover:bg-gray-50">Kembali</button>
                        <button type="submit" onclick="return validasiSubmit()" class="h-[38px] rounded bg-[#091426] px-5 text-[12px] font-medium text-white hover:bg-slate-800">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    {{-- ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', confirmButtonColor: '#091426' });
        @endif

        // Logika Pindah Step
        function goToStep2() {
            if(event) event.preventDefault();
            let idPemasok = document.getElementById('ID_Pemasok').value;
            let tglMasuk = document.getElementById('Tanggal_Masuk').value;

            if (!idPemasok || !tglMasuk) {
                return Swal.fire({
                    icon: 'warning',
                    text: 'Pemasok dan Tanggal wajib diisi!',
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah')
                });
            }

            document.getElementById('step-1').classList.add('hidden');
            document.getElementById('step-2').classList.remove('hidden');
        }

        function goToStep1() {
            const step2 = document.getElementById('step-2');
            const step1 = document.getElementById('step-1');

            if(step2 && step1) {
                step2.classList.add('hidden');
                step1.classList.remove('hidden');
            }
        }

        // Logika Tambah Keranjang
        let idx = 0;
        function tambahBarang() {
            let brg = document.getElementById('input_barang');
            let qty = document.getElementById('input_kuantitas').value;
            let harga = document.getElementById('input_harga').value;

            let hargaInt = parseInt(harga);

            if (!brg.value || qty == "" || harga == "") {
                Swal.fire({
                    icon: 'warning',
                    text: 'Pastikan barang, kuantitas, dan harga beli diisi!',
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah')
                });
                return;
            }

            let errorList = [];
            if (isNaN(qty) || qty <= 0) errorList.push("• Kuantitas tidak boleh kurang dari 1!");
            if (isNaN(harga) || harga < 0) errorList.push("• Harga tidak boleh kurang dari 1!");

            if (errorList.length > 0) {
                return Swal.fire({
                    icon: 'error',
                    html: `<div style="text-align: left;">${errorList.join('<br>')}</div>`,
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah')
                });
            }

            let nama = brg.options[brg.selectedIndex].getAttribute('data-nama');
            let list = document.getElementById('keranjang_list');
            list.classList.remove('hidden');

            list.insertAdjacentHTML('beforeend', `
                <div class="flex justify-between items-center bg-gray-50 p-3 rounded mb-2 border border-gray-200" id="row-${idx}">
                    <div class="text-[12px] text-[#45474C]">
                        <span class="font-bold text-[#091426]">${nama}</span> <br>
                        Qty: ${qty} | Rp ${hargaInt.toLocaleString('id-ID')}

                        <input type="hidden" name="barang[${idx}][ID_Barang]" value="${brg.value}">
                        <input type="hidden" name="barang[${idx}][Kuantitas]" value="${qty}">
                        <input type="hidden" name="barang[${idx}][Harga_Beli]" value="${hargaInt}">
                    </div>
                    <button type="button" onclick="document.getElementById('row-${idx}').remove()" class="text-red-500 hover:text-red-700">
                        <i class="ri-delete-bin-line text-lg"></i>
                    </button>
                </div>
            `);

            idx++;
            brg.value = qty = harga = '';
            document.getElementById('input_kuantitas').value = '';
            document.getElementById('input_harga').value = '';
        }

        function validasiSubmit() {
            if (document.getElementById('keranjang_list').innerHTML.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    text: 'Tambahkan minimal 1 barang ke keranjang!',
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah')
                });
                return false;
            }
            return true;
        }
    </script>
@endsection
