<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('attendance.request.index') }}"
                class="p-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 text-gray-400 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Form Pengajuan (Lupa Absen / Hari Libur)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none sm:rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('attendance.request.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            <!-- Tipe Absen -->
                            <div class="space-y-2">
                                <label for="type" class="text-xs font-bold text-gray-500 uppercase tracking-widest">Tipe
                                    Absen</label>
                                <select name="type" id="type" required onchange="toggleFields()"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner">
                                    <option value="check-in" {{ request('type') === 'check-in' ? 'selected' : '' }}>Check-in (Masuk)</option>
                                    <option value="check-out" {{ request('type') === 'check-out' ? 'selected' : '' }}>Check-out (Pulang)</option>
                                    <option value="day-off" {{ request('type') === 'day-off' ? 'selected' : '' }}>Day-Off (Hari Libur / Izin)</option>
                                </select>
                                @error('type') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal -->
                            <div class="space-y-2">
                                <label for="date"
                                    class="text-xs font-bold text-gray-500 uppercase tracking-widest">Tanggal
                                    Absen</label>
                                <input type="date" name="date" id="date" required value="{{ request('date', date('Y-m-d')) }}"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner">
                                @error('date') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Waktu -->
                            <div class="space-y-2" id="time_container">
                                <label for="time"
                                    class="text-xs font-bold text-gray-500 uppercase tracking-widest">Waktu
                                    Seharusnya</label>
                                <input type="time" name="time" id="time" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner">
                                @error('time') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Foto Bukti -->
                        <div class="space-y-2" id="photo_container">
                            <label for="photo" class="text-xs font-bold text-gray-500 uppercase tracking-widest">Foto Bukti (Selfie/Lokasi)</label>
                            <input type="file" name="photo" id="photo" accept="image/*"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-[10px] text-gray-400 italic">* Wajib melampirkan foto untuk pengajuan Lupa Absen.</p>
                            @error('photo') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Alasan -->
                        <div class="space-y-2">
                            <label for="reason" class="text-xs font-bold text-gray-500 uppercase tracking-widest">Alasan
                                Pengajuan</label>
                            <textarea name="reason" id="reason" rows="4" required
                                placeholder="Jelaskan alasan mengapa Anda tidak dapat melakukan absensi secara normal..."
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner"></textarea>
                            <p class="text-[10px] text-gray-400 italic">* Sertakan alasan yang jelas agar Admin dapat
                                menyetujui pengajuan Anda.</p>
                            @error('reason') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-xl transition-all shadow-lg shadow-indigo-200 hover:-translate-y-1 active:translate-y-0 text-sm flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleFields() {
                const type = document.getElementById('type').value;
                const timeContainer = document.getElementById('time_container');
                const timeInput = document.getElementById('time');
                const dateInput = document.getElementById('date');

                if (type === 'day-off') {
                    timeContainer.style.display = 'none';
                    document.getElementById('photo_container').style.display = 'none';
                    timeInput.removeAttribute('required');
                    document.getElementById('photo').removeAttribute('required');
                    dateInput.removeAttribute('max'); // allow future dates
                } else {
                    timeContainer.style.display = 'block';
                    document.getElementById('photo_container').style.display = 'block';
                    timeInput.setAttribute('required', 'required');
                    document.getElementById('photo').setAttribute('required', 'required');
                    dateInput.setAttribute('max', '{{ date("Y-m-d") }}'); // restrict to today/past
                }
            }

            // Initialize on load
            document.addEventListener("DOMContentLoaded", function() {
                toggleFields();
            });
        </script>
    @endpush
</x-app-layout>
