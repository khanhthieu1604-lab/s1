<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Thiuu Rental') }} - Elite Experience</title>
    
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/png">

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600|montserrat:800,900&display=swap" rel="stylesheet" />
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts loaded via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root { --accent-gold: #eab308; }
        body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
        .font-heading { font-family: 'Montserrat', sans-serif; }
        [x-cloak] { display: none !important; }

        
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d4d4d8; border-radius: 20px; }
        .dark ::-webkit-scrollbar-thumb { background: #27272a; }
        ::selection { background: var(--accent-gold); color: #000; }
    </style>

    <script>
        const theme = localStorage.getItem('color-theme') || 
                     (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', theme === 'dark');
    </script>
</head>

<body class="antialiased bg-white text-zinc-900 dark:bg-[#050505] dark:text-zinc-100 flex flex-col min-h-screen">

    <header>
        @include('layouts.navigation')
    </header>

    <main id="main-content" class="flex-grow animate-fade-in-up">
        @if(isset($slot) && $slot->isNotEmpty())
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    
    <footer class="py-24 border-t border-zinc-100 dark:border-white/5 bg-white dark:bg-[#050505] transition-colors duration-500 mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-16 mb-20">
                
                
                <div class="md:col-span-4">
                    <a href="{{ route('home') }}" class="inline-block mb-8 group">
                        <span class="text-3xl font-black tracking-tighter text-gray-900 dark:text-white uppercase transition-colors group-hover:text-yellow-500">
                            THIUU<span class="text-yellow-500 italic">.</span>
                        </span>
                    </a>
                    <p class="text-gray-500 dark:text-zinc-500 text-[11px] leading-relaxed max-w-xs uppercase tracking-[0.2em] font-semibold mb-10">
                        Định nghĩa lại chuẩn mực di chuyển thượng lưu. Tinh hoa của tốc độ và sự sang trọng bậc nhất.
                    </p>
                    <div class="flex gap-6">
                        <a href="#" class="text-zinc-400 hover:text-yellow-500 transition-all hover:-translate-y-1"><i class="fa-brands fa-instagram text-lg"></i></a>
                        <a href="#" class="text-zinc-400 hover:text-yellow-500 transition-all hover:-translate-y-1"><i class="fa-brands fa-facebook-f text-lg"></i></a>
                        <a href="#" class="text-zinc-400 hover:text-yellow-500 transition-all hover:-translate-y-1"><i class="fa-brands fa-linkedin-in text-lg"></i></a>
                    </div>
                </div>

                
                <div class="md:col-span-3">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-900 dark:text-white mb-10">Dịch vụ & Hướng dẫn</h4>
                    <ul class="space-y-6">
                        <li><a href="{{ route('pages.procedures') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 hover:text-yellow-500 transition-colors">Quy trình thuê xe</a></li>
                        <li><a href="{{ route('pages.payment') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 hover:text-yellow-500 transition-colors">Thanh toán đặc quyền</a></li>
                        <li><a href="{{ route('pages.faq') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 hover:text-yellow-500 transition-colors">Hỗ trợ FAQ</a></li>
                        <li><a href="{{ route('vehicles.index') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 hover:text-yellow-500 transition-colors">Elite Collection</a></li>
                    </ul>
                </div>

                
                <div class="md:col-span-3">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-900 dark:text-white mb-10">Hệ sinh thái</h4>
                    <ul class="space-y-6">
                        <li><a href="{{ route('about') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 hover:text-yellow-500 transition-colors">Câu chuyện thương hiệu</a></li>
                        <li><a href="{{ route('pages.partnership') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 hover:text-yellow-500 transition-colors">Hợp tác chiến lược</a></li>
                        <li><a href="{{ route('pages.policy') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 hover:text-yellow-500 transition-colors">Quyền riêng tư</a></li>
                        <li><a href="#" class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 hover:text-yellow-500 transition-colors">Điều khoản Elite</a></li>
                    </ul>
                </div>

                
                <div class="md:col-span-2">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-900 dark:text-white mb-10">Support</h4>
                    <div class="p-5 border border-zinc-100 dark:border-white/5 rounded-2xl bg-zinc-50 dark:bg-zinc-900/30">
                        <p class="text-[9px] font-black text-zinc-400 uppercase tracking-widest mb-3">Concierge 24/7</p>
                        <p class="text-xs font-black text-gray-900 dark:text-white tracking-tighter mb-1">1900 8888</p>
                        <p class="text-[9px] text-yellow-600 font-bold tracking-widest">VIP SERVICE ONLY</p>
                    </div>
                </div>
            </div>

            
            <div class="pt-10 border-t border-zinc-100 dark:border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-[9px] font-black uppercase tracking-[0.5em] text-zinc-400 opacity-60">
                    &copy; {{ date('Y') }} THIUU RENTAL ELITE. ALL RIGHTS RESERVED.
                </div>
                <div class="flex gap-8">
                    <span class="text-[9px] font-bold text-zinc-400 uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-yellow-500/50"></i> Global Secure
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Remove transparency after load to ensure everything is visible
            // The animation is now handled by CSS 'animate-fade-in-up' on the main element
            setTimeout(() => {
                document.querySelectorAll('.page-fade-in').forEach(el => el.classList.remove('opacity-0'));
            }, 100);
        });
    </script>
</body>
</html>