@extends('layouts.app')

@section('content')
    
    <style>
        
        .text-reflect {
            position: relative;
            -webkit-box-reflect: below -20px linear-gradient(transparent, rgba(255,255,255,0.1));
        }

        
        .bg-grainy {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.03;
            pointer-events: none;
        }

        
        .service-card-premium {
            transition: all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
            backdrop-filter: blur(20px);
        }
        
        
        .service-card-premium {
            background: linear-gradient(135deg, rgba(0,0,0,0.02) 0%, rgba(0,0,0,0) 100%);
            border: 1px solid rgba(0,0,0,0.05);
        }

        
        .dark .service-card-premium {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 100%);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .service-card-premium:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }
        
        .dark .service-card-premium:hover {
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        
        .glow-line {
            background: linear-gradient(90deg, transparent, #eab308, transparent);
            background-size: 200% 100%;
            animation: glowMove 3s linear infinite;
        }
        @keyframes glowMove { 0% { background-position: 100% 0; } 100% { background-position: -100% 0; } }
    </style>

    
    <div class="bg-white dark:bg-[#050505] min-h-screen text-gray-900 dark:text-white transition-colors duration-500 overflow-hidden relative">
        <div class="absolute inset-0 bg-grainy z-10 pointer-events-none"></div>

        
        <section class="relative h-[85vh] flex items-center justify-center pt-20">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1503376763036-066120622c74?q=80&w=2070" 
                     class="w-full h-full object-cover opacity-30 dark:opacity-40" id="hero-img"
                     onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=2070'">
                
                <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-white dark:from-[#050505] dark:to-[#050505]"></div>
            </div>

            <div class="container mx-auto px-4 relative z-10 text-center">
                <div class="hero-stagger opacity-0 mb-6">
                    <span class="px-6 py-2 rounded-full border border-yellow-500/30 bg-yellow-500/5 text-yellow-600 dark:text-yellow-500 text-[10px] font-black uppercase tracking-[0.6em]">
                        The Art of Service
                    </span>
                </div>
                <h1 class="hero-stagger opacity-0 text-7xl md:text-[10rem] font-black tracking-tighter leading-none text-gray-900 dark:text-white dark:text-reflect mb-12">
                    EXCELLENCE
                </h1>
                <p class="hero-stagger opacity-0 text-gray-600 dark:text-gray-400 text-lg md:text-2xl font-light max-w-3xl mx-auto leading-relaxed">
                    Không chỉ là dịch vụ, đó là một lời cam kết về sự <span class="text-yellow-600 dark:text-white font-medium italic">hoàn hảo</span> trên từng dặm đường.
                </p>
            </div>
        </section>

        
        <section class="py-32 container mx-auto px-4 relative">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 relative z-10">
                @php
                    $services = [
                        ['title' => 'Self Drive', 'label' => 'Tự lái', 'desc' => 'Tự do tuyệt đối với bộ sưu tập siêu xe đời mới nhất. Thủ tục bảo mật, giao xe ẩn danh.', 'color' => 'yellow', 'icon' => 'fa-steering-wheel'],
                        ['title' => 'Elite Chauffeur', 'label' => 'Có tài xế', 'desc' => 'Đội ngũ tài xế riêng chuẩn mực concierge. Phục vụ 24/7 với tinh thần chuyên nghiệp tuyệt đối.', 'color' => 'blue', 'icon' => 'fa-user-tie'],
                        ['title' => 'Red Carpet', 'label' => 'Sự kiện', 'desc' => 'Dàn xe hoa, Roadshow và đưa đón nguyên thủ. Kiến tạo dấu ấn khó quên cho thời khắc lịch sử.', 'color' => 'pink', 'icon' => 'fa-gem']
                    ];
                @endphp

                @foreach($services as $s)
                <div class="service-card opacity-0 service-card-premium group p-12 rounded-[3.5rem] overflow-hidden relative">
                    
                    <div class="absolute -inset-1 bg-gradient-to-br from-{{ $s['color'] }}-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-{{ $s['color'] }}-500/10 flex items-center justify-center text-{{ $s['color'] }}-600 dark:text-{{ $s['color'] }}-500 text-2xl mb-12 border border-{{ $s['color'] }}-500/20">
                            <i class="fa-solid {{ $s['icon'] }}"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-400 mb-4 block">{{ $s['title'] }}</span>
                        <h3 class="text-4xl font-black mb-8 tracking-tighter text-gray-900 dark:text-white">{{ $s['label'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 font-light leading-relaxed text-lg mb-12">
                            {{ $s['desc'] }}
                        </p>
                        <a href="#" class="inline-flex items-center gap-4 text-xs font-black uppercase tracking-widest text-{{ $s['color'] }}-600 dark:text-{{ $s['color'] }}-500 group-hover:gap-6 transition-all">
                            Request Access <i class="fa-solid fa-arrow-right-long"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        
        <section class="py-32 relative">
            <div class="container mx-auto px-4">
                <div class="bg-gray-50 dark:bg-[#0a0a0a] rounded-[5rem] border border-gray-100 dark:border-white/5 p-12 md:p-24 relative overflow-hidden reveal-on-scroll">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                        <div>
                            <h2 class="text-5xl md:text-7xl font-black tracking-tighter mb-10 leading-none text-gray-900 dark:text-white">
                                ĐỐI TÁC <br> <span class="text-yellow-600 dark:text-yellow-500 italic">CHIẾN LƯỢC</span>
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 text-xl font-light leading-relaxed mb-12">
                                Chúng tôi thiết kế các gói giải pháp vận tải dành riêng cho doanh nghiệp, đảm bảo sự đồng bộ về hình ảnh và tối ưu hóa chi phí vận hành.
                            </p>
                            <a href="#" class="inline-block px-12 py-6 bg-gray-900 dark:bg-white text-white dark:text-black font-black uppercase text-xs tracking-widest rounded-2xl hover:bg-yellow-500 transition-colors shadow-xl">
                                Hợp tác ngay
                            </a>
                        </div>
                        <div class="rounded-[3rem] overflow-hidden border border-gray-200 dark:border-white/10 shadow-2xl relative">
                            <img src="https://images.unsplash.com/photo-1560179707-f14e90ef3623?q=80&w=2073" class="w-full h-full object-cover"
                                 onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=2000'">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
        <section class="py-32 bg-gray-50/50 dark:bg-[#070707] relative overflow-hidden">
            <div class="container mx-auto px-4 max-w-6xl text-center">
                <h2 class="text-4xl font-black uppercase tracking-[0.5em] text-gray-300 dark:text-gray-700 mb-32">Quy Trình Chuẩn</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-20 relative">
                    <div class="hidden md:block absolute top-12 left-0 w-full h-[1px] glow-line opacity-20"></div>
                    @foreach(['01' => 'Concierge', '02' => 'Verification', '03' => 'Delivery', '04' => 'Completion'] as $num => $title)
                        <div class="process-item opacity-0 relative z-10 group">
                            <div class="w-24 h-24 mx-auto rounded-full bg-white dark:bg-black border border-gray-200 dark:border-white/10 flex items-center justify-center text-yellow-600 dark:text-yellow-500 font-black text-xl mb-8 group-hover:border-yellow-500 transition-all duration-500 shadow-xl group-hover:shadow-yellow-500/20">
                                {{ $num }}
                            </div>
                            <h4 class="text-xl font-black mb-4 tracking-tighter text-gray-900 dark:text-white">{{ $title }}</h4>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const heroTl = anime.timeline({ easing: 'easeOutExpo' });
            heroTl
                .add({ targets: '#hero-img', scale: [1.2, 1], opacity: [0, 0.4], duration: 3000 })
                .add({ targets: '.hero-stagger', translateY: [60, 0], opacity: [0, 1], delay: anime.stagger(200), duration: 1500 }, '-=2500');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = entry.target;
                        if (target.classList.contains('service-card')) {
                            anime({ targets: target, opacity: [0, 1], translateY: [50, 0], scale: [0.95, 1], duration: 1500, easing: 'easeOutElastic(1, .8)' });
                        } else if (target.classList.contains('process-item')) {
                            anime({ targets: target, opacity: [0, 1], scale: [0.5, 1], duration: 1000, easing: 'easeOutBack' });
                        } else {
                            anime({ targets: target, opacity: [0, 1], translateY: [40, 0], duration: 1200, easing: 'easeOutQuad' });
                        }
                        observer.unobserve(target);
                    }
                });
            }, { threshold: 0.15 });

            document.querySelectorAll('.service-card, .process-item, .reveal-on-scroll').forEach(el => observer.observe(el));
        });
    </script>
@endsection