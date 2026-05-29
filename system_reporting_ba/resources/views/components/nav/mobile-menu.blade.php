<div class="pt-2 pb-3 space-y-1">
    @if(Auth::user()->isBa())
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
            {{ __('Riwayat Laporan Saya') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('attendance.index')" :active="request()->routeIs('attendance.*')">
            {{ __('Absensi') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('attendance.request.index')"
            :active="request()->routeIs('attendance.request.*')">
            {{ __('Pengajuan (Absen & Day-Off)') }}
        </x-responsive-nav-link>
    @elseif(Auth::user()->isAnyViewer() && !Auth::user()->isAdmin())
        <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
            {{ __('Riwayat Laporan') }}
        </x-responsive-nav-link>
        @if(Auth::user()->isRbs())
        <x-responsive-nav-link :href="route('admin.attendance.index')" :active="request()->routeIs('admin.attendance.*')">
            {{ __('Log Absensi BA') }}
        </x-responsive-nav-link>
        @endif
    @endif
    @if(Auth::user()->isAdmin())
        <div class="pt-4 pb-2 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                Main Menu
            </div>
        </div>
        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            {{ __('Dashboard Admin') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
            {{ __('Manajemen Pengguna') }}
        </x-responsive-nav-link>

        <div class="pt-2 pb-1 px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
            Manajemen Absensi
        </div>
        <x-responsive-nav-link :href="route('admin.attendance.index')"
            :active="request()->routeIs('admin.attendance.*')">
            {{ __('Log Absensi') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.attendance-requests.index')"
            :active="request()->routeIs('admin.attendance-requests.*')">
            {{ __('Persetujuan Absen') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.settings.attendance')"
            :active="request()->routeIs('admin.settings.attendance')">
            {{ __('Konfigurasi Jadwal') }}
        </x-responsive-nav-link>

        <div class="pt-2 pb-1 px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
            Master Data
        </div>
        <x-responsive-nav-link :href="route('admin.brands.index')" :active="request()->routeIs('admin.brands.*')">
            {{ __('Brand') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.products.index')"
            :active="request()->routeIs('admin.products.*')">
            {{ __('Produk') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.distributors.index')"
            :active="request()->routeIs('admin.distributors.*')">
            {{ __('Distributor') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.provinces.index')"
            :active="request()->routeIs('admin.provinces.*')">
            {{ __('Provinsi') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.cities.index')" :active="request()->routeIs('admin.cities.*')">
            {{ __('Kota') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.regions.index')" :active="request()->routeIs('admin.regions.*')">
            {{ __('Wilayah (Region)') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.areas.index')" :active="request()->routeIs('admin.areas.*')">
            {{ __('Area') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.outlets.index')" :active="request()->routeIs('admin.outlets.*')">
            {{ __('Toko') }}
        </x-responsive-nav-link>
    @endif
</div>
