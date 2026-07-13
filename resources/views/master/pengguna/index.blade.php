@extends('layouts.app')
@section('title', 'Data Pengguna')
@section('content')

    {{-- Breadcrumbs --}}
    <div class="mb-2 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
        DATA MASTER <span class="mx-2">></span> <span class="text-[#091426]">PENGGUNA</span>
    </div>

    {{-- Header & Tombol Tambah --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-[32px] font-bold text-[#091426]">Data Pengguna</h1>

        {{-- PERBAIKAN: Menggunakan ikon plus (+) dan padding dinamis agar tidak terpotong --}}
        <button onclick="modal_tambah.showModal()" class="flex h-[40px] items-center justify-center gap-2 rounded bg-[#091426] px-4 text-[13px] font-semibold text-white shadow-sm transition hover:bg-slate-800">
            <i class="ri-add-line text-base"></i>
            Tambah Pengguna
        </button>
    </div>

    {{-- Tab Navigasi Master Data --}}
    <div class="mb-6 flex border-b border-gray-200">
        <a href="{{ route('pemasok.index') }}" class="border-b-2 border-transparent px-6 py-3 text-[12px] font-semibold uppercase text-[#45474C] transition hover:text-[#091426]">Data Pemasok</a>
        <a href="{{ route('barang.index') }}" class="border-b-2 border-transparent px-6 py-3 text-[12px] font-semibold uppercase text-[#45474C] transition hover:text-[#091426]">Data Barang</a>
        <a href="{{ route('pengguna.index') }}" class="border-b-2 border-[#855300] px-6 py-3 text-[12px] font-semibold uppercase text-[#091426]">Data Pengguna</a>
    </div>

    {{-- Container Tabel & Filter --}}
    <div class="w-full overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">
        
        {{-- Bar Pencarian --}}
        <div class="p-6 border-b border-gray-100">
            <form action="{{ route('pengguna.index') }}" method="GET" class="relative w-[300px]">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                    class="h-[40px] w-full rounded border border-gray-200 pl-10 pr-4 text-[13px] outline-none focus:border-gray-400">
            </form>
        </div>

        {{-- Tabel Data --}}
        <table class="w-full text-left text-[13px] text-[#45474C]">
            <thead class="bg-gray-50 text-[11px] font-bold uppercase tracking-wider text-[#45474C] border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 w-[120px]">ID_PENGGUNA</th>
                    <th class="px-6 py-4">NAMA LENGKAP</th>
                    <th class="px-6 py-4">EMAIL</th>
                    <th class="px-6 py-4">ROLE</th>
                    <th class="px-6 py-4">STATUS</th>
                    <th class="px-6 py-4 w-[100px] text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($pengguna as $item)
                <tr class="hover:bg-gray-50/70 transition">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->ID_Pengguna }}</td>
                    <td class="px-6 py-4 font-semibold text-[#091426]">{{ $item->Nama_Lengkap }}</td>
                    <td class="px-6 py-4">{{ $item->Email }}</td>
                    <td class="px-6 py-4">
                        <span class="uppercase text-slate-700 font-medium">
                            {{ $item->Role }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->Status_Aktif == 'Aktif')
                            <span class="inline-flex items-center gap-1 text-green-600 font-medium">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-red-500 font-medium">
                                Tidak Aktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-4">
                            {{-- Tombol Edit --}}
                            <button onclick="bukaModalEdit({{ json_encode($item) }})" class="text-gray-400 hover:text-blue-600 transition">
                                <i class="ri-pencil-line text-base"></i>
                            </button>
                            {{-- PERBAIKAN: Mengubah warna default menjadi merah (text-red-500) sama persis seperti gambar 2 --}}
                            <button onclick="bukaModalHapus({{ $item->ID_Pengguna }}, '{{ $item->Nama_Lengkap }}')" class="text-red-500 hover:text-red-700 transition">
                                <i class="ri-delete-bin-line text-base"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                        Data pengguna tidak ditemukan atau masih kosong.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($pengguna->hasPages())
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $pengguna->withQueryString()->links() }}
        </div>
        @endif
    </div>

    {{-- ==================== MODAL TAMBAH ==================== --}}
    <dialog id="modal_tambah" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-6 shadow-lg max-w-md">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Tambah Pengguna Baru</h3>
            <form action="{{ route('pengguna.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Nama Lengkap</label>
                    {{-- PERBAIKAN 1: Menambahkan placeholder contoh nama --}}
                    <input type="text" name="Nama_Lengkap" required placeholder="Contoh: Budi Pratama" class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Email</label>
                    {{-- PERBAIKAN 2: Menambahkan placeholder contoh email --}}
                    <input type="email" name="Email" required placeholder="Contoh: budi@vulkanstore.com" class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Role</label>
                    <input type="text" name="Role" required placeholder="Contoh: Admin / Gudang" class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Kata Sandi</label>
                    <input type="password" name="Kata_Sandi" required class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Status</label>
                    <select name="Status_Aktif" required class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400 bg-white">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>

                {{-- PERBAIKAN 3: Spacer div setinggi 24px (h-6) agar tombol tidak menempel --}}
                <div class="h-6"></div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="modal_tambah.close()" class="h-[40px] rounded border border-gray-300 px-5 text-[12px] font-semibold text-[#45474C] bg-white hover:bg-gray-50 transition">Batal</button>
                    <button type="submit" class="h-[40px] rounded bg-[#091426] px-5 text-[12px] font-semibold text-white hover:bg-slate-800 transition">Simpan</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>
    {{-- ==================== MODAL EDIT ==================== --}}
    <dialog id="modal_edit" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-6 shadow-lg max-w-md">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Ubah Data Pengguna</h3>
            <form id="form_edit" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Nama Lengkap</label>
                    <input type="text" id="edit_nama" name="Nama_Lengkap" required class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Email</label>
                    <input type="email" id="edit_email" name="Email" required class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Role</label>
                    {{-- PERBAIKAN 1: Ditambahkan atribut 'readonly' dan styling background abu-abu tipis biar mutlak ga bisa diedit --}}
                    <input type="text" id="edit_role" name="Role" readonly class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Kata Sandi Baru <span class="text-gray-400 font-normal">(Kosongkan jika tidak diganti)</span></label>
                    <input type="password" name="Kata_Sandi" class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Status</label>
                    <select id="edit_status" name="Status_Aktif" required class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400 bg-white">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                
                {{-- SOLUSI NYATA: Spacer div setinggi 24px (h-6) untuk memaksa tombol turun kebawah --}}
                <div class="h-6"></div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="modal_edit.close()" class="h-[40px] rounded border border-gray-300 px-5 text-[12px] font-semibold text-[#45474C] bg-white hover:bg-gray-50 transition">Batal</button>
                    <button type="submit" class="h-[40px] rounded bg-[#091426] px-5 text-[12px] font-semibold text-white hover:bg-slate-800 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    {{-- ==================== MODAL HAPUS ==================== --}}
    <dialog id="modal_hapus" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-6 shadow-lg max-w-sm text-center">
            <i class="ri-error-warning-line text-5xl text-red-500 block mb-2"></i>
            <h3 class="text-[18px] font-bold text-[#091426] mb-1">Hapus Pengguna?</h3>
            <p class="text-[13px] text-[#45474C] mb-6">Kamu akan menghapus pengguna <span id="hapus_nama" class="font-bold text-red-600"></span>. Tindakan ini tidak dapat dibatalkan.</p>
            <form id="form_hapus" method="POST" class="flex justify-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="modal_hapus.close()" class="h-[40px] rounded border border-gray-300 px-5 text-[12px] font-semibold text-[#45474C]">Batal</button>
                <button type="submit" class="h-[40px] rounded bg-red-600 px-5 text-[12px] font-semibold text-white hover:bg-red-700">Ya, Hapus</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    {{-- Script Otomatis Mengisi Data Modal Edit dan Hapus --}}
    <script>
        function bukaModalEdit(user) {
            document.getElementById('form_edit').action = `/pengguna/${user.ID_Pengguna}`;
            document.getElementById('edit_nama').value = user.Nama_Lengkap;
            document.getElementById('edit_email').value = user.Email;
            document.getElementById('edit_role').value = user.Role;
            document.getElementById('edit_status').value = user.Status_Aktif;
            modal_edit.showModal();
        }

        function bukaModalHapus(id, nama) {
            document.getElementById('form_hapus').action = `/pengguna/${id}`;
            document.getElementById('hapus_nama').textContent = nama;
            modal_hapus.showModal();
        }
    </script>

@endsection