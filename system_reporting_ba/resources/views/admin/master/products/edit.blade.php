<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ubah Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <x-input-label for="brand_id" :value="__('Brand')" />
                        <select id="brand_id" name="brand_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Produk')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="barcode" :value="__('Barcode')" />
                        <div class="flex gap-2 mt-1">
                            <x-text-input id="barcode" class="block w-full" type="text" name="barcode" :value="old('barcode', $product->barcode)" placeholder="Masukkan barcode atau generate otomatis" />
                            <button type="button" id="btn-generate-barcode" class="px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Generate') }}
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('barcode')" class="mt-2" />
                        
                        <div id="barcode-preview-container" class="mt-3 flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 hidden">
                            <svg id="barcode-preview"></svg>
                            <span id="barcode-preview-text" class="text-xs text-gray-500 mt-1 font-mono"></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="het" :value="__('HET')" />
                        <x-text-input id="het" class="block mt-1 w-full" type="text" name="het"
                            :value="number_format(old('het', $product->het), 0, ',', '.')" required />
                        <x-input-error :messages="$errors->get('het')" class="mt-2" />
                    </div>



                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.products.index') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900">Batal</a>
                        <x-primary-button class="ms-4">
                            {{ __('Perbarui Produk') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const barcodeInput = document.getElementById('barcode');
                const btnGenerate = document.getElementById('btn-generate-barcode');
                const previewContainer = document.getElementById('barcode-preview-container');
                const previewSvg = document.getElementById('barcode-preview');
                const previewText = document.getElementById('barcode-preview-text');

                function calculateEAN13Checksum(code12) {
                    let sum = 0;
                    for (let i = 0; i < 12; i++) {
                        sum += parseInt(code12[i]) * (i % 2 === 0 ? 1 : 3);
                    }
                    let checkDigit = (10 - (sum % 10)) % 10;
                    return checkDigit.toString();
                }

                function generateEAN13() {
                    let randPart = Math.floor(100000000 + Math.random() * 900000000).toString();
                    let code12 = '899' + randPart;
                    let checkDigit = calculateEAN13Checksum(code12);
                    return code12 + checkDigit;
                }

                function updateBarcodePreview(value) {
                    if (value.trim() !== '') {
                        previewContainer.classList.remove('hidden');
                        try {
                            JsBarcode(previewSvg, value, {
                                format: "CODE128",
                                lineColor: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#1f2937',
                                background: 'transparent',
                                displayValue: false,
                                height: 60,
                                margin: 10
                            });
                            previewText.textContent = value;
                            previewText.classList.remove('text-red-500');
                        } catch (e) {
                            previewText.textContent = "Barcode tidak valid";
                            previewText.classList.add('text-red-500');
                        }
                    } else {
                        previewContainer.classList.add('hidden');
                    }
                }

                btnGenerate.addEventListener('click', function () {
                    const newBarcode = generateEAN13();
                    barcodeInput.value = newBarcode;
                    updateBarcodePreview(newBarcode);
                });

                barcodeInput.addEventListener('input', function () {
                    updateBarcodePreview(this.value);
                });

                if (barcodeInput.value.trim() !== '') {
                    updateBarcodePreview(barcodeInput.value);
                }

                // Format HET input with thousands separator
                const hetInput = document.getElementById('het');
                if (hetInput) {
                    hetInput.addEventListener('input', function () {
                        let value = this.value.replace(/[^0-9]/g, '');
                        this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
