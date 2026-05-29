@props(['totalBadge', 'hasIncomplete', 'hasMissing'])

@unless(Auth::user()->isRbs() || Auth::user()->isViewOnly())
<div class="hidden sm:flex sm:items-center sm:ms-3">
    <x-dropdown align="right" width="64">
        <x-slot name="trigger">
            <button
                class="relative inline-flex items-center p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                @if($totalBadge > 0)
                    <span class="absolute top-0 right-0 flex h-4 w-4">
                        <span
                            class="animate-pulse absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span
                            class="relative inline-flex items-center justify-center rounded-full h-4 w-4 bg-red-600 text-[9px] font-bold text-white shadow-sm ring-1 ring-white dark:ring-gray-800">
                            {{ $totalBadge > 9 ? '9+' : $totalBadge }}
                        </span>
                    </span>
                @endif
            </button>
        </x-slot>

        <x-slot name="content">
            <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <span
                        class="text-xs font-semibold text-gray-500 uppercase tracking-widest">{{ __('Notifikasi') }}</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <form method="POST" action="{{ route('notifications.markAsRead') }}">
                            @csrf
                            <button type="submit"
                                class="text-[10px] text-indigo-600 dark:text-indigo-400 hover:underline">
                                {{ __('Tandai semua dibaca') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="max-h-64 overflow-y-auto">
                @if(auth()->user()->isBa())
                    @if($hasIncomplete)
                        <div class="px-4 py-3 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/30 transition duration-150 border-b border-amber-100 dark:border-amber-900/50">
                            <a href="{{ route('attendance.index') }}" class="block">
                                <p class="text-xs text-amber-800 dark:text-amber-400 font-bold flex items-center gap-2">
                                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    Peringatan: Lupa Check-out kemarin!
                                </p>
                                <p class="text-[10px] text-amber-600 dark:text-amber-500 mt-1">
                                    Segera ajukan koreksi absen.
                                </p>
                            </a>
                        </div>
                    @endif
                    @if($hasMissing)
                        <div class="px-4 py-3 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/30 transition duration-150 border-b border-rose-100 dark:border-rose-900/50">
                            <a href="{{ route('attendance.index') }}" class="block">
                                <p class="text-xs text-rose-800 dark:text-rose-400 font-bold flex items-center gap-2">
                                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                    Peringatan: Absensi Kosong kemarin!
                                </p>
                                <p class="text-[10px] text-rose-600 dark:text-rose-500 mt-1">
                                    Sistem mendeteksi Anda belum absen.
                                </p>
                            </a>
                        </div>
                    @endif
                @endif
                @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                    <div
                        class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 {{ $notification->read_at ? 'opacity-60' : '' }}">
                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block">
                            <p class="text-xs text-gray-800 dark:text-gray-200 font-medium line-clamp-2">
                                {{ $notification->data['message'] }}
                            </p>
                            <p class="text-[10px] text-gray-400 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </a>
                    </div>
                @empty
                    <div class="px-4 py-6 text-center">
                        <p class="text-xs text-gray-500 font-medium">{{ __('Tidak ada notifikasi') }}</p>
                    </div>
                @endforelse
            </div>
        </x-slot>
    </x-dropdown>
</div>
@endunless
