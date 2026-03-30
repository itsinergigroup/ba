<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Laporan Penjualan') }}
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('reports.edit', $mainReport->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Ubah
                </a>
                <form action="{{ route('reports.destroy', $mainReport->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh laporan transaksi ini?');"
                    class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Hapus
                    </button>
                </form>
                <a href="{{ url()->previous() == route('reports.show', $mainReport->id) ? route('dashboard') : url()->previous() }}"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Detail Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">
                <!-- Header Status -->
                <div class="px-8 py-6 bg-indigo-600 text-white">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <p class="text-indigo-100 text-xs uppercase tracking-wider font-bold mb-1">ID LAPORAN:
                                #{{ $mainReport->id }}</p>
                            <h3 class="text-2xl font-black">Laporan Selesai</h3>
                        </div>
                        <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl border border-white/30">
                            <p class="text-xs text-indigo-100 mb-1">Tanggal Penjualan</p>
                            <p class="font-bold text-lg">{{ date('d F Y', strtotime($mainReport->date)) }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Grid Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

                        <!-- Col 1: BA & Store Info -->
                        <div class="space-y-8">
                            <div>
                                <h4
                                    class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 border-b pb-2">
                                    Informasi BA & Distributor</h4>
                                <div class="space-y-4">
                                    <div class="flex items-start gap-4">
                                        <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl">
                                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Beauty Advisor</p>
                                            <p class="text-gray-900 dark:text-gray-100 font-bold text-lg">
                                                {{ $mainReport->user->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-4">
                                        <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-2xl">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Distributor</p>
                                            <p class="text-gray-900 dark:text-gray-100 font-bold">
                                                {{ $mainReport->distributor->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-4 px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl grid grid-cols-2 gap-4 border border-gray-100 dark:border-gray-700">
                                        <div>
                                            <p class="text-[10px] text-gray-500 uppercase font-black">Account Type</p>
                                            <p class="font-bold text-indigo-600">{{ $mainReport->account_type }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-500 uppercase font-black">Chanel</p>
                                            <p class="font-bold text-indigo-600">{{ $mainReport->channel }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4
                                    class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 border-b pb-2">
                                    Informasi Lokasi Toko</h4>
                                <div class="space-y-4">
                                    <div class="flex items-start gap-4">
                                        <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl">
                                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Nama Toko</p>
                                            <p class="text-gray-900 dark:text-gray-100 font-bold text-lg leading-tight">
                                                {{ $mainReport->outlet->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $mainReport->outlet->city->name }},
                                                {{ $mainReport->outlet->city->province->name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Col 2: Product & Pricing -->
                        <div class="space-y-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b pb-2">
                                Item Produk ({{ $reports->count() }} SKU)</h4>

                            <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($reports as $item)
                                    <div
                                        class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-700 relative overflow-hidden transition hover:shadow-md">
                                        <div class="relative z-10">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <p class="text-[9px] font-black text-indigo-500 uppercase">
                                                        {{ $item->brand->name }}
                                                    </p>
                                                    <p
                                                        class="text-sm font-black text-gray-900 dark:text-white leading-tight">
                                                        {{ $item->product->name }}
                                                    </p>
                                                </div>
                                                <span
                                                    class="px-2 py-1 bg-indigo-600 text-white rounded-lg text-[10px] font-black">
                                                    {{ $item->quantity }} Pcs
                                                </span>
                                            </div>

                                            <div
                                                class="grid grid-cols-2 gap-4 mt-3 pt-3 border-t border-dashed border-gray-200 dark:border-gray-600">
                                                <div>
                                                    <p class="text-[9px] text-gray-400 uppercase font-bold">Harga Jual</p>
                                                    <p class="text-xs font-bold text-gray-900 dark:text-white">Rp
                                                        {{ number_format($item->unit_price) }}
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-[9px] text-gray-400 uppercase font-bold">Subtotal</p>
                                                    <p class="text-xs font-black text-indigo-600">Rp
                                                        {{ number_format($item->total_price) }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-2 flex items-center gap-2">
                                                <span
                                                    class="text-[10px] font-bold text-red-500 bg-red-50 px-1.5 rounded">Disc:
                                                    {{ number_format($item->discount, 1) }}%</span>
                                                <span class="text-[10px] text-gray-400 italic">HET: Rp
                                                    {{ number_format($item->het) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Total Price Card -->
                            <div
                                class="p-6 bg-gray-50 dark:bg-gray-700/50 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-600 translate-y-2">
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">
                                    Total Penjualan</p>
                                <div class="flex items-baseline gap-2 text-black dark:text-white">
                                    <span class="font-bold text-lg opacity-40">Rp</span>
                                    <h5 class="text-4xl font-black tracking-tighter">
                                        {{ number_format($reports->sum('total_price')) }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Action if needed -->
                <div class="px-8 py-4 bg-gray-50 dark:bg-gray-700/30 border-t dark:border-gray-700 text-right">
                    <p class="text-[10px] text-gray-500 font-medium italic italic">Terakhir diupdate:
                        {{ $mainReport->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>