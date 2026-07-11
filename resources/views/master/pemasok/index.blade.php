@extends('layouts.app')
@section('title', 'Data Pemasok')
@section('content')

    <div class="mb-2 text-[12px] font-semibold uppercase tracking-wide text-[#45474C]">
        DATA MASTER <span class="mx-2">></span> <span class="text-[#091426]">PEMASOK</span>
    </div>

    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-[32px] font-bold text-[#091426]">Data Pemasok</h1>

        <button onclick="modal_tambah.showModal()" class="flex h-[40px] w-[163px] items-center justify-center gap-2 rounded bg-[#091426] text-[12px] font-semibold text-white shadow-sm transition hover:bg-slate-800">
            <i class="ri-add-line text-lg"></i>
            Tambah Pemasok
        </button>
    </div>

    <div class="mb-6 flex border-b border-gray-200">
        <a href="{{ route('pemasok.index') }}" class="border-b-2 border-[#855300] px-6 py-3 text-[12px] font-semibold uppercase text-[#091426]">Data Pemasok</a>
        <a href="#" class="border-b-2 border-transparent px-6 py-3 text-[12px] font-semibold uppercase text-[#45474C] transition hover:text-[#091426]">Data Barang</a>
        <a href="#" class="border-b-2 border-transparent px-6 py-3 text-[12px] font-semibold uppercase text-[#45474C] transition hover:text-[#091426]">Data Pengguna</a>
    </div>

    <div class="w-full overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">

        <div class="px-6 py-5">
            <form action="{{ route('pemasok.index') }}" method="GET" class="flex w-full items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pemasok..." class="h-[38px] w-[320px] rounded border border-gray-300 pl-10 pr-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>

                    @if(request('search') || request('kategori'))
                        <a href="{{ route('pemasok.index') }}" class="flex h-[38px] items-center rounded bg-red-100 px-4 text-[12px] font-bold text-red-600 transition hover:bg-red-200">Reset</a>
                    @endif
                </div>

                <select name="kategori" onchange="this.form.submit()" class="h-[38px] cursor-pointer rounded border border-gray-300 px-4 text-[12px] font-semibold text-[#45474C] outline-none hover:bg-gray-50 focus:border-[#091426]">
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
                        <th class="px-6 py-4">ID_Pemasok</th>
                        <th class="px-6 py-4">Nama_Pemasok</th>
                        <th class="px-6 py-4">KATEGORI_PEMASOK</th>
                        <th class="px-6 py-4">Kontak_Pemasok</th>
                        <th class="px-6 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-[14px]">
                    @forelse($pemasok as $item)
                    <tr class="border-b border-gray-100 transition hover:bg-slate-50">
                        <td class="px-6 py-5 font-semibold text-[#45474C]">{{ $item->ID_Pemasok }}</td>
                        <td class="px-6 py-5 font-semibold text-[#45474C]">{{ $item->Nama_Pemasok }}</td>
                        <td class="px-6 py-5">
                            <span class="rounded bg-gray-100 px-3 py-1 text-[11px] font-bold text-[#45474C] outline outline-1 outline-gray-300">{{ $item->Kategori_Pemasok }}</span>
                        </td>
                        <td class="px-6 py-5 font-semibold text-[#45474C]">{{ $item->Kontak_Pemasok }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-3">
                                <button type="button"
                                    onclick='openEditModal(@json($item))'
                                    class="text-gray-500 transition hover:text-[#091426]">
                                    <i class="ri-pencil-line text-[18px]"></i>
                                </button>
                                <form action="{{ route('pemasok.destroy', $item->ID_Pemasok) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-500 transition hover:text-red-700" onclick="confirmDelete(this)">
                                        <i class="ri-delete-bin-line text-[18px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm font-medium text-gray-500">
                            Data pemasok tidak ditemukan!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-200 px-6 py-4">
            {{ $pemasok->withQueryString()->links() }}
        </div>
    </div>

    <dialog id="modal_tambah" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-6 shadow-lg">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Tambah Pemasok Baru</h3>

            <form action="{{ route('pemasok.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="mb-2 block text-[12px] font-semibold text-[#091426]">NAMA PEMASOK</label>
                    <input type="text" name="Nama_Pemasok" required placeholder="Contoh: PT. Logistik Jaya" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                </div>

                <div class="mb-4">
                    <label class="mb-2 block text-[12px] font-semibold text-[#091426]">KONTAK PEMASOK</label>
                    <input type="text" name="Kontak_Pemasok" required placeholder="Contoh: 0812-xxxx-xxxx" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                </div>

                <div class="mb-6">
                    <label class="mb-2 block text-[12px] font-semibold text-[#091426]">KATEGORI PEMASOK</label>
                    <select name="Kategori_Pemasok" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                        <option value="" disabled selected>Pilih Kategori...</option>
                        <option value="EXTERNAL">External</option>
                        <option value="INTERNAL (DIVISI VULKANISIR)">Internal (Divisi Vulkanisir)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="modal_tambah.close()" class="h-[40px] rounded border border-gray-300 px-5 text-[12px] font-semibold text-[#45474C] transition hover:bg-gray-50">Batal</button>
                    <button type="submit" class="h-[40px] rounded bg-[#091426] px-5 text-[12px] font-semibold text-white transition hover:bg-slate-800">Simpan Data</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <dialog id="modal_edit" class="modal">
        <div class="modal-box rounded-[8px] bg-white p-6 shadow-lg">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Edit Data Pemasok</h3>

            <form id="form_edit" action="" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="mb-2 block text-[12px] font-semibold text-[#091426]">NAMA PEMASOK</label>
                    <input type="text" id="edit_nama" name="Nama_Pemasok" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                </div>

                <div class="mb-4">
                    <label class="mb-2 block text-[12px] font-semibold text-[#091426]">KONTAK PEMASOK</label>
                    <input type="text" id="edit_kontak" name="Kontak_Pemasok" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                </div>

                <div class="mb-6">
                    <label class="mb-2 block text-[12px] font-semibold text-[#091426]">KATEGORI PEMASOK</label>
                    <select id="edit_kategori" name="Kategori_Pemasok" required class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                        <option value="INTERNAL (DIVISI VULKANISIR)">Internal (Divisi Vulkanisir)</option>
                        <option value="EXTERNAL">External</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="modal_edit.close()" class="h-[40px] rounded border border-gray-300 px-5 text-[12px] font-semibold text-[#45474C] transition hover:bg-gray-50">Batal</button>
                    <button type="submit" class="h-[40px] rounded bg-[#091426] px-5 text-[12px] font-semibold text-white transition hover:bg-slate-800">Update Data</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        function openEditModal(data) {
            console.log("Data yang ditangkep:", data);

            document.getElementById('form_edit').action = `/pemasok/${data.ID_Pemasok}`;

            document.getElementById('edit_nama').value = data.Nama_Pemasok;
            document.getElementById('edit_kontak').value = data.Kontak_Pemasok;
            document.getElementById('edit_kategori').value = data.Kategori_Pemasok;

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
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('.delete-form').submit();
                }
            });
        }
    </script>
@endsection
