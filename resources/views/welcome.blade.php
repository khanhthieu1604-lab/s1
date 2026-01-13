@extends('layouts.app')

@section('content')

{{-- Cấu hình Font và Màu sắc cục bộ --}}
<style>
    .font-display { font-family: 'Cinzel', serif; }
    .font-body { font-family: 'Manrope', sans-serif; }
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="bg-[#050505] min-h-screen text-[#e0e0e0] font-body selection:bg-white selection:text-black overflow-x-hidden">

   

    {{-- HERO SECTION: Editorial Style --}}
    <section class="relative h-screen w-full flex flex-col justify-center items-center pt-20">
        
        {{-- Background Image (Tối giản hơn video, tập trung emotion) --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-[#050505] via-transparent to-[#050505] z-10"></div>
            <img src="https://images.unsplash.com/photo-1617788138017-80ad40651399?q=80&w=2070&auto=format&fit=crop" 
                 class="w-full h-full object-cover opacity-40 scale-105 animate-kenburns">
        </div>

        {{-- Typography Hero --}}
        <div class="relative z-20 text-center space-y-6 px-4">
            <p class="text-[10px] md:text-xs font-bold tracking-[0.5em] text-white/60 uppercase mb-4 animate-fade-in-up">
                Established 2026
            </p>
            <h1 class="font-display text-5xl md:text-8xl lg:text-[9rem] leading-none text-white mix-blend-overlay opacity-90 animate-fade-in-up" style="animation-delay: 0.1s;">
                SILENT <br> <span class="italic font-light">POWER</span>
            </h1>
            <p class="max-w-md mx-auto text-xs md:text-sm font-light text-gray-400 tracking-wide leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s;">
                Nghệ thuật di chuyển dành cho giới tinh hoa. <br>
                Không phô trương. Chỉ đẳng cấp thuần túy.
            </p>
        </div>

        {{-- Quick Search Widget (Floating Glass) --}}
        <div class="absolute bottom-12 z-30 w-full max-w-3xl px-4 animate-fade-in-up" style="animation-delay: 0.3s;">
            <form action="{{ route('vehicles.index') }}" method="GET" class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-full p-2 flex items-center justify-between">
                <div class="flex-1 px-6 border-r border-white/10">
                    <label class="block text-[9px] uppercase tracking-wider text-gray-500 mb-1">Location</label>
                    <input type="text" name="location" placeholder="Điểm đón..." class="bg-transparent border-none text-white text-sm placeholder-gray-600 w-full focus:ring-0 p-0">
                </div>
                <div class="flex-1 px-6">
                    <label class="block text-[9px] uppercase tracking-wider text-gray-500 mb-1">Date</label>
                    <input type="text" name="date" placeholder="Thời gian..." class="bg-transparent border-none text-white text-sm placeholder-gray-600 w-full focus:ring-0 p-0">
                </div>
                <button type="submit" class="bg-white text-black rounded-full h-12 w-12 md:w-32 flex items-center justify-center gap-2 hover:bg-gray-200 transition-colors">
                    <span class="hidden md:inline text-xs font-bold uppercase tracking-widest">Tìm Xe</span>
                    <i class="fa-solid fa-arrow-right -rotate-45"></i>
                </button>
            </form>
        </div>
    </section>

    {{-- SECTION: THE FLEET (Bento Grid Layout thay vì Slide) --}}
    <section class="py-32 px-4 md:px-12 bg-[#050505]">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 border-b border-white/10 pb-8">
            <div>
                <span class="text-xs font-bold text-gray-500 tracking-widest uppercase block mb-2">The Collection</span>
                <h2 class="font-display text-4xl md:text-5xl text-white">Royal Fleet</h2>
            </div>
            <a href="#" class="text-xs uppercase tracking-widest border-b border-white/30 pb-1 hover:text-white hover:border-white transition-all text-gray-400 mt-4 md:mt-0">
                View All Vehicles
            </a>
        </div>

        {{-- Bento Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 h-auto">
            @foreach($vehicles->take(5) as $index => $vehicle)
                {{-- Logic layout: Xe đầu tiên to nhất --}}
                <div class="group relative overflow-hidden rounded-sm bg-zinc-900 border border-white/5 {{ $index === 0 ? 'md:col-span-2 md:row-span-2 min-h-[500px]' : 'min-h-[300px]' }}">
                    
                    {{-- Image --}}
                    <img src="{{ str_starts_with($vehicle->image, 'http') ? $vehicle->image : asset('storage/' . $vehicle->image) }}" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-60 group-hover:opacity-80">
                    
                    {{-- Overlay Gradient --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

                    {{-- Content --}}
                    <div class="absolute bottom-0 left-0 p-6 md:p-8 w-full flex flex-col justify-end items-start transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <span class="inline-block px-2 py-1 mb-3 text-[10px] font-bold uppercase tracking-widest border border-white/20 bg-black/30 backdrop-blur-sm text-gray-300">
                            {{ $vehicle->brand->name ?? 'Luxury' }}
                        </span>
                        <h3 class="font-display {{ $index === 0 ? 'text-4xl' : 'text-2xl' }} text-white mb-2">{{ $vehicle->name }}</h3>
                        
                        <div class="h-0 overflow-hidden group-hover:h-auto transition-all duration-300 opacity-0 group-hover:opacity-100 delay-100">
                            <p class="text-gray-400 text-xs mb-4 line-clamp-2">{{ $vehicle->description }}</p>
                            <div class="flex items-center gap-4">
                                <span class="text-white font-body font-bold">{{ number_format($vehicle->price) }} <span class="text-[10px] text-gray-500">VND/Day</span></span>
                                <a href="{{ route('vehicles.show', $vehicle->id) }}" class="w-8 h-8 rounded-full bg-white text-black flex items-center justify-center hover:bg-gray-200">
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- SECTION: SERVICES (Horizontal Sticky Scroll) --}}
    <section class="py-24 border-t border-white/5 bg-[#080808]">
        <div class="container mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
                {{-- Left: Sticky Title --}}
                <div class="md:col-span-4">
                    <div class="sticky top-32">
                        <h2 class="font-display text-4xl md:text-6xl mb-6 leading-tight">Beyond <br> <span class="text-gray-600">Driving</span></h2>
                        <p class="text-gray-400 text-sm font-light leading-relaxed mb-8">
                            Chúng tôi không chỉ cung cấp phương tiện. Chúng tôi cung cấp sự tự do, riêng tư và những đặc quyền không thể tìm thấy ở bất kỳ nơi nào khác.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="w-1.5 h-1.5 bg-white rounded-full"></span> 24/7 Concierge
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="w-1.5 h-1.5 bg-white rounded-full"></span> Private Chauffeur
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="w-1.5 h-1.5 bg-white rounded-full"></span> Security Detail
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Right: Service Cards --}}
                <div class="md:col-span-8 space-y-8">
                    {{-- Service 1 --}}
                    <div class="group bg-zinc-900 border border-white/5 p-8 md:p-12 hover:bg-zinc-800 transition-colors duration-500">
                        <i class="fa-solid fa-user-shield text-3xl text-gray-500 mb-6 group-hover:text-white transition-colors"></i>
                        <h3 class="font-display text-2xl text-white mb-3">Vệ sĩ & Tài xế riêng</h3>
                        <p class="text-gray-400 text-sm font-light leading-relaxed">
                            Đội ngũ tài xế được đào tạo chuẩn hoàng gia Anh, thông thạo ngoại ngữ và quy tắc ứng xử. Dịch vụ vệ sĩ tháp tùng đảm bảo sự an toàn tuyệt đối cho chuyến đi của bạn.
                        </p>
                    </div>

                    {{-- Service 2 --}}
                    <div class="group bg-zinc-900 border border-white/5 p-8 md:p-12 hover:bg-zinc-800 transition-colors duration-500">
                        <i class="fa-solid fa-wine-glass text-3xl text-gray-500 mb-6 group-hover:text-white transition-colors"></i>
                        <h3 class="font-display text-2xl text-white mb-3">Tiện ích Thượng lưu</h3>
                        <p class="text-gray-400 text-sm font-light leading-relaxed">
                            Rượu champagne ướp lạnh, xì gà Cuba, hay tạp chí Forbes mới nhất? Mọi yêu cầu dù nhỏ nhất đều được chuẩn bị sẵn trên xe trước khi bạn bước lên.
                        </p>
                    </div>

                     {{-- Service 3 --}}
                     <div class="group bg-zinc-900 border border-white/5 p-8 md:p-12 hover:bg-zinc-800 transition-colors duration-500">
                        <i class="fa-solid fa-plane-up text-3xl text-gray-500 mb-6 group-hover:text-white transition-colors"></i>
                        <h3 class="font-display text-2xl text-white mb-3">Airport VIP Fast-track</h3>
                        <p class="text-gray-400 text-sm font-light leading-relaxed">
                            Đón tiễn tận cửa máy bay. Không xếp hàng, không chờ đợi. Chiếc xe sang trọng sẽ chờ sẵn ngay khi bạn vừa đáp xuống đường băng.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER CTA --}}
    <section class="relative py-32 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=2000')] bg-cover bg-center opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/80 to-transparent"></div>
        
        <div class="relative z-10 text-center">
            <h2 class="font-display text-5xl md:text-7xl mb-8">Ready to Arrive?</h2>
            <a href="{{ route('vehicles.index') }}" class="inline-block border border-white/30 px-12 py-4 hover:bg-white hover:text-black hover:border-white transition-all duration-500 uppercase tracking-[0.2em] text-sm">
                Book Your Experience
            </a>
        </div>
    </section>

</div>

{{-- CSS Animation Keyframes (Thêm vào cuối file hoặc file CSS riêng) --}}
<style>
    @keyframes kenburns {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
    .animate-kenburns {
        animation: kenburns 20s ease-out infinite alternate;
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.8s ease-out forwards;
    }
</style>

@endsection