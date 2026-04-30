<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ubah Pengguna') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Peran')" />
                        <select id="role" name="role"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required onchange="toggleFields(this.value)">
                            <option value="ba" {{ old('role', $user->role) == 'ba' ? 'selected' : '' }}>Beauty Advisor (BA)</option>
                            <option value="rbs" {{ old('role', $user->role) == 'rbs' ? 'selected' : '' }}>RBS</option>
                            <option value="view user only" {{ old('role', $user->role) == 'view user only' ? 'selected' : '' }}>View User Only</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- NEW FIELDS: Cluster, Region, RBS, Area -->
                    <div id="hierarchy_fields" class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 {{ old('role', $user->role) != 'ba' ? 'hidden' : '' }}">
                        <div>
                            <x-input-label for="cluster" :value="__('Cluster')" />
                            <select id="cluster" name="cluster" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">-- Pilih Cluster --</option>
                                <option value="A" {{ old('cluster', $user->cluster) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('cluster', $user->cluster) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="Area" {{ old('cluster', $user->cluster) == 'Area' ? 'selected' : '' }}>Area</option>
                            </select>
                            <x-input-error :messages="$errors->get('cluster')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="region" :value="__('Region')" />
                            <select id="region" name="region" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">-- Pilih Region --</option>
                                @foreach($regions as $reg)
                                    <option value="{{ $reg->name }}" {{ old('region', $user->region) == $reg->name ? 'selected' : '' }}>{{ $reg->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('region')" class="mt-2" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="rbs_id" :value="__('RBS (Atasan)')" />
                            <select id="rbs_id" name="rbs_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">-- Pilih RBS --</option>
                                @foreach($rbsUsers as $rbs)
                                    <option value="{{ $rbs->id }}" {{ old('rbs_id', $user->rbs_id) == $rbs->id ? 'selected' : '' }}>{{ $rbs->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('rbs_id')" class="mt-2" />
                        </div>
                    </div>

                    <div id="area_group" class="mt-4 {{ old('role', $user->role) != 'ba' ? 'hidden' : '' }}">
                        <x-input-label for="areas" :value="__('Area')" />
                        @php 
                            $selectedAreas = old('areas', $user->areas ?? []);
                            $areaOptions = $areas->map(fn($a) => $a->name)->toArray();
                        @endphp
                        <div x-data="{ 
                            openArea: false, 
                            searchArea: '',
                            selectedAreas: {{ json_encode($selectedAreas) }},
                            areaOptions: {{ json_encode($areaOptions) }},
                            get filteredAreas() {
                                if (this.searchArea === '') return this.areaOptions;
                                return this.areaOptions.filter(a => a.toLowerCase().includes(this.searchArea.toLowerCase()));
                            }
                        }" class="relative mt-2">
                            <button @click="openArea = !openArea" type="button" class="w-full bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm pl-3 pr-10 py-2.5 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 dark:text-gray-300 sm:text-sm">
                                <span class="block truncate" x-text="selectedAreas.length > 0 ? selectedAreas.length + ' Area dipilih' : '-- Pilih Area --'"></span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                            <div x-show="openArea" @click.away="openArea = false" style="display: none;" class="absolute z-50 mt-1 w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                <div class="p-2 border-b dark:border-gray-700">
                                    <input type="text" x-model="searchArea" placeholder="Cari area..." class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div class="max-h-60 overflow-auto">
                                    <template x-for="area in filteredAreas" :key="area">
                                        <label class="relative flex items-center py-2 px-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                            <input type="checkbox" name="areas[]" :value="area" x-model="selectedAreas" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded shadow-sm">
                                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300" x-text="area"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('areas')" class="mt-2" />
                    </div>

                    <div id="distributor_group" class="mt-4 {{ old('role', $user->role) != 'ba' ? 'hidden' : '' }}">
                        <x-input-label for="distributor_id" :value="__('Distributor')" />
                        <select id="distributor_id" name="distributor_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">-- Pilih Distributor --</option>
                            @foreach($distributors as $distributor)
                                <option value="{{ $distributor->id }}" {{ old('distributor_id', $user->distributor_id) == $distributor->id ? 'selected' : '' }}>{{ $distributor->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('distributor_id')" class="mt-2" />
                    </div>

                    <div id="outlet_group" class="mt-4 {{ old('role', $user->role) != 'ba' ? 'hidden' : '' }}">
                        <x-input-label for="outlets" :value="__('Tugaskan Toko')" />
                        @php 
                            $assignedOutlets = $user->outlets->pluck('id')->toArray();
                            $selectedOutlets = array_map('strval', old('outlets', $assignedOutlets ?? [])); 
                        @endphp
                        <div x-data="{ 
                            open: false, 
                            search: '',
                            selected: {{ json_encode($selectedOutlets) }},
                            outlets: {{ json_encode(\App\Models\Outlet::orderBy('name')->get()->map(fn($o) => ['id' => strval($o->id), 'name' => $o->name])) }},
                            get filteredOutlets() {
                                if (this.search === '') return this.outlets;
                                return this.outlets.filter(o => o.name.toLowerCase().includes(this.search.toLowerCase()));
                            }
                        }" class="relative mt-2">
                            
                            <!-- Dropdown Button -->
                            <button @click="open = !open" type="button" class="w-full bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm pl-3 pr-10 py-2.5 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 dark:text-gray-300 sm:text-sm">
                                <span class="block truncate" x-text="selected.length > 0 ? selected.length + ' Toko dipilih' : '-- Pilih Toko --'"></span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>

                            <!-- Dropdown Panel -->
                            <div x-show="open" @click.away="open = false" style="display: none;" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute z-40 mt-1 w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                <div class="p-2 border-b dark:border-gray-700">
                                    <input type="text" x-model="search" placeholder="Cari toko..." class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div class="max-h-60 overflow-auto">
                                    <template x-for="outlet in filteredOutlets" :key="outlet.id">
                                        <label class="relative flex items-center py-2 px-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="outlets[]" :value="outlet.id" 
                                                x-model="selected"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded shadow-sm">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <span class="font-medium text-gray-700 dark:text-gray-300" x-text="outlet.name"></span>
                                        </div>
                                    </label>
                                    </template>
                                    
                                    <div x-show="filteredOutlets.length === 0" class="py-2 px-3 text-sm text-gray-500 italic">
                                        Tidak ada toko yang cocok dengan pencarian
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-1 italic">*BA dapat menginput laporan untuk semua toko yang dicentang.</p>
                        <x-input-error :messages="$errors->get('outlets')" class="mt-2" />
                    </div>

                    <!-- DATA MASTER BA -->
                    @php 
                        $profile = $user->profile; 
                        $docs = $user->documents->keyBy('type');
                    @endphp
                    <div id="ba_fields" class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6 {{ old('role', $user->role) != 'ba' ? 'hidden' : '' }}">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Tambahan Pribadi Pegawai (Khusus BA)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="nik" :value="__('NIK / Employee ID')" />
                                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik', $profile->nik ?? '')" />
                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="phone" :value="__('Nomor Handphone')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $profile->phone ?? '')" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">- Pilih Jenis Kelamin -</option>
                                    <option value="Laki-laki" {{ old('gender', $profile->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender', $profile->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="dob" :value="__('Tanggal Lahir')" />
                                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob', $profile->dob ?? '')" />
                                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Alamat Domisili')" />
                                <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3">{{ old('address', $profile->address ?? '') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="employment_status" :value="__('Status Karyawan')" />
                                <select id="employment_status" name="employment_status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">- Pilih Status Pegawai -</option>
                                    <option value="Tetap" {{ old('employment_status', $profile->employment_status ?? '') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                    <option value="Kontrak" {{ old('employment_status', $profile->employment_status ?? '') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                    <option value="Magang" {{ old('employment_status', $profile->employment_status ?? '') == 'Magang' ? 'selected' : '' }}>Magang</option>
                                </select>
                                <x-input-error :messages="$errors->get('employment_status')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="join_date" :value="__('Tanggal Bergabung')" />
                                <x-text-input id="join_date" class="block mt-1 w-full" type="date" name="join_date" :value="old('join_date', $profile->join_date ?? '')" />
                                <x-input-error :messages="$errors->get('join_date')" class="mt-2" />
                            </div>
                            
                            <div class="md:col-span-2 mt-2">
                                <x-input-label for="photo" :value="__('Upload Foto Diri (Wajah)')" />
                                @if($user->photo_path)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($user->photo_path) }}" alt="Foto Pegawai" class="h-20 w-20 object-cover rounded-full border border-gray-300 dark:border-gray-600">
                                    </div>
                                @endif
                                <input id="photo" name="photo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <p class="text-[10px] text-gray-500 mt-1 italic">Biarkan kosong jika tidak ingin mengubah foto.</p>
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-8 mb-4">Dokumen Pendukung</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(['ktp' => 'Dokumen KTP', 'npwp' => 'Dokumen NPWP', 'kontrak_kerja' => 'Kontrak Kerja', 'ijazah' => 'Ijazah', 'sertifikat' => 'Sertifikat Lainnya'] as $docKey => $docLabel)
                                <div class="{{ $docKey == 'sertifikat' ? 'md:col-span-2' : '' }}">
                                    <x-input-label for="doc_{{ $docKey }}" value="{{ $docLabel }}" />
                                    @if(isset($docs[$docKey]))
                                        <div class="mb-1">
                                            <a href="{{ Storage::url($docs[$docKey]->file_path) }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-900 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                                Lihat Dokumen Saat Ini
                                            </a>
                                        </div>
                                    @endif
                                    <input id="doc_{{ $docKey }}" name="documents[{{ $docKey }}]" type="file" accept=".pdf,image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-gray-100 file:text-gray-700" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 mb-4">Kosongkan kata sandi jika tidak ingin mengubahnya.</p>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Kata Sandi Baru')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.users.index') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900">Batal</a>
                        <x-primary-button class="ms-4">
                            {{ __('Perbarui Pengguna') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleFields(role) {
            const diGroup = document.getElementById('distributor_group');
            const ouGroup = document.getElementById('outlet_group');
            const baFields = document.getElementById('ba_fields');
            const hiFields = document.getElementById('hierarchy_fields');
            const arGroup = document.getElementById('area_group');
            
            if (role === 'ba') {
                diGroup.classList.remove('hidden');
                ouGroup.classList.remove('hidden');
                baFields.classList.remove('hidden');
                hiFields.classList.remove('hidden');
                arGroup.classList.remove('hidden');
            } else {
                diGroup.classList.add('hidden');
                ouGroup.classList.add('hidden');
                baFields.classList.add('hidden');
                hiFields.classList.add('hidden');
                arGroup.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
