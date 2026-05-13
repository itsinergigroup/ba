<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Pengajuan & Day-Off') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
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
                                    Pengajuan</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Filter berdasarkan status pengajuan
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.attendance-requests.index') }}" method="GET"
                        class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <select name="status"
                                class="w-full px-4 py-3 bg-gray-50/50 dark:bg-gray-900/50 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                                    (Menunggu Persetujuan)</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved
                                    (Disetujui)</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected
                                    (Ditolak)</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:-translate-y-0.5 active:translate-y-0 gap-2 min-w-[140px]">
                            Terapkan Filter
                        </button>
                        @if(request()->filled('status'))
                            <a href="{{ route('admin.attendance-requests.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-sm font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 transition-all shadow-sm">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none sm:rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">Daftar Pengajuan Masuk
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total pengajuan: <span
                            class="font-bold text-indigo-600 dark:text-indigo-400">{{ $requests->total() }}</span> data
                    </p>
                </div>

                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/80 dark:bg-gray-700/50">
                                    <th
                                        class="py-4 px-8 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                        Beauty Advisor</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                        Waktu Pengajuan</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                        Tipe Pengajuan</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                        Alasan</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500 text-center">
                                        Bukti</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500 text-center">
                                        Status</th>
                                    <th
                                        class="py-4 px-8 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500 text-right">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                                @forelse($requests as $request)
                                    <tr
                                        class="group hover:bg-gray-50/50 dark:hover:bg-gray-900/20 transition-all duration-300">
                                        <td class="py-5 px-8">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                                    {{ substr($request->user->name, 0, 1) }}
                                                </div>
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-bold text-gray-800 dark:text-gray-200 tracking-tight">{{ $request->user->name }}</span>
                                                    <span
                                                        class="text-[11px] text-gray-500 uppercase tracking-widest font-semibold">{{ $request->user->distributor->name ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-5 px-6">
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($request->date)->format('d M Y') }}</span>
                                                @if($request->type !== 'day-off')
                                                    <span
                                                        class="text-[11px] text-gray-400">{{ \Carbon\Carbon::parse($request->time)->format('H:i') }}
                                                        WIB</span>
                                                @else
                                                    <span class="text-[11px] text-gray-400 italic">Seharian</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-5 px-6">
                                            <div class="flex flex-col gap-1">
                                                @php
                                                    $typeColor = match($request->type) {
                                                        'check-in' => 'bg-blue-100 text-blue-800',
                                                        'check-out' => 'bg-indigo-100 text-indigo-800',
                                                        'day-off' => 'bg-purple-100 text-purple-800',
                                                        default => 'bg-gray-100 text-gray-800'
                                                    };
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold uppercase {{ $typeColor }} w-max">
                                                    {{ str_replace('-', ' ', $request->type) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-5 px-6">
                                            <p class="text-xs text-gray-600 dark:text-gray-400 max-w-[200px]"
                                                title="{{ $request->reason }}">
                                                {{ $request->reason }}
                                            </p>
                                        </td>
                                        <td class="py-5 px-6 text-center">
                                            @if($request->photo_path)
                                                <a href="{{ asset('storage/' . $request->photo_path) }}" target="_blank" class="inline-block relative group">
                                                    <img src="{{ asset('storage/' . $request->photo_path) }}" 
                                                         class="w-10 h-10 object-cover rounded-lg ring-2 ring-white dark:ring-gray-700 shadow-sm transition-transform group-hover:scale-110" 
                                                         alt="Bukti">
                                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 rounded-lg transition-opacity flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </div>
                                                </a>
                                            @else
                                                <span class="text-[10px] text-gray-300 italic">No Photo</span>
                                            @endif
                                        </td>
                                        <td class="py-5 px-6 text-center">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                    'approved' => 'bg-green-50 text-green-700 border-green-100 dark:bg-green-900/30 dark:text-green-400',
                                                    'rejected' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/30 dark:text-red-400',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border {{ $statusClasses[$request->status] }}">
                                                {{ $request->status }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-8 text-right">
                                            @if($request->status === 'pending')
                                                <div class="flex justify-end gap-2" x-data="{ open: false }">
                                                    <!-- Modal-like simple action -->
                                                    <button @click="open = true"
                                                        class="px-4 py-1.5 bg-indigo-600 text-white rounded-lg text-[11px] font-bold hover:bg-indigo-700 transition-colors shadow-sm">
                                                        Proses
                                                    </button>

                                                    <!-- Simple Inline Form Modal -->
                                                    <div x-show="open"
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                                                        x-cloak>
                                                        <div @click.away="open = false"
                                                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-8 text-left">
                                                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                                                                Tinjau Pengajuan</h4>
                                                            <p class="text-sm text-gray-500 mb-6">Tentukan apakah pengajuan dari
                                                                <strong>{{ $request->user->name }}</strong> dapat disetujui.</p>

                                                            @if($request->photo_path)
                                                                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700">
                                                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Foto Bukti Terlampir:</p>
                                                                    <img src="{{ asset('storage/' . $request->photo_path) }}" class="w-full h-48 object-cover rounded-xl shadow-lg border-2 border-white dark:border-gray-800" alt="Evidence">
                                                                </div>
                                                            @endif

                                                            <form
                                                                action="{{ route('admin.attendance-requests.update', $request->id) }}"
                                                                method="POST" class="space-y-4">
                                                                @csrf
                                                                @method('PATCH')

                                                                <div class="space-y-2">
                                                                    <label
                                                                        class="text-xs font-bold text-gray-400 uppercase tracking-widest">Keputusan</label>
                                                                    <select name="status" required
                                                                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm">
                                                                        <option value="approved">Setujui (Approved)</option>
                                                                        <option value="rejected">Tolak (Rejected)</option>
                                                                    </select>
                                                                </div>

                                                                <div class="space-y-2">
                                                                    <label
                                                                        class="text-xs font-bold text-gray-400 uppercase tracking-widest">Catatan
                                                                        (Opsional)</label>
                                                                    <textarea name="admin_note" rows="3"
                                                                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm"
                                                                        placeholder="Tulis catatan persetujuan atau alasan penolakan..."></textarea>
                                                                </div>

                                                                <div class="flex gap-3 pt-4">
                                                                    <button type="button" @click="open = false"
                                                                        class="flex-1 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-sm font-bold">Batal</button>
                                                                    <button type="submit"
                                                                        class="flex-1 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 overflow-hidden">Submit
                                                                        Keputusan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-[11px] text-gray-400 italic">Diproses pada
                                                    {{ $request->updated_at->format('d/m/y H:i') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-24 text-center">
                                            <div class="flex flex-col items-center gap-4">
                                                <div
                                                    class="w-20 h-20 bg-gray-50 dark:bg-gray-900/50 rounded-full flex items-center justify-center text-gray-200 dark:text-gray-800">
                                                    <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <p
                                                    class="text-base font-bold text-gray-500 dark:text-gray-400 tracking-tight">
                                                    Tidak Ada Pengajuan Masuk</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($requests->hasPages())
                        <div
                            class="px-8 py-6 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700">
                            {{ $requests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
