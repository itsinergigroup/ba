<x-app-layout>
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
                                <span class="ml-1 text-xs font-bold text-indigo-600 uppercase tracking-widest">Edit
                                    Absensi</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight uppercase tracking-tight">
                    {{ __('Edit Data Absensi') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-bold">Ubah catatan absensi untuk <span
                        class="text-indigo-600">{{ $attendance->user->name }}</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 dark:bg-gray-950/20 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8 sm:p-12">
                    <form method="POST" action="{{ route('admin.attendance.update', $attendance) }}" class="space-y-8">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- User Selection -->
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Beauty
                                    Advisor</label>
                                <select name="user_id" required
                                    class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-2 focus:ring-indigo-500 rounded-2xl py-4 px-6 font-bold transition shadow-sm">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $attendance->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Outlet Selection -->
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Toko
                                    / Outlet</label>
                                <select name="outlet_id"
                                    class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-2 focus:ring-indigo-500 rounded-2xl py-4 px-6 font-bold transition shadow-sm">
                                    <option value="">-- Lokasi Umum --</option>
                                    @foreach($outlets as $outlet)
                                        <option value="{{ $outlet->id }}" {{ old('outlet_id', $attendance->outlet_id) == $outlet->id ? 'selected' : '' }}>
                                            {{ $outlet->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('outlet_id') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Attendance Type -->
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Tipe
                                    Absensi</label>
                                <select name="type" required
                                    class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-2 focus:ring-indigo-500 rounded-2xl py-4 px-6 font-bold transition shadow-sm">
                                    <option value="check-in" {{ old('type', $attendance->type) == 'check-in' ? 'selected' : '' }}>Check-in (Masuk)</option>
                                    <option value="check-out" {{ old('type', $attendance->type) == 'check-out' ? 'selected' : '' }}>Check-out (Pulang)</option>
                                </select>
                                @error('type') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date Selection -->
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Tanggal</label>
                                <input type="date" name="date" value="{{ old('date', $attendance->date) }}" required
                                    class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-2 focus:ring-indigo-500 rounded-2xl py-4 px-6 font-bold transition shadow-sm">
                                @error('date') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Time Selection -->
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Waktu
                                    / Jam</label>
                                <input type="time" name="time"
                                    value="{{ old('time', date('H:i', strtotime($attendance->time))) }}" required
                                    class="w-full bg-gray-50 dark:bg-gray-900 border-none focus:ring-2 focus:ring-indigo-500 rounded-2xl py-4 px-6 font-bold transition shadow-sm">
                                @error('time') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-8 flex flex-col sm:flex-row gap-4">
                            <button type="submit"
                                class="flex-1 py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 dark:shadow-none transition transform active:scale-95 duration-200 uppercase text-sm tracking-widest">
                                Perbarui Absensi
                            </button>
                            <a href="{{ route('admin.attendance.index') }}"
                                class="flex-1 py-5 bg-white dark:bg-gray-800 text-gray-400 hover:text-gray-600 border border-gray-100 dark:border-gray-700 text-center font-black rounded-2xl transition uppercase text-sm tracking-widest">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div
                class="mt-8 p-6 bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/30 rounded-2xl">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs text-amber-700 dark:text-amber-400 font-bold leading-relaxed">
                        <span class="block uppercase font-black mb-1">Peringatan:</span>
                        Mengubah data absensi akan memperbarui catatan waktu dan status keterlambatan secara otomatis.
                        Data latitude/longitude dan foto asli (jika ada) akan tetap dipertahankan namun tidak lagi
                        divalidasi ulang terhadap jam yang baru.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>