<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard BA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="{{ $hasCheckedInToday ? 'bg-blue-600' : 'bg-red-600' }} rounded-lg shadow-lg p-6 mb-4 text-white transition-colors duration-500">
                <h3 class="text-lg font-bold opacity-80 uppercase tracking-wider">Selamat Datang,</h3>
                <p class="text-3xl font-extrabold">{{ auth()->user()->name }}</p>
                <p class="mt-2 opacity-90">Distributor: {{ auth()->user()->distributor->name ?? '-' }}</p>
                @if (!$hasCheckedInToday)
                    <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white text-red-600 uppercase tracking-wider animate-bounce">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 9V5a1 1 0 112 0v4a1 1 0 11-2 0zm1 4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                        Belum Check-In
                    </div>
                @else
                    <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white text-blue-600 uppercase tracking-wider">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Sudah Check-In
                    </div>
                @endif
            </div>

            @if (!$hasCheckedInToday)
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
                            <p class="text-red-700">Sistem mendeteksi Anda belum melakukan check-in hari ini. Silahkan melakukan
                                <a href="{{ route('attendance.create') }}" class="font-bold underline hover:text-red-900 transition-colors">
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
                            <p class="text-blue-700">Terima kasih, Anda telah melakukan check-in hari ini. Selamat bekerja!</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total
                        Laporan Bulan Ini</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_reports_month'] }}
                    </p>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Sell
                        Penjualan Bulan Ini</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Rp
                        {{ number_format($stats['total_sell_out_month']) }}
                    </p>
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
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                    <th class="py-3 px-4 text-gray-500">Tanggal</th>
                                    <th class="py-3 px-4 text-gray-500">Produk</th>
                                    <th class="py-3 px-4 text-gray-500">QTY</th>
                                    <th class="py-3 px-4 text-gray-500 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['recent_reports'] as $report)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="py-3 px-4">{{ date('d/m/Y', strtotime($report->date)) }}</td>
                                        <td class="py-3 px-4 font-bold">{{ $report->product->name }}</td>
                                        <td class="py-3 px-4">{{ $report->quantity }}</td>
                                        <td class="py-3 px-4 text-right font-bold text-green-600">Rp
                                            {{ number_format($report->total_price) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-gray-500 italic">Belum ada data.</td>
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