@props(['hasIncomplete', 'hasMissing'])

@unless(Auth::user()->isRbs() || Auth::user()->isViewOnly())
    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <div class="px-4 flex justify-between items-center mb-2">
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                Notifikasi
            </div>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form method="POST" action="{{ route('notifications.markAsRead') }}">
                    @csrf
                    <button type="submit" class="text-[10px] text-indigo-600 font-bold uppercase tracking-widest hover:underline">
                        Baca Semua
                    </button>
                </form>
            @endif
        </div>
        <div class="space-y-1">
            @if(auth()->user()->isBa())
                @if($hasIncomplete)
                    <div class="mx-2 mb-1">
                        <a href="{{ route('attendance.index') }}" class="block px-4 py-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-900/50">
                            <p class="text-xs text-amber-800 dark:text-amber-400 font-bold flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                Peringatan: Lupa Check-out kemarin!
                            </p>
                        </a>
                    </div>
                @endif
                @if($hasMissing)
                    <div class="mx-2 mb-1">
                        <a href="{{ route('attendance.index') }}" class="block px-4 py-3 bg-rose-50 dark:bg-rose-900/20 rounded-xl border border-rose-100 dark:border-rose-900/50">
                            <p class="text-xs text-rose-800 dark:text-rose-400 font-bold flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                Peringatan: Absensi Kosong kemarin!
                            </p>
                        </a>
                    </div>
                @endif
            @endif

            @forelse(auth()->user()->notifications()->latest()->take(3)->get() as $notification)
                <x-responsive-nav-link :href="$notification->data['url'] ?? '#'" :class="$notification->read_at ? 'opacity-60' : 'bg-indigo-50/30 dark:bg-indigo-900/10'">
                    <div class="flex flex-col">
                        <span class="text-xs {{ $notification->read_at ? '' : 'font-bold text-indigo-700 dark:text-indigo-400' }}">
                            {{ $notification->data['message'] }}
                        </span>
                        <span class="text-[10px] text-gray-400 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>
                </x-responsive-nav-link>
            @empty
                <div class="px-4 py-4 text-center">
                    <p class="text-xs text-gray-400 italic">Tidak ada notifikasi baru</p>
                </div>
            @endforelse
        </div>
    </div>
@endunless
