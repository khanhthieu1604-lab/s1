@extends('layouts.app')

@section('content')
    


    <style>
        :root {
            --gold-primary: #f59e0b;
            --black-deep: #050505;
        }

        .luxury-text {
            letter-spacing: -0.05em;
            line-height: 0.85;
            font-family: 'Inter', sans-serif;
            will-change: transform, opacity; 
        }

        
        .trailer-text {
            color: transparent;
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.15);
            transition: -webkit-text-stroke 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gold-fill-text {
            background: linear-gradient(to bottom, #fff 30%, var(--gold-primary) 60%, #78350f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 15px rgba(245, 158, 11, 0.3));
        }

        
        #transition-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: var(--gold-primary);
            z-index: 10000;
            transform: translateX(-100%);
            pointer-events: none;
            will-change: transform;
        }

        
        .btn-trailer {
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-trailer:hover {
            background: #fff !important;
            color: #000 !important;
            box-shadow: 0 0 40px rgba(245, 158, 11, 0.5);
            transform: scale(1.05) translateY(-2px);
        }

        header, footer { display: none !important; }

        
        video, h1, span {
            -webkit-font-smoothing: antialiased;
            backface-visibility: hidden;
        }
    </style>

    <div id="transition-overlay"></div>

    <div class="bg-black min-h-screen overflow-hidden relative" id="main-wrapper">

        
        <section class="relative h-screen flex items-center justify-center overflow-hidden">

            
            <video autoplay muted loop playsinline id="trailer-video" 
                   class="absolute inset-0 w-full h-full object-cover z-0 transition-opacity duration-1000 opacity-0">
                <source src="{{ asset('videos/trailer.mp4') }}" type="video/mp4">
            </video>
            
            
            <div class="absolute inset-0 bg-gradient-to-b from-black via-black/20 to-black z-10"></div>
            <div class="absolute inset-0 shadow-[inset_0_0_200px_rgba(0,0,0,0.9)] z-10"></div>
            
            <div class="relative z-20 text-center px-8 w-full max-w-7xl mx-auto">
                
                <div class="overflow-hidden mb-8">
                    <span class="block text-amber-500 font-black uppercase text-xs md:text-sm tracking-[1em] opacity-0 translate-y-full" id="seq-1">
                        Unleash The Pure Power
                    </span>
                </div>

                
                <h1 class="luxury-text text-[15vw] md:text-[12vw] font-black leading-none mb-12 flex flex-col items-center">
                    <span class="trailer-text opacity-0" id="seq-2-a">THE</span>
                    <span class="gold-fill-text opacity-0" id="seq-2-b">ELITE</span>
                </h1>

                
                <div class="overflow-hidden mb-16">
                    <p class="text-gray-400 md:text-xl font-light tracking-widest opacity-0" id="seq-3">
                        HÀNH TRÌNH KHÔNG <span class="text-white border-b border-amber-500/50">GIỚI HẠN</span>
                    </p>
                </div>
                
                
                <div class="opacity-0 scale-90" id="seq-4">
                    <div class="magnetic-wrap inline-block">
                        <a href="{{ route('home') }}" 
                           class="btn-trailer group flex items-center gap-8 px-16 py-6 bg-white/5 text-white uppercase text-[10px] font-bold tracking-[0.5em] rounded-full">
                            Explore Experience
                            <i class="fa-solid fa-arrow-right-long group-hover:translate-x-4 transition-transform duration-500"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            
            <div class="absolute bottom-10 left-0 w-full overflow-hidden pointer-events-none opacity-[0.04] z-0">
                <h2 class="text-[250px] font-black luxury-text whitespace-nowrap italic text-white" id="bg-scrolling-text">
                    THIUU RENTAL • LUXURY PERFORMANCE • ELITE DRIVING •
                </h2>
            </div>
        </section>
    </div>

    <script>
        
        function navigateToWelcome() {
            const overlay = document.getElementById('transition-overlay');
            
            
            document.body.style.pointerEvents = 'none';

            if (window.anime) {
                anime.timeline({
                    easing: 'easeInOutQuart'
                })
                .add({
                    targets: overlay,
                    translateX: ['-100%', '0%'],
                    duration: 600 
                })
                .add({
                    targets: '#main-wrapper',
                    scale: 1.1,
                    filter: 'blur(10px)',
                    opacity: 0,
                    duration: 600,
                    offset: '-=600',
                    complete: () => {
                        window.location.href = "{{ route('home') }}";
                    }
                });
            } else {
                window.location.href = "{{ route('home') }}";
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
             // FAILSAFE: Ensure elements are visible if animation fails
            setTimeout(() => {
                const hiddenElements = ['#seq-1', '#seq-2-a', '#seq-2-b', '#seq-3', '#seq-4'];
                hiddenElements.forEach(selector => {
                    const el = document.querySelector(selector);
                    if(el) {
                        el.classList.remove('opacity-0');
                        el.style.opacity = '1';
                    }
                });
                document.getElementById('trailer-video').style.opacity = '0.6';
            }, 2000);

            const video = document.getElementById('trailer-video');
            video.oncanplay = () => video.style.opacity = '0.6';

            if (typeof anime !== 'undefined') {
                const tl = anime.timeline({
                    easing: 'easeOutQuart'
                });

                tl.add({
                    targets: '#seq-1',
                    translateY: ['100%', '0%'],
                    opacity: [0, 1],
                    duration: 800,
                    delay: 400
                })
                .add({
                    targets: '#seq-2-a',
                    translateY: [50, 0],
                    opacity: [0, 1],
                    letterSpacing: ['1em', '-0.05em'],
                    duration: 1200,
                    offset: '-=400'
                })
                .add({
                    targets: '#seq-2-b',
                    scale: [1.2, 1],
                    opacity: [0, 1],
                    filter: ['blur(15px)', 'blur(0px)'],
                    duration: 1500,
                    offset: '-=1000'
                })
                .add({
                    targets: '#seq-3',
                    opacity: [0, 1],
                    duration: 800,
                    offset: '-=800'
                })
                .add({
                    targets: '#seq-4',
                    opacity: [0, 1],
                    scale: [0.9, 1],
                    duration: 1000,
                    offset: '-=600'
                });

                
                let mouseX = 0;
                document.addEventListener('mousemove', (e) => {
                    mouseX = (e.clientX / window.innerWidth - 0.5) * 100;
                    anime({
                        targets: '#bg-scrolling-text',
                        translateX: mouseX,
                        duration: 2000,
                        easing: 'easeOutQuad'
                    });
                });

                
                const magnetic = document.querySelector('.magnetic-wrap');
                magnetic.addEventListener('mousemove', (e) => {
                    const rect = magnetic.getBoundingClientRect();
                    const x = (e.clientX - rect.left - rect.width / 2) * 0.4;
                    const y = (e.clientY - rect.top - rect.height / 2) * 0.4;
                    
                    magnetic.style.transform = `translate3d(${x}px, ${y}px, 0)`;
                });
                magnetic.addEventListener('mouseleave', () => {
                    magnetic.style.transform = `translate3d(0, 0, 0)`;
                });
            }
        });
    </script>
@endsection