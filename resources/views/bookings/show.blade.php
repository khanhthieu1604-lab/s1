@extends('layouts.app')

@section('content')
<div class="bg-gray-100 dark:bg-black min-h-screen py-8 font-sans text-sm transition-colors duration-300">
    <div class="container mx-auto px-4 max-w-4xl">
        
        
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('bookings.history') }}" class="flex items-center gap-2 text-gray-500 hover:text-gray-900 dark:hover:text-white font-bold transition">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
            <div class="text-xs font-mono text-gray-400">ID: #{{ $booking->id }}</div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            
            <div class="lg:col-span-1 order-2 lg:order-1">
                <div class="bg-white dark:bg-[#121212] rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 h-full">
                    <h3 class="text-lg font-black text-gray-900 dark:text-white mb-6 uppercase">Trạng thái</h3>
                    
                    <div class="relative pl-4 border-l-2 border-gray-100 dark:border-gray-800 space-y-8">
                        
                        
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-green-500 ring-4 ring-white dark:ring-[#121212]"></div>
                            <p class="text-xs font-bold text-gray-400 uppercase">1. Đặt xe</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">Đã gửi yêu cầu</p>
                            <p class="text-[10px] text-gray-400">{{ $booking->created_at->format('H:i d/m/Y') }}</p>
                        </div>

                        
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full {{ $booking->status != 'pending' ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-700' }} ring-4 ring-white dark:ring-[#121212]"></div>
                            <p class="text-xs font-bold text-gray-400 uppercase">2. Thanh toán cọc</p>
                            @if($booking->status == 'pending')
                                <p class="text-sm font-bold text-yellow-600 dark:text-yellow-500 mt-1">Đang chờ thanh toán</p>
                                <a href="{{ route('payment.create', $booking->id) }}" class="inline-block mt-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-400 text-black text-xs font-bold rounded shadow-sm">
                                    Thanh toán ngay
                                </a>
                            @else
                                <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">Đã xác nhận</p>
                            @endif
                        </div>

                        
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full {{ ($booking->status == 'completed') ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-700' }} ring-4 ring-white dark:ring-[#121212]"></div>
                            <p class="text-xs font-bold text-gray-400 uppercase">3. Nhận xe & Vi vu</p>
                            <p class="text-sm text-gray-500 mt-1">Mang theo bằng lái xe</p>
                        </div>

                        
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full {{ $booking->status == 'completed' ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-700' }} ring-4 ring-white dark:ring-[#121212]"></div>
                            <p class="text-xs font-bold text-gray-400 uppercase">4. Trả xe</p>
                            <p class="text-sm text-gray-500 mt-1">Kết thúc chuyến đi</p>
                        </div>
                    </div>

                    @if($booking->status == 'pending')
                        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
                            <button onclick="alert('Tính năng đang phát triển!')" class="w-full py-3 border border-red-200 text-red-600 dark:border-red-900/50 dark:text-red-500 rounded-xl text-xs font-bold hover:bg-red-50 dark:hover:bg-red-900/10 transition">
                                <i class="fa-solid fa-ban mr-1"></i> Hủy chuyến đi này
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            
            <div class="lg:col-span-2 order-1 lg:order-2">
                
                
                <div class="bg-white dark:bg-[#1a1a1a] rounded-[2rem] shadow-2xl overflow-hidden relative border border-gray-200 dark:border-gray-800">
                    
                    
                    <div class="h-48 relative">
                        <img src="{{ str_starts_with($booking->vehicle->image, 'http') ? $booking->vehicle->image : asset('storage/' . $booking->vehicle->image) }}" 
                             class="h-full w-full object-cover"
                             onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=400'"> 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a1a] via-transparent to-transparent"></div>
                        
                        <div class="absolute bottom-4 left-6 text-white">
                            <p class="text-xs font-bold opacity-80 uppercase tracking-widest">{{ $booking->vehicle->brand->name ?? 'BRAND' }}</p>
                            <h2 class="text-3xl font-black italic">{{ $booking->vehicle->name }}</h2>
                        </div>
                        
                        <div class="absolute top-4 right-4 bg-white/10 backdrop-blur-md border border-white/20 text-white px-3 py-1 rounded-full text-xs font-bold">
                            {{ $booking->vehicle->license_plate ?? '51H-999.99' }}
                        </div>
                    </div>

                    
                    <div class="p-8">
                        <div class="flex flex-col md:flex-row gap-8">
                            
                            
                            <div class="flex-grow space-y-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-[10px] uppercase text-gray-400 font-bold mb-1">Người đặt</p>
                                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $booking->user->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] uppercase text-gray-400 font-bold mb-1">Tổng tiền</p>
                                        <p class="text-base font-black text-blue-600 dark:text-yellow-500">{{ number_format($booking->total_price) }}đ</p>
                                    </div>
                                </div>

                                <div class="p-4 bg-gray-50 dark:bg-[#121212] rounded-xl border border-gray-100 dark:border-gray-800 flex items-center justify-between">
                                    <div>
                                        <p class="text-[10px] uppercase text-gray-400 font-bold">Nhận xe</p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->start_date)->format('H:i - d/m') }}</p>
                                    </div>
                                    <div class="text-gray-300 dark:text-gray-600"><i class="fa-solid fa-arrow-right"></i></div>
                                    <div class="text-right">
                                        <p class="text-[10px] uppercase text-gray-400 font-bold">Trả xe</p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->end_date)->format('H:i - d/m') }}</p>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="flex-shrink-0 flex flex-col items-center justify-center border-l border-dashed border-gray-200 dark:border-gray-700 pl-0 md:pl-8 pt-6 md:pt-0 border-t md:border-t-0 mt-6 md:mt-0">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-2 tracking-wide text-center">Quét nhận xe</p>
                                <div class="bg-white p-2 rounded-lg">
                                    
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=BOOKING-{{ $booking->id }}" class="w-24 h-24 mix-blend-multiply">
                                </div>
                                <p class="text-[10px] font-mono text-gray-400 mt-2">#{{ $booking->id }}</p>
                            </div>

                        </div>
                    </div>

                    
                    <div class="h-4 bg-gray-100 dark:bg-black relative -mt-2">
                        <div class="absolute top-0 w-full h-full bg-[radial-gradient(circle_at_10px_0,transparent_6px,currentColor_7px)] text-white dark:text-[#1a1a1a] bg-repeat-x bg-[length:20px_20px]"></div>
                    </div>

                    
                    <div class="p-6 bg-gray-50 dark:bg-[#222] flex justify-between items-center">
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            <i class="fa-solid fa-circle-info mr-1"></i> Cần hỗ trợ? Gọi <a href="tel:19001000" class="font-bold underline hover:text-blue-500">1900 1000</a>
                        </div>
                        
                        @if($booking->status == 'confirmed')
                            <a href="{{ route('bookings.contract', $booking->id) }}" target="_blank" class="px-4 py-2 bg-black dark:bg-white text-white dark:text-black font-bold text-xs rounded-lg shadow hover:opacity-80 transition flex items-center gap-2">
                                <i class="fa-solid fa-file-contract"></i> Hợp đồng
                            </a>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection