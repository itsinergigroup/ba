<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Master Toko (Outlet)') }}
            </h2>
            <a href="{{ route('admin.outlets.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                Tambah Toko Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ 
        selectedOutlet: {
            name: '',
            area: '',
            region: '',
            address: '',
            channel: '',
            jenis_akun: ''
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if(session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif


            <!-- Filter Section -->
            <div
                class="bg-white dark:bg-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div
                                class="p-2 bg-indigo-50 dark:bg-indigo-900/40 rounded-lg text-indigo-600 dark:text-indigo-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 tracking-tight">Filter
                                    Toko</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Cari outlet berdasarkan nama, kota,
                                    atau provinsi</p>
                            </div>
                        </div>
                        @if(request()->filled('search'))
                            <div
                                class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 rounded-full">
                                <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">Pencarian aktif:
                                    "{{ request('search') }}"</span>
                                <a href="{{ route('admin.outlets.index') }}"
                                    class="text-indigo-400 hover:text-indigo-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('admin.outlets.index') }}" method="GET"
                        class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                placeholder="Ketik nama toko, kota, atau provinsi..."
                                class="w-full pl-11 pr-4 py-3 bg-gray-50/50 dark:bg-gray-900/50 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner placeholder:text-gray-400 dark:text-gray-200">
                        </div>
                        <div class="flex gap-3">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:-translate-y-0.5 active:translate-y-0 gap-2 min-w-[140px]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari Data
                            </button>
                            @if(request()->filled('search'))
                                <a href="{{ route('admin.outlets.index') }}"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-sm font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 transition-all shadow-sm">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Section -->
            <div
                class="bg-white dark:bg-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none sm:rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div
                    class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">Daftar Toko
                            (Outlet)</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total data: <span
                                class="font-bold text-indigo-600 dark:text-indigo-400">{{ $outlets->total() }}</span>
                            outlet terdaftar</p>
                    </div>
                </div>

                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/80 dark:bg-gray-700/50">
                                    <th
                                        class="py-4 px-8 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500 w-20">
                                        No.</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                        Detail Toko</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                        Area</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                        Channel</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                        Jenis Akun</th>
                                    <th
                                        class="py-4 px-8 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500 text-right">
                                        Manajemen Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                                @forelse($outlets as $index => $outlet)
                                    <tr
                                        class="group hover:bg-indigo-50/20 dark:hover:bg-indigo-900/5 transition-all duration-300">
                                        <td class="py-5 px-8">
                                            <span
                                                class="text-xs font-bold text-gray-400 dark:text-gray-600 group-hover:text-indigo-500 transition-colors">
                                                {{ ($outlets->currentPage() - 1) * $outlets->perPage() + $loop->iteration }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-6">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 flex items-center justify-center text-blue-600 dark:text-blue-400 shadow-sm group-hover:scale-110 transition-transform duration-300">
                                                    <svg class="w-5 h-5 shadow-sm" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-bold text-gray-800 dark:text-gray-200 tracking-tight group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $outlet->name }}</span>
                                                    <span
                                                        class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-widest font-semibold">Nama
                                                        Outlet</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-5 px-6">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                {{ $outlet->area->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-6">
                                            @if($outlet->channel)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                    {{ $outlet->channel === 'Direct' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' }}">
                                                    {{ $outlet->channel }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="py-5 px-6">
                                            @if($outlet->jenis_akun)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                    {{ $outlet->jenis_akun === 'GT' ? 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400' }}">
                                                    {{ $outlet->jenis_akun }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="py-5 px-8">
                                            <div class="flex justify-end items-center gap-2">
                                                <button type="button"
                                                    @click="selectedOutlet = { 
                                                        name: '{{ addslashes($outlet->name) }}', 
                                                        area: '{{ $outlet->area->name ?? '-' }}', 
                                                        region: '{{ $outlet->area->region->name ?? '-' }}', 
                                                        address: '{{ addslashes($outlet->address ?? '-') }}',
                                                        channel: '{{ $outlet->channel ?? '-' }}',
                                                        jenis_akun: '{{ $outlet->jenis_akun ?? '-' }}'
                                                    }; $dispatch('open-modal', 'show-outlet-modal')"
                                                    class="p-2 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:text-emerald-400 dark:hover:bg-emerald-900/50 rounded-lg transition-all shadow-sm border border-emerald-100 dark:border-emerald-900/50"
                                                    title="Lihat Detail">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                <a href="{{ route('admin.outlets.edit', $outlet->id) }}"
                                                    class="p-2 text-indigo-600 hover:bg-indigo-600 hover:text-white dark:text-indigo-400 dark:hover:bg-indigo-900/50 rounded-lg transition-all shadow-sm border border-indigo-100 dark:border-indigo-900/50"
                                                    title="Ubah Data">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-24 text-center">
                                            <div class="flex flex-col items-center gap-4">
                                                <div
                                                    class="w-20 h-20 bg-gray-50 dark:bg-gray-900/50 rounded-full flex items-center justify-center text-gray-200 dark:text-gray-800">
                                                    <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="space-y-1">
                                                    <p
                                                        class="text-base font-bold text-gray-500 dark:text-gray-400 tracking-tight">
                                                        Data Toko Tidak Ditemukan</p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-600">Gunakan kata kunci
                                                        pencarian lain atau tambahkan toko baru.</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($outlets->hasPages())
                        <div
                            class="px-8 py-6 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700">
                            {{ $outlets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Modal Show Outlet -->
        <x-modal name="show-outlet-modal" focusable>
            <div class="p-8">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100" x-text="selectedOutlet.name"></h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Detail Informasi Outlet</p>
                        </div>
                    </div>
                    <button @click="$dispatch('close')" class="text-gray-400 hover:text-gray-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 block mb-1">Nama Outlet</label>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedOutlet.name"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 block mb-1">Area</label>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedOutlet.area"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 block mb-1">Region</label>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedOutlet.region"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 block mb-1">Alamat</label>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedOutlet.address"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 block mb-1">Channel</label>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedOutlet.channel"></p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 block mb-1">Jenis Akun</label>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="selectedOutlet.jenis_akun"></p>
                    </div>
                </div>

                <div class="mt-10 flex justify-end">
                    <x-secondary-button @click="$dispatch('close')">
                        Tutup
                    </x-secondary-button>
                </div>
            </div>
        </x-modal>
    </div>
    </div>
    </div>
</x-app-layout>
