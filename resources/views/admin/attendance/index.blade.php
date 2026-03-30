<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <style>
            #mapModalContainer {
                height: 400px;
                width: 100%;
                border-radius: 1.5rem;
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight uppercase tracking-tight">
                    {{ __('Log Absensi BA') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-bold">Monitoring aktivitas Check-in &
                    Check-out secara real-time</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 dark:bg-gray-950/20 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div
                class="mb-8 bg-white dark:bg-gray-800 p-8 rounded-xl shadow-xl shadow-gray-200/40 dark:shadow-none border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('admin.attendance.index') }}"
                    class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">

                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Dari
                            Tanggal</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}"
                            class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-2 focus:ring-indigo-500 rounded-lg py-3 font-bold transition shadow-sm">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Sampai
                            Tanggal</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}"
                            class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-2 focus:ring-indigo-500 rounded-lg py-3 font-bold transition shadow-sm">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Beauty
                            Advisor</label>
                        <select name="user_id"
                            class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-2 focus:ring-indigo-500 rounded-lg py-3 font-bold transition shadow-sm">
                            <option value="">-- Semua BA --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2 flex flex-wrap gap-3">
                        <button type="submit"
                            class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-lg shadow-lg shadow-indigo-100 dark:shadow-none transition transform active:scale-95 duration-200 uppercase text-xs tracking-widest shrink-0">
                            Filter
                        </button>

                        <button type="submit" formaction="{{ route('admin.attendance.export') }}"
                            class="flex-1 py-3 bg-green-600 hover:bg-green-700 text-white font-black rounded-lg shadow-lg shadow-green-200 dark:shadow-none transition transform active:scale-95 duration-200 uppercase text-xs tracking-widest flex items-center justify-center gap-2 shrink-0 text-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Export Excel
                        </button>

                        <a href="{{ route('admin.attendance.index') }}"
                            class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-400 hover:text-gray-600 border-2 border-gray-100 dark:border-gray-700 font-black rounded-lg transition uppercase text-xs tracking-widest text-center shrink-0">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- List Section -->
            <div
                class="bg-white dark:bg-gray-800 shadow-2xl shadow-gray-200/50 dark:shadow-none sm:rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-4 md:p-10">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-4">
                            <thead>
                                <tr class="text-gray-400 text-[10px] uppercase tracking-[0.3em] font-black">
                                    <th class="pb-2 px-6">Beauty Advisor</th>
                                    <th class="pb-2 px-6">Toko / Outlet</th>
                                    <th class="pb-2 px-6">Waktu & Status</th>
                                    <th class="pb-2 px-6 text-center">Tipe</th>
                                    <th class="pb-2 px-6 text-center">Aksi</th>
                                    <th class="pb-2 px-6 text-right pr-12">Bukti Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $atten)
                                    <tr
                                        class="bg-gray-50/50 dark:bg-gray-700/20 hover:bg-white dark:hover:bg-gray-700 hover:shadow-2xl hover:shadow-indigo-100/50 dark:hover:shadow-none transition-all duration-500 rounded-lg">
                                        <td class="py-6 px-6 rounded-l-lg">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-sm shadow-lg shadow-indigo-100">
                                                    {{ strtoupper(substr($atten->user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div
                                                        class="font-black text-gray-900 dark:text-gray-100 leading-tight uppercase tracking-tight">
                                                        {{ $atten->user->name }}
                                                    </div>
                                                    <div
                                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">
                                                        {{ $atten->user->distributor->name ?? 'Internal' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6 px-6 leading-tight">
                                            <div class="font-black text-gray-700 dark:text-gray-300">
                                                {{ $atten->outlet->name ?? 'LOKASI UMUM' }}
                                            </div>
                                            <button type="button" 
                                                onclick="openMapModal({{ $atten->latitude }}, {{ $atten->longitude }}, '{{ addslashes($atten->user->name) }}')"
                                                class="text-[10px] text-gray-400 font-black hover:text-indigo-600 inline-flex items-center gap-1 mt-2 transition uppercase tracking-widest">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                </svg>
                                                LIHAT LOKASI
                                            </button>
                                        </td>
                                        <td class="py-6 px-6 whitespace-nowrap">
                                            <div
                                                class="font-black text-gray-800 dark:text-gray-200 text-base leading-none mb-1">
                                                {{ date('H:i', strtotime($atten->time)) }}
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="text-[10px] text-gray-400 font-black uppercase tracking-widest">
                                                    {{ date('d M Y', strtotime($atten->date)) }}
                                                </span>
                                                @if($atten->type === 'check-in')
                                                    @if($atten->late_minutes > 0)
                                                        <span class="bg-red-500 text-white text-[9px] px-2 py-0.5 rounded-full font-black uppercase shadow-sm">
                                                            Terlambat 
                                                            @php $h = floor($atten->late_minutes / 60); $m = $atten->late_minutes % 60; @endphp
                                                            {{ $h > 0 ? $h . 'j ' : '' }}{{ $m > 0 ? $m . 'm' : '' }}
                                                        </span>
                                                    @else
                                                        <span class="bg-green-500 text-white text-[9px] px-2 py-0.5 rounded-full font-black uppercase shadow-sm">Tepat Waktu</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-6 px-6 text-center">
                                            <span
                                                class="inline-block px-5 py-2 rounded-lg text-[10px] font-black tracking-widest uppercase {{ $atten->type === 'check-in' ? 'bg-green-500 text-white shadow-lg shadow-green-100' : 'bg-blue-600 text-white shadow-lg shadow-blue-100' }}">
                                                {{ $atten->type }}
                                            </span>
                                        </td>
                                        <td class="py-6 px-6 text-center">
                                            <a href="{{ route('admin.attendance.show', $atten) }}"
                                                class="inline-flex items-center justify-center w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm group/view"
                                                title="Lihat Detail Absensi">
                                                <svg class="w-5 h-5 transition-transform group-hover/view:scale-110"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="py-6 px-6 rounded-r-lg pr-12">
                                            <div class="flex justify-end relative group/photo">
                                                <button type="button"
                                                    onclick="openModal('{{ asset('storage/' . $atten->photo_path) }}')"
                                                    class="w-16 h-16 rounded-2xl overflow-hidden ring-4 ring-white dark:ring-gray-800 shadow-xl group/btn hover:scale-110 active:scale-95 transition-all duration-300">
                                                    <img src="{{ asset('storage/' . $atten->photo_path) }}" alt="Foto"
                                                        class="w-full h-full object-cover">
                                                    <div
                                                        class="absolute inset-0 bg-indigo-600/30 opacity-0 group-hover/btn:opacity-100 transition flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="3" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="3"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-24">
                                            <div class="flex flex-col items-center opacity-30">
                                                <svg class="w-20 h-20 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <p class="font-black tracking-widest uppercase text-xs">Belum ada data
                                                    absensi</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-12">
                        {{ $attendances->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Modal -->
    <div id="mapModal"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-gray-900/90 backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div class="relative max-w-4xl w-full transform scale-95 transition-transform duration-300">
            <button onclick="closeMapModal()"
                class="absolute -top-12 right-0 text-white hover:text-indigo-400 p-2 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-[2.5rem] shadow-2xl overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center mb-4">
                    <div>
                        <h3 id="mapModalTitle"
                            class="font-black text-gray-900 dark:text-white uppercase tracking-tight">Lokasi Absensi
                        </h3>
                        <p id="mapModalCoords"
                            class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1"></p>
                    </div>
                    <a id="externalMapLink" href="#" target="_blank"
                        class="text-[10px] bg-indigo-50 text-indigo-600 px-4 py-2 rounded-xl font-black uppercase tracking-widest hover:bg-indigo-100 transition">Buka
                        Google Maps</a>
                </div>
                <div id="mapModalContainer" class="shadow-inner bg-gray-100 dark:bg-gray-900"></div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-gray-900/90 backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div class="relative max-w-4xl w-full transform scale-95 transition-transform duration-300">
            <button onclick="closeModal()"
                class="absolute -top-12 right-0 text-white hover:text-indigo-400 p-2 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="bg-white dark:bg-gray-800 p-2 rounded-[2.5rem] shadow-2xl overflow-hidden flex justify-center">
                <img id="modalImg" src="" alt="Bukti Absensi" class="max-h-[80vh] w-auto rounded-[2rem] object-contain">
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            let detailMap = null;
            let detailMarker = null;

            function openMapModal(lat, lng, name) {
                const modal = document.getElementById('mapModal');
                document.getElementById('mapModalTitle').innerText = `Lokasi Absensi: ${name}`;
                document.getElementById('mapModalCoords').innerText = `${lat}, ${lng}`;
                document.getElementById('externalMapLink').href = `https://www.google.com/maps?q=${lat},${lng}`;

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                setTimeout(() => {
                    modal.classList.add('opacity-100');
                    modal.querySelector('div').classList.remove('scale-95');
                    modal.querySelector('div').classList.add('scale-100');

                    if (!detailMap) {
                        detailMap = L.map('mapModalContainer', {
                            attributionControl: false
                        }).setView([lat, lng], 16);
                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19
                        }).addTo(detailMap);
                        detailMarker = L.marker([lat, lng]).addTo(detailMap);
                    } else {
                        detailMap.setView([lat, lng], 16);
                        detailMarker.setLatLng([lat, lng]);
                    }

                    // Paksa render ulang peta Leaflet setelah animasi pop-up (300ms) selesai
                    setTimeout(() => {
                        detailMap.invalidateSize();
                    }, 350);
                }, 10);
            }

            function closeMapModal() {
                const modal = document.getElementById('mapModal');
                modal.classList.remove('opacity-100');
                modal.querySelector('div').classList.replace('scale-100', 'scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300);
            }

            function openModal(src) {
                const modal = document.getElementById('imageModal');
                const img = document.getElementById('modalImg');
                img.src = src;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modal.classList.add('opacity-100');
                    modal.querySelector('div').classList.remove('scale-95');
                    modal.querySelector('div').classList.add('scale-100');
                }, 10);
            }

            function closeModal() {
                const modal = document.getElementById('imageModal');
                modal.classList.remove('opacity-100');
                modal.querySelector('div').classList.replace('scale-100', 'scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300);
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                    closeMapModal();
                }
            });
        </script>
    @endpush
</x-app-layout>