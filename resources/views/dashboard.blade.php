<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ auth()->user()->isAdmin() ? __('Dashboard Admin') : __('Dashboard BA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="{{ auth()->user()->isBa() ? ($isDayOffToday ? 'bg-green-600' : ($hasCheckedInToday ? 'bg-blue-600' : 'bg-red-600')) : 'bg-indigo-600' }} rounded-lg shadow-lg p-6 mb-4 text-white transition-colors duration-500">
                <h3 class="text-lg font-bold opacity-80 uppercase tracking-wider">Selamat Datang,</h3>
                <p class="text-3xl font-extrabold">{{ auth()->user()->name }}</p>
                
                @if(auth()->user()->isBa())
                    <p class="mt-2 opacity-90">Distributor: {{ auth()->user()->distributor->name ?? '-' }}</p>
                    @if ($rbsName)
                        <p class="mt-1 opacity-90">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                RBS (Atasan): <strong>{{ $rbsName }}</strong>
                            </span>
                        </p>
                    @endif
                @endif

                @if(auth()->user()->isAdmin())
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('admin.dashboard') }}" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg text-sm font-bold transition-all border border-white/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Buka Analitik Lengkap
                        </a>
                        <a href="{{ route('admin.users.index') }}" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white text-indigo-600 hover:bg-indigo-50 rounded-lg text-sm font-bold transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Manajemen Pengguna
                        </a>
                    </div>
                @endif
                @if (auth()->user()->isBa())
                    @if ($isDayOffToday)
                        <div
                            class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-600 text-purple-600 uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Hari Libur (Day-Off)
                        </div>
                    @elseif (!$hasCheckedInToday)
                        <div
                            class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white text-red-600 uppercase tracking-wider animate-bounce">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 9V5a1 1 0 112 0v4a1 1 0 11-2 0zm1 4a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            Belum Check-In
                        </div>
                    @else
                        <div
                            class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white text-blue-600 uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Sudah Check-In
                        </div>
                    @endif
                @endif
            </div>

            @if(auth()->user()->isBa())
                @if ($isDayOffToday)
                    <div class="bg-purple-50 border-l-4 border-purple-500 p-4 mb-8 rounded-r-lg shadow-md">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-purple-800 font-bold">Status: Hari Libur (Day-Off)</h3>
                                <p class="text-purple-700">Kami mendeteksi pengajuan libur Anda telah disetujui untuk hari ini.
                                    Selamat menikmati hari libur!</p>
                            </div>
                        </div>
                    </div>
                @elseif (!$hasCheckedInToday)
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-lg shadow-md animate-pulse">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-red-800 font-bold">Peringatan: Kehadiran Diperlukan!</h3>
                                <p class="text-red-700">Sistem mendeteksi Anda belum melakukan check-in hari ini. Silahkan
                                    melakukan
                                    <a href="{{ route('attendance.create') }}"
                                        class="font-bold underline hover:text-red-900 transition-colors">
                                        check-in di sini
                                    </a> untuk mencatat kehadiran Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-lg shadow-md">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-blue-800 font-bold">Status: Sudah Absen</h3>
                                <p class="text-blue-700">Terima kasih, Anda telah melakukan check-in hari ini. Selamat bekerja!
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Alert Incomplete Attendance -->
            @if(auth()->user()->isBa() && auth()->user()->hasIncompleteAttendance())
                @php $incomplete = auth()->user()->getIncompleteAttendance(); @endphp
                <div class="bg-amber-50 border-l-4 border-amber-500 p-6 mb-8 rounded-r-xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4 animate-pulse">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-amber-100 rounded-full text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-amber-800 font-black text-sm uppercase tracking-tight">Peringatan: Absensi Belum Lengkap!</h4>
                            <p class="text-amber-700 text-xs mt-1">
                                Anda tercatat melakukan <strong>Check-in</strong> pada <strong>{{ date('d M Y', strtotime($incomplete->date)) }}</strong> pukul {{ date('H:i', strtotime($incomplete->time)) }}, namun belum melakukan <strong>Check-out</strong>.
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('attendance.request.create', ['type' => 'check-out', 'date' => $incomplete->date]) }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white text-xs font-black uppercase tracking-widest rounded-xl transition shadow-lg shadow-amber-200">
                        Ajukan Koreksi Check-out
                    </a>
                </div>
            @endif

            <!-- Alert Missing Attendance Entirely -->
            @if(auth()->user()->isBa() && auth()->user()->hasMissingAttendanceYesterday())
                <div class="bg-rose-50 border-l-4 border-rose-500 p-6 mb-8 rounded-r-xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-rose-100 rounded-full text-rose-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-rose-800 font-black text-sm uppercase tracking-tight">Peringatan: Tidak Ada Data Absensi!</h4>
                            <p class="text-rose-700 text-xs mt-1">
                                Sistem mendeteksi Anda <strong>tidak melakukan absensi sama sekali</strong> pada hari kerja kemarin ({{ date('d M Y', strtotime('-1 day')) }}). Apakah Anda lupa?
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('attendance.request.create', ['date' => date('Y-m-d', strtotime('-1 day'))]) }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white text-xs font-black uppercase tracking-widest rounded-xl transition shadow-lg shadow-rose-200">
                        Ajukan Lupa Absen
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-green-50 dark:bg-green-900/30 rounded-xl text-green-600 dark:text-green-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                            {{ auth()->user()->isAdmin() ? 'Total Laporan Seluruh BA' : 'Total Laporan Saya' }}
                        </h3>
                        <p class="text-3xl font-black text-gray-900 dark:text-white mt-1">
                            {{ number_format($stats['total_reports_month']) }}
                            <span class="text-xs font-medium text-gray-400 ml-1">Laporan</span>
                        </p>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600 dark:text-blue-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                            {{ auth()->user()->isAdmin() ? 'Total Sell Out Seluruh BA' : 'Total Sell Out Saya' }}
                        </h3>
                        <p class="text-3xl font-black text-gray-900 dark:text-white mt-1">
                            <span class="text-sm font-bold text-blue-600 mr-0.5">Rp</span>{{ number_format($stats['total_sell_out_month']) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Laporan Terkini</h3>
                        <a href="{{ route('reports.index') }}"
                            class="text-indigo-600 hover:text-indigo-900 text-sm font-bold">Lihat Semua</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700">
                                    <th class="py-4 px-4">Tanggal</th>
                                    @if(auth()->user()->isAdmin())
                                        <th class="py-4 px-4">BA</th>
                                    @endif
                                    <th class="py-4 px-4">Produk</th>
                                    <th class="py-4 px-4">QTY</th>
                                    <th class="py-4 px-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['recent_reports'] as $report)
                                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="py-3 px-4 text-xs">{{ date('d/m/Y', strtotime($report->date)) }}</td>
                                        @if(auth()->user()->isAdmin())
                                            <td class="py-3 px-4 font-semibold text-indigo-600">{{ $report->user->name }}</td>
                                        @endif
                                        <td class="py-3 px-4 font-bold">{{ $report->product->name }}</td>
                                        <td class="py-3 px-4">{{ $report->quantity }}</td>
                                        <td class="py-3 px-4 text-right font-bold text-green-600 whitespace-nowrap">Rp
                                            {{ number_format($report->total_price) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ auth()->user()->isAdmin() ? 5 : 4 }}" class="text-center py-4 text-gray-500 italic">Belum ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
