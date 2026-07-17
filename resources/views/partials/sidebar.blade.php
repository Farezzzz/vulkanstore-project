<aside class="flex min-h-screen w-[240px] flex-col border-r border-[#E5E7EB] bg-[#F2F4F6]">
    <div class="flex items-center gap-3 px-6 pb-10 pt-8">
        <div class="flex h-8 w-8 items-center justify-center rounded bg-[#091426]">
            <span class="text-sm font-bold text-white">V</span>
        </div>
        <h1 class="text-[20px] font-bold text-[#091426]">
            VulkanStore
        </h1>
    </div>

    <nav class="flex-1">

        <a href="{{ route('pemasok.index') }}"
            class="flex h-11 items-center gap-3 border-l-4 pl-5 text-[12px] transition
            {{ request()->routeIs(['pemasok.*', 'barang.*', 'pengguna.*'])
                ? 'border-[#855300] bg-[#E8EAED] font-semibold text-[#091426]'
                : 'border-transparent font-semibold text-[#45474C] hover:bg-[#ECEFF1] hover:text-[#091426]' }}">
            <i class="ri-database-2-line text-[18px]"></i>
            Master Data
        </a>

        <a href="{{ route('penerimaan.index') }}"
            class="flex h-11 items-center gap-3 border-l-4 pl-5 text-[12px] transition
            {{ request()->routeIs('penerimaan.*')
                ? 'border-[#855300] bg-[#E8EAED] font-semibold text-[#091426]'
                : 'border-transparent font-semibold text-[#45474C] hover:bg-[#ECEFF1] hover:text-[#091426]' }}">
            <i class="ri-box-3-line text-[18px]"></i> Penerimaan
        </a>

       
        <a href="{{ route('pesanan.index') }}" 
        class="flex h-11 items-center gap-3 border-l-4 pl-5 text-[12px] transition
            {{ request()->routeIs('pesanan.*')
                ? 'border-[#855300] bg-[#E8EAED] font-semibold text-[#091426]'
                : 'border-transparent font-semibold text-[#45474C] hover:bg-[#ECEFF1] hover:text-[#091426]' }}">
            <i class="ri-database-2-line text-[18px]"></i>
            <span>Pemesanan</span>
        </a>

        <a href="{{ route('pengiriman.index') }}" 
        class="flex h-11 items-center gap-3 border-l-4 pl-5 text-[12px] transition
            {{ request()->routeIs('pengiriman.*')
                ? 'border-[#855300] bg-[#E8EAED] font-semibold text-[#091426]'
                : 'border-transparent font-semibold text-[#45474C] hover:bg-[#ECEFF1] hover:text-[#091426]' }}">
            <i class="ri-database-2-line text-[18px]"></i>
            <span>Pengiriman</span>
        </a>

        <a href="{{ route('laporan.index') }}"_
            class="flex h-11 items-center gap-3 border-l-4 border-transparent pl-5 text-[12px] font-semibold text-[#45474C] transition hover:bg-[#ECEFF1] hover:text-[#091426]">
            <i class="ri-file-chart-line text-[18px]"></i>
            Laporan
        </a>
    </nav>

    <div class="px-4 pb-6">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex w-full items-center gap-3 rounded-lg px-2 py-3 text-[14px] font-normal text-[#45474C] transition hover:bg-[#ECEFF1] hover:text-[#091426]">
                <i class="ri-logout-box-r-line text-[18px]"></i>
                Logout
            </button>
        </form>
    </div>
</aside>
