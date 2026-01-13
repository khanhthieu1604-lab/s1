@props([
    'id' => null,
    'title' => null,
    'subtitle' => null,
    'padding' => 'py-20',
])

<section 
    @if($id) id="{{ $id }}" @endif
    {{ $attributes->merge(['class' => 'relative z-10 ' . $padding]) }}
>
    <div class="container mx-auto px-6">
        @if($title || $subtitle)
            <div class="mb-16 text-center max-w-3xl mx-auto">
                @if($subtitle)
                    <p class="text-yellow-500 font-bold tracking-[0.2em] mb-4 uppercase text-sm animate-on-scroll opacity-0 translate-y-4">
                        {{ $subtitle }}
                    </p>
                @endif
                @if($title)
                    <h2 class="text-4xl md:text-6xl font-black text-white leading-tight tracking-tighter animate-on-scroll opacity-0 translate-y-4" style="transition-delay: 100ms;">
                        {{ $title }}
                    </h2>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</section>
