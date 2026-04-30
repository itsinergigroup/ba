<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Area Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.areas.store') }}" method="POST">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Nama Area')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="region_id" :value="__('Wilayah (Region)')" />
                        <select id="region_id" name="region_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">-- Pilih Region --</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('region_id')" />
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        <a href="{{ route('admin.areas.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
