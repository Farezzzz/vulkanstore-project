@extends('layouts.app')
@section('title', 'Data Pesanan')
@section('content')

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-[32px] font-bold text-[#091426]">Data Pesanan</h1>
        <button onclick="modal_tambah.showModal()" class="flex h-[40px] w-[163px] items-center justify-center gap-2 rounded bg-[#091426] text-[12px] font-semibold text-white shadow-sm transition hover:bg-slate-800">
            <i class="ri-add-line text-lg"></i>
            Tambah Pesanan
        </button>
    </div>

    {{-- CONTAINER --}}
    <div class="w-full overflow-hidden rounded-[8px] border border-gray-200 bg-white shadow-sm">

        <div class="px-6 py-5">
            <form action="{{ route('pesanan.index') }}" method="GET" class="flex w-full items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID_Pesanan atau Nama Pelanggan..." class="h-[38px] w-[320px] rounded border border-gray-300 pl-10 pr-4 text-sm text-[#091426] outline-none focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('pesanan.index') }}" class="flex h-[38px] items-center rounded bg-red-100 px-4 text-[12px] font-bold text-red-600 transition hover:bg-red-200">Reset</a>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <select name="status" onchange="this.form.submit()" class="h-[38px] cursor-pointer rounded border border-gray-300 px-4 text-[12px] font-semibold text-[#45474C] outline-none">
                    <option value="">Filter</option>
                    <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Belum Lunas" {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                </div>
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

        {{-- TABEL DATA PESANAN --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] text-left">
                <thead class="bg-[#F8F9FB]">
                    <tr class="border-y border-gray-200 text-[11px] font-semibold uppercase tracking-wider text-[#45474C]">
                        <th class="px-6 py-4 w-[3%]">ID</th>
                        <th class="px-6 py-4 w-[10%]">Nama_Pelanggan</th>
                        <th class="px-6 py-4 w-[10%]">Tanggal</th>
                        <th class="px-6 py-4 max-w-[50px]">Alamat</th>
                        <th class="px-6 py-4 w-[12%]">Total_Tagihan</th>
                        <th class="px-6 py-4 text-center w-[14%]">Pembayaran</th>
                        <th class="px-6 py-4 text-center w-[9%]">Status</th>
                        <th class="px-6 py-4 text-center w-[14%]">Metode</th>
                        <th class="px-6 py-4 text-center w-[3%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[13px]">
                    @forelse($pesanan as $item)
                    <tr class="border-b border-gray-100 transition hover:bg-slate-50">
                        <td class="px-6 py-5 font-bold text-[#45474C]">{{ $item->ID_Pesanan }}</td>
                        <td class="px-6 py-5 font-bold text-[#091426]">{{ $item->Nama_Pelanggan }}</td>
                        <td class="px-6 py-5 text-[#45474C] font-medium">
                            {{ $item->Tanggal ? \Carbon\Carbon::parse($item->Tanggal)->format('d M Y') : '-' }}
                        </td>

                        {{-- ALAMAT DENGAN EFEK TRUNCATE (...) --}}
                        <td class="px-6 py-5 text-[#45474C] font-medium truncate max-w-[200px]" title="{{ $item->Alamat }}">
                            {{ $item->Alamat }}
                        </td>

                        <td class="px-6 py-5 font-bold text-[#091426]">
                            Rp {{ number_format($item->Total_Tagihan, 0, ',', '.') }}
                        </td>

                        {{-- BADGE STATUS PEMBAYARAN --}}
                        <td class="px-6 py-5 text-center">
                            @if($item->Status_Pembayaran == 'Lunas')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 border border-green-200 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-green-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> LUNAS
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 border border-red-200 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-red-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span> BELUM LUNAS
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-5 text-center">
                            @if($item->Status_Pesanan == 'Selesai')
                                <span class="inline-flex items-center rounded bg-green-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-green-700">
                                    SELESAI
                                </span>
                            @elseif($item->Status_Pesanan == 'Diproses')
                                <span class="inline-flex items-center rounded bg-yellow-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-yellow-700">
                                    DIPROSES
                                </span>
                            @else
                                <span class="inline-flex items-center rounded bg-red-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-red-700">
                                    DIBATALKAN
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <span class="rounded bg-gray-100 px-3 py-1 text-[11px] font-bold text-[#45474C] outline outline-1 outline-gray-300">{{ $item->Metode_Pengiriman }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center">
                                <a href="{{ route('pesanan.show', $item->ID_Pesanan) }}" class="text-gray-400 transition hover:text-[#091426]" title="Detail Pesanan">
                                    <i class="ri-information-line text-[22px]"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-sm font-medium text-gray-500">
                            Data transaksi pesanan tidak ditemukan!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="border-t border-gray-200 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-[14px] text-[#45474C]">
                Menampilkan {{ $pesanan->firstItem() ?? 0 }} - {{ $pesanan->lastItem() ?? 0 }} dari {{ $pesanan->total() }} pesanan
            </span>
            <div>
                {{ $pesanan->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <dialog id="modal_tambah" class="modal">
        <div class="modal-box w-[448px] max-w-lg rounded-[8px] bg-white p-6 shadow-lg">
            <h3 class="mb-5 text-[20px] font-bold text-[#091426]">Tambah Pesanan Baru</h3>

            <form action="{{ route('pesanan.store') }}" method="POST" id="form_tambah_pesanan">
                @csrf

                {{-- STEP 1 --}}
                <div id="step-1">
                    <div class="mb-4">
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Nama Pelanggan</label>
                        <input type="text" id="input_nama" name="Nama_Pelanggan" placeholder="Masukkan nama pelanggan" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426]">
                    </div>

                    <div class="mb-4">
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Tanggal Pesanan</label>
                        <input type="date" id="input_tanggal" name="Tanggal" value="{{ date('Y-m-d') }}" max="{{ now()->toDateString() }}" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426]">
                    </div>

                    <div class="mb-4">
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Alamat Lengkap</label>
                        <textarea id="input_alamat" name="Alamat" rows="2" placeholder="Masukkan alamat pengiriman" class="w-full rounded border border-slate-300 p-4 text-sm text-[#091426] outline-none focus:border-[#091426]"></textarea>
                    </div>

                    <div class="mb-8">
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Jarak Tempuh (km)</label>
                        <input type="number" id="input_jarak" name="Jarak_Tempuh_Km" placeholder="Contoh: 15" min="0.1" step="0.1" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426]">
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
                        <select id="input_barang" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426] bg-white">
                            <option value="" disabled selected hidden>Pilih atau masukan nama barang...</option>
                            @foreach($barangList as $barang)
                                <option value="{{ $barang->ID_Barang }}" data-nama="{{ $barang->Nama_Barang }}" data-harga="{{ $barang->Harga_Jual }}">
                                    {{ $barang->Nama_Barang }} (Stok: {{ $barang->Stok_Tersedia ?? 0 }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="mb-2 block text-[12px] font-semibold text-[#091426]">Kuantitas</label>
                        <input type="number" id="input_kuantitas" placeholder="Contoh: 10" min="1" class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none focus:border-[#091426]">
                    </div>

                    <button type="button" onclick="tambahBarang()" class="mb-4 flex h-[38px] w-full items-center justify-center rounded bg-[#091426] text-[12px] font-bold text-white transition hover:bg-slate-800">
                        <i class="ri-add-line mr-2 text-[16px]"></i> Tambah Barang Pesanan
                    </button>

                    <div id="keranjang_list" class="mb-6 max-h-[150px] overflow-y-auto hidden"></div>

                    {{-- Box Layak --}}
                    <div id="box_kelayakan" class="mb-6 p-4 rounded border hidden">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Hasil Analisis Pengiriman</p>
                        <div class="flex items-center justify-between">
                            <p id="teks_metode" class="text-[16px] font-extrabold"></p>
                            <span id="badge_metode" class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-bold"></span>
                        </div>
                        <p id="teks_alasan" class="text-[12px] font-medium text-orange-600 mt-1 flex items-start gap-1 hidden">
                            <i class="ri-error-warning-fill text-[14px]"></i> <span></span>
                        </p>
                        <div class="mt-2 text-[12px] font-bold text-[#091426] border-t border-gray-200 pt-2">
                            Estimasi Harga Rp.<span id="teks_total_belanja">0</span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-gray-200 pt-4">
                        <button type="button" onclick="goToStep1()" class="h-[38px] rounded border border-gray-300 px-5 text-[12px] font-medium text-[#091426] hover:bg-gray-50">Kembali</button>
                        <button type="submit" onclick="return validasiSubmit()" class="h-[38px] rounded bg-[#091426] px-5 text-[12px] font-medium text-white hover:bg-slate-800">Simpan Data</button>
                    </div>
                </div>

            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    {{--JAVASCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($errors->any())
            let errorHtml = '<ul style="text-align: left; margin-left: 20px;">';
            @foreach ($errors->all() as $error)
                errorHtml += '<li>{{ $error }}</li>';
            @endforeach
            errorHtml += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                html: errorHtml,
                confirmButtonColor: '#091426'
            });
        @endif

        // Logika Pindah Step
        function goToStep2(event) {
            if(event) event.preventDefault();

            let nama = document.getElementById('input_nama').value;
            let tanggal = document.getElementById('input_tanggal').value;
            let alamat = document.getElementById('input_alamat').value;
            let jarak = document.getElementById('input_jarak').value;

            if (!nama || !tanggal || !alamat || !jarak) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap!',
                    text: 'Pastikan Nama, Tanggal, Alamat, dan Jarak diisi!',
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah')
                });
            }

            if (parseFloat(jarak) <= 0) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Format Jarak tidak sesuai!',
                    text: 'Jarak tempuh tidak valid! Harus lebih dari 0 km.',
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah')
                });
            }

            document.getElementById('step-1').classList.add('hidden');
            document.getElementById('step-2').classList.remove('hidden');
        }

        function goToStep1() {
            document.getElementById('step-2').classList.add('hidden');
            document.getElementById('step-1').classList.remove('hidden');
        }

        // Logika Keranjang
        let idx = 0;
        let totalBelanja = 0;
        let barangDiKeranjang = [];

        function tambahBarang() {
            let brg = document.getElementById('input_barang');
            let qty = parseInt(document.getElementById('input_kuantitas').value);
            let idBarang = brg.value;

            if (!idBarang || isNaN(qty)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap!',
                    text: 'Pastikan Barang dan Kuantitas diisi!',
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah') });
                return;
            }

            if (qty <= 0) {
                return Swal.fire({ icon: 'error', text: 'Kuantitas tidak boleh kurang dari 1!', confirmButtonColor: '#091426', target: document.getElementById('modal_tambah') });
            }

            if (barangDiKeranjang.includes(idBarang)) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Ditolak!',
                    text: 'Barang ini sudah ada di keranjang. Jika ingin mengubah jumlah, hapus dulu barang yang ada di keranjang.',
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah')
                });
            }

            let nama = brg.options[brg.selectedIndex].getAttribute('data-nama');
            let harga = parseInt(brg.options[brg.selectedIndex].getAttribute('data-harga'));
            let subtotal = harga * qty;

            totalBelanja += subtotal;

            let list = document.getElementById('keranjang_list');
            list.classList.remove('hidden');

            list.insertAdjacentHTML('beforeend', `
                <div class="flex justify-between items-center bg-gray-50 p-3 rounded mb-2 border border-gray-200" id="row-${idx}">
                    <div class="text-[12px] text-[#45474C]">
                        <span class="font-bold text-[#091426]">${nama}</span> <br>
                        Qty: ${qty} Unit | Subtotal: Rp ${subtotal.toLocaleString('id-ID')}

                        <input type="hidden" name="barang[${idx}][ID_Barang]" value="${idBarang}">
                        <input type="hidden" name="barang[${idx}][Kuantitas]" value="${qty}">
                    </div>
                    <button type="button" onclick="hapusBarang(${idx}, ${subtotal}, '${idBarang}')" class="text-red-500 hover:text-red-700">
                        <i class="ri-delete-bin-line text-lg"></i>
                    </button>
                </div>
            `);

            barangDiKeranjang.push(idBarang);

            idx++;
            brg.value = '';
            document.getElementById('input_kuantitas').value = '';

            hitungKelayakan();
        }

        function hapusBarang(idRow, subtotalMinus, idBarang) {
            document.getElementById('row-' + idRow).remove();

            totalBelanja -= subtotalMinus;
            barangDiKeranjang = barangDiKeranjang.filter(item => item !== String(idBarang));

            if (barangDiKeranjang.length === 0) {
                totalBelanja = 0;
                document.getElementById('box_kelayakan').classList.add('hidden');
                document.getElementById('keranjang_list').classList.add('hidden');
            } else {

                hitungKelayakan();
            }
        }

        function hitungKelayakan() {
            let jarak = parseFloat(document.getElementById('input_jarak').value);
            let metode = 'DIKIRIM';
            let alasan = '';
            let max_jarak = 0;

            if (totalBelanja < 3000000) {
                metode = 'DIAMBIL SENDIRI';
                alasan = 'Nominal belanja di bawah Rp 3 Juta.';
            } else {
                if (totalBelanja <= 7000000) max_jarak = 10;
                else if (totalBelanja <= 15000000) max_jarak = 20;
                else if (totalBelanja <= 25000000) max_jarak = 30;
                else if (totalBelanja <= 35000000) max_jarak = 40;
                else max_jarak = 50;

                if (jarak > max_jarak) {
                    metode = 'DIAMBIL SENDIRI';
                    alasan = `Jarak ${jarak}km melebihi batas (${max_jarak}km) untuk nominal ini.`;
                }
            }

            let box = document.getElementById('box_kelayakan');
            let teksMetode = document.getElementById('teks_metode');
            let badgeMetode = document.getElementById('badge_metode');
            let teksAlasan = document.getElementById('teks_alasan');

            box.classList.remove('hidden');
            document.getElementById('teks_total_belanja').innerText = totalBelanja.toLocaleString('id-ID');
            teksMetode.innerText = metode;

            if (metode === 'DIKIRIM') {
                box.className = 'mb-6 p-4 rounded border bg-blue-50 border-blue-200 transition-all';
                teksMetode.className = 'text-[16px] font-extrabold text-blue-700';
                badgeMetode.className = 'inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 text-[11px] font-bold text-blue-700';
                badgeMetode.innerHTML = '<i class="ri-check-line"></i> Layak Kirim';
                teksAlasan.classList.add('hidden');
            } else {
                box.className = 'mb-6 p-4 rounded border bg-orange-50 border-orange-200 transition-all';
                teksMetode.className = 'text-[16px] font-extrabold text-orange-700';
                badgeMetode.className = 'inline-flex items-center gap-1.5 rounded-full bg-orange-100 px-3 py-1 text-[11px] font-bold text-orange-700';
                badgeMetode.innerHTML = '<i class="ri-store-3-line"></i> Pickup Gudang';

                teksAlasan.classList.remove('hidden');
                teksAlasan.querySelector('span').innerText = alasan;
            }
        }

        function validasiSubmit() {
            if (document.getElementById('keranjang_list').innerHTML.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Keranjang (Detail Barang yang dipesan) masih kosong!',
                    text: 'Tambahkan minimal 1 barang ke keranjang pesanan!',
                    confirmButtonColor: '#091426',
                    target: document.getElementById('modal_tambah')
                });
                return false;
            }
            return true;
        }
    </script>
@endsection
