<aside class="w-[240px] min-h-screen bg-[#F2F4F6] border-r border-[#E5E7EB] flex flex-col">

    <div class="flex items-center gap-3 px-6 pt-8 pb-10">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#111827]">
            <span class="text-lg font-bold text-white">V</span>
        </div>

        <h1 class="text-[18px] font-semibold text-gray-900">
            VulkanStore
        </h1>
    </div>

    <nav class="flex-1">

        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 h-11 pl-5 border-l-4 transition
            {{ request()->routeIs('dashboard')
                ? 'border-[#855300] bg-[#E8EAED] text-gray-900 font-medium'
                : 'border-transparent text-gray-500 hover:bg-[#ECEFF1] hover:text-gray-900' }}">

            <i class="ri-dashboard-line text-[18px]"></i>
            Dashboard
        </a>

        <a href="#"
            class="flex items-center gap-3 h-11 pl-5 border-l-4 border-transparent text-gray-500 hover:bg-[#ECEFF1] hover:text-gray-900 transition">

            <i class="ri-database-2-line text-[18px]"></i>
            Master Data
        </a>

        <a href="#"
            class="flex items-center gap-3 h-11 pl-5 border-l-4 border-transparent text-gray-500 hover:bg-[#ECEFF1] hover:text-gray-900 transition">

            <i class="ri-inbox-archive-line text-[18px]"></i>
            Penerimaan
        </a>

        <a href="#"
            class="flex items-center gap-3 h-11 pl-5 border-l-4 border-transparent text-gray-500 hover:bg-[#ECEFF1] hover:text-gray-900 transition">

            <i class="ri-shopping-cart-2-line text-[18px]"></i>
            Pemesanan
        </a>

        <a href="#"
            class="flex items-center gap-3 h-11 pl-5 border-l-4 border-transparent text-gray-500 hover:bg-[#ECEFF1] hover:text-gray-900 transition">

            <i class="ri-truck-line text-[18px]"></i>
            Pengiriman
        </a>

        <a href="#"
            class="flex items-center gap-3 h-11 pl-5 border-l-4 border-transparent text-gray-500 hover:bg-[#ECEFF1] hover:text-gray-900 transition">

            <i class="ri-file-chart-line text-[18px]"></i>
            Laporan
        </a>

    </nav>

    <div class="px-4 pb-6">

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                class="flex w-full items-center gap-3 rounded-lg px-2 py-3 text-[14px] font-medium text-gray-600 hover:bg-[#ECEFF1] hover:text-gray-900 transition">
                <i class="ri-logout-box-r-line text-[18px]"></i>
                Logout

            </button>
        </form>

    </div>

</aside>
