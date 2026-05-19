<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Pengguna') }}: {{ $user->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}"
                    class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded text-sm transition-colors">
                    Ubah Data
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm transition-colors">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column: Basic Info & Profile Photo -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <div class="relative inline-block">
                            @if($user->photo_path)
                                <img src="{{ Storage::url($user->photo_path) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-50 mx-auto shadow-md">
                            @else
                                <div class="w-32 h-32 rounded-full bg-indigo-100 flex items-center justify-center mx-auto border-4 border-indigo-50 shadow-md">
                                    <span class="text-4xl font-bold text-indigo-400">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <span class="absolute bottom-1 right-1 h-6 w-6 rounded-full {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }} border-4 border-white dark:border-gray-800 shadow-sm" title="{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}"></span>
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">{{ $user->role }}</p>
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 space-y-2 text-left">
                            <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>{{ $user->email }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Terdaftar: {{ $user->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($user->role === 'ba')
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Hierarki & Penugasan</h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Distributor</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->distributor->name ?? '-' }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase">Cluster</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->cluster ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase">Region</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->region ?? '-' }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">RBS (Atasan)</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->rbs->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Area Cakupan</p>
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @forelse($user->areas ?? [] as $area)
                                            <span class="px-2 py-0.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded text-[10px] font-bold">{{ $area }}</span>
                                        @empty
                                            <span class="text-sm text-gray-400 italic">Tidak ada area</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Details & Documents -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Personal Info -->
                    @if($user->role === 'ba')
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Pribadi Pegawai</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">NIK / Employee ID</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->profile->nik ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Nomor Handphone</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->profile->phone ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Jenis Kelamin</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->profile->gender ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Tanggal Lahir</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->profile->dob ? date('d M Y', strtotime($user->profile->dob)) : '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Status Karyawan</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $user->profile->employment_status ?? '-' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Tanggal Bergabung</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->profile->join_date ? date('d M Y', strtotime($user->profile->join_date)) : '-' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Alamat Domisili</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $user->profile->address ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Dokumen Pendukung</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @php
                                    $docTypes = [
                                        'ktp' => 'KTP',
                                        'npwp' => 'NPWP',
                                        'kontrak_kerja' => 'Kontrak Kerja',
                                        'ijazah' => 'Ijazah',
                                        'sertifikat' => 'Sertifikat'
                                    ];
                                    $userDocs = $user->documents->keyBy('type');
                                @endphp
                                
                                @foreach($docTypes as $type => $label)
                                    <div class="p-3 border border-gray-100 dark:border-gray-700 rounded-xl flex justify-between items-center">
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $label }}</p>
                                            <p class="text-xs {{ isset($userDocs[$type]) ? 'text-green-600 font-bold' : 'text-gray-400 italic' }}">
                                                {{ isset($userDocs[$type]) ? 'Tersedia' : 'Belum Upload' }}
                                            </p>
                                        </div>
                                        @if(isset($userDocs[$type]))
                                            <a href="{{ Storage::url($userDocs[$type]->file_path) }}" target="_blank" 
                                                class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Assigned Outlets -->
                    @if($user->role === 'ba')
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Daftar Toko Yang Ditugaskan</h4>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse text-sm">
                                    <thead>
                                        <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                            <th class="py-2 px-4 text-gray-500">Nama Toko</th>
                                            <th class="py-2 px-4 text-gray-500">Kota</th>
                                            <th class="py-2 px-4 text-gray-500">Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($user->outlets as $outlet)
                                            <tr class="border-b dark:border-gray-700">
                                                <td class="py-2 px-4 font-bold">{{ $outlet->name }}</td>
                                                <td class="py-2 px-4 text-xs">{{ $outlet->city->name ?? '-' }}</td>
                                                <td class="py-2 px-4 text-xs text-gray-500 line-clamp-1">{{ $outlet->address ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-gray-500 italic">Belum ada toko yang ditugaskan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
