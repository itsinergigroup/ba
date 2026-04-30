<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
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
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Riwayat Absensi') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pantau kehadiran Anda setiap hari</p>
            </div>
            @if(Auth::user()->hasApprovedDayOffToday())
                <div
                    class="w-full md:w-auto text-center px-6 py-3 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 font-bold rounded-xl border border-purple-200 dark:border-purple-800 cursor-not-allowed flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Menikmati Hari Libur (Day-Off)
                </div>
            @elseif(!Auth::user()->hasFinishedAttendanceToday())
                <a href="{{ route('attendance.create') }}"
                    class="w-full md:w-auto text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg shadow-blue-200 dark:shadow-none transition transform active:scale-95 duration-200">
                    + Absen Sekarang
                </a>
            @else
                <div
                    class="w-full md:w-auto text-center px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 font-bold rounded-xl border border-gray-200 dark:border-gray-600 cursor-not-allowed flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Absensi besok tepat waktu ya!
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alert Incomplete Attendance -->
            @if(Auth::user()->hasIncompleteAttendance())
                @php $incomplete = Auth::user()->getIncompleteAttendance(); @endphp
                <div class="mx-4 md:mx-0 bg-amber-50 border-l-4 border-amber-400 p-6 rounded-xl mb-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 animate-pulse">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-amber-100 rounded-full text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-amber-800 font-black text-sm uppercase tracking-tight">Peringatan Absensi Belum Lengkap!</h4>
                            <p class="text-amber-700 text-xs mt-1">
                                Anda tercatat melakukan <strong>Check-in</strong> pada <strong>{{ date('d M Y', strtotime($incomplete->date)) }}</strong> pukul {{ date('H:i', strtotime($incomplete->time)) }}, namun belum melakukan <strong>Check-out</strong>.
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('attendance.request.create', ['type' => 'check-out', 'date' => $incomplete->date]) }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-[10px] font-black uppercase tracking-widest rounded-lg transition shadow-md shadow-amber-200">
                        Ajukan Koreksi Check-out
                    </a>
                </div>
            @endif

            <!-- Alert Missing Attendance Entirely -->
            @if(Auth::user()->hasMissingAttendanceYesterday())
                <div class="mx-4 md:mx-0 bg-rose-50 border-l-4 border-rose-500 p-6 rounded-xl mb-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
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
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-[10px] font-black uppercase tracking-widest rounded-lg transition shadow-md shadow-rose-200">
                        Ajukan Lupa Absen
                    </a>
                </div>
            @endif

            <!-- Alert Success -->
            @if(session('success'))
                <div class="mx-4 md:mx-0 flex items-center gap-3 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 text-green-700 dark:text-green-400 px-6 py-4 rounded-xl mb-8 shadow-sm"
                    role="alert">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filter Section -->
            <div
                class="mb-8 bg-white dark:bg-gray-800 p-6 md:p-8 rounded-xl shadow-xl shadow-gray-200/40 dark:shadow-none border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('attendance.index') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">

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

                    <div class="md:col-span-2 flex flex-wrap gap-3">
                        <button type="submit"
                            class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-lg shadow-lg shadow-indigo-100 dark:shadow-none transition transform active:scale-95 duration-200 uppercase text-xs tracking-widest shrink-0">
                            Filter
                        </button>
                        <a href="{{ route('attendance.index') }}"
                            class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-400 hover:text-gray-600 border-2 border-gray-100 dark:border-gray-700 font-black rounded-lg transition uppercase text-xs tracking-widest text-center shrink-0">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Mobile View (Cards) -->
            <div class="md:hidden space-y-4 px-4">
                @forelse($attendances as $atten)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 relative">
                        <div class="flex items-center justify-between mb-4">
                            <span
                                class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase {{ $atten->type === 'check-in' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $atten->type }}
                            </span>
                            <div class="text-right">
                                <h3 class="font-black text-gray-800 dark:text-gray-100">
                                    {{ date('d M Y', strtotime($atten->date)) }}
                                </h3>
                            </div>
                        </div>

                        <div class="flex items-center gap-5">
                            <div class="relative group">
                                <button type="button" onclick="openModal('{{ asset('storage/' . $atten->photo_path) }}')"
                                    class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-white shadow-md active:scale-95 transition">
                                    <img src="{{ asset('storage/' . $atten->photo_path) }}" alt="Foto"
                                        class="w-full h-full object-cover">
                                </button>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <p class="text-2xl font-black text-indigo-600">
                                        {{ date('H:i', strtotime($atten->time)) }}
                                    </p>
                                </div>
                                <p class="text-sm font-bold text-gray-600 dark:text-gray-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                    {{ $atten->outlet->name ?? 'Lokasi Umum' }}
                                </p>
                            </div>
                        </div>



                        <div class="mt-4 pt-4 border-t dark:border-gray-700 flex justify-between items-center">
                            <a href="{{ route('attendance.show', $atten) }}" class="text-[10px] font-black text-white bg-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-700 transition uppercase tracking-widest shadow-sm">
                                Lihat Detail
                            </a>
                            <button type="button"
                                onclick="openMapModal({{ $atten->latitude }}, {{ $atten->longitude }}, '{{ addslashes($atten->outlet->name ?? 'Lokasi Umum') }}')"
                                class="text-xs font-black text-indigo-600 hover:text-indigo-700 flex items-center gap-1 translate-y-0 active:translate-y-0.5 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 7m0 10V7m0 0L9 7">
                                    </path>
                                </svg>
                                Tracking Lokasi
                            </button>
                        </div>
                    </div>
                @empty
                    <div
                        class="text-center py-20 bg-white dark:bg-gray-800 rounded-[2.5rem] border-2 border-dashed border-gray-100 dark:border-gray-700">
                        <div
                            class="w-20 h-20 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-400 font-bold italic">Belum ada riwayat absensi.</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop View (Table) -->
            <div
                class="hidden md:block bg-white dark:bg-gray-800 shadow-2xl shadow-gray-200/40 dark:shadow-none sm:rounded-xl overflow-hidden border border-gray-50 dark:border-gray-700">
                <div class="p-10">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-4">
                            <thead>
                                <tr class="text-gray-400 text-[11px] uppercase tracking-[0.2em] font-black">
                                    <th class="pb-4 px-6">WAKTU & TANGGAL</th>
                                    <th class="pb-4 px-6">TOKO / OUTLET</th>
                                    <th class="pb-4 px-6 pt-1 text-center">TIPE</th>
                                    <th class="pb-4 px-6 text-center">AKSI</th>
                                    <th class="pb-4 px-6 text-right pr-12">BUKTI FOTO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $atten)
                                    <tr
                                        class="group bg-gray-50/50 dark:bg-gray-700/20 hover:bg-white dark:hover:bg-gray-700 hover:shadow-2xl hover:shadow-indigo-100/50 dark:hover:shadow-none transition-all duration-500 rounded-lg">
                                        <td class="py-6 px-6 rounded-l-lg">
                                            <div
                                                class="font-black text-gray-900 dark:text-gray-100 text-lg leading-tight uppercase">
                                                {{ date('d M Y', strtotime($atten->date)) }}
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <div class="text-indigo-600 font-black text-sm">
                                                    {{ date('H:i', strtotime($atten->time)) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6 px-6">
                                            <div class="font-black text-gray-700 dark:text-gray-300">
                                                {{ $atten->outlet->name ?? 'Lokasi Umum' }}
                                            </div>
                                            <button type="button"
                                                onclick="openMapModal({{ $atten->latitude }}, {{ $atten->longitude }}, '{{ addslashes($atten->outlet->name ?? 'Lokasi Umum') }}')"
                                                class="text-[10px] font-black text-gray-400 hover:text-indigo-600 flex items-center gap-1 mt-1 transition uppercase tracking-widest">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                </svg>
                                                Lihat Lokasi
                                            </button>
                                        </td>
                                        <td class="py-6 px-6 text-center">
                                            <span
                                                class="inline-block px-5 py-2 rounded-lg text-[10px] font-black tracking-widest uppercase {{ $atten->type === 'check-in' ? 'bg-green-500 text-white' : 'bg-blue-600 text-white' }} shadow-lg {{ $atten->type === 'check-in' ? 'shadow-green-100' : 'shadow-blue-100' }}">
                                                {{ $atten->type }}
                                            </span>
                                        </td>
                                        <td class="py-6 px-6 text-center">
                                            <a href="{{ route('attendance.show', $atten) }}"
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
                                            <div class="flex justify-end">
                                                <button type="button"
                                                    onclick="openModal('{{ asset('storage/' . $atten->photo_path) }}')"
                                                    class="relative w-16 h-16 rounded-[1.25rem] overflow-hidden ring-4 ring-white dark:ring-gray-800 shadow-xl group/img hover:scale-110 active:scale-95 transition-all duration-300">
                                                    <img src="{{ asset('storage/' . $atten->photo_path) }}" alt="Foto"
                                                        class="w-full h-full object-cover">
                                                    <div
                                                        class="absolute inset-0 bg-indigo-600/20 opacity-0 group-hover/img:opacity-100 transition flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-24">
                                            <div class="flex flex-col items-center opacity-30">
                                                <svg class="w-20 h-20 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <p class="font-black tracking-widest uppercase text-xs">Riwayat Kosong</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-12 md:max-w-none max-w-[calc(100vw-4rem)]">
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
        <div class="relative max-w-2xl w-full transform scale-95 transition-transform duration-300">
            <button onclick="closeModal()"
                class="absolute -top-12 right-0 text-white hover:text-indigo-400 p-2 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="bg-white dark:bg-gray-800 p-3 rounded-[2.5rem] shadow-2xl overflow-hidden">
                <img id="modalImg" src="" class="w-full h-auto rounded-[2rem] shadow-sm shadow-black/20">
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            let detailMap = null;
            let detailMarker = null;

            function openMapModal(lat, lng, name) {
                const modal = document.getElementById('mapModal');
                document.getElementById('mapModalTitle').innerText = `Lokasi: ${name}`;
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

            // Close on escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                    closeMapModal();
                }
            });
        </script>
    @endpush
</x-app-layout>
