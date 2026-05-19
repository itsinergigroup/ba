<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Riwayat Laporan') }}
            </h2>
            <div class="flex gap-2">
                @if(auth()->user()->isAnyViewer())
                    <a href="{{ route('reports.export', request()->all()) }}" 
                        id="export_excel_btn"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export Excel
                    </a>
                @endif
                
                @if(auth()->user()->isBa())
                    <a href="{{ route('reports.create') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                        + Input Laporan Baru
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100 p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Filters -->
                <div class="mb-6 p-4 border border-gray-100 dark:border-gray-700 rounded-lg">
                    <form method="GET" action="{{ route('reports.index') }}"
                        class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <x-input-label for="start_date" :value="__('Dari Tanggal')" />
                            <x-text-input id="start_date" name="start_date" type="date"
                                class="block mt-1 w-full text-xs" value="{{ request('start_date') }}" />
                        </div>
                        <div>
                            <x-input-label for="end_date" :value="__('Sampai Tanggal')" />
                            <x-text-input id="end_date" name="end_date" type="date" class="block mt-1 w-full text-xs"
                                value="{{ request('end_date') }}" />
                        </div>
                        <div>
                            <x-input-label for="outlet_id" :value="__('Toko')" />
                            <select name="outlet_id" id="outlet_filter"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-xs">
                                <option value="">-- Semua Toko --</option>
                                @foreach($outlets as $outlet)
                                    <option value="{{ $outlet->id }}" {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="distributor_id" :value="__('Distributor')" />
                            <select name="distributor_id" id="distributor_filter" onchange="fetchBAs(this.value)"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-xs">
                                <option value="">-- Semua Distributor --</option>
                                @foreach($distributors as $dist)
                                    <option value="{{ $dist->id }}" {{ request('distributor_id') == $dist->id ? 'selected' : '' }}>{{ $dist->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->isAnyViewer())
                        <div>
                            <x-input-label for="user_id" :value="__('Beauty Advisor')" />
                            <select name="user_id" id="user_filter" onchange="fetchBAData(this.value)"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-xs">
                                <option value="">-- Semua BA --</option>
                                @foreach($bas as $ba)
                                    <option value="{{ $ba->id }}" {{ request('user_id') == $ba->id ? 'selected' : '' }}>{{ $ba->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="flex items-end gap-2">
                            <x-primary-button class="w-full justify-center">
                                Filter
                            </x-primary-button>
                            <a href="{{ route('reports.index') }}"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded text-xs hover:bg-gray-300 dark:text-gray-100 italic">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                <th class="py-3 px-4">Tanggal</th>
                                @if(auth()->user()->isAnyViewer())
                                    <th class="py-3 px-4">BA Name</th>
                                @endif
                                <th class="py-3 px-4">Toko</th>
                                <th class="py-3 px-4">Distributor</th>
                                <th class="py-3 px-4 text-center">Jumlah Item</th>
                                <th class="py-3 px-4 text-right">Total Penjualan</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $groupId => $items)
                                @php $first = $items->first(); @endphp
                                <tr
                                    class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium">
                                    <td class="py-3 px-4">
                                        <div class="font-bold">{{ date('d M Y', strtotime($first->date)) }}</div>
                                        <div class="text-[10px] text-gray-500 uppercase">{{ $groupId ?? 'N/A' }}</div>
                                    </td>
                                    @if(auth()->user()->isAnyViewer())
                                        <td class="py-3 px-4 text-xs font-medium">{{ optional($first->user)->name ?? 'N/A' }}</td>
                                    @endif
                                    <td class="py-3 px-4">
                                        <div class="font-bold text-indigo-600">{{ $first->outlet->name }}</div>
                                        <div class="text-[10px] text-gray-500 italic">{{ $first->account_type }} |
                                            {{ $first->channel }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-xs font-medium">{{ $first->distributor->name }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-indigo-100 text-indigo-800">
                                            {{ $items->count() }} SKU
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="font-black text-gray-900 dark:text-gray-100">
                                            Rp {{ number_format($items->sum('total_price')) }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-center space-x-1">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('reports.show', $first->id) }}"
                                               class="inline-flex items-center p-2 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white rounded-xl transition duration-200"
                                               title="Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            
                                            @if(auth()->user()->isBa())
                                                <a href="{{ route('reports.edit', $first->id) }}"
                                                   class="inline-flex items-center p-2 bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 hover:bg-amber-600 hover:text-white rounded-xl transition duration-200"
                                                   title="Ubah">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <form action="{{ route('reports.destroy', $first->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center p-2 bg-red-50 dark:bg-red-900/40 text-red-600 dark:text-red-400 hover:bg-red-600 hover:text-white rounded-xl transition duration-200"
                                                            title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10 text-gray-500 italic">Belum ada laporan yang
                                        disubmit.</td>
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
    </div>
    @push('scripts')
    <script>
        function fetchBAData(userId) {
            const outletFilter = document.getElementById('outlet_filter');
            const distributorFilter = document.getElementById('distributor_filter');
            
            if (!userId) {
                location.reload(); // Easier to reset all filters
                return;
            }

            fetch(`/api/users/${userId}/data`)
                .then(response => response.json())
                .then(data => {
                    // Update Outlets
                    outletFilter.innerHTML = '<option value="">-- Semua Toko --</option>';
                    data.outlets.forEach(outlet => {
                        outletFilter.innerHTML += `<option value="${outlet.id}">${outlet.name}</option>`;
                    });

                    // Update Distributor
                    if (data.distributor) {
                        distributorFilter.value = data.distributor.id;
                    }
                    updateExportLinks();
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function fetchBAs(distributorId) {
            const userFilter = document.getElementById('user_filter');
            if (!userFilter) return; // For non-admin roles

            if (!distributorId) {
                // Fetch all BAs instead of reloading
                fetch(`/api/bas/all`)
                    .then(response => response.json())
                    .then(data => {
                        userFilter.innerHTML = '<option value="">-- Semua BA --</option>';
                        data.forEach(ba => {
                            userFilter.innerHTML += `<option value="${ba.id}">${ba.name}</option>`;
                        });
                        updateExportLinks();
                    });
                return;
            }

            fetch(`/api/distributors/${distributorId}/bas`)
                .then(response => response.json())
                .then(data => {
                    userFilter.innerHTML = '<option value="">-- Semua BA --</option>';
                    data.forEach(ba => {
                        userFilter.innerHTML += `<option value="${ba.id}">${ba.name}</option>`;
                    });
                    updateExportLinks();
                })
                .catch(error => console.error('Error fetching BAs:', error));
        }

        function updateExportLinks() {
            const start = document.getElementById('start_date').value;
            const end = document.getElementById('end_date').value;
            const dist = document.getElementById('distributor_filter').value;
            const outlet = document.getElementById('outlet_filter').value;
            const ba = document.getElementById('user_filter'); // Might be null for BA role
            const baValue = ba ? ba.value : null;

            const params = new URLSearchParams();
            if (start) params.append('start_date', start);
            if (end) params.append('end_date', end);
            if (dist) params.append('distributor_id', dist);
            if (outlet) params.append('outlet_id', outlet);
            if (baValue) params.append('user_id', baValue);

            const excelBtn = document.getElementById('export_excel_btn');
            if (excelBtn) {
                const excelUrl = new URL("{{ route('reports.export') }}", window.location.origin);
                excelUrl.search = params.toString();
                excelBtn.href = excelUrl.href;
            }
        }

        // Listen for any filter changes
        document.querySelectorAll('input, select').forEach(el => {
            if (el.id && (el.id.includes('date') || el.id.includes('filter'))) {
                el.addEventListener('change', updateExportLinks);
            }
        });
    </script>
    @endpush
</x-app-layout>
