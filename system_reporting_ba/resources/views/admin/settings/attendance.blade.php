<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight uppercase tracking-tight">
                    {{ __('Konfigurasi Jadwal') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-bold">Atur waktu operasional absensi dan syarat minimal jam kerja</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 dark:bg-gray-950/20 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div
                    class="mb-8 bg-green-500 text-white p-6 rounded-2xl shadow-lg shadow-green-100 dark:shadow-none border-none flex items-center gap-4 animate-fade-in">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="font-black uppercase tracking-widest text-xs">{{ session('success') }}</p>
                </div>
            @endif

            <div
                class="bg-white dark:bg-gray-800 shadow-2xl shadow-gray-200/40 dark:shadow-none rounded-[2.5rem] overflow-hidden border border-gray-100 dark:border-gray-700">
                <form action="{{ route('admin.settings.attendance.update') }}" method="POST" class="p-8 md:p-12">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Left Column: Start & End Time -->
                        <div class="space-y-8">
                            <div>
                                <h3
                                    class="text-gray-900 dark:text-white font-black uppercase tracking-tight text-lg mb-6 flex items-center gap-3">
                                    <span
                                        class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white text-xs">01</span>
                                    Waktu Operasional
                                </h3>

                                <div class="space-y-6">
                                    <div>
                                        <label
                                            class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Mulai
                                            Absensi (Check-in)</label>
                                        <input type="time" name="attendance_start_time"
                                            value="{{ old('attendance_start_time', $settings['attendance_start_time']) }}"
                                            class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-4 focus:ring-indigo-500/10 rounded-2xl py-4 px-6 font-black text-lg transition shadow-inner">
                                        @error('attendance_start_time')
                                            <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-widest">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Selesai
                                            Absensi (Check-out)</label>
                                        <input type="time" name="attendance_end_time"
                                            value="{{ old('attendance_end_time', $settings['attendance_end_time']) }}"
                                            class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-4 focus:ring-indigo-500/10 rounded-2xl py-4 px-6 font-black text-lg transition shadow-inner">
                                        @error('attendance_end_time')
                                            <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-widest">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Minimum Work Hours -->
                        <div class="space-y-8">
                            <div>
                                <h3
                                    class="text-gray-900 dark:text-white font-black uppercase tracking-tight text-lg mb-6 flex items-center gap-3">
                                    <span
                                        class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-white text-xs">02</span>
                                    Aturan Kerja
                                </h3>

                                <div class="space-y-6">
                                    <div>
                                        <label
                                            class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Syarat Minimal Jam Kerja (Check-out)</label>
                                        <div class="relative">
                                            <input type="number" name="minimum_work_hours" min="1" max="24"
                                                value="{{ old('minimum_work_hours', $settings['minimum_work_hours'] ?? 8) }}"
                                                class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-4 focus:ring-orange-500/10 rounded-2xl py-4 px-6 font-black text-lg transition shadow-inner">
                                            <span class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Jam</span>
                                        </div>
                                        <p class="mt-3 text-[10px] text-gray-400 font-medium italic">BA tidak akan bisa melakukan Check-out sebelum durasi kerja ini terpenuhi (dihitung sejak Check-in).</p>
                                        @error('minimum_work_hours')
                                            <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-widest">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="mt-10 space-y-8">
                        <div>
                            <h3
                                class="text-gray-900 dark:text-white font-black uppercase tracking-tight text-lg mb-6 flex items-center gap-3">
                                <span
                                    class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center text-white text-xs">03</span>
                                Hari Kerja
                            </h3>

                            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 shadow-inner border-none">
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-4">Pilih Hari Kerja</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                                    @php
                                        $days = [
                                            1 => 'Senin',
                                            2 => 'Selasa',
                                            3 => 'Rabu',
                                            4 => 'Kamis',
                                            5 => 'Jumat',
                                            6 => 'Sabtu',
                                            7 => 'Minggu',
                                        ];
                                        $workingDays = old('working_days', $settings['working_days'] ?? [1, 2, 3, 4, 5, 6, 7]);
                                        if (is_string($workingDays)) {
                                            $workingDays = json_decode($workingDays, true);
                                        }
                                    @endphp
                                    @foreach($days as $value => $label)
                                        <label class="relative flex items-center gap-3 p-4 cursor-pointer rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all">
                                            <input type="checkbox" name="working_days[]" value="{{ $value }}"
                                                @checked(in_array($value, is_array($workingDays) ? $workingDays : []))
                                                class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600 transition duration-200">
                                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('working_days')
                                    <p class="text-red-500 text-[10px] font-bold mt-4 uppercase tracking-widest">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-16 pt-10 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                        <button type="submit"
                            class="group relative inline-flex items-center gap-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black px-10 py-5 rounded-2xl shadow-2xl shadow-indigo-200 dark:shadow-none transition-all transform hover:-translate-y-1 active:scale-95 duration-300">
                            <span class="uppercase tracking-widest text-xs">Simpan Konfigurasi</span>
                            <div
                                class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:bg-white/30 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Card -->
            <div
                class="mt-10 bg-indigo-50 dark:bg-gray-800/50 p-8 rounded-[2rem] border border-indigo-100 dark:border-gray-700">
                <div class="flex items-start gap-4">
                    <div
                        class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4
                            class="font-black text-indigo-900 dark:text-indigo-200 uppercase tracking-tight text-sm mb-2">
                            Informasi Keamanan</h4>
                        <p class="text-xs text-indigo-700/80 dark:text-gray-400 font-bold leading-relaxed">
                            Perubahan pada konfigurasi jadwal akan langsung berdampak pada seluruh Beauty Advisor (BA)
                            secara real-time.
                            Pastikan Anda telah mensosialisasikan perubahan waktu kerja kepada tim sebelum melakukan
                            update.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }
    </style>
</x-app-layout>
