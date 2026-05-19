<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Input Laporan Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('reports.store') }}" method="POST" id="reportForm">
                    @csrf

                    <!-- Section A – General Info -->
                    <div class="mb-8 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                        <div
                            class="bg-gray-50 dark:bg-gray-700 px-4 py-2 font-bold border-b border-gray-200 dark:border-gray-700">
                            Informasi Umum
                        </div>
                        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label :value="__('Nama Lengkap')" />
                                <x-text-input class="block mt-1 w-full bg-gray-100 dark:bg-gray-900" type="text"
                                    value="{{ auth()->user()->name }}" disabled />
                            </div>
                            <div>
                                <x-input-label for="date" :value="__('Tanggal Penjualan')" />
                                <x-text-input id="date" class="block mt-1 w-full" type="date" name="date"
                                    value="{{ date('Y-m-d') }}" required />
                            </div>
                            <div>
                                <x-input-label for="distributor_id" :value="__('Distributor')" />
                                <select id="distributor_id" name="distributor_id"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    required>
                                    <option value="">-- Pilih Distributor --</option>
                                    @foreach($distributors as $dist)
                                        <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="account_type" :value="__('Jenis Akun')" />
                                <select id="account_type" name="account_type"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    required>
                                    <option value=""></option>
                                    <option value="GT">GT</option>
                                    <option value="MT">MT</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="channel" :value="__('Chanel')" />
                                <select id="channel" name="channel"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    required>
                                    <option value=""></option>
                                    <option value="Direct">Direct</option>
                                    <option value="Indirect">Indirect</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section B – Store Info -->
                    <div class="mb-8 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                        <div
                            class="bg-gray-50 dark:bg-gray-700 px-4 py-2 font-bold border-b border-gray-200 dark:border-gray-700">
                            Informasi Toko
                        </div>
                        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="province_id" :value="__('Provinsi')" />
                                <select id="province_id" name="province_id"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    required onchange="fetchCities(this.value)">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach($provinces as $prov)
                                        <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="city_id" :value="__('Kota / Kabupaten')" />
                                <select id="city_id" name="city_id"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    required>
                                    <option value="">-- Pilih Kota --</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="outlet_id" :value="__('Nama Toko')" />
                                <select id="outlet_id" name="outlet_id"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    required>
                                    <option value="">-- Pilih Toko --</option>
                                    @foreach($outlets as $outlet)
                                        <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section C – Product Items -->
                    <div class="mb-8 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                        <div
                            class="bg-gray-50 dark:bg-gray-700 px-4 py-2 font-bold border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <span>Produk Terjual</span>
                            <button type="button" onclick="addRow()"
                                class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded-lg transition">
                                + Tambah Produk
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm md:text-base" id="itemsTable">
                                <thead class="hidden md:table-header-group">
                                    <tr class="bg-gray-100 dark:bg-gray-700/50 border-b dark:border-gray-700 text-[10px] md:text-xs font-bold uppercase tracking-wider text-gray-500">
                                        <th class="p-3">Brand & Produk</th>
                                        <th class="p-3 w-32 text-center">QTY</th>
                                        <th class="p-3 w-48 {{ auth()->user()->isAdmin() ? 'hidden' : '' }} text-right">Harga Jual</th>
                                        <th class="p-3 w-32 text-right">HET</th>
                                        <th class="p-3 w-24 text-center">Disc</th>
                                        <th class="p-3 w-40 text-right">Total</th>
                                        <th class="p-3 w-12 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="itemRows">
                                    <!-- Rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="p-4 bg-indigo-50 dark:bg-indigo-900/30 text-right font-bold text-xl border-t dark:border-gray-700">
                            Grand Total: <span id="grandTotal">Rp 0</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-4">
                        <a href="{{ route('reports.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Kembali') }}
                        </a>
                        <x-primary-button>
                            {{ __('Kirim Laporan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Row Template -->
    <template id="rowTemplate">
        <tr
            class="flex flex-col md:table-row border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition item-row p-4 md:p-0">
            <td class="p-0 md:px-3 md:py-2 mb-4 md:mb-0 align-middle relative">
                <div class="md:hidden text-[10px] font-extrabold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-3 border-b dark:border-gray-700 pb-2">
                    Item Detail
                </div>
                <div class="md:hidden text-[10px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Brand & Produk
                </div>
                <div class="flex flex-col md:flex-row gap-2">
                    <select name="items[INDEX][brand_id]"
                        class="block w-full text-xs md:text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md"
                        required onchange="fetchProducts(this)">
                        <option value="">-- Brand --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    <select name="items[INDEX][product_id]"
                        class="block w-full text-xs md:text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md product-select"
                        required onchange="setHET(this)">
                        <option value="">-- Produk --</option>
                    </select>
                </div>
            </td>
            <td class="p-0 md:px-6 md:py-2 mb-2 md:mb-0 align-middle">
                <div class="md:hidden text-[10px] font-bold text-gray-500 mb-1 uppercase tracking-wider">QTY</div>
                <input type="number" name="items[INDEX][quantity]"
                    class="block w-full text-xs md:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md qty-input text-center px-1 py-1.5"
                    min="1" required oninput="calculateRow(this.closest('tr'))">
            </td>
            <td class="p-0 md:px-6 md:py-2 mb-2 md:mb-0 {{ auth()->user()->isAdmin() ? 'hidden' : '' }} align-middle">
                <div class="md:hidden text-[10px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Harga Jual
                </div>
                <input type="text" name="items[INDEX][unit_price]"
                    class="block w-full text-xs md:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-md price-input text-right px-2 py-1.5"
                    {{ auth()->user()->isBa() ? 'oninput=formatAndCalc(this)' : 'readonly' }} required>
            </td>
            <td class="p-0 md:px-3 md:py-2 mb-2 md:mb-0 flex md:table-cell items-center justify-between md:justify-end align-middle">
                <div class="md:hidden text-[10px] font-bold text-gray-500 uppercase tracking-wider">HET</div>
                <div class="text-xs md:text-sm text-gray-500 text-right font-medium">
                    <span class="het-display">-</span>
                    <input type="hidden" class="het-hidden">
                </div>
            </td>
            <td class="p-0 md:px-3 md:py-2 mb-2 md:mb-0 flex md:table-cell items-center justify-between md:justify-center align-middle">
                <div class="md:hidden text-[10px] font-bold text-gray-500 uppercase tracking-wider">Disc</div>
                <span class="disc-display font-black text-red-500 text-xs md:text-sm bg-red-50 dark:bg-red-900/20 px-1.5 py-0.5 rounded">0%</span>
            </td>
            <td class="p-0 md:px-3 md:py-2 mb-0 flex md:table-cell items-center justify-between md:justify-end align-middle">
                <div class="md:hidden text-[10px] font-bold text-gray-500 uppercase tracking-wider">Subtotal</div>
                <span class="row-total font-black text-indigo-600 dark:text-indigo-400 text-sm md:text-base" data-value="0">Rp 0</span>
            </td>
            <td class="p-0 md:px-3 md:py-2 mt-2 md:mt-0 pt-3 md:pt-0 border-t md:border-0 dark:border-gray-700 flex md:table-cell align-middle text-center">
                <button type="button" onclick="removeRow(this)"
                    class="group inline-flex items-center justify-center gap-2 text-red-500 hover:text-red-700 transition font-bold text-[10px] uppercase tracking-wider w-full md:w-auto">
                    <div class="bg-red-50 dark:bg-red-900/20 p-1.5 rounded-lg group-hover:bg-red-100 transition">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </div>
                    <span class="md:hidden">Hapus Produk Ini</span>
                </button>
            </td>
        </tr>
    </template>

    <script>
        let rowIndex = 0;

        function addRow() {
            const template = document.getElementById('rowTemplate').innerHTML;
            const html = template.replace(/INDEX/g, rowIndex);
            document.getElementById('itemRows').insertAdjacentHTML('beforeend', html);
            rowIndex++;
            updateGrandTotal();
        }

        function removeRow(btn) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                btn.closest('tr').remove();
                updateGrandTotal();
            } else {
                alert('Minimal harus ada satu produk.');
            }
        }

        const distributorsData = @json($distributors->keyBy('id'));

        async function fetchCities(provinceId) {
            const citySelect = document.getElementById('city_id');
            citySelect.innerHTML = '<option value="">-- Memuat... --</option>';

            if (!provinceId) {
                citySelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
                return;
            }

            try {
                const response = await fetch(`/api/cities/${provinceId}`);
                const cities = await response.json();

                citySelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
                cities.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                });
            } catch (error) {
                console.error('Error fetching cities:', error);
                citySelect.innerHTML = '<option value="">-- Gagal memuat data --</option>';
            }
        }        async function fetchProducts(brandSelect) {
            const row = brandSelect.closest('tr');
            const productSelect = row.querySelector('.product-select');
            productSelect.innerHTML = '<option value="">-- Loading... --</option>';

            const brandId = brandSelect.value;
            if (!brandId) return;

            // Tambahkan cache buster ?t=... untuk memastikan data selalu fresh dari server
            const response = await fetch(`/api/products/${brandId}?t=${new Date().getTime()}`);
            const products = await response.json();

            console.log("Products received for brand " + brandId + ":", products);

            // Store products on the select element itself for easy access
            productSelect.dataset.products = JSON.stringify(products);

            productSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';
            products.forEach(p => {
                productSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
            });
        }

        function setHET(productSelect) {
            const row = productSelect.closest('tr');
            if (!row) return;

            const hetDisplay = row.querySelector('.het-display');
            const hetHidden = row.querySelector('.het-hidden');
            const priceInput = row.querySelector('.price-input');

            const productId = productSelect.value;
            if (!productId) {
                hetDisplay.innerText = "-";
                hetHidden.value = "0";
                priceInput.value = "";
                calculateRow(row);
                return;
            }

            const productsData = productSelect.dataset.products;
            if (!productsData) return;

            const products = JSON.parse(productsData);
            const product = products.find(p => p.id == productId);

            if (product) {
                // Ensure we use floating point for HET and integer/float for selling_price
                const hetValue = parseFloat(product.het) || 0;
                const sellingPriceValue = parseFloat(product.selling_price) || 0;

                hetDisplay.innerText = formatNumber(hetValue);
                hetHidden.value = hetValue;

                // Ini adalah bagian yang mengambil harga jual dari master
                priceInput.value = formatNumber(sellingPriceValue);

                calculateRow(row);
            }
        }

        function formatAndCalc(input) {
            let value = input.value.replace(/[^0-9]/g, "");
            input.value = value ? formatNumber(value) : "";
            calculateRow(input.closest('tr'));
        }

        function calculateRow(row) {
            if (!row) return;

            const het = parseFloat(row.querySelector('.het-hidden').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value.replace(/\./g, '')) || 0;
            const qty = parseInt(row.querySelector('.qty-input').value) || 0;

            // Discount
            const discDisplay = row.querySelector('.disc-display');
            if (het > 0) {
                const disc = ((price - het) / het) * 100;
                discDisplay.innerText = disc.toFixed(1) + '%';
            } else {
                discDisplay.innerText = '0%';
            }

            // Row Total
            const total = price * qty;
            const totalDisplay = row.querySelector('.row-total');
            totalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
            totalDisplay.dataset.value = total;

            updateGrandTotal();
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.row-total').forEach(el => {
                grandTotal += parseFloat(el.dataset.value) || 0;
            });
            document.getElementById('grandTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        function formatNumber(number) {
            if (number === null || number === undefined || number === "") return "0";
            // Convert to number if it's a string, and remove decimal if it's .00
            let val = parseFloat(number);
            if (isNaN(val)) return "0";

            // Format with dot separator for thousands
            return val.toString().split('.')[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Initialize with one row
        window.addEventListener('load', () => {
            addRow();
        });
    </script>
</x-app-layout>
