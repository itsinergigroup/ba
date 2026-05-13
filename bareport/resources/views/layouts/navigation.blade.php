@php
    $unreadCount = auth()->user()->unreadNotifications->count();
    $issueCount = 0;
    $hasIncomplete = false;
    $hasMissing = false;
    
    if (auth()->user()->isBa()) {
        $hasIncomplete = auth()->user()->hasIncompleteAttendance();
        $hasMissing = auth()->user()->hasMissingAttendanceYesterday();
        if ($hasIncomplete) $issueCount++;
        if ($hasMissing) $issueCount++;
    }
    $totalBadge = $unreadCount + $issueCount;
@endphp
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-12 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
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
            </div>

            <!-- Notifications Dropdown -->
            @unless(Auth::user()->isRbs() || Auth::user()->isViewOnly())
                <div class="hidden sm:flex sm:items-center sm:ms-3">
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button
                                class="relative inline-flex items-center p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                                @if($totalBadge > 0)
                                    <span class="absolute top-0 right-0 flex h-4 w-4">
                                        <span
                                            class="animate-pulse absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span
                                            class="relative inline-flex items-center justify-center rounded-full h-4 w-4 bg-red-600 text-[9px] font-bold text-white shadow-sm ring-1 ring-white dark:ring-gray-800">
                                            {{ $totalBadge > 9 ? '9+' : $totalBadge }}
                                        </span>
                                    </span>
                                @endif
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                                <div class="flex justify-between items-center">
                                    <span
                                        class="text-xs font-semibold text-gray-500 uppercase tracking-widest">{{ __('Notifikasi') }}</span>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <form method="POST" action="{{ route('notifications.markAsRead') }}">
                                            @csrf
                                            <button type="submit"
                                                class="text-[10px] text-indigo-600 dark:text-indigo-400 hover:underline">
                                                {{ __('Tandai semua dibaca') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                @if(auth()->user()->isBa())
                                    @if($hasIncomplete)
                                        <div class="px-4 py-3 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/30 transition duration-150 border-b border-amber-100 dark:border-amber-900/50">
                                            <a href="{{ route('attendance.index') }}" class="block">
                                                <p class="text-xs text-amber-800 dark:text-amber-400 font-bold flex items-center gap-2">
                                                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                    Peringatan: Lupa Check-out kemarin!
                                                </p>
                                                <p class="text-[10px] text-amber-600 dark:text-amber-500 mt-1">
                                                    Segera ajukan koreksi absen.
                                                </p>
                                            </a>
                                        </div>
                                    @endif
                                    @if($hasMissing)
                                        <div class="px-4 py-3 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/30 transition duration-150 border-b border-rose-100 dark:border-rose-900/50">
                                            <a href="{{ route('attendance.index') }}" class="block">
                                                <p class="text-xs text-rose-800 dark:text-rose-400 font-bold flex items-center gap-2">
                                                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                                    Peringatan: Absensi Kosong kemarin!
                                                </p>
                                                <p class="text-[10px] text-rose-600 dark:text-rose-500 mt-1">
                                                    Sistem mendeteksi Anda belum absen.
                                                </p>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                                @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                                    <div
                                        class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block">
                                            <p class="text-xs text-gray-800 dark:text-gray-200 font-medium line-clamp-2">
                                                {{ $notification->data['message'] }}
                                            </p>
                                            <p class="text-[10px] text-gray-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </a>
                                    </div>
                                @empty
                                    <div class="px-4 py-6 text-center">
                                        <p class="text-xs text-gray-500 font-medium">{{ __('Tidak ada notifikasi') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endunless

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-3">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger & Mobile Notifications -->
            <div class="-me-2 flex items-center sm:hidden">
                <!-- Mobile Notifications -->
                @unless(Auth::user()->isRbs() || Auth::user()->isViewOnly())
                    <div class="mr-2">
                        <x-dropdown align="right" width="64">
                            <x-slot name="trigger">
                                <button
                                    class="relative inline-flex items-center p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                    @if($totalBadge > 0)
                                        <span class="absolute top-1 right-1 flex h-4 w-4">
                                            <span
                                                class="animate-pulse absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                            <span
                                                class="relative inline-flex items-center justify-center rounded-full h-4 w-4 bg-red-600 text-[9px] font-bold text-white shadow-sm ring-1 ring-white dark:ring-gray-800">
                                                {{ $totalBadge > 9 ? '9+' : $totalBadge }}
                                            </span>
                                        </span>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-xs font-semibold text-gray-500 uppercase tracking-widest">{{ __('Notifikasi') }}</span>
                                        @if(auth()->user()->unreadNotifications->count() > 0)
                                            <form method="POST" action="{{ route('notifications.markAsRead') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="text-[10px] text-indigo-600 dark:text-indigo-400 hover:underline">
                                                    {{ __('Tandai semua dibaca') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    @if(auth()->user()->isBa())
                                        @if($hasIncomplete)
                                            <div class="px-4 py-3 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/30 transition duration-150 border-b border-amber-100 dark:border-amber-900/50">
                                                <a href="{{ route('attendance.index') }}" class="block">
                                                    <p class="text-xs text-amber-800 dark:text-amber-400 font-bold flex items-center gap-2">
                                                        <span class="flex-shrink-0 w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                        Peringatan: Lupa Check-out kemarin!
                                                    </p>
                                                    <p class="text-[10px] text-amber-600 dark:text-amber-500 mt-1">
                                                        Segera ajukan koreksi absen.
                                                    </p>
                                                </a>
                                            </div>
                                        @endif
                                        @if($hasMissing)
                                            <div class="px-4 py-3 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/30 transition duration-150 border-b border-rose-100 dark:border-rose-900/50">
                                                <a href="{{ route('attendance.index') }}" class="block">
                                                    <p class="text-xs text-rose-800 dark:text-rose-400 font-bold flex items-center gap-2">
                                                        <span class="flex-shrink-0 w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                                        Peringatan: Absensi Kosong kemarin!
                                                    </p>
                                                    <p class="text-[10px] text-rose-600 dark:text-rose-500 mt-1">
                                                        Sistem mendeteksi Anda belum absen.
                                                    </p>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                    @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                                        <div
                                            class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                            <a href="{{ $notification->data['url'] ?? '#' }}" class="block">
                                                <p class="text-xs text-gray-800 dark:text-gray-200 font-medium line-clamp-2">
                                                    {{ $notification->data['message'] }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 mt-1">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="px-4 py-6 text-center">
                                            <p class="text-xs text-gray-500 font-medium">{{ __('Tidak ada notifikasi') }}</p>
                                        </div>
                                    @endforelse
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endunless

                <button @click="open = ! open"
                    class="relative inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    @if($totalBadge > 0)
                        <span class="absolute top-2 right-2 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                        </span>
                    @endif
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
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

        <!-- Mobile Notifications -->
        @unless(Auth::user()->isRbs() || Auth::user()->isViewOnly())
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4 flex justify-between items-center mb-2">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        Notifikasi
                    </div>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <form method="POST" action="{{ route('notifications.markAsRead') }}">
                            @csrf
                            <button type="submit" class="text-[10px] text-indigo-600 font-bold uppercase tracking-widest hover:underline">
                                Baca Semua
                            </button>
                        </form>
                    @endif
                </div>
                <div class="space-y-1">
                    @if(auth()->user()->isBa())
                        @if($hasIncomplete)
                            <div class="mx-2 mb-1">
                                <a href="{{ route('attendance.index') }}" class="block px-4 py-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-900/50">
                                    <p class="text-xs text-amber-800 dark:text-amber-400 font-bold flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                        Peringatan: Lupa Check-out kemarin!
                                    </p>
                                </a>
                            </div>
                        @endif
                        @if($hasMissing)
                            <div class="mx-2 mb-1">
                                <a href="{{ route('attendance.index') }}" class="block px-4 py-3 bg-rose-50 dark:bg-rose-900/20 rounded-xl border border-rose-100 dark:border-rose-900/50">
                                    <p class="text-xs text-rose-800 dark:text-rose-400 font-bold flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                        Peringatan: Absensi Kosong kemarin!
                                    </p>
                                </a>
                            </div>
                        @endif
                    @endif

                    @forelse(auth()->user()->notifications()->latest()->take(3)->get() as $notification)
                        <x-responsive-nav-link :href="$notification->data['url'] ?? '#'" :class="$notification->read_at ? 'opacity-60' : 'bg-indigo-50/30 dark:bg-indigo-900/10'">
                            <div class="flex flex-col">
                                <span class="text-xs {{ $notification->read_at ? '' : 'font-bold text-indigo-700 dark:text-indigo-400' }}">
                                    {{ $notification->data['message'] }}
                                </span>
                                <span class="text-[10px] text-gray-400 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </x-responsive-nav-link>
                    @empty
                        <div class="px-4 py-4 text-center">
                            <p class="text-xs text-gray-400 italic">Tidak ada notifikasi baru</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endunless

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
