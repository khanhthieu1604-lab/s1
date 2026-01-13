@extends('layouts.app')

@section('content')

{{-- Font Loading --}}
<link href="https://fonts.googleapis.com/css2?family=Italiana&family=Manrope:wght@200;300;400;600&family=Syncopate:wght@400;700&display=swap" rel="stylesheet">

<style>
    :root {
        --c-gold: #C5A059;
        --c-gold-dim: #8a703d;
        --c-black: #080808;
        --c-dark-gray: #1a1a1a;
    }

    body { background-color: var(--c-black); color: #f0f0f0; }
    
    /* Typography */
    .font-serif-display { font-family: 'Italiana', serif; }
    .font-sans-display { font-family: 'Manrope', sans-serif; }
    .font-future { font-family: 'Syncopate', sans-serif; letter-spacing: 0.2em; text-transform: uppercase; }

    /* Custom Cursor */
    .cursor-dot, .cursor-circle {
        position: fixed; top: 0; left: 0; transform: translate(-50%, -50%); border-radius: 50%; pointer-events: none; z-index: 9999;
    }
    .cursor-dot { width: 8px; height: 8px; background: white; }
    .cursor-circle { 
        width: 60px; height: 60px; border: 1px solid rgba(255, 255, 255, 0.2); 
        transition: width 0.3s, height 0.3s, background-color 0.3s;
    }
    body:hover .cursor-circle { width: 40px; height: 40px; } 

    /* Ambient Effects */
    .noise-wrapper {
        position: fixed; inset: 0; pointer-events: none; z-index: 50; opacity: 0.05;
        background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
    }

    /* Scroll Progress */
    .scroll-line { position: fixed; right: 40px; top: 50%; transform: translateY(-50%); height: 200px; width: 1px; background: rgba(255,255,255,0.1); z-index: 40; }
    .scroll-fill { width: 100%; background: var(--c-gold); height: 0%; transition: height 0.1s; box-shadow: 0 0 10px var(--c-gold); }

    /* Animations */
    .mask-reveal {
        clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
        transition: clip-path 1.5s cubic-bezier(0.77, 0, 0.175, 1);
    }
    .mask-reveal.active { clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%); }

    .text-reveal-line { overflow: hidden; display: block; }
    .text-reveal-line span { display: block; transform: translateY(100%); transition: transform 1.2s cubic-bezier(0.19, 1, 0.22, 1); }
    .active .text-reveal-line span { transform: translateY(0); }

    .fade-up { opacity: 0; transform: translateY(30px); transition: all 1s ease-out; }
    .fade-up.visible { opacity: 1; transform: translateY(0); }

    /* Component Styles */
    .glow-card {
        background: rgba(255,255,255,0.02); 
        backdrop-filter: blur(10px); 
        border: 1px solid rgba(255,255,255,0.05);
        transition: all 0.5s;
    }
    .glow-card:hover { 
        border-color: var(--c-gold); 
        box-shadow: 0 0 30px rgba(197, 160, 89, 0.1); 
        transform: translateY(-10px); 
    }
</style>

<div class="noise-wrapper"></div>
<div class="scroll-line hidden md:block"><div class="scroll-fill"></div></div>

<div class="bg-[#020202] text-[#f0f0f0] min-h-screen font-sans-display overflow-x-hidden selection:bg-[#C5A059] selection:text-black">

    <!-- HERO SECTION -->
    <section class="h-screen relative flex items-center justify-center overflow-hidden" data-cursor="-exclusion">
        <div class="absolute inset-0 z-0">
            <!-- Using a cinematic car video -->
            <video autoplay loop muted playsinline class="w-full h-full object-cover opacity-40 grayscale scale-105 parallax-bg">
                <source src="https://videos.pexels.com/video-files/3206132/3206132-uhd_2560_1440_25fps.mp4" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-gradient-to-t from-[#020202] via-transparent to-[#020202]"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-[#020202]/80 via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 text-center mix-blend-mode-difference px-4">
            <div class="overflow-hidden mb-8">
                <p class="font-future text-xs md:text-sm tracking-[0.5em] text-[#C5A059] hero-anim translate-y-full">Established 1910</p>
            </div>
            <h1 class="font-serif-display text-7xl md:text-[10rem] lg:text-[13rem] leading-[0.85] uppercase tracking-tight mb-8">
                <div class="text-reveal-line"><span>The Legacy</span></div>
                <div class="text-reveal-line"><span class="italic text-[#C5A059]">Of Thiuu</span></div>
            </h1>
            <div class="max-w-2xl mx-auto overflow-hidden">
                <p class="text-white/80 text-lg md:text-2xl font-light hero-anim translate-y-full delay-100 font-sans-display">
                    "Chúng tôi không cho thuê xe. Chúng tôi trao cho bạn quyền năng chinh phục những con đường."
                </p>
            </div>
        </div>
        
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2">
            <div class="w-[1px] h-20 bg-gradient-to-b from-transparent via-[#C5A059] to-transparent animate-pulse"></div>
        </div>
    </section>

    <!-- CONTENT WRAPPER -->
    <div class="relative py-32 md:py-40 border-t border-white/5">
        <div class="container mx-auto px-6 max-w-7xl">
            
            <!-- CHAPTER 1 -->
            <div class="flex flex-col md:flex-row items-center gap-16 md:gap-32 mb-40 md:mb-60 scroll-section">
                <div class="md:w-1/2 relative group">
                    <span class="absolute -left-10 -top-20 md:-left-24 md:-top-32 text-[8rem] md:text-[18rem] font-serif-display text-white/5 select-none z-0 transition-transform duration-1000 group-hover:translate-x-10">01</span>
                    <div class="relative z-10 mask-reveal w-full aspect-[3/4] md:aspect-[4/5] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1000" class="w-full h-full object-cover grayscale sepia-[0.3] hover:scale-105 transition-transform duration-[2s]">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                </div>
                <div class="md:w-1/2 pl-0 md:pl-10 text-reveal-trigger">
                    <span class="text-[#C5A059] font-future text-xs mb-4 block tracking-widest">Chapter I — The Origin</span>
                    <h2 class="text-5xl md:text-7xl font-serif-display mb-8 leading-tight">1910 <br><span class="text-white/30 italic text-4xl md:text-5xl">Khởi Nguyên</span></h2>
                    <p class="text-zinc-400 text-lg leading-relaxed mb-8 font-light">
                        Giữa lòng Sài Gòn hoa lệ đầu thế kỷ 20, cụ cố Khanh Thiuu đã đặt nền móng cho đế chế vận tải hạng sang đầu tiên. 
                        <br><br>
                        Không chỉ là những cỗ xe, đó là lời khẳng định về vị thế. Với triết lý <strong class="text-white">"Sự sang trọng thầm lặng"</strong>, Thiuu Transport nhanh chóng trở thành lựa chọn độc tôn của giới thượng lưu Đông Dương.
                    </p>
                    <div class="w-24 h-[1px] bg-[#C5A059]"></div>
                </div>
            </div>

            <!-- CHAPTER 2 -->
            <div class="flex flex-col md:flex-row-reverse items-center gap-16 md:gap-32 mb-40 md:mb-60 scroll-section">
                <div class="md:w-1/2 relative group">
                    <span class="absolute -right-10 -top-20 md:-right-24 md:-top-32 text-[8rem] md:text-[18rem] font-serif-display text-white/5 select-none z-0 transition-transform duration-1000 group-hover:-translate-x-10">02</span>
                    <div class="relative z-10 mask-reveal w-full aspect-[3/4] md:aspect-[4/5] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1566008885218-90abf9200ddb?q=80&w=1000" class="w-full h-full object-cover grayscale contrast-125 hover:scale-105 transition-transform duration-[2s]">
                    </div>
                </div>
                <div class="md:w-1/2 pr-0 md:pr-10 text-reveal-trigger">
                    <span class="text-[#C5A059] font-future text-xs mb-4 block tracking-widest">Chapter II — The Golden Era</span>
                    <h2 class="text-5xl md:text-7xl font-serif-display mb-8 leading-tight">1980 <br><span class="text-white/30 italic text-4xl md:text-5xl">Kỷ Nguyên Vàng</span></h2>
                    <p class="text-zinc-400 text-lg leading-relaxed mb-8 font-light">
                        Khi những chiếc Rolls-Royce Silver Spirit đầu tiên cập bến, Thiuu Rental đã định nghĩa lại khái niệm di chuyển xa xỉ. 
                        <br><br>
                        Chúng tôi không chỉ cung cấp phương tiện, chúng tôi kiến tạo những khoảnh khắc trường tồn. Mỗi hành trình cùng Thiuu là một màn trình diễn nghệ thuật của sự quyền uy và đẳng cấp.
                    </p>
                    <div class="w-24 h-[1px] bg-[#C5A059]"></div>
                </div>
            </div>

            <!-- CHAPTER 3 -->
            <div class="flex flex-col md:flex-row items-center gap-16 md:gap-32 scroll-section">
                <div class="md:w-1/2 relative">
                    <span class="absolute -left-10 -top-20 md:-left-24 md:-top-32 text-[8rem] md:text-[18rem] font-serif-display text-white/5 select-none z-0">03</span>
                    <div class="relative z-10 mask-reveal w-full aspect-video overflow-hidden border border-white/10 rounded-sm">
                        <img src="https://images.unsplash.com/photo-1621528405020-f574d7501a30?q=80&w=1200" class="w-full h-full object-cover hover:scale-105 transition-transform duration-[2s]">
                        
                        <!-- HUD Overlay UI -->
                        <div class="absolute inset-0 border border-white/5 m-4 pointer-events-none">
                            <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-[#C5A059]"></div>
                            <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-[#C5A059]"></div>
                            <div class="absolute bottom-6 left-6 flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                <span class="font-future text-[10px] text-[#C5A059] tracking-widest">System Active // v4.0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 pl-0 md:pl-10 text-reveal-trigger">
                    <span class="text-[#C5A059] font-future text-xs mb-4 block tracking-widest">Chapter III — Digital Future</span>
                    <h2 class="text-5xl md:text-7xl font-serif-display mb-8 leading-tight">2026 <br><span class="text-white/30 italic text-4xl md:text-5xl">Đế Chế Số</span></h2>
                    <p class="text-zinc-400 text-lg leading-relaxed mb-8 font-light">
                        Tiếp nối di sản, tôi - thế hệ thứ tư - đã mã hóa tinh hoa gia tộc vào từng dòng lệnh.
                        <strong class="text-white">Thiuu Elite</strong> ra đời - nền tảng cho phép bạn kiểm soát hạm đội 500 siêu xe chỉ với một cú chạm.
                        <br><br>
                        Tốc độ của công nghệ kết hợp với phẩm chất phục vụ quý tộc. Đó là tương lai chúng tôi hướng đến.
                    </p>
                    <div class="grid grid-cols-3 gap-8 mt-12 border-t border-white/10 pt-8">
                        <div><span class="text-3xl md:text-4xl font-serif-display text-white block">500+</span><span class="text-[10px] text-zinc-500 uppercase tracking-widest">Supercars</span></div>
                        <div><span class="text-3xl md:text-4xl font-serif-display text-white block">24/7</span><span class="text-[10px] text-zinc-500 uppercase tracking-widest">Support</span></div>
                        <div><span class="text-3xl md:text-4xl font-serif-display text-white block">Global</span><span class="text-[10px] text-zinc-500 uppercase tracking-widest">Coverage</span></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- CORE VALUES -->
    <section class="py-32 bg-[#050505] relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-[#C5A059]/5 rounded-full blur-[120px] pointer-events-none"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-24">
                <span class="text-[#C5A059] font-future text-xs tracking-[0.3em] uppercase block mb-4">Our Philosophy</span>
                <h2 class="font-serif-display text-5xl md:text-6xl text-white">The <span class="italic text-zinc-600">Thiuu Standard</span></h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Card 1 --}}
                <div class="glow-card p-10 md:p-12 rounded-sm relative group">
                    <div class="text-4xl text-[#C5A059] mb-8"><i class="fa-solid fa-infinity"></i></div>
                    <h3 class="text-2xl font-future text-white mb-6 group-hover:text-[#C5A059] transition-colors">Omotenashi</h3>
                    <p class="text-zinc-400 font-light leading-relaxed">
                        Nghệ thuật hiếu khách tận tâm của Nhật Bản. Chúng tôi thấu hiểu và đáp ứng nhu cầu của bạn ngay cả khi bạn chưa kịp nói ra. Một sự phục vụ vô hình nhưng toàn diện.
                    </p>
                </div>

                {{-- Card 2 --}}
                <div class="glow-card p-10 md:p-12 rounded-sm relative group border-[#C5A059]/20">
                    <div class="text-4xl text-[#C5A059] mb-8"><i class="fa-regular fa-gem"></i></div>
                    <h3 class="text-2xl font-future text-white mb-6 group-hover:text-[#C5A059] transition-colors">Bespoke</h3>
                    <p class="text-zinc-400 font-light leading-relaxed">
                        Không có hai hành trình nào giống nhau. Từ mùi hương nội thất, playlist nhạc đến lộ trình di chuyển - mọi thứ đều được may đo độc bản cho riêng bạn.
                    </p>
                </div>

                {{-- Card 3 --}}
                <div class="glow-card p-10 md:p-12 rounded-sm relative group">
                    <div class="text-4xl text-[#C5A059] mb-8"><i class="fa-solid fa-shield-halved"></i></div>
                    <h3 class="text-2xl font-future text-white mb-6 group-hover:text-[#C5A059] transition-colors">Privacy</h3>
                    <p class="text-zinc-400 font-light leading-relaxed">
                        Sự riêng tư của bạn là thánh địa bất khả xâm phạm. Dữ liệu được mã hóa, tài xế ký cam kết bảo mật trọn đời. Những gì xảy ra trên xe, vĩnh viễn ở lại trên xe.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER CTA -->
    <section class="min-h-screen relative flex items-center justify-center bg-black overflow-hidden perspective-1000">
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[40vw] h-[40vw] bg-[#C5A059] rounded-full blur-[200px] opacity-10 animate-pulse"></div>

        <div class="relative z-10 text-center w-full px-4">
            <p class="font-future text-zinc-500 text-xs mb-12 tracking-widest fade-up trigger-cta">Experience the Extraordinary</p>
            
            <div class="card-3d-wrapper perspective-1000 inline-block fade-up trigger-cta user-select-none">
                <a href="{{ route('vehicles.index') }}" class="card-3d block relative w-[320px] md:w-[400px] h-[500px] md:h-[600px] bg-[#0f0f0f] border border-[#C5A059]/20 rounded-xl overflow-hidden group cursor-none">
                    
                    <!-- Card Content -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-12 z-20">
                        <div class="w-20 h-20 mb-10 opacity-80 group-hover:scale-110 transition-transform duration-700">
                            <!-- SVG Crown Icon -->
                            <svg viewBox="0 0 100 100" fill="none" class="w-full h-full stroke-[#C5A059] stroke-[1.5]">
                                <path d="M50 20L20 40L30 80H70L80 40L50 20Z" />
                                <circle cx="50" cy="20" r="3" fill="#C5A059"/>
                                <circle cx="20" cy="40" r="3" fill="#C5A059"/>
                                <circle cx="80" cy="40" r="3" fill="#C5A059"/>
                            </svg>
                        </div>

                        <h3 class="font-serif-display text-5xl text-white mb-4 group-hover:text-[#C5A059] transition-colors duration-500">Thiuu Elite</h3>
                        <p class="text-zinc-500 text-xs uppercase tracking-[0.4em] mb-12">Membership Invitation</p>
                        
                        <div class="w-24 h-px bg-[#C5A059] group-hover:w-full transition-all duration-700 opacity-50"></div>
                        
                        <div class="mt-auto">
                            <p class="font-sans-display text-white text-sm tracking-widest uppercase group-hover:text-[#C5A059] transition-colors">Enter The Garage</p>
                        </div>
                    </div>

                    <!-- Shine Effect -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-transparent translate-x-[-150%] group-hover:translate-x-[150%] transition-transform duration-1000 z-30"></div>
                    
                    <!-- Texture -->
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/leather.png')] opacity-20 z-0"></div>
                </a>
            </div>

            <p class="mt-16 font-serif-display italic text-zinc-600 text-lg fade-up trigger-cta">"Luxury is a state of mind."</p>
        </div>
    </section>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.29/bundled/lenis.min.js"></script>

<script>
    // Smooth Scroll
    const lenis = new Lenis({ duration: 1.5, easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), smoothWheel: true });
    function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
    requestAnimationFrame(raf);

    gsap.registerPlugin(ScrollTrigger);

    // Initial Load Animations
    const tl = gsap.timeline();
    
    gsap.utils.toArray('.text-reveal-line span').forEach((span, i) => {
        tl.to(span, { y: 0, opacity: 1, duration: 1.2, ease: "power4.out" }, i * 0.1);
    });
    
    tl.to('.hero-anim', { y: 0, opacity: 1, duration: 1.2, ease: "power4.out", stagger: 0.1 }, "-=0.8");

    // Scroll Progress
    window.addEventListener('scroll', () => {
        const scrollPercent = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
        document.querySelector('.scroll-fill').style.height = scrollPercent + '%';
    });

    // Scroll Reveals
    const revealSections = document.querySelectorAll('.scroll-section');
    revealSections.forEach(section => {
        ScrollTrigger.create({
            trigger: section,
            start: "top 75%",
            onEnter: () => section.querySelector('.mask-reveal').classList.add('active')
        });

        gsap.fromTo(section.querySelector('.text-reveal-trigger'), 
            { y: 50, opacity: 0 },
            { y: 0, opacity: 1, duration: 1.5, ease: "power3.out", scrollTrigger: { trigger: section, start: "top 70%" } }
        );
    });

    // Fade Up Elements
    const fadeElements = document.querySelectorAll('.fade-up');
    fadeElements.forEach(el => {
        ScrollTrigger.create({
            trigger: el,
            start: "top 85%",
            onEnter: () => el.classList.add('visible')
        });
    });

    // 3D Card Hover Effect
    const card = document.querySelector('.card-3d');
    if(card) {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = ((y - centerY) / centerY) * -8; 
            const rotateY = ((x - centerX) / centerX) * 8;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
        });
    }
</script>
@endsection