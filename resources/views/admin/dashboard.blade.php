<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.dashboard') }}"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                        <div>
                            <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                            <x-text-input id="start_date" name="start_date" type="date"
                                class="block mt-1 w-full text-sm" value="{{ request('start_date') }}" />
                        </div>
                        <div>
                            <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                            <x-text-input id="end_date" name="end_date" type="date" class="block mt-1 w-full text-sm"
                                value="{{ request('end_date') }}" />
                        </div>
                        <div>
                            <x-input-label for="distributor_id" :value="__('Distributor')" />
                            <select name="distributor_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm">
                                <option value="">-- Semua Distributor --</option>
                                @foreach($distributors as $distributor)
                                    <option value="{{ $distributor->id }}" {{ request('distributor_id') == $distributor->id ? 'selected' : '' }}>
                                        {{ $distributor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="outlet_id" :value="__('Toko')" />
                            <select name="outlet_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm">
                                <option value="">-- Semua Toko --</option>
                                @foreach($outlets as $outlet)
                                    <option value="{{ $outlet->id }}" {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="user_id" :value="__('Beauty Advisor')" />
                            <select name="user_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm">
                                <option value="">-- Semua BA --</option>
                                @foreach($bas as $ba)
                                    <option value="{{ $ba->id }}" {{ request('user_id') == $ba->id ? 'selected' : '' }}>
                                        {{ $ba->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <x-primary-button class="w-full justify-center py-2.5">
                                {{ __('Filter') }}
                            </x-primary-button>
                        </div>
                    </form>
                    <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('admin.export.reports', array_merge(request()->all(), ['format' => 'xlsx'])) }}"
                            class="px-4 py-2 bg-green-600 text-white rounded text-sm font-semibold hover:bg-green-700 transition flex items-center whitespace-nowrap">
                            Export Excel
                        </a>
                        <a href="{{ route('admin.export.reports', array_merge(request()->all(), ['format' => 'csv'])) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-semibold hover:bg-blue-700 transition flex items-center whitespace-nowrap">
                            Export CSV
                        </a>
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded text-sm hover:bg-gray-300 dark:text-gray-100 italic">Reset
                            Filter</a>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-indigo-500">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total BA
                        Aktif</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_ba_active'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total
                        Laporan (Filtered)</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($stats['total_reports']) }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-orange-500">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Sell
                        Out</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Rp
                        {{ number_format($stats['total_sell_out']) }}
                    </p>
                </div>
            </div>

            <!-- Sales Chart -->
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Tren Penjualan Bulanan ({{ date('Y') }})</h3>
                    <div class="relative w-full" style="height: 300px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Riwayat Penjualan Section -->
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Riwayat Penjualan (Ringkasan)</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700 font-bold">
                                    <th class="py-3 px-4">BA</th>
                                    <th class="py-3 px-4 text-[10px] uppercase">ID Transaksi</th>
                                    <th class="py-3 px-4">Tanggal</th>
                                    <th class="py-3 px-4">Distributor</th>
                                    <th class="py-3 px-4">Toko</th>
                                    <th class="py-3 px-4">Produk</th>
                                    <th class="py-3 px-4">QTY</th>
                                    <th class="py-3 px-4">Harga Jual</th>
                                    <th class="py-3 px-4">Diskon</th>
                                    <th class="py-3 px-4 text-right">Total Penjualan</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                    <tr
                                        class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="py-3 px-4 font-medium text-indigo-600 dark:text-indigo-400">
                                            {{ $report->user->name }}
                                        </td>
                                        <td class="py-3 px-4 text-[9px] font-mono text-gray-500 uppercase">
                                            {{ $report->group_id ?? '-' }}
                                        </td>
                                        <td class="py-3 px-4">{{ date('d M Y', strtotime($report->date)) }}</td>
                                        <td class="py-3 px-4 text-gray-500 italic">{{ $report->distributor->name }}</td>
                                        <td class="py-3 px-4">{{ $report->outlet->name }}</td>
                                        <td class="py-3 px-4">
                                            <div class="font-bold">{{ $report->product->name }}</div>
                                            <div class="text-[10px] text-gray-500">{{ $report->brand->name }}</div>
                                        </td>
                                        <td class="py-3 px-4">{{ $report->quantity }}</td>
                                        <td class="py-3 px-4">Rp {{ number_format($report->unit_price) }}</td>
                                        <td class="py-3 px-4">
                                            <span
                                                class="text-[10px] font-bold text-red-600 bg-red-50 dark:bg-red-900/20 px-1 rounded">
                                                {{ number_format($report->discount, 2) }}%
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-right font-bold text-gray-900 dark:text-gray-100">
                                            Rp {{ number_format($report->total_price) }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <a href="{{ route('reports.show', $report->id) }}"
                                                class="inline-flex items-center p-2 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 dark:hover:text-white rounded-xl transition duration-200 shadow-sm"
                                                title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-10 text-gray-500 italic">Belum ada data
                                            penjualan yang sesuai kriteria.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $reports->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

            <!-- BA Summary Section -->
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Ringkasan Per BA</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b dark:border-gray-700 font-bold bg-gray-50 dark:bg-gray-700">
                                    <th class="py-3 px-4">Nama BA</th>
                                    <th class="py-3 px-4 text-center">Total Laporan</th>
                                    <th class="py-3 px-4 text-center">Total Qty</th>
                                    <th class="py-3 px-4 text-right">Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ba_summary as $summary)
                                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3 px-4 font-bold text-indigo-600 dark:text-indigo-400">
                                            {{ $summary->user->name }}
                                        </td>
                                        <td class="py-3 px-4 text-center">{{ $summary->total_reports }}</td>
                                        <td class="py-3 px-4 text-center">{{ number_format($summary->total_qty) }}</td>
                                        <td class="py-3 px-4 text-right font-bold text-gray-900 dark:text-gray-100">
                                            Rp {{ number_format($summary->total_sales) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $ba_summary->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('salesChart').getContext('2d');
                const data = @json($chart_data);
                const labels = @json($chart_labels);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            data: data,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#4f46e5',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(156, 163, 175, 0.1)'
                                },
                                ticks: {
                                    callback: function (value) {
                                        return 'Rp ' + (value >= 1000000 ? (value / 1000000).toFixed(1) + 'jt' : value.toLocaleString('id-ID'));
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>