@extends('layouts.app')
@section('title', 'Data Pengguna')
@section('content')

    <div class="mb-2 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
        DATA MASTER <span class="mx-2">></span> <span class="text-[#091426]">PENGGUNA</span>
    </div>

    {{-- Header & Tombol Tambah --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-[32px] font-bold text-[#091426]">Data Pengguna</h1>
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

    {{-- Container Tabel & Filter --}}
    <div class="w-full overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">

        {{-- Bar Pencarian --}}
        <div class="px-6 py-5">
            <form action="{{ route('pengguna.index') }}" method="GET" class="flex w-full items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID atau Nama Pengguna..." class="h-[38px] w-[320px] rounded border border-gray-300 pl-10 pr-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>

                    @if(request()->anyFilled(['search']))
                        <a href="{{ route('pengguna.index') }}" class="flex h-[38px] items-center rounded bg-red-100 px-4 text-[12px] font-bold text-red-600 transition hover:bg-red-200">Reset</a>
                    @endif
                </div>

                <select name="status" onchange="this.form.submit()" class="h-[38px] cursor-pointer rounded border border-gray-300 px-4 text-[12px] font-semibold text-[#45474C] outline-none hover:bg-gray-50 focus:border-[#091426]">
                    <option value="">Filter Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
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
                    <td class="px-6 py-4 font-semibold text-[#091426]">{{ $item->ID_Pengguna }}</td>
                    <td class="px-6 py-4 font-semibold text-[#091426]">{{ $item->Nama_Lengkap }}</td>
                    <td class="px-6 py-4 font-semibold text-[#091426]">{{ $item->Email }}</td>
                    <td class="px-6 py-4 font-semibold text-[#091426]">
                        <span class="uppercase font-semibold text-[#091426]">
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
                            <button onclick='bukaModalEdit(@json($item))' class="text-gray-400 hover:text-blue-600 transition">
                                <i class="ri-pencil-line text-base"></i>
                            </button>
                            @if(auth()->id() != $item->ID_Pengguna)
                                <form action="{{ route('pengguna.destroy', $item->ID_Pengguna) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-500 hover:text-red-700" onclick="confirmDelete(this)">
                                        <i class="ri-delete-bin-line text-[18px]"></i>
                                    </button>
                                </form>
                            @endif
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
        <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between">
            <span class="text-[14px] text-[#45474C]">
                Menampilkan {{ $pengguna->firstItem() ?? 0 }} - {{ $pengguna->lastItem() ?? 0 }} dari {{ $pengguna->total() }} pengguna
            </span>
            <div>
                {{ $pengguna->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <dialog id="modal_tambah" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-6 shadow-lg max-w-md">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Tambah Pengguna Baru</h3>
            <form action="{{ route('pengguna.store') }}" method="POST" class="space-y-4" onsubmit="return validasiForm(event, 'modal_tambah')">
                @csrf
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Nama Lengkap</label>
                    <input type="text" name="Nama_Lengkap" placeholder="Contoh: Budi Pratama" class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Email</label>
                    <input type="text" name="Email" placeholder="Contoh: budi@vulkanstore.com" class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Role</label>
                    <input type="text" name="Role" value="Admin" readonly class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Kata Sandi</label>
                    <input type="password" name="Kata_Sandi" placeholder="Masukkan kata sandi..." class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Status</label>
                    <input type="text" name="Status_Aktif" value="Aktif" readonly class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>

                <div class="h-6"></div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="modal_tambah.close()" class="h-[40px] rounded border border-gray-300 px-5 text-[12px] font-semibold text-[#45474C] bg-white hover:bg-gray-50 transition">Batal</button>
                    <button type="submit" class="h-[40px] rounded bg-[#091426] px-5 text-[12px] font-semibold text-white hover:bg-slate-800 transition">Simpan</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    {{-- MODAL EDIT --}}
    <dialog id="modal_edit" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-6 shadow-lg max-w-md">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Ubah Data Pengguna</h3>
            <form id="form_edit" method="POST" class="space-y-4" onsubmit="return validasiForm(event, 'modal_edit')">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Nama Lengkap</label>
                    <input type="text" id="edit_nama" name="Nama_Lengkap" placeholder="Ubah nama pengguna..." class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Email</label>
                    <input type="text" id="edit_email" name="Email" placeholder="Ubah email pengguna..." class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Role</label>
                    <input type="text" id="edit_role" name="Role" readonly class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Kata Sandi Baru <span class="text-gray-400 font-normal">(Kosongkan jika tidak diganti)</span></label>
                    <input type="password" name="Kata_Sandi" placeholder="Ketik sandi baru..." class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400">
                </div>
                <div>
                    <label class="block text-[12px] font-semibold text-[#45474C] mb-1">Status</label>
                    <select id="edit_status" name="Status_Aktif" class="w-full h-[40px] rounded border border-gray-200 px-3 text-[13px] outline-none focus:border-gray-400 bg-white">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="h-6"></div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="modal_edit.close()" class="h-[40px] rounded border border-gray-300 px-5 text-[12px] font-semibold text-[#45474C] bg-white hover:bg-gray-50 transition">Batal</button>
                    <button type="submit" class="h-[40px] rounded bg-[#091426] px-5 text-[12px] font-semibold text-white hover:bg-slate-800 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validasiForm(event, modalId) {
            const form = event.target;

            const nama = form.elements['Nama_Lengkap'].value.trim();
            const email = form.elements['Email'].value.trim();
            const role = form.elements['Role'].value.trim();
            const password = form.elements['Kata_Sandi'].value.trim();

            if (!nama || !email || (modalId === 'modal_tambah' && !password)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap!',
                    text: 'Pastikan Nama, Email, dan Password sudah terisi semua!',
                    confirmButtonColor: '#091426',
                    target: document.getElementById(modalId)
                });
                return false;
            }
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regexEmail.test(email)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Format Email tidak sesuai!',
                    text: 'Gunakan "@" di email (contoh: admin@gmail.com)!',
                    confirmButtonColor: '#d33',
                    target: document.getElementById(modalId)
                });
                form.elements['Email'].focus();

                return false;
            }
            return true;
        }

        function bukaModalEdit(user) {
            document.getElementById('form_edit').action = `/pengguna/${user.ID_Pengguna}`;
            document.getElementById('edit_nama').value = user.Nama_Lengkap;
            document.getElementById('edit_email').value = user.Email;
            document.getElementById('edit_role').value = user.Role;
            document.getElementById('edit_status').value = user.Status_Aktif;
            modal_edit.showModal();
        }

        function confirmDelete(button) {
            Swal.fire({
                title: 'Yakin mau dihapus?',
                text: "Data yang dihapus tidak bisa dipulihkan kembali!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#091426',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) { button.closest('.delete-form').submit(); }
            });
        }
    </script>

@endsection
