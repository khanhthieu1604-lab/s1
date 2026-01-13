@extends('layouts.app')

@section('content')

<div class="bg-gray-50 dark:bg-[#050505] min-h-screen relative font-sans overflow-x-hidden selection:bg-yellow-500 selection:text-black">
    {{-- Noise Texture --}}
    <div class="fixed inset-0 z-0 opacity-5 pointer-events-none" style="background-image: url('{{ asset('images/noise.png') }}'); background-repeat: repeat;"></div>

    {{-- Hero Section --}}
    <div class="relative h-[50vh] flex items-center justify-center overflow-hidden group">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1494905998402-395d579af9c5?q=80&w=2070" 
                 class="w-full h-full object-cover opacity-80 scale-105 transition-transform duration-[3s] ease-in-out group-hover:scale-110" 
                 alt="Fleet Banner">
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/20 to-gray-50 dark:to-[#050505]"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl header-anim opacity-0 translate-y-4">
            <span class="inline-block py-1.5 px-5 rounded-full border border-yellow-500/50 bg-black/30 backdrop-blur-md text-yellow-400 text-[10px] font-black uppercase tracking-[0.4em] mb-6 animate-pulse">
                The Royal Fleet
            </span>
            <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tighter drop-shadow-2xl">
                Ultimate <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-amber-600">Machine</span>
            </h1>
        </div>
    </div>

    {{-- Filter & List --}}
    <div class="relative z-20 -mt-20 pb-20">
        <div class="container mx-auto px-4">
            
            {{-- Filter Bar --}}
            <div class="glass-premium p-6 rounded-[2rem] shadow-2xl transition-all duration-500 ease-out sticky top-6 z-50 mb-12 border border-white/10">
                <form action="{{ route('vehicles.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    
                    <div class="md:col-span-4 relative group">
                        <x-ui.input name="search" value="{{ request('search') }}" placeholder="Tìm tên siêu xe..." class="!bg-white/5 !border-white/10 !text-white !rounded-xl !pl-10 focus:!ring-yellow-500" />
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500 group-focus-within:text-yellow-500 transition-colors pointer-events-none"></i>
                    </div>

                    
                    <div class="md:col-span-3">
                        <select name="category" class="w-full px-5 py-3.5 bg-white/5 border border-white/10 rounded-xl text-sm font-bold text-white focus:ring-1 focus:ring-yellow-500 cursor-pointer hover:bg-white/10 transition-colors">
                            <option value="" class="text-black">Tất cả phân khúc</option>
                            <option value="Sedan" class="text-black" {{ request('category') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                            <option value="SUV" class="text-black" {{ request('category') == 'SUV' ? 'selected' : '' }}>SUV</option>
                            <option value="Coupe" class="text-black" {{ request('category') == 'Coupe' ? 'selected' : '' }}>Coupe</option>
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <select name="price" class="w-full px-5 py-3.5 bg-white/5 border border-white/10 rounded-xl text-sm font-bold text-white focus:ring-1 focus:ring-yellow-500 cursor-pointer hover:bg-white/10 transition-colors">
                            <option value="" class="text-black">Mức giá</option>
                            <option value="under_1m" class="text-black" {{ request('price') == 'under_1m' ? 'selected' : '' }}>&lt; 1 Triệu</option>
                            <option value="above_2m" class="text-black" {{ request('price') == 'above_2m' ? 'selected' : '' }}>&gt; 2 Triệu</option>
                        </select>
                    </div>

                    
                    <div class="md:col-span-2">
                        <x-ui.button type="submit" variant="primary" size="md" :fullWidth="true" class="!shadow-none">
                            Tìm Kiếm
                        </x-ui.button>
                    </div>
                </form>
            </div>

            
            {{-- Vehicle Grid Container --}}
            <div id="vehicle-grid-container" class="transition-opacity duration-300">
                @include('vehicles._grid')
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Animation for header
        if (window.anime) {
            anime({
                targets: '.header-anim',
                opacity: [0, 1],
                translateY: [20, 0],
                easing: 'easeOutExpo',
                duration: 1200,
                delay: 200
            });
        } else {
             document.querySelector('.header-anim').style.opacity = 1;
             document.querySelector('.header-anim').style.transform = 'translateY(0)';
        }

        // INSTANT SEARCH LOGIC
        const form = document.querySelector('form[action="{{ route('vehicles.index') }}"]');
        const searchInput = form.querySelector('input[name="search"]');
        const selects = form.querySelectorAll('select');
        const gridContainer = document.getElementById('vehicle-grid-container');
        let debounceTimer;

        function fetchVehicles() {
            // Helper to get form data
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);

            // Add loading state
            gridContainer.style.opacity = '0.5';

            fetch(`{{ route('vehicles.index') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                gridContainer.innerHTML = html;
                gridContainer.style.opacity = '1';
                
                // Re-trigger animations if needed (optional logic here)
                // Since simpler CSS animations are used, they trigger on insert automatically
            })
            .catch(err => {
                console.error('Error fetching vehicles:', err);
                gridContainer.style.opacity = '1';
            });
        }

        // Debounce for text input
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchVehicles();
            }, 500); // Wait 500ms after typing stops
        });

        // Instant update for selects
        selects.forEach(select => {
            select.addEventListener('change', () => {
                fetchVehicles();
            });
        });

        // Prevent default form submit and use standard fetch instead
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            fetchVehicles();
        });
    });
</script>

@endsection