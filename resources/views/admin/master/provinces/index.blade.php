<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Master Provinsi') }}
            </h2>
            <a href="{{ route('admin.provinces.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                Tambah Provinsi Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg flex items-center gap-3 animate-fade-in"
                    role="alert">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
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
                                    Data</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Temukan data provinsi dengan cepat
                                </p>
                            </div>
                        </div>
                        @if(request()->filled('search'))
                            <div
                                class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 rounded-full">
                                <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">Pencarian aktif:
                                    "{{ request('search') }}"</span>
                                <a href="{{ route('admin.provinces.index') }}"
                                    class="text-indigo-400 hover:text-indigo-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('admin.provinces.index') }}" method="GET"
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
                                placeholder="Cari berdasarkan nama provinsi (misal: Jawa Barat)..."
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
                                <a href="{{ route('admin.provinces.index') }}"
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
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">Daftar Provinsi
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total data: <span
                                class="font-bold text-indigo-600 dark:text-indigo-400">{{ $provinces->total() }}</span>
                            provinsi terdaftar</p>
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
                                        Nama Wilayah Provinsi</th>
                                    <th
                                        class="py-4 px-8 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500 text-right">
                                        Manajemen Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                                @forelse($provinces as $index => $province)
                                    <tr
                                        class="group hover:bg-indigo-50/20 dark:hover:bg-indigo-900/5 transition-all duration-300">
                                        <td class="py-5 px-8">
                                            <span
                                                class="text-xs font-bold text-gray-400 dark:text-gray-600 group-hover:text-indigo-500 transition-colors">
                                                {{ ($provinces->currentPage() - 1) * $provinces->perPage() + $loop->iteration }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-6">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 shadow-sm group-hover:scale-110 transition-transform duration-300">
                                                    <svg class="w-5 h-5 shadow-sm" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M9 20l-5.447-2.724A2 2 0 012.553 15.553V5.447a2 2 0 011.447-1.894l5.447-2.724a2 2 0 011.106 0l5.447 2.724a2 2 0 011.447 1.894v10.106a2 2 0 01-1.106 1.894L9 20z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5" d="M9 10L9 20"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5" d="M2 5L9 10"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5" d="M9 10L16 15"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-bold text-gray-800 dark:text-gray-200 tracking-tight group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $province->name }}</span>
                                                    <span
                                                        class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-widest font-semibold">Provinsi
                                                        Indonesia</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-5 px-8">
                                            <div class="flex justify-end items-center gap-2">
                                                <a href="{{ route('admin.provinces.edit', $province->id) }}"
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
                                                <form action="{{ route('admin.provinces.destroy', $province->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus provinsi {{ $province->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-red-600 hover:bg-red-600 hover:text-white dark:text-red-400 dark:hover:bg-red-900/50 rounded-lg transition-all shadow-sm border border-red-100 dark:border-red-900/50"
                                                        title="Hapus Data">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-24 text-center">
                                            <div class="flex flex-col items-center gap-4">
                                                <div
                                                    class="w-20 h-20 bg-gray-50 dark:bg-gray-900/50 rounded-full flex items-center justify-center text-gray-200 dark:text-gray-800">
                                                    <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1"
                                                            d="M9 20l-5.447-2.724A2 2 0 012.553 15.553V5.447a2 2 0 011.447-1.894l5.447-2.724a2 2 0 011.106 0l5.447 2.724a2 2 0 011.447 1.894v10.106a2 2 0 01-1.106 1.894L9 20z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="space-y-1">
                                                    <p
                                                        class="text-base font-bold text-gray-500 dark:text-gray-400 tracking-tight">
                                                        Tidak Ada Data Provinsi</p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-600">Coba ubah kata kunci
                                                        pencarian Anda atau tambahkan provinsi baru.</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($provinces->hasPages())
                        <div
                            class="px-8 py-6 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700">
                            {{ $provinces->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-app-layout>