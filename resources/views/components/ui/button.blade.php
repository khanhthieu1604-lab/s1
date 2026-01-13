@props([
    'variant' => 'primary', // primary, secondary, outline, danger, ghost
    'size' => 'md', // sm, md, lg
    'href' => null,
    'fullWidth' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-bold tracking-wide transition-all duration-300 ease-out focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed group relative overflow-hidden';
    
    $variants = [
        'primary' => 'bg-yellow-500 text-black border border-yellow-500 hover:bg-yellow-400 hover:border-yellow-400 hover:scale-105 shadow-[0_0_20px_rgba(234,179,8,0.3)]',
        'secondary' => 'bg-white/10 backdrop-blur-md text-white border border-white/20 hover:bg-white/20 hover:border-white/40 hover:scale-105 shadow-[0_0_20px_rgba(255,255,255,0.1)]',
        'outline' => 'bg-transparent text-white border border-white/30 hover:bg-white/10 hover:border-white/60',
        'danger' => 'bg-red-600 text-white border border-red-600 hover:bg-red-500 hover:border-red-500',
        'ghost' => 'bg-transparent text-white/70 hover:text-white hover:bg-white/5',
    ];

    $sizes = [
        'sm' => 'px-4 py-2 text-xs rounded-lg uppercase',
        'md' => 'px-6 py-3 text-sm rounded-xl uppercase',
        'lg' => 'px-8 py-4 text-base rounded-2xl uppercase',
    ];

    $classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size] . ($fullWidth ? ' w-full' : '');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        <span class="relative z-10 flex items-center gap-2">
            {{ $slot }}
        </span>
        {{-- Shine Effect for Primary --}}
        @if($variant === 'primary')
            <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-700 bg-gradient-to-r from-transparent via-white/30 to-transparent z-0"></div>
        @endif
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        <span class="relative z-10 flex items-center gap-2">
            {{ $slot }}
        </span>
        {{-- Shine Effect for Primary --}}
        @if($variant === 'primary')
            <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-700 bg-gradient-to-r from-transparent via-white/30 to-transparent z-0"></div>
        @endif
    </button>
@endif
