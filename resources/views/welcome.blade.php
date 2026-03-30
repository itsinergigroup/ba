<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Reporting BA - Distributor Management</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex items-center justify-center p-6">
    <div
        class="max-w-5xl w-full bg-white dark:bg-[#161615] shadow-2xl rounded-3xl overflow-hidden flex flex-col md:flex-row border border-gray-100 dark:border-gray-800">
        <!-- Left Side: Content -->
        <div class="p-10 lg:p-16 md:w-3/5 flex flex-col justify-center">
            <div class="flex items-center gap-2 mb-8">
                <div
                    class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                    S</div>
                <span class="font-bold text-xl tracking-tight uppercase">SRN Management</span>
            </div>

            <h1 class="text-4xl lg:text-5xl font-black mb-4 leading-tight">
                System Reporting <span class="text-indigo-600">BA</span>
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-10 max-w-md">
                Solusi manajemen distributor dan pelaporan penjualan harian terpadu untuk efisiensi operasional
                maksimal.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-12">
                <div
                    class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800">
                    <div class="text-green-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold text-sm italic">Laporan Harian</span>
                </div>
                <div
                    class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800">
                    <div class="text-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span class="font-semibold text-sm italic">Data Master</span>
                </div>
            </div>

            @if (Route::has('login'))
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-10 py-4 bg-indigo-600 text-white rounded-xl font-bold text-lg hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-1 transition duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-10 py-4 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1b1b18] rounded-xl font-bold text-lg hover:opacity-90 hover:shadow-lg hover:-translate-y-1 transition duration-200">
                            Masuk Ke Sistem
                        </a>
                    @endauth
                </div>
            @endif
        </div>

        <!-- Right Side: Visual -->
        <div class="md:w-2/5 bg-indigo-600 relative overflow-hidden flex items-center justify-center p-12">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-black opacity-10 rounded-full"></div>

            <div class="relative z-10 text-center text-white">
                <div class="text-8xl font-black mb-2 opacity-20">SRN</div>
                <div class="h-1 w-20 bg-white mx-auto mb-6"></div>
                <p class="text-xl font-medium tracking-[0.2em] uppercase">Reporting App</p>
                <p class="mt-4 text-sm opacity-60">Version 1.0.0</p>
            </div>

            <!-- Abstract Grid -->
            <div class="absolute inset-0 opacity-10"
                style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 20px 20px;">
            </div>
        </div>
    </div>
</body>

</html>