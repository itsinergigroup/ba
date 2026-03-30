<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.products.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="brand_id" :value="__('Brand')" />
                        <select id="brand_id" name="brand_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required>
                            <option value="">-- Pilih Brand --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Produk')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="het" :value="__('HET')" />
                        <x-text-input id="het" class="block mt-1 w-full" type="text" name="het" :value="old('het')"
                            required />
                        <x-input-error :messages="$errors->get('het')" class="mt-2" />
                    </div>



                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.products.index') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900">Batal</a>
                        <x-primary-button class="ms-4">
                            {{ __('Simpan Produk') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>