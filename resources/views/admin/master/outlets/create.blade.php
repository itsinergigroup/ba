<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Toko Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 shadow-sm rounded-r-lg flex items-center gap-3 animate-fade-in" role="alert">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('admin.outlets.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Toko')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="area_id" :value="__('Area')" />
                        <select id="area_id" name="area_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                            <option value="">{{ __('Pilih Area') }}</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('area_id')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="address" :value="__('Alamat')" />
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.outlets.index') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900">Batal</a>
                        <x-primary-button class="ms-4">
                            {{ __('Simpan Toko') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>
