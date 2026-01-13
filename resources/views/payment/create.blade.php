@extends('layouts.app')

@section('content')
<div class="bg-gray-50 dark:bg-[#050505] min-h-screen pb-20 transition-colors duration-300 font-sans text-sm">
    
    
    <div class="bg-white dark:bg-[#121212] border-b border-gray-200 dark:border-gray-800 sticky top-0 z-30 shadow-sm">
        <div class="container mx-auto px-4 max-w-5xl h-16 flex items-center justify-between">
            <div class="font-black text-lg text-gray-900 dark:text-white uppercase tracking-wider">Thiuu<span class="text-yellow-500">Pay</span></div>
            
            <div class="hidden md:flex items-center gap-4">
                <div class="flex items-center gap-2 text-green-500">
                    <i class="fa-solid fa-circle-check"></i> <span class="text-xs font-bold">Chọn xe</span>
                </div>
                <div class="w-8 h-[1px] bg-green-500"></div>
                <div class="flex items-center gap-2 text-green-500">
                    <i class="fa-solid fa-circle-check"></i> <span class="text-xs font-bold">Đặt chỗ</span>
                </div>
                <div class="w-8 h-[1px] bg-gray-300 dark:bg-gray-700"></div>
                <div class="flex items-center gap-2 text-blue-600 dark:text-yellow-500">
                    <span class="w-6 h-6 rounded-full bg-blue-600 dark:bg-yellow-500 text-white dark:text-black flex items-center justify-center text-[10px] font-bold">3</span>
                    <span class="text-xs font-bold">Thanh toán</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-5xl mt-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            
            <div class="space-y-6">
                <div class="bg-white dark:bg-[#121212] p-8 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-800 text-center relative overflow-hidden">
                    
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
                    
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-2">Quét Mã Thanh Toán</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-xs mb-8">Sử dụng ứng dụng ngân hàng hoặc ví điện tử (Momo, ZaloPay)</p>

                    <div class="inline-block p-4 bg-white rounded-2xl border-2 border-dashed border-gray-200 shadow-inner">
                        
                        
                        <img src="https://img.vietqr.io/image/MB-0909123456-compact2.png?amount={{ $booking->total_price }}&addInfo=THUE XE {{ $booking->id }}&accountName=THIUU RENTAL" 
                             alt="QR Code Payment" 
                             class="w-56 h-56 object-contain">
                    </div>

                    <div class="mt-8 space-y-3">
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-[#1a1a1a] p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                            <span class="text-xs text-gray-500 uppercase font-bold">Số tiền</span>
                            <span class="text-xl font-black text-blue-600 dark:text-yellow-500">{{ number_format($booking->total_price) }}đ</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-[#1a1a1a] p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                            <span class="text-xs text-gray-500 uppercase font-bold">Nội dung</span>
                            <span class="font-bold text-gray-900 dark:text-white select-all">THUE XE {{ $booking->id }}</span>
                        </div>
                    </div>

                    <form action="{{ route('payment.confirm', $booking->id) }}" method="POST" class="mt-8">
                        @csrf
                        <button type="submit" class="w-full py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/30 transition transform hover:scale-[1.02] flex items-center justify-center gap-2">
                            <i class="fa-solid fa-check-circle"></i>
                            <span>TÔI ĐÃ CHUYỂN KHOẢN</span>
                        </button>
                        <p class="text-[10px] text-gray-400 mt-3">Hệ thống sẽ tự động kích hoạt đơn hàng sau khi xác nhận.</p>
                    </form>
                </div>
            </div>

            
            <div class="space-y-6">
                <div class="bg-white dark:bg-[#121212] p-8 rounded-[2rem] shadow-lg border border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
                        Chi tiết đơn hàng <span class="text-blue-500">#{{ $booking->id }}</span>
                    </h3>

                    
                    <div class="flex gap-4 mb-6">
                        <img src="{{ str_starts_with($booking->vehicle->image, 'http') ? $booking->vehicle->image : asset('storage/' . $booking->vehicle->image) }}" 
                             class="w-24 h-24 object-cover rounded-xl bg-gray-100 dark:bg-gray-800"
                             onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=200'">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase">{{ $booking->vehicle->brand->name ?? 'Xe' }}</p>
                            <h4 class="text-xl font-black text-gray-900 dark:text-white mb-1">{{ $booking->vehicle->name }}</h4>
                            <span class="inline-block px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-500 text-[10px] font-bold rounded">
                                {{ $booking->vehicle->type }}
                            </span>
                        </div>
                    </div>

                    
                    <div class="relative pl-4 border-l-2 border-dashed border-gray-200 dark:border-gray-700 space-y-6 my-8">
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1 w-3 h-3 bg-blue-500 rounded-full border-2 border-white dark:border-black"></div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Nhận xe</p>
                            <p class="font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->start_date)->format('H:i - d/m/Y') }}</p>
                        </div>
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white dark:border-black"></div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Trả xe</p>
                            <p class="font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->end_date)->format('H:i - d/m/Y') }}</p>
                        </div>
                    </div>

                    
                    @if($booking->note)
                        <div class="p-4 bg-gray-50 dark:bg-[#1a1a1a] rounded-xl border border-gray-100 dark:border-gray-800">
                            <p class="text-xs text-gray-500 italic">"{{ $booking->note }}"</p>
                        </div>
                    @endif
                </div>

                <div class="text-center">
                    <a href="{{ route('bookings.history') }}" class="text-xs font-bold text-gray-400 hover:text-gray-900 dark:hover:text-white transition border-b border-transparent hover:border-gray-400 pb-0.5">
                        Thanh toán sau (Vào lịch sử đơn hàng)
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection