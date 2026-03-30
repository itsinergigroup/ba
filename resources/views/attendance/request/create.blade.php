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
                {{ __('Form Pengajuan Lupa Absen') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none sm:rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('attendance.request.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tipe Absen -->
                            <div class="space-y-2">
                                <label for="type" class="text-xs font-bold text-gray-500 uppercase tracking-widest">Tipe
                                    Absen</label>
                                <select name="type" id="type" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner">
                                    <option value="check-in">Check-in (Masuk)</option>
                                    <option value="check-out">Check-out (Pulang)</option>
                                </select>
                                @error('type') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Toko/Outlet (Optional if matching current structure) -->
                            <div class="space-y-2">
                                <label for="outlet_id"
                                    class="text-xs font-bold text-gray-500 uppercase tracking-widest">Toko/Outlet</label>
                                <select name="outlet_id" id="outlet_id"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner">
                                    <option value="">Pilih Toko (Opsional)</option>
                                    @foreach($outlets as $outlet)
                                        <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                    @endforeach
                                </select>
                                @error('outlet_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal -->
                            <div class="space-y-2">
                                <label for="date"
                                    class="text-xs font-bold text-gray-500 uppercase tracking-widest">Tanggal
                                    Absen</label>
                                <input type="date" name="date" id="date" required max="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner">
                                @error('date') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Waktu -->
                            <div class="space-y-2">
                                <label for="time"
                                    class="text-xs font-bold text-gray-500 uppercase tracking-widest">Waktu
                                    Seharusnya</label>
                                <input type="time" name="time" id="time" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm shadow-inner">
                                @error('time') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
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
</x-app-layout>