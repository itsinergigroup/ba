<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Pengguna') }}
            </h2>
            <a href="{{ route('admin.users.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Tambah Pengguna Baru
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
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 tracking-tight">Filter
                                    Pengguna</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Cari berdasarkan nama, email, atau
                                    distributor</p>
                            </div>
                        </div>
                        @if(request()->filled('search'))
                            <div
                                class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 rounded-full">
                                <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">Pencarian aktif:
                                    "{{ request('search') }}"</span>
                                <a href="{{ route('admin.users.index') }}"
                                    class="text-indigo-400 hover:text-indigo-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('admin.users.index') }}" method="GET"
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
                                placeholder="Ketik nama, email, atau distributor..."
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
                                <a href="{{ route('admin.users.index') }}"
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
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">Daftar Pengguna
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total data: <span
                                class="font-bold text-indigo-600 dark:text-indigo-400">{{ $users->total() }}</span> akun
                            terdaftar</p>
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
                                        Informasi Profil</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                        Akses & Peran</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                        Afiliasi Distributor</th>
                                    <th
                                        class="py-4 px-8 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500 text-right">
                                        Manajemen Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                                @forelse($users as $index => $user)
                                    <tr
                                        class="group hover:bg-indigo-50/20 dark:hover:bg-indigo-900/5 transition-all duration-300">
                                        <td class="py-5 px-8">
                                            <span
                                                class="text-xs font-bold text-gray-400 dark:text-gray-600 group-hover:text-indigo-500 transition-colors">
                                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-6">
                                            <div class="flex items-center gap-4">
                                                @if($user->photo_path)
                                                    <img src="{{ Storage::url($user->photo_path) }}" alt="Foto Profile"
                                                        class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-sm group-hover:scale-110 transition-transform duration-300">
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded-full bg-gradient-to-br {{ $user->role === 'admin' ? 'from-rose-50 to-rose-100 text-rose-600 dark:from-rose-900/20 dark:to-rose-800/20' : 'from-indigo-50 to-indigo-100 text-indigo-600 dark:from-indigo-900/20 dark:to-indigo-800/20' }} border-2 border-white dark:border-gray-700 flex items-center justify-center font-bold shadow-sm group-hover:scale-110 transition-transform duration-300">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-bold text-gray-800 dark:text-gray-200 tracking-tight group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $user->name }}</span>
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</span>
                                                    @if($user->profile && $user->profile->nik)
                                                        <span
                                                            class="text-[10px] text-gray-400 mt-1 font-mono tracking-wider">NIK:
                                                            {{ $user->profile->nik }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-5 px-6">
                                            <div class="flex flex-col items-start gap-2">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold tracking-wider {{ $user->role === 'admin' ? 'bg-rose-50 text-rose-600 border border-rose-100 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800' : 'bg-indigo-50 text-indigo-600 border border-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800' }}">
                                                    {{ strtoupper($user->role) }}
                                                </span>
                                                @if($user->is_active)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">Aktif</span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400">Nonaktif</span>
                                                @endif
                                                @if($user->role === 'ba' && $user->profile && $user->profile->employment_status)
                                                    <span
                                                        class="text-[10px] text-gray-500 dark:text-gray-400">{{ $user->profile->employment_status }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-5 px-6">
                                            <div class="flex flex-col gap-1">
                                                <span
                                                    class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $user->distributor->name ?? '-' }}</span>
                                                @if($user->role === 'ba')
                                                    <span
                                                        class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">{{ $user->outlets->count() }}
                                                        Toko Terdaftar</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-5 px-8">
                                            <div class="flex justify-end items-center gap-2">
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
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
                                                <div x-data="{ showModal: false }">
                                                    <button type="button" @click="showModal = true"
                                                        class="p-2 {{ $user->is_active ? 'text-orange-600 hover:bg-orange-600 border-orange-100 dark:text-orange-400 dark:border-orange-900/50' : 'text-emerald-600 hover:bg-emerald-600 border-emerald-100 dark:text-emerald-400 dark:border-emerald-900/50' }} hover:text-white dark:hover:bg-opacity-50 rounded-lg transition-all shadow-sm border"
                                                        title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                                        @if($user->is_active)
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                                </path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        @endif
                                                    </button>

                                                    <!-- AlpineJS Modal -->
                                                    <div x-show="showModal" style="display: none;"
                                                        class="fixed inset-0 z-50 overflow-y-auto"
                                                        aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                        <!-- Backdrop -->
                                                        <div x-show="showModal" x-transition:enter="ease-out duration-300"
                                                            x-transition:enter-start="opacity-0"
                                                            x-transition:enter-end="opacity-100"
                                                            x-transition:leave="ease-in duration-200"
                                                            x-transition:leave-start="opacity-100"
                                                            x-transition:leave-end="opacity-0"
                                                            class="fixed inset-0 transition-opacity"
                                                            style="background-color: rgba(17, 24, 39, 0.7); backdrop-filter: blur(4px);"
                                                            aria-hidden="true" @click="showModal = false"></div>

                                                        <div class="fixed inset-0 z-50 overflow-y-auto">
                                                            <div
                                                                class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                                                                <div x-show="showModal"
                                                                    x-transition:enter="ease-out duration-300"
                                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                                    x-transition:leave="ease-in duration-200"
                                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                    @click.away="showModal = false"
                                                                    class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 dark:border-gray-700">

                                                                    <div
                                                                        class="bg-white dark:bg-gray-800 px-6 pb-6 pt-8 flex flex-col items-center">
                                                                        <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full mb-6"
                                                                            style="{{ $user->is_active ? 'background-color: #ffedd5; color: #ea580c;' : 'background-color: #d1fae5; color: #059669;' }}">
                                                                            @if($user->is_active)
                                                                                <svg class="h-8 w-8" fill="none"
                                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                                    stroke="currentColor" aria-hidden="true">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                                </svg>
                                                                            @else
                                                                                <svg class="h-8 w-8" fill="none"
                                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                                    stroke="currentColor">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                </svg>
                                                                            @endif
                                                                        </div>
                                                                        <div class="text-center w-full">
                                                                            <h3 class="text-xl font-bold leading-6 text-gray-900 dark:text-white"
                                                                                id="modal-title">
                                                                                {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                                                                            </h3>
                                                                            <div class="mt-4">
                                                                                <p
                                                                                    class="text-sm text-gray-500 dark:text-gray-400">
                                                                                    Apakah Anda yakin ingin
                                                                                    {{ $user->is_active ? 'menyetop' : 'mengaktifkan kembali' }}
                                                                                    akses
                                                                                    <strong>{{ $user->name }}</strong>?
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div
                                                                        class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-center gap-3">
                                                                        <button type="button" @click="showModal = false"
                                                                            class="inline-flex w-full justify-center items-center rounded-xl bg-white dark:bg-gray-800 px-6 py-3 text-sm font-semibold text-gray-900 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all sm:w-auto">
                                                                            Batal
                                                                        </button>
                                                                        <form
                                                                            action="{{ route('admin.users.toggle', $user->id) }}"
                                                                            method="POST" class="w-full sm:w-auto m-0">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button type="submit"
                                                                                class="inline-flex w-full justify-center items-center rounded-xl px-6 py-3 text-sm font-semibold shadow-sm transition-all sm:w-auto"
                                                                                style="{{ $user->is_active ? 'background-color: #ea580c; color: white;' : 'background-color: #059669; color: white;' }}">
                                                                                Ya,
                                                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-red-600 hover:bg-red-600 hover:text-white dark:text-red-400 dark:hover:bg-red-900/50 rounded-lg transition-all shadow-sm border border-red-100 dark:border-red-900/50"
                                                        title="Hapus Data">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
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
                                                            stroke-width="1"
                                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="space-y-1">
                                                    <p
                                                        class="text-base font-bold text-gray-500 dark:text-gray-400 tracking-tight">
                                                        Tidak Ada Pengguna Ditemukan</p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-600">Coba ubah kata kunci
                                                        atau tambahkan pengguna baru.</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div
                            class="px-8 py-6 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>