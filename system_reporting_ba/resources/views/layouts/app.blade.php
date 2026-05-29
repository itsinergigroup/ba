<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- PWA Setup -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    <link rel="apple-touch-icon" href="{{ asset('SRN (1).png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 pb-16 sm:pb-0">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @if(auth()->check() && auth()->user()->isBa())
            <!-- Bottom Navigation Bar for BA on Mobile -->
            <div class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-gray-850 border-t border-gray-150 dark:border-gray-700 block sm:hidden shadow-lg shadow-gray-200/50 dark:shadow-none">
                <div class="flex justify-around items-center h-16 px-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full h-full text-xs font-bold transition-all duration-200">
                        <div class="{{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white px-5 py-1 rounded-2xl shadow-md shadow-blue-500/20' : 'text-gray-400 dark:text-gray-500' }} flex items-center justify-center transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <span class="mt-1 text-[9px] font-black uppercase tracking-wider {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}">Dashboard</span>
                    </a>

                    <!-- Laporan -->
                    <a href="{{ route('reports.index') }}" class="flex flex-col items-center justify-center w-full h-full text-xs font-bold transition-all duration-200">
                        <div class="{{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white px-5 py-1 rounded-2xl shadow-md shadow-blue-500/20' : 'text-gray-400 dark:text-gray-500' }} flex items-center justify-center transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="mt-1 text-[9px] font-black uppercase tracking-wider {{ request()->routeIs('reports.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}">Laporan</span>
                    </a>

                    <!-- Absensi -->
                    <a href="{{ route('attendance.index') }}" class="flex flex-col items-center justify-center w-full h-full text-xs font-bold transition-all duration-200">
                        <div class="{{ (request()->routeIs('attendance.*') && !request()->routeIs('attendance.request.*')) ? 'bg-blue-600 text-white px-5 py-1 rounded-2xl shadow-md shadow-blue-500/20' : 'text-gray-400 dark:text-gray-500' }} flex items-center justify-center transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="mt-1 text-[9px] font-black uppercase tracking-wider {{ (request()->routeIs('attendance.*') && !request()->routeIs('attendance.request.*')) ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}">Absensi</span>
                    </a>

                    <!-- Pengajuan -->
                    <a href="{{ route('attendance.request.index') }}" class="flex flex-col items-center justify-center w-full h-full text-xs font-bold transition-all duration-200">
                        <div class="{{ request()->routeIs('attendance.request.*') ? 'bg-blue-600 text-white px-5 py-1 rounded-2xl shadow-md shadow-blue-500/20' : 'text-gray-400 dark:text-gray-500' }} flex items-center justify-center transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2-2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <span class="mt-1 text-[9px] font-black uppercase tracking-wider {{ request()->routeIs('attendance.request.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}">Pengajuan</span>
                    </a>
                </div>
            </div>
        @endif
    </div>

    @stack('scripts')
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/sw.js').then(function (registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function (err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
</body>

</html>
