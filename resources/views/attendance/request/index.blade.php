<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pengajuan (Absen & Day-Off)') }}
            </h2>
            <a href="{{ route('attendance.request.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl text-sm shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5">
                Buat Pengajuan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg flex items-center gap-3 animate-fade-in" role="alert">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none sm:rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">Riwayat Pengajuan</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Daftar permohonan koreksi absensi dan hari libur Anda</p>
                </div>

                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/80 dark:bg-gray-700/50">
                                    <th class="py-4 px-8 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">Tanggal & Waktu</th>
                                    <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">Tipe</th>
                                    <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">Alasan</th>
                                    <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">Status</th>
                                    <th class="py-4 px-8 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500 text-right">Catatan Admin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                                @forelse($requests as $request)
                                    <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-900/20 transition-all duration-300">
                                        <td class="py-5 px-8">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200 tracking-tight">{{ \Carbon\Carbon::parse($request->date)->format('d M Y') }}</span>
                                                @if($request->type !== 'day-off')
                                                    <span class="text-[11px] text-gray-400 font-medium">{{ \Carbon\Carbon::parse($request->time)->format('H:i') }} WIB</span>
                                                @else
                                                    <span class="text-[11px] text-gray-400 font-medium italic">Seharian</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-5 px-6">
                                            @php
                                                $typeColor = match($request->type) {
                                                    'check-in' => 'bg-blue-50 text-blue-700 border-blue-100 dark:bg-blue-900/30 dark:text-blue-400',
                                                    'check-out' => 'bg-indigo-50 text-indigo-700 border-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400',
                                                    'day-off' => 'bg-purple-50 text-purple-700 border-purple-100 dark:bg-purple-900/30 dark:text-purple-400',
                                                    default => 'bg-gray-50 text-gray-700 border-gray-100 dark:bg-gray-900/30 dark:text-gray-400'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold {{ $typeColor }} border uppercase tracking-wider">
                                                {{ str_replace('-', ' ', $request->type) }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-6">
                                            <p class="text-xs text-gray-600 dark:text-gray-400 max-w-xs truncate" title="{{ $request->reason }}">
                                                {{ $request->reason }}
                                            </p>
                                        </td>
                                        <td class="py-5 px-6">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                    'approved' => 'bg-green-50 text-green-700 border-green-100 dark:bg-green-900/30 dark:text-green-400',
                                                    'rejected' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/30 dark:text-red-400',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border {{ $statusClasses[$request->status] }}">
                                                {{ $request->status }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-8 text-right">
                                            <span class="text-[11px] text-gray-500 dark:text-gray-400 italic">
                                                {{ $request->admin_note ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-24 text-center">
                                            <div class="flex flex-col items-center gap-4">
                                                <div class="w-20 h-20 bg-gray-50 dark:bg-gray-900/50 rounded-full flex items-center justify-center text-gray-200 dark:text-gray-800">
                                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-base font-bold text-gray-500 dark:text-gray-400 tracking-tight">Belum Ada Pengajuan</p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-600">Klik tombol "Buat Pengajuan Baru" untuk memulai.</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($requests->hasPages())
                        <div class="px-8 py-6 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700">
                            {{ $requests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
