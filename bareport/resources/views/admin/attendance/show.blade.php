<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <style>
            #map {
                height: 200px;
                width: 100%;
                border-radius: 1rem;
                z-index: 1;
                background-color: #f3f4f6;
            }

            .leaflet-container {
                font-family: inherit;
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.attendance.index') }}"
                                class="text-xs font-bold text-gray-400 hover:text-indigo-600 uppercase tracking-widest transition">
                                Log Absensi
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="ml-1 text-xs font-bold text-indigo-600 uppercase tracking-widest">Detail
                                    Absensi</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    Detail Absensi: <span class="text-indigo-600">{{ $attendance->user->name }}</span>
                </h2>
            </div>
            <a href="{{ route('admin.attendance.index') }}"
                class="px-6 py-3 bg-white border-2 border-gray-100 hover:bg-gray-50 text-gray-500 font-bold rounded-xl transition flex items-center gap-2 text-sm shadow-sm group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/30 dark:bg-gray-950/20">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Info Section (Main) -->
                <div
                    class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <span
                                class="px-5 py-2 rounded-lg text-[10px] font-black tracking-widest uppercase {{ $attendance->type === 'check-in' ? 'bg-green-500 text-white shadow-lg shadow-green-100' : 'bg-blue-600 text-white shadow-lg shadow-blue-100' }}">
                                {{ $attendance->type }}
                            </span>
                            <div class="text-right">
                                <span
                                    class="block text-xl font-black text-gray-900 dark:text-white">{{ date('d M Y', strtotime($attendance->date)) }}</span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Tanggal
                                    Absensi</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                            <div class="space-y-6">
                                <div class="pb-6 border-b border-gray-50 dark:border-gray-700">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">
                                        Waktu Check</div>
                                    <div class="text-4xl font-black text-indigo-600 mb-2">
                                        {{ date('H:i', strtotime($attendance->time)) }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">
                                        Beauty Advisor</div>
                                    <div class="font-black text-gray-800 dark:text-gray-100 uppercase">
                                        {{ $attendance->user->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 font-bold mt-0.5">
                                        {{ $attendance->user->distributor->name ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="pb-6 border-b border-gray-50 dark:border-gray-700">
                                    <div class="font-black text-gray-800 dark:text-gray-100 text-lg leading-tight">
                                        {{ $attendance->outlet->name ?? 'LOKASI UMUM' }}
                                    </div>

                                    <!-- Embedded Leaflet Map -->
                                    <div id="map" class="mt-4"></div>

                                    <div class="flex flex-wrap gap-2 mt-4">
                                        <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 text-indigo-600 border border-indigo-100 dark:border-indigo-900 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Google Maps
                                        </a>
                                    </div>
                                </div>

                                <div
                                    class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                                    <div class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">
                                        Koordinat GPS</div>
                                    <div class="text-xs font-mono font-bold text-gray-600 dark:text-gray-400">
                                        {{ $attendance->latitude }}, {{ $attendance->longitude }}
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4">
                                    <div
                                        class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                                        <div
                                            class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">
                                            Sumber Data</div>
                                        <div class="flex items-center gap-2">
                                            @if($attendance->attendance_request_id)
                                                <span
                                                    class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[9px] font-black uppercase rounded">Pengajuan
                                                    Manual</span>
                                            @else
                                                <span
                                                    class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[9px] font-black uppercase rounded">Sistem
                                                    (Aplikasi)</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($attendance->attendanceRequest)
                                        <div
                                            class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-xl border border-indigo-100 dark:border-indigo-900/50">
                                            <div
                                                class="text-[9px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-1">
                                                Keterangan (Alasan)</div>
                                            <p
                                                class="text-xs text-indigo-700 dark:text-indigo-300 font-medium leading-relaxed italic">
                                                "{{ $attendance->attendanceRequest->reason }}"
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documentation Section (Smaller Photo) -->
                <div class="lg:col-span-1 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-50 dark:border-gray-700 bg-gray-50/30">
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.25em]">Dokumentasi
                                Foto</h3>
                        </div>
                        <div class="p-6">
                            <div class="relative group cursor-pointer"
                                onclick="window.open('{{ asset('storage/' . $attendance->photo_path) }}', '_blank')">
                                <div
                                    class="aspect-[3/4] rounded-lg overflow-hidden ring-4 ring-white dark:ring-gray-900 shadow-xl">
                                    <img src="{{ asset('storage/' . $attendance->photo_path) }}" alt="Bukti Foto"
                                        class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                                </div>
                                <div
                                    class="absolute inset-0 bg-indigo-600/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                                    <div
                                        class="p-3 bg-white/90 rounded-full shadow-2xl transform scale-75 group-hover:scale-100 transition-transform duration-300">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p
                                class="mt-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-relaxed">
                                Klik untuk melihat resolusi penuh
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const lat = {{ $attendance->latitude }};
                const lng = {{ $attendance->longitude }};

                const map = L.map('map', {
                    attributionControl: false,
                    scrollWheelZoom: false
                }).setView([lat, lng], 16);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(map);

                const customIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div style="background-color:#4f46e5; width:12px; height:12px; border:2px solid white; border-radius:50%; box-shadow:0 0 5px rgba(0,0,0,0.3);"></div>`,
                    iconSize: [12, 12],
                    iconAnchor: [6, 6]
                });

                L.marker([lat, lng], { icon: customIcon }).addTo(map);

                // Add circle for accuracy/area feel
                L.circle([lat, lng], {
                    color: '#4f46e5',
                    fillColor: '#4f46e5',
                    fillOpacity: 0.1,
                    radius: 50
                }).addTo(map);

                setTimeout(() => {
                    map.invalidateSize();
                }, 500);
            });
        </script>
    @endpush
</x-app-layout>