@props([
    'label' => null,
    'id' => null,
    'type' => 'text',
    'name' => '',
    'placeholder' => '',
    'error' => null,
])

@php
    $id = $id ?? $name;
@endphp

<div class="relative group">
    @if($label)
        <label for="{{ $id }}" class="block mb-2 text-xs font-bold tracking-wider text-white/60 uppercase group-focus-within:text-yellow-500 transition-colors">
            {{ $label }}
        </label>
    @endif
    
    <div class="relative">
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-all duration-300']) }}
        >
        
        @if($error)
            <div class="absolute right-3 top-3 text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        @endif
    </div>

    @if($error)
        <p class="mt-1 text-xs text-red-500 font-medium">{{ $error }}</p>
    @endif
</div>
