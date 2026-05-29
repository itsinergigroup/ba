<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    @if(Auth::user()->isAdmin())
        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            {{ __('Dashboard Admin') }}
        </x-nav-link>
        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
            {{ __('Manajemen Pengguna') }}
        </x-nav-link>

        <!-- Dropdown Absensi -->
        <div class="hidden sm:flex sm:items-center">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.attendance.*') || request()->routeIs('admin.attendance-requests.*') ? 'border-indigo-400 dark:border-indigo-600 text-gray-900 dark:text-gray-100' : 'border-transparent text-gray-500 dark:text-gray-400' }} text-sm font-medium leading-5 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none transition duration-150 ease-in-out h-16">
                        <span>Absensi</span>
                        <svg class="ms-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('admin.attendance.index')">
                        {{ __('Log Absensi') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.attendance-requests.index')">
                        {{ __('Persetujuan Absen') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.settings.attendance')">
                        {{ __('Konfigurasi Jadwal') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Dropdown Master Data -->
        <div class="hidden sm:flex sm:items-center">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.brands.*') || request()->routeIs('admin.products.*') || request()->routeIs('admin.distributors.*') || request()->routeIs('admin.provinces.*') || request()->routeIs('admin.cities.*') || request()->routeIs('admin.outlets.*') ? 'border-indigo-400 dark:border-indigo-600 text-gray-900 dark:text-gray-100' : 'border-transparent text-gray-500 dark:text-gray-400' }} text-sm font-medium leading-5 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none transition duration-150 ease-in-out h-16">
                        <span>Master Data</span>
                        <svg class="ms-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('admin.brands.index')">
                        {{ __('Brand') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.products.index')">
                        {{ __('Produk') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.distributors.index')">
                        {{ __('Distributor') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.provinces.index')">
                        {{ __('Provinsi') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.cities.index')">
                        {{ __('Kota') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.regions.index')">
                        {{ __('Wilayah (Region)') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.areas.index')">
                        {{ __('Area') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.outlets.index')">
                        {{ __('Toko') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>
    @else
        @if(Auth::user()->isBa())
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>
        @endif

        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
            {{ Auth::user()->isBa() ? __('Riwayat Laporan Saya') : __('Riwayat Laporan') }}
        </x-nav-link>

        @if(Auth::user()->isRbs())
        <!-- Dropdown Absensi untuk RBS/KAM -->
        <div class="hidden sm:flex sm:items-center">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.attendance.*') ? 'border-indigo-400 dark:border-indigo-600 text-gray-900 dark:text-gray-100' : 'border-transparent text-gray-500 dark:text-gray-400' }} text-sm font-medium leading-5 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none transition duration-150 ease-in-out h-16">
                        <span>Absensi</span>
                        <svg class="ms-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('admin.attendance.index')">
                        {{ __('Log Absensi BA') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>
        @endif

        @if(Auth::user()->isBa())
            <x-nav-link :href="route('attendance.index')" :active="request()->routeIs('attendance.*')">
                {{ __('Absensi') }}
            </x-nav-link>
            <x-nav-link :href="route('attendance.request.index')"
                :active="request()->routeIs('attendance.request.*')">
                {{ __('Pengajuan (Absen & Day-Off)') }}
            </x-nav-link>
        @endif
    @endif
</div>
