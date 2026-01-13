@extends('layouts.app')

@section('content')

<div class="bg-gray-50 dark:bg-[#050505] min-h-screen py-10 transition-colors duration-500 font-sans relative overflow-x-hidden">
    
    {{-- Ambient Glow --}}
    <div class="fixed top-0 left-0 w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-0 right-0 w-[500px] h-[500px] bg-yellow-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="container mx-auto px-4 max-w-7xl relative z-10">
        
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 mb-8 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 animate-fade-in-up">
            <a href="{{ route('home') }}" class="hover:text-yellow-500 transition-colors"><i class="fa-solid fa-house"></i></a>
            <span class="text-gray-300 dark:text-gray-700">/</span>
            <a href="{{ route('vehicles.index') }}" class="hover:text-yellow-500 transition-colors">Danh sách xe</a>
            <span class="text-gray-300 dark:text-gray-700">/</span>
            <span class="text-gray-900 dark:text-white luxury-text">{{ $vehicle->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            {{-- Left Column: Images & Details --}}
            <div class="lg:col-span-8 space-y-10 animate-fade-in-up" style="animation-delay: 0.1s;">
                
                {{-- Main Image Area --}}
                <div class="group relative rounded-[2.5rem] overflow-hidden shadow-2xl dark:shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-white/50 dark:border-white/5 bg-gray-100 dark:bg-[#111]">
                    
                    <div class="aspect-w-16 aspect-h-10 overflow-hidden relative">
                        <img src="{{ str_starts_with($vehicle->image, 'http') ? $vehicle->image : asset('storage/' . $vehicle->image) }}" 
                             class="w-full h-full object-cover transform group-hover:scale-105 transition duration-[2s] ease-in-out"
                             onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1200'">
                        
                        {{-- Overlay Gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60"></div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="absolute top-6 right-6">
                        @if($vehicle->status == 'available')
                            <div class="backdrop-blur-md bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Sẵn sàng
                            </div>
                        @else
                            <div class="backdrop-blur-md bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span> Đã được thuê
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Specs Grid --}}
                <div>
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest mb-6 flex items-center gap-3">
                        <span class="w-8 h-0.5 bg-yellow-500"></span> Thông số kỹ thuật
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        
                        <x-ui.card variant="glass" padding="p-5" class="rounded-3xl flex flex-col items-center text-center group hover:bg-white/5 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500 mb-3 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-chair text-sm"></i>
                            </div>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1">Số chỗ</p>
                            <p class="text-base font-black text-gray-900 dark:text-white">{{ $vehicle->seats ?? '5' }}</p>
                        </x-ui.card>
                        
                        <x-ui.card variant="glass" padding="p-5" class="rounded-3xl flex flex-col items-center text-center group hover:bg-white/5 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-red-500/10 flex items-center justify-center text-red-500 mb-3 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-gas-pump text-sm"></i>
                            </div>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nhiên liệu</p>
                            <p class="text-base font-black text-gray-900 dark:text-white">{{ $vehicle->fuel ?? 'Xăng' }}</p>
                        </x-ui.card>
                        
                        <x-ui.card variant="glass" padding="p-5" class="rounded-3xl flex flex-col items-center text-center group hover:bg-white/5 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-purple-500/10 flex items-center justify-center text-purple-500 mb-3 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-gears text-sm"></i>
                            </div>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1">Hộp số</p>
                            <p class="text-base font-black text-gray-900 dark:text-white">Tự động</p>
                        </x-ui.card>
                        
                        <x-ui.card variant="glass" padding="p-5" class="rounded-3xl flex flex-col items-center text-center group hover:bg-white/5 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-teal-500/10 flex items-center justify-center text-teal-500 mb-3 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-snowflake text-sm"></i>
                            </div>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tiện nghi</p>
                            <p class="text-base font-black text-gray-900 dark:text-white">Full</p>
                        </x-ui.card>
                    </div>
                </div>

                {{-- Description --}}
                <x-ui.card variant="glass" padding="p-8" class="rounded-[2rem]">
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest mb-4 flex items-center gap-3">
                        <span class="w-8 h-0.5 bg-yellow-500"></span> Mô tả chi tiết
                    </h3>
                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 text-sm leading-8 font-medium">
                        {!! nl2br(e($vehicle->description ?? 'Đang cập nhật mô tả cho dòng xe này...')) !!}
                    </div>
                </x-ui.card>

                {{-- Reviews --}}
                <x-ui.card id="reviews" variant="glass" padding="p-8" class="rounded-[2rem]">
                     <div class="flex items-center justify-between mb-8 pb-8 border-b border-gray-100 dark:border-white/5">
                        <div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white">Đánh giá khách hàng</h3>
                            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider font-bold">Xác thực bởi Thiuu System</p>
                        </div>
                        <div class="text-center bg-gray-50 dark:bg-white/5 px-6 py-3 rounded-2xl border border-gray-100 dark:border-white/5">
                            <div class="text-3xl font-black text-yellow-500 flex items-center justify-center gap-1">
                                {{ number_format($vehicle->average_rating ?? 5, 1) }} <i class="fa-solid fa-star text-lg"></i>
                            </div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase mt-1">{{ $vehicle->reviews->count() }} lượt đánh giá</div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @forelse($vehicle->reviews as $review)
                            <div class="flex gap-4 group">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center text-gray-600 dark:text-white font-black text-sm shadow-inner">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow bg-gray-50 dark:bg-white/5 p-5 rounded-2xl rounded-tl-none border border-gray-100 dark:border-white/5 group-hover:border-yellow-500/20 transition-all">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-white text-xs uppercase tracking-wide">{{ $review->user->name }}</h4>
                                            <div class="flex text-yellow-400 text-[9px] mt-1 gap-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-gray-300 dark:text-gray-700' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-medium text-gray-400">{{ $review->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm italic">"{{ $review->comment }}"</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 flex flex-col items-center">
                                <div class="w-12 h-12 bg-gray-100 dark:bg-white/5 rounded-full flex items-center justify-center text-gray-300 mb-3 animate-float">
                                    <i class="fa-regular fa-comment text-xl"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Chưa có đánh giá nào.</p>
                            </div>
                        @endforelse
                    </div>
                </x-ui.card>

            </div>

            {{-- Right Column: Booking & Info --}}
            <div class="lg:col-span-4 animate-fade-in-up" style="animation-delay: 0.3s;">
                <div class="sticky top-24 space-y-6">
                    
                    {{-- Pricing Card --}}
                    <div class="relative overflow-hidden rounded-[2.5rem] bg-white dark:bg-[#111] border border-gray-100 dark:border-white/10 shadow-2xl dark:shadow-[0_0_60px_rgba(0,0,0,0.4)]">
                        {{-- Background FX --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/10 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>

                        <div class="p-8 relative z-10">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2">{{ $vehicle->brand->name ?? 'LUXURY' }}</p>
                            <h1 class="text-3xl font-black text-gray-900 dark:text-white leading-tight mb-8">{{ $vehicle->name }}</h1>
                            
                            <div class="flex items-end gap-2 mb-8 pb-8 border-b border-gray-100 dark:border-white/5">
                                <span class="text-5xl font-black text-blue-600 dark:text-yellow-500 tracking-tighter">{{ number_format($vehicle->price) }}</span>
                                <div class="flex flex-col mb-1.5">
                                    <span class="text-[10px] font-bold text-blue-600 dark:text-yellow-500">VNĐ</span>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase">/ 24 Giờ</span>
                                </div>
                            </div>

                            {{-- Benefits --}}
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center gap-4 group">
                                    <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-500 text-xs">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 font-bold group-hover:text-green-500 transition-colors">Bảo hiểm toàn diện</span>
                                </div>
                                <div class="flex items-center gap-4 group">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-500 text-xs">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 font-bold group-hover:text-blue-500 transition-colors">Hỗ trợ 24/7</span>
                                </div>
                                <div class="flex items-center gap-4 group">
                                    <div class="w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-500 text-xs">
                                        <i class="fa-solid fa-file-signature"></i>
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 font-bold group-hover:text-purple-500 transition-colors">Thủ tục trong 5 phút</span>
                                </div>
                            </div>

                            {{-- Actions --}}
                            @if($vehicle->status == 'available')
                                <x-ui.button href="{{ route('bookings.create', $vehicle->id) }}" variant="primary" size="lg" :fullWidth="true" class="!py-4 !rounded-2xl shadow-lg">
                                    Đặt Xe Ngay <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </x-ui.button>
                                <p class="text-center text-[9px] text-gray-400 mt-3 font-bold uppercase tracking-wide">Không cần thanh toán trước</p>
                            @else
                                <button disabled class="block w-full py-4 bg-gray-100 dark:bg-white/5 text-gray-400 font-bold text-center rounded-2xl cursor-not-allowed border border-gray-200 dark:border-white/5">
                                    TẠM THỜI HẾT XE
                                </button>
                                <p class="text-center text-[10px] text-red-500 mt-3 font-bold uppercase tracking-wide flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> Vui lòng chọn xe khác
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Support Card --}}
                    <x-ui.card variant="glass" padding="p-6" class="rounded-[2rem] relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl -mr-5 -mt-5"></div>
                        
                        <div class="relative z-10 flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-2xl text-blue-500">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold opacity-60 uppercase mb-1 tracking-widest text-gray-400">Tổng đài hỗ trợ</p>
                                <a href="tel:19008888" class="text-2xl font-black tracking-wider text-gray-900 dark:text-white hover:text-yellow-500 transition">1900 8888</a>
                            </div>
                        </div>
                    </x-ui.card>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection