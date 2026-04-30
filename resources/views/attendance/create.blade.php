<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <style>
            #map {
                height: 280px !important;
                max-height: 280px !important;
                width: 100%;
                border-radius: 1.5rem;
                z-index: 5;
                background-color: #f3f4f6;
                overflow: hidden;
                border: 4px solid white;
                box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .leaflet-container {
                background: transparent !important;
                outline: none;
            }

            .mapboxgl-ctrl-bottom-right {
                display: none;
                /* Menyembunyikan logo mapbox agar lebih clean jika dinginkan */
            }

            /* Removed HERE Maps specific CSS as per instruction */
            /* .H_logo,
                                                                                                            .H_btn {
                                                                                                                display: none !important;
                                                                                                            } */

            @keyframes pulse-marker {
                0% {
                    transform: scale(0.95);
                    box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.7);
                }

                70% {
                    transform: scale(1);
                    box-shadow: 0 0 0 10px rgba(79, 70, 229, 0);
                }

                100% {
                    transform: scale(0.95);
                    box-shadow: 0 0 0 0 rgba(79, 70, 229, 0);
                }
            }
        </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Absensi') }} <span class="text-indigo-600">({{ strtoupper($nextType) }})</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 dark:bg-gray-900/50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.08)] dark:shadow-none rounded-[2.5rem] overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-6 sm:p-10">
                    @if(session('error'))
                        <div class="flex items-center gap-3 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl mb-8"
                            role="alert">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-bold">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form id="attendanceForm" action="{{ route('attendance.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $nextType }}">
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="photo" id="photoData">

                        {{-- Section Pilih Toko dihapus sesuai permintaan --}}
                        <input type="hidden" name="outlet_id" id="outlet_id"
                            value="{{ $outlets->count() === 1 ? $outlets->first()->id : '' }}">

                        <!-- Camera Preview -->
                        <div class="mb-10 text-center">
                            <label
                                class="inline-block text-[10px] font-black uppercase tracking-[0.2em] text-indigo-600 bg-indigo-50 dark:bg-indigo-900/30 px-4 py-1.5 rounded-full mb-4">
                                Bukti Foto Kehadiran
                            </label>

                            <div id="camera_container"
                                class="relative mx-auto aspect-square max-w-sm bg-gray-900 rounded-[2.5rem] overflow-hidden shadow-2xl shadow-indigo-100 dark:shadow-none border-8 border-white dark:border-gray-700">
                                <video id="video" class="w-full h-full object-cover" autoplay playsinline></video>
                                <canvas id="canvas" class="hidden"></canvas>
                                <img id="capturedImg" class="hidden w-full h-full object-cover">

                                <div id="permission_overlay"
                                    class="absolute inset-0 flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900 z-10 p-6 text-center">
                                    <div
                                        class="w-20 h-20 bg-indigo-50 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mb-6">
                                        <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-black text-lg mb-2">Akses Kamera Diperlukan</h3>
                                    <p class="text-sm text-gray-500 mb-6">Kami memerlukan akses kamera untuk bukti
                                        kehadiran Anda.</p>
                                    <button type="button" onclick="startCamera()"
                                        class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-black shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                                        Izinkan Kamera
                                    </button>
                                </div>

                                <!-- Shutter Effect -->
                                <div id="shutter"
                                    class="absolute inset-0 bg-white opacity-0 pointer-events-none z-50 transition-opacity duration-100">
                                </div>
                            </div>

                            <div class="mt-8 flex justify-center gap-4">
                                <button type="button" id="snapBtn" onclick="takeSnapshot()"
                                    class="hidden px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black flex items-center gap-3 shadow-xl shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Ambil Foto
                                </button>
                                <button type="button" id="retakeBtn" onclick="retakePhoto()"
                                    class="hidden px-10 py-4 bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-2xl font-black flex items-center gap-3 border border-gray-100 dark:border-gray-600 shadow-lg hover:bg-gray-50 transition-all duration-300">
                                    <svg class="w-6 h-6 opacity-60" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Foto Ulang
                                </button>
                            </div>
                        </div>

                        <!-- Location Preview with Leaflet (Refined) -->
                        <div class="mb-10">
                            <div class="text-center mb-6">
                                <label
                                    class="inline-block text-[10px] font-black uppercase tracking-[0.2em] text-indigo-600 bg-indigo-50 dark:bg-indigo-900/30 px-4 py-1.5 rounded-full">
                                    Verifikasi Lokasi & Map
                                </label>
                            </div>

                            <div
                                class="p-1 bg-white dark:bg-gray-800 rounded-[2rem] shadow-2xl shadow-indigo-100/30 dark:shadow-none border border-gray-50 dark:border-gray-700 overflow-hidden">
                                <div class="relative group">
                                    <div id="map" class="bg-gray-50 dark:bg-gray-900 overflow-hidden">
                                        <div id="mapLoader" class="flex items-center justify-center h-full">
                                            <div class="text-center p-6">
                                                <div
                                                    class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-3 animate-bounce">
                                                    <svg class="w-5 h-5 text-indigo-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p
                                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                                    Menyiapkan Peta...</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Source Badge Overlay -->
                                    <div class="absolute top-4 left-4 z-[1000]">
                                        <div
                                            class="flex items-center gap-2 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md px-3 py-1.5 rounded-full shadow-lg border border-white/50 dark:border-gray-700/50">
                                            <div id="locationDot"
                                                class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse border-2 border-white shadow-sm">
                                            </div>
                                            <span id="locationSource"
                                                class="text-[9px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Mencari
                                                Posisi...</span>
                                        </div>
                                    </div>

                                </div>

                                <div
                                    class="p-5 bg-gray-50/80 dark:bg-gray-900/80 border-t border-gray-100 dark:border-gray-800">
                                    <div id="locationStatus" class="flex items-start gap-4">
                                        <div
                                            class="w-10 h-10 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center shadow-md border border-gray-100 dark:border-gray-700 shrink-0 mt-1">
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 20l-5.447-2.724A2 2 0 013 15.485V5.122a2 2 0 011.082-1.789l5.447-2.724a2 2 0 011.742 0l5.447 2.724A2 2 0 0118 5.485v10.363a2 2 0 01-1.082 1.789L11.47 20.37a2 2 0 01-1.742 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <!-- Map Tools Row -->
                                            <div class="flex items-center gap-2 mb-3">
                                                <!-- Google Maps Redirect Button -->
                                                <a id="googleMapsBtn" href="#" target="_blank"
                                                    class="hidden flex items-center justify-center gap-2 bg-white dark:bg-gray-800 px-3 py-2 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm hover:bg-gray-50 transition-all duration-200 group">
                                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                                            fill="#4285F4" />
                                                        <path
                                                            d="M12 11.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"
                                                            fill="#34A853" />
                                                    </svg>
                                                    <span
                                                        class="text-[10px] font-black text-gray-600 dark:text-gray-400 uppercase tracking-widest">Maps</span>
                                                </a>

                                                <!-- Refresh Button -->
                                                <button type="button" onclick="getLocation()"
                                                    class="flex items-center justify-center gap-2 bg-white dark:bg-gray-800 px-3 py-2 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm hover:bg-gray-50 transition-all duration-200 group">
                                                    <svg class="w-4 h-4 text-indigo-600 transition-transform group-active:rotate-180 duration-500"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                        </path>
                                                    </svg>
                                                    <span
                                                        class="text-[10px] font-black text-gray-600 dark:text-gray-400 uppercase tracking-widest">Reload</span>
                                                </button>
                                            </div>

                                            <div
                                                class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 opacity-70">
                                                Informasi Lokasi Precision</div>
                                            <div id="locationText"
                                                class="font-black text-gray-900 dark:text-gray-100 text-xs sm:text-sm leading-snug break-words">
                                                Mencari data lokasi...
                                            </div>
                                            <!-- Detail lokasi tambahan -->
                                            <div id="locationDetail" class="hidden mt-3 flex flex-wrap gap-1.5">
                                                <span id="locationBadgeKelurahan"
                                                    class="hidden items-center gap-1.5 bg-white dark:bg-gray-800 text-indigo-700 dark:text-indigo-300 text-[9px] font-black px-2.5 py-1.5 rounded-lg border border-indigo-50 dark:border-indigo-900/50 shadow-sm">
                                                    <div class="w-1 h-1 rounded-full bg-indigo-400"></div>
                                                    <span id="locationKelurahan"></span>
                                                </span>
                                                <span id="locationBadgeKota"
                                                    class="hidden items-center gap-1.5 bg-white dark:bg-gray-800 text-blue-700 dark:text-blue-300 text-[9px] font-black px-2.5 py-1.5 rounded-lg border border-blue-50 dark:border-blue-900/50 shadow-sm">
                                                    <div class="w-1 h-1 rounded-full bg-blue-400"></div>
                                                    <span id="locationKota"></span>
                                                </span>
                                                <span id="locationBadgeProvinsi"
                                                    class="hidden items-center gap-1.5 bg-white dark:bg-gray-800 text-violet-700 dark:text-violet-300 text-[9px] font-black px-2.5 py-1.5 rounded-lg border border-violet-50 dark:border-violet-900/50 shadow-sm">
                                                    <div class="w-1 h-1 rounded-full bg-violet-400"></div>
                                                    <span id="locationProvinsi"></span>
                                                </span>
                                                <span id="locationBadgeKoordinat"
                                                    class="hidden items-center gap-1.5 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-[9px] font-black px-2.5 py-1.5 rounded-lg border border-gray-100 dark:border-gray-700 shadow-sm">
                                                    <div class="w-1 h-1 rounded-full bg-gray-400"></div>
                                                    <span id="locationKoordinat"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-4 mt-10">
                                @if($nextType === 'check-out' && $durationStatus === 'blocked')
                                    <div class="mb-4 p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 text-orange-700 dark:text-orange-400 rounded-xl">
                                        <p class="font-bold flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Waktu Kerja Belum Terpenuhi
                                        </p>
                                        <p class="text-sm mt-1">Anda harus bekerja minimal {{ $minHours }} jam sebelum bisa melakukan check-out. Sisa waktu: <strong>{{ floor($remainingMinutes / 60) }} jam {{ $remainingMinutes % 60 }} menit</strong>.</p>
                                    </div>
                                @endif

                                <button type="submit" id="submitBtn" disabled
                                    class="w-full py-5 bg-blue-600 hover:bg-blue-700 shadow-xl shadow-blue-500/30 text-white rounded-2xl font-black text-lg disabled:opacity-30 disabled:cursor-not-allowed hover:opacity-90 dark:shadow-none transform hover:-translate-y-1 active:scale-95 transition-all duration-300">
                                    <div class="flex items-center justify-center gap-3">
                                        <span>{{ $nextType === 'check-in' ? 'Konfirmasi Check-in' : 'Konfirmasi Check-out' }}</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </div>
                                </button>
                                <a href="{{ route('attendance.index') }}"
                                    class="w-full py-4 text-center text-gray-400 dark:text-gray-500 font-bold text-sm tracking-widest hover:text-gray-600 transition duration-200">
                                    BATALKAN & KEMBALI
                                </a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const capturedImg = document.getElementById('capturedImg');
            const snapBtn = document.getElementById('snapBtn');
            const retakeBtn = document.getElementById('retakeBtn');
            const submitBtn = document.getElementById('submitBtn');
            const permissionOverlay = document.getElementById('permission_overlay');
            const locationDot = document.getElementById('locationDot');
            const locationText = document.getElementById('locationText');
            const locationSource = document.getElementById('locationSource');
            const shutter = document.getElementById('shutter');

            let stream = null;
            let map = null;
            let marker = null;
            let radiusCircle = null;

            function initMap(lat, lng) {
                if (map) return;

                const mapEl = document.getElementById('map');
                mapEl.innerHTML = ""; // hapus loader
                mapEl.style.height = "260px"; // kunci tinggi via JS juga

                map = L.map('map', {
                    zoomControl: false,
                    dragging: true,     // Aktifkan geser agar user bisa melihat sekitar
                    scrollWheelZoom: false,
                    doubleClickZoom: true,
                    touchZoom: true
                }).setView([lat, lng], 19); // Zoom untuk detail radius 25m

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 20
                }).addTo(map);

                // Tambahkan Radius 25 Meter
                radiusCircle = L.circle([lat, lng], {
                    color: '#4f46e5',
                    fillColor: '#4f46e5',
                    fillOpacity: 0.15,
                    radius: 25, // Radius 25 Meter
                    weight: 2,
                    dashArray: '5, 10'
                }).addTo(map);

                const customDeviceIcon = L.divIcon({
                    className: 'custom-device-icon',
                    html: `
                                                            <div style="position: relative; width: 32px; height: 32px;">
                                                                <div style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 8px; height: 8px; background: #4f46e5; border: 2px solid white; border-radius: 50%; box-shadow: 0 0 10px rgba(79, 70, 229, 0.5); z-index: 10;"></div>
                                                                <svg style="position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%); width: 32px; height: 32px; color: #4f46e5; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                                                </svg>
                                                            </div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 32]
                });

                marker = L.marker([lat, lng], {
                    icon: customDeviceIcon,
                    zIndexOffset: 1000 // Memastikan pin selalu di atas lingkaran radius
                }).addTo(map);

                setTimeout(() => {
                    map.invalidateSize(true);
                }, 400);
            }

            async function startCamera() {
                if (!window.isSecureContext && location.hostname !== "localhost" && location.hostname !== "127.0.0.1") {
                    alert('Kamera diblokir: Halaman ini harus diakses melalui HTTPS agar kamera dapat berfungsi.');
                    return;
                }

                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 720 }, height: { ideal: 720 } },
                        audio: false
                    });
                    video.srcObject = stream;
                    permissionOverlay.classList.add('hidden');
                    snapBtn.classList.remove('hidden');
                    getLocation();
                } catch (err) {
                    console.warn("First camera attempt failed, trying generic video...", err);
                    try {
                        stream = await navigator.mediaDevices.getUserMedia({ video: true });
                        video.srcObject = stream;
                        permissionOverlay.classList.add('hidden');
                        snapBtn.classList.remove('hidden');
                        getLocation();
                    } catch (err2) {
                        alert('Gagal mengakses kamera. Mohon pastikan situs ini diberikan izin menggunakan kamera di pengaturan peramban Anda.');
                        console.error(err2);
                    }
                }
            }

            function takeSnapshot() {
                shutter.classList.add('opacity-100');
                setTimeout(() => shutter.classList.remove('opacity-100'), 100);

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);

                const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
                document.getElementById('photoData').value = dataUrl;

                capturedImg.src = dataUrl;
                capturedImg.classList.remove('hidden');
                video.classList.add('hidden');

                snapBtn.classList.add('hidden');
                retakeBtn.classList.remove('hidden');
                checkReady();
            }

            function retakePhoto() {
                capturedImg.classList.add('hidden');
                video.classList.remove('hidden');
                snapBtn.classList.remove('hidden');
                retakeBtn.classList.add('hidden');
                document.getElementById('photoData').value = "";
                checkReady();
            }

            function getLocation() {
                locationText.innerText = "Mendeteksi lokasi GPS... (mohon tunggu)";
                locationDot.classList.add('animate-pulse');
                locationDot.classList.replace('bg-green-500', 'bg-red-500');

                if (!navigator.geolocation) {
                    getIpLocation();
                    return;
                }

                // Fase 1: Coba GPS akurasi tinggi (khusus HTTPS — chip GPS satelit nyata di HP)
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        const accuracy = Math.round(pos.coords.accuracy);
                        console.log(`[GPS OK] Akurasi: ±${accuracy}m`);
                        applyLocation(lat, lng, accuracy);
                    },
                    (err) => {
                        // Fase 2: GPS gagal/ditolak → coba WiFi triangulation
                        console.warn(`[GPS Gagal: ${err.message}] → mencoba WiFi...`);
                        locationText.innerText = "GPS gagal, mencoba via WiFi...";
                        navigator.geolocation.getCurrentPosition(
                            (pos2) => {
                                const lat = pos2.coords.latitude;
                                const lng = pos2.coords.longitude;
                                const accuracy = Math.round(pos2.coords.accuracy);
                                console.log(`[WiFi OK] Akurasi: ±${accuracy}m`);
                                applyLocation(lat, lng, accuracy);
                            },
                            (err2) => {
                                // Fase 3: Semua gagal → fallback IP
                                console.warn(`[WiFi Gagal: ${err2.message}] → fallback ke IP`);
                                getIpLocation();
                            },
                            { enableHighAccuracy: false, timeout: 8000, maximumAge: 0 }
                        );
                    },
                    { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                    // enableHighAccuracy: true = aktifkan GPS satelit (hanya berfungsi di HTTPS)
                    // maximumAge: 0 = jangan gunakan cache, selalu ambil koordinat segar
                );
            }

            async function applyLocation(lat, lng, accuracy) {
                try {
                    const req = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=14`);
                    const data = await req.json();
                    if (data && data.address) {
                        const addr = data.address;
                        const kecamatan = addr.city_district || addr.suburb || addr.quarter || "";
                        const kota = addr.city || addr.town || addr.county || "";
                        const provinsi = addr.state || "";
                        const parts = [kecamatan, kota, provinsi].filter(Boolean);
                        const fullArea = parts.length > 0 ? parts.join(", ") : "Area Tidak Diketahui";
                        updateLocationUI(lat, lng, `GPS ±${accuracy}m`, fullArea);
                        updateLocationBadges(addr);
                    } else {
                        updateLocationUI(lat, lng, `GPS ±${accuracy}m`, "");
                    }
                } catch (error) {
                    console.warn("Reverse geocoding gagal:", error);
                    updateLocationUI(lat, lng, `GPS ±${accuracy}m`, "");
                }
            }

            async function getIpLocation() {
                locationText.innerText = "Mencari lokasi via IP Internet...";
                try {
                    // geojs.io lebih stabil dan ringan
                    const response = await fetch('https://get.geojs.io/v1/ip/geo.json');
                    const data = await response.json();

                    if (data.latitude && data.longitude) {
                        const lat = parseFloat(data.latitude);
                        const lng = parseFloat(data.longitude);
                        const detail = data.city ? `${data.city}, ${data.region}` : 'Titik Provider Internet';

                        updateLocationUI(lat, lng, "Titik IP Internet / Provider", detail);
                    } else {
                        throw new Error("Data IP tidak valid");
                    }
                } catch (err) {
                    console.error("IP Geoloc Error:", err);
                    showLocationError("Gagal mendapatkan titik lokasi jaringan.");
                }
            }

            function showLocationError(msg) {
                locationText.innerHTML = `<span class="text-red-600 font-bold">${msg}</span><br>
                                                                                                                                                                                                                                                                <button type="button" onclick="getLocation()" class="mt-2 text-indigo-600 underline text-xs font-black uppercase tracking-widest">Coba Cari Ulang</button>`;
                locationDot.classList.replace('bg-green-500', 'bg-red-500');
                locationDot.classList.remove('animate-pulse');
            }

            function updateLocationUI(lat, lng, source, detail = "") {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                locationDot.classList.replace('bg-red-500', 'bg-green-500');
                locationDot.classList.remove('animate-pulse');
                locationSource.innerText = source;
                locationText.innerText = detail ? `${detail} (${lat.toFixed(4)}, ${lng.toFixed(4)})` : `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;

                if (!map) {
                    initMap(lat, lng);
                } else {
                    const latLng = new L.LatLng(lat, lng);
                    marker.setLatLng(latLng);
                    if (radiusCircle) radiusCircle.setLatLng(latLng);
                    map.setView(latLng, 19);

                    setTimeout(() => map.invalidateSize(), 400);
                }

                // Update Google Maps Link
                const gmapsBtn = document.getElementById('googleMapsBtn');
                if (gmapsBtn) {
                    gmapsBtn.href = `https://www.google.com/maps?q=${lat},${lng}`;
                    gmapsBtn.classList.remove('hidden');
                }

                checkReady();
            }

            function checkReady() {
                const hasPhoto = document.getElementById('photoData').value !== "";
                const hasLocation = document.getElementById('latitude').value !== "";
                let isBlocked = false;
                
                @if($nextType === 'check-out' && $durationStatus === 'blocked')
                    isBlocked = true;
                @endif

                submitBtn.disabled = !(hasPhoto && hasLocation) || isBlocked;
            }

            // Auto-trigger if permissions allowed
            window.addEventListener('load', () => {
                if (navigator.permissions && navigator.permissions.query) {
                    navigator.permissions.query({ name: 'geolocation' }).then(s => {
                        if (s.state === 'granted') getLocation();
                    }).catch(() => { });
                    navigator.permissions.query({ name: 'camera' }).then(s => {
                        if (s.state === 'granted') startCamera();
                    }).catch(() => { });
                }
            });

            function updateLocationBadges(address) {
                const detail = document.getElementById('locationDetail');
                detail.classList.remove('hidden');

                // Kelurahan / Desa
                const kelurahan = address.village || address.suburb || address.neighbourhood || address.hamlet || null;
                if (kelurahan) {
                    document.getElementById('locationKelurahan').innerText = kelurahan;
                    document.getElementById('locationBadgeKelurahan').classList.remove('hidden');
                    document.getElementById('locationBadgeKelurahan').classList.add('inline-flex');
                }

                // Kota / Kabupaten
                const kota = address.city || address.regency || address.town || address.county || null;
                if (kota) {
                    document.getElementById('locationKota').innerText = kota;
                    document.getElementById('locationBadgeKota').classList.remove('hidden');
                    document.getElementById('locationBadgeKota').classList.add('inline-flex');
                }

                // Provinsi
                const provinsi = address.state || null;
                if (provinsi) {
                    document.getElementById('locationProvinsi').innerText = provinsi;
                    document.getElementById('locationBadgeProvinsi').classList.remove('hidden');
                    document.getElementById('locationBadgeProvinsi').classList.add('inline-flex');
                }

                // Koordinat
                const lat = parseFloat(document.getElementById('latitude').value);
                const lng = parseFloat(document.getElementById('longitude').value);
                document.getElementById('locationKoordinat').innerText = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
                document.getElementById('locationBadgeKoordinat').classList.remove('hidden');
                document.getElementById('locationBadgeKoordinat').classList.add('inline-flex');
            }
        </script>
    @endpush
</x-app-layout>
