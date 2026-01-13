@extends('layouts.app')

@section('content')
<div class="bg-gray-50 dark:bg-[#050505] min-h-screen py-10 transition-colors duration-300 font-sans text-sm">
    <div class="container mx-auto px-4 max-w-5xl">
        
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-wide">
                    Lịch sử <span class="text-yellow-500">Chuyến đi</span>
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">Quản lý các đơn đặt xe và trạng thái thanh toán</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('vehicles.index') }}" class="px-4 py-2 bg-black dark:bg-white text-white dark:text-black font-bold text-xs rounded-full shadow hover:opacity-80 transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Đặt xe mới
                </a>
            </div>
        </div>

        
        @if($bookings->count() > 0)
            <div class="space-y-6">
                @foreach($bookings as $booking)
                    <div class="group bg-white dark:bg-[#121212] rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-lg hover:border-yellow-500/30 transition-all duration-300 relative overflow-hidden">
                        
                        
                        <div class="absolute left-0 top-0 bottom-0 w-1 
                            {{ $booking->status == 'pending' ? 'bg-yellow-500' : '' }}
                            {{ $booking->status == 'confirmed' ? 'bg-blue-500' : '' }}
                            {{ $booking->status == 'completed' ? 'bg-green-500' : '' }}
                            {{ $booking->status == 'cancelled' ? 'bg-red-500' : '' }}
                        "></div>

                        <div class="flex flex-col md:flex-row gap-6">
                            
                            
                            <div class="w-full md:w-48 h-32 flex-shrink-0 bg-gray-100 dark:bg-[#1a1a1a] rounded-xl overflow-hidden relative">
                                <img src="{{ str_starts_with($booking->vehicle->image, 'http') ? $booking->vehicle->image : asset('storage/' . $booking->vehicle->image) }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=400'">
                            </div>

                            
                            <div class="flex-grow">
                                <div class="flex flex-col sm:flex-row justify-between items-start mb-2 gap-2">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-[10px] font-bold text-gray-400 bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded">#{{ $booking->id }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">{{ $booking->created_at->diffForHumans() }}</span>
                                        </div>
                                        <h3 class="text-xl font-black text-gray-900 dark:text-white">
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="hover:text-yellow-500 transition">
                                                {{ $booking->vehicle->name }}
                                            </a>
                                        </h3>
                                    </div>
                                    
                                    
                                    @php
                                        $statusConfig = [
                                            'pending'   => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Chờ thanh toán'],
                                            'confirmed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Đã cọc'],
                                            'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Hoàn thành'],
                                            'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Đã hủy'],
                                        ];
                                        $st = $statusConfig[$booking->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $st['bg'] }} {{ $st['text'] }}">
                                        {{ $st['label'] }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-6 my-4 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">{{ \Carbon\Carbon::parse($booking->start_date)->format('H:i d/m') }}</span>
                                    <i class="fa-solid fa-arrow-right text-xs text-gray-300"></i>
                                    <span class="font-bold">{{ \Carbon\Carbon::parse($booking->end_date)->format('H:i d/m') }}</span>
                                </div>
                            </div>

                            
                            <div class="flex flex-col justify-between items-end min-w-[150px] border-l border-dashed border-gray-200 dark:border-gray-800 pl-4">
                                <p class="text-xl font-black text-blue-700 dark:text-yellow-500">{{ number_format($booking->total_price) }}đ</p>

                                <div class="mt-4 w-full flex justify-end">
                                    @if($booking->status == 'pending')
                                        <a href="{{ route('payment.create', $booking->id) }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg shadow-lg flex items-center gap-2">
                                            <i class="fa-solid fa-qrcode"></i> Thanh toán
                                        </a>
                                    @elseif($booking->status == 'confirmed')
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs font-bold rounded hover:bg-gray-200">
                                            Chi tiết
                                        </a>
                                    @elseif($booking->status == 'completed')
                                        @if($booking->review)
                                            <span class="text-xs font-bold text-yellow-500 flex items-center gap-1">
                                                <i class="fa-solid fa-star"></i> Đã đánh giá {{ $booking->review->rating }}*
                                            </span>
                                        @else
                                            
                                            <button onclick="openReviewModal({{ $booking->id }}, '{{ $booking->vehicle->name }}')" 
                                                class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded shadow-lg flex items-center gap-2 animate-bounce-subtle">
                                                <i class="fa-regular fa-star"></i> Đánh giá ngay
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-8">{{ $bookings->links() }}</div>
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-gray-500">Chưa có chuyến đi nào.</p>
                <a href="{{ route('vehicles.index') }}" class="text-blue-600 font-bold underline mt-2 inline-block">Đặt xe ngay</a>
            </div>
        @endif
    </div>

    
    <div id="reviewModal" class="fixed inset-0 z-50 hidden">
        
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="closeReviewModal()"></div>
        
        
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-4">
            <div class="bg-white dark:bg-[#1a1a1a] rounded-2xl shadow-2xl overflow-hidden scale-100 transition-transform">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mx-auto mb-4 text-yellow-500 text-3xl">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white mb-1">Đánh giá chuyến đi</h3>
                    <p class="text-xs text-gray-500 mb-6">Xe: <span id="modalVehicleName" class="font-bold text-gray-800 dark:text-gray-300">...</span></p>

                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" id="modalBookingId">
                        
                        
                        <div class="flex justify-center gap-2 mb-6 flex-row-reverse group">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="peer hidden" required />
                                <label for="star{{ $i }}" class="text-3xl text-gray-300 dark:text-gray-700 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 cursor-pointer transition">
                                    <i class="fa-solid fa-star"></i>
                                </label>
                            @endfor
                        </div>

                        <textarea name="comment" rows="3" placeholder="Chia sẻ trải nghiệm của bạn (xe sạch sẽ, chủ xe thân thiện...)" 
                            class="w-full bg-gray-50 dark:bg-[#121212] border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-sm mb-4 focus:ring-2 focus:ring-yellow-400 outline-none dark:text-white"></textarea>

                        <div class="flex gap-3">
                            <button type="button" onclick="closeReviewModal()" class="flex-1 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 font-bold rounded-xl text-xs hover:bg-gray-200">
                                Bỏ qua
                            </button>
                            <button type="submit" class="flex-1 py-3 bg-yellow-400 hover:bg-yellow-300 text-black font-bold rounded-xl text-xs shadow-lg shadow-yellow-400/20">
                                Gửi đánh giá
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function openReviewModal(bookingId, vehicleName) {
        document.getElementById('modalBookingId').value = bookingId;
        document.getElementById('modalVehicleName').innerText = vehicleName;
        document.getElementById('reviewModal').classList.remove('hidden');
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
    }
</script>
@endsection