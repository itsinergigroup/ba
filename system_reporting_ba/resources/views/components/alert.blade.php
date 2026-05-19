@props(['type' => 'success', 'message'])

@php
    $colors = [
        'success' => [
            'bg' => 'bg-emerald-50 dark:bg-emerald-900/20',
            'border' => 'border-emerald-500',
            'text' => 'text-emerald-800 dark:text-emerald-200',
            'icon_bg' => 'bg-emerald-100 dark:bg-emerald-800/40',
            'icon_color' => 'text-emerald-600 dark:text-emerald-400',
        ],
        'error' => [
            'bg' => 'bg-rose-50 dark:bg-rose-900/20',
            'border' => 'border-rose-500',
            'text' => 'text-rose-800 dark:text-rose-200',
            'icon_bg' => 'bg-rose-100 dark:bg-rose-800/40',
            'icon_color' => 'text-rose-600 dark:text-rose-400',
        ],
    ][$type];
@endphp

<div x-data="{ show: true }" 
     x-show="show" 
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     {{ $attributes->merge(['class' => "flex items-center p-4 mb-4 rounded-xl border-l-4 shadow-sm {$colors['bg']} {$colors['border']}"]) }} 
     role="alert">
    
    <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-lg {{ $colors['icon_bg'] }} {{ $colors['icon_color'] }}">
        @if($type === 'success')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        @else
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        @endif
    </div>

    <div class="ml-4 text-sm font-semibold {{ $colors['text'] }}">
        {{ $message }}
    </div>

    <button @click="show = false" type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 {{ $colors['text'] }} hover:bg-white/50 dark:hover:bg-black/20 transition-colors focus:ring-2 focus:ring-gray-300">
        <span class="sr-only">Close</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
