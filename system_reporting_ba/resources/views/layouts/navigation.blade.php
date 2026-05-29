@php
    $unreadCount = auth()->user()->unreadNotifications->count();
    $issueCount = 0;
    $hasIncomplete = false;
    $hasMissing = false;
    
    if (auth()->user()->isBa()) {
        $hasIncomplete = auth()->user()->hasIncompleteAttendance();
        $hasMissing = auth()->user()->hasMissingAttendanceYesterday();
        if ($hasIncomplete) $issueCount++;
        if ($hasMissing) $issueCount++;
    }
    $totalBadge = $unreadCount + $issueCount;
@endphp
<nav x-data="{ open: false, drawer: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-12 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <x-nav.desktop-menu />
            </div>

            <!-- Notifications Dropdown -->
            <x-nav.desktop-notifications :total-badge="$totalBadge" :has-incomplete="$hasIncomplete" :has-missing="$hasMissing" />

            <!-- Settings Dropdown -->
            <x-nav.desktop-profile />

            <!-- Hamburger & Mobile Notifications -->
            <div class="-me-2 flex items-center sm:hidden">
                <!-- Mobile Notifications Icon -->
                <x-nav.mobile-notifications-icon :total-badge="$totalBadge" :has-incomplete="$hasIncomplete" :has-missing="$hasMissing" />

                <button @click="open = ! open"
                    class="relative inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    @if($totalBadge > 0)
                        <span class="absolute top-2 right-2 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                        </span>
                    @endif
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- Mobile Menu Links -->
        <x-nav.mobile-menu />

        <!-- Mobile Notifications List -->
        <x-nav.mobile-notifications-list :has-incomplete="$hasIncomplete" :has-missing="$hasMissing" />

        <!-- Responsive Settings Options -->
        <x-nav.mobile-profile />
    </div>
</nav>
