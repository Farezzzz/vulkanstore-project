@extends('layouts.app')
@section('title', 'Data Barang')
@section('content')

    <div class="mb-2 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
        DATA MASTER <span class="mx-2">></span> <span class="text-[#091426]">BARANG</span>
    </div>

    {{-- Header & Tombol Tambah --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-[32px] font-bold text-[#091426]">Data Barang</h1>
        <button onclick="modal_tambah.showModal()" class="flex h-[40px] w-[163px] items-center justify-center gap-2 rounded bg-[#091426] text-[12px] font-semibold text-white shadow-sm transition hover:bg-slate-800">
            <i class="ri-add-line text-lg"></i>
            Tambah Barang
        </button>
    </div>

    {{-- Tab Navigasi Master Data --}}
    <div class="mb-6 flex border-b border-gray-200">
        <a href="{{ route('pemasok.index') }}" class="border-b-2 border-transparent px-6 py-3 text-[12px] font-semibold uppercase text-[#45474C] transition hover:text-[#091426]">Data Pemasok</a>
        <a href="{{ route('barang.index') }}" class="border-b-2 border-[#855300] px-6 py-3 text-[12px] font-semibold uppercase text-[#091426]">Data Barang</a>
        <a href="{{ route('pengguna.index') }}" class="border-b-2 border-transparent px-6 py-3 text-[12px] font-semibold uppercase text-[#45474C] transition hover:text-[#091426]">Data Pengguna</a>
    </div>

    {{-- ALERT SUCCESS --}}
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

    <div class="w-full overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">
        <div class="px-6 py-5">
            <form action="{{ route('barang.index') }}" method="GET" class="flex w-full items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID atau Nama Barang..." class="h-[38px] w-[320px] rounded border border-gray-300 pl-10 pr-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('barang.index') }}" class="flex h-[38px] items-center rounded bg-red-100 px-4 text-[12px] font-bold text-red-600 transition hover:bg-red-200">Reset</a>
                    @endif
                </div>
                <select name="stok_status" onchange="this.form.submit()" class="h-[38px] cursor-pointer rounded border border-gray-300 px-4 text-[12px] font-semibold text-[#45474C] outline-none">
                    <option value="">Filter Stok</option>
                    <option value="menipis" {{ request('stok_status') == 'menipis' ? 'selected' : '' }}>Stok Menipis (<= 15) </option>
                    <option value="aman" {{ request('stok_status') == 'aman' ? 'selected' : '' }}>Stok Aman (> 15) </option>
                </select>
            </form>
        </div>

        <div class="w-full overflow-x-auto border-t border-gray-100">
            <table class="w-full min-w-[800px] text-left">
                <thead class="bg-[#F8F9FB]">
                    <tr class="border-y border-gray-200 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
                        <th class="px-6 py-4">ID_Barang</th>
                        <th class="px-6 py-4">Nama_Barang</th>
                        <th class="px-6 py-4">Kategori_Barang</th>
                        <th class="px-6 py-4">Stok_Tersedia</th>
                        <th class="px-6 py-4">Harga_Jual</th>
                        <th class="px-6 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-[14px]">
                    @forelse($barang as $item)
                    <tr class="border-b border-gray-100 transition hover:bg-slate-50">
                        <td class="px-6 py-5 font-semibold text-[#45474C]">{{ $item->ID_Barang }}</td>
                        <td class="px-6 py-5 font-semibold text-[#45474C]">{{ $item->Nama_Barang }}</td>
                        <td class="px-6 py-5 font-semibold text-[#45474C]">{{ $item->Kategori_Barang }}</td>
                        <td class="px-6 py-5 font-semibold text-[#45474C]">{{ $item->Stok_Tersedia }}</td>
                        <td class="px-6 py-5 font-semibold text-[#45474C]">Rp {{ number_format($item->Harga_Jual, 0, ',', '.') }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-3">
                                <button type="button" onclick='openEditModal(@json($item))' class="text-gray-500 transition hover:text-[#091426]">
                                    <i class="ri-pencil-line text-[18px]"></i>
                                </button>
                                <form action="{{ route('barang.destroy', $item->ID_Barang) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="text-red-500 transition hover:text-red-700" onclick="confirmDelete(this)">
                                        <i class="ri-delete-bin-line text-[18px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-sm font-medium text-gray-500">Data barang tidak ditemukan!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between">
            <span class="text-[14px] text-[#45474C]">
                Menampilkan {{ $barang->firstItem() ?? 0 }} - {{ $barang->lastItem() ?? 0 }} dari {{ $barang->total() }} barang
            </span>
            <div>
                {{ $barang->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH  --}}
    <dialog id="modal_tambah" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-6 shadow-lg">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Tambah Barang Baru</h3>
            <form action="{{ route('barang.store') }}" method="POST" onsubmit="return validasiForm(event, 'modal_tambah')">
                @csrf
                <div class="mb-4">
                    <label class="mb-2 block text-[12px] font-semibold text-[#091426]">NAMA BARANG</label>
                    <input type="text" id="input_nama" name="Nama_Barang" placeholder="Contoh: Baut Baja 10mm" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                </div>
                <div class="mb-4">
                    <label class="mb-2 block text-[12px] font-semibold text-[#091426]">KATEGORI BARANG</label>
                    <input type="text" id="input_kategori" name="Kategori_Barang" placeholder="Contoh: Material Bangunan" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">STOK</label>
                        <input type="number" id="input_stok" name="Stok_Tersedia" placeholder="0" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>
                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">HARGA JUAL</label>
                        <input type="number" id="input_harga" name="Harga_Jual" placeholder="Rp 0" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="modal_tambah.close()" class="h-[40px] rounded border border-gray-300 px-5 text-[12px] font-semibold text-[#45474C] transition hover:bg-gray-50">Batal</button>
                    <button type="submit" class="h-[40px] rounded bg-[#091426] px-5 text-[12px] font-semibold text-white transition hover:bg-slate-800">Simpan Data</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- MODAL EDIT --}}
    <dialog id="modal_edit" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-6 shadow-lg">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Edit Data Barang</h3>
            <form id="form_edit" action="" method="POST" onsubmit="return validasiForm(event, 'modal_edit')">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="mb-2 block text-[12px] font-semibold text-[#091426]">NAMA BARANG</label>
                    <input type="text" id="edit_nama" name="Nama_Barang" placeholder="Ubah nama barang..." class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                </div>
                <div class="mb-4">
                    <label class="mb-2 block text-[12px] font-semibold text-[#091426]">KATEGORI BARANG</label>
                    <input type="text" id="edit_kategori" name="Kategori_Barang" placeholder="Ubah kategori..." class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">STOK</label>
                        <input type="number" id="edit_stok" name="Stok_Tersedia" placeholder="0" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>
                    <div>
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">HARGA JUAL</label>
                        <input type="number" id="edit_harga" name="Harga_Jual" placeholder="Rp 0" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="modal_edit.close()" class="h-[40px] rounded border border-gray-300 px-5 text-[12px] font-semibold text-[#45474C] transition hover:bg-gray-50">Batal</button>
                    <button type="submit" class="h-[40px] rounded bg-[#091426] px-5 text-[12px] font-semibold text-white transition hover:bg-slate-800">Update Data</button>
                </div>
            </form>
        </div>
    </dialog>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validasiForm(event, modalId) {
            const form = event.target;
            const nama = form.elements['Nama_Barang'].value.trim();
            const kategori = form.elements['Kategori_Barang'].value.trim();
            const stok = form.elements['Stok_Tersedia'].value.trim();
            const harga = form.elements['Harga_Jual'].value.trim();

            if (!nama || !kategori || !stok || !harga) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap!',
                    text: 'Pastikan Nama, Kategori, Stok, dan Harga sudah terisi semua!',
                    confirmButtonColor: '#091426',
                    target: document.getElementById(modalId)
                });
                return false;
            }
            const regexAngkaBulat = /^\d+$/;

                if (!regexAngkaBulat.test(stok) || !regexAngkaBulat.test(harga)) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Stok atau Harga Jual tidak sesuai!',
                        text: 'Stok dan Harga Jual harus berupa angka bulat positif (tidak boleh minus, desimal, atau huruf e)!',
                        confirmButtonColor: '#d33',
                        target: document.getElementById(modalId)
                    });
                    return false;
                }

            return true;
        }

        function openEditModal(data) {
            document.getElementById('form_edit').action = `/barang/${data.ID_Barang}`;
            document.getElementById('edit_nama').value = data.Nama_Barang;
            document.getElementById('edit_kategori').value = data.Kategori_Barang;
            document.getElementById('edit_stok').value = data.Stok_Tersedia;
            document.getElementById('edit_harga').value = data.Harga_Jual;
            document.getElementById('modal_edit').showModal();
        }

        function confirmDelete(button) {
            Swal.fire({
                title: 'Yakin mau dihapus?',
                text: "Data yang dihapus tidak bisa dipulihkan kembali!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#091426',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) { button.closest('.delete-form').submit(); }
            });
        }
    </script>
@endsection
