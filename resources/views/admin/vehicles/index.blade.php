@extends('layouts.app')

@section('content')
<div class="bg-gray-50 dark:bg-[#0a0a0a] min-h-screen py-10 font-sans transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 animate-fade-in-down">
            <div>
                <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Đội xe Thiuu Rental</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Quản lý đội xe, trạng thái vận hành và bảo trì.</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.vehicles.create') }}" class="group relative px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-black rounded-xl font-bold text-xs uppercase tracking-widest overflow-hidden shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5">
                    <span class="relative z-10 flex items-center gap-2 group-hover:text-blue-400 dark:group-hover:text-yellow-600 transition-colors">
                        <i class="fa-solid fa-plus-circle"></i> Nhập xe mới
                    </span>
                    <div class="absolute inset-0 bg-gray-800 dark:bg-gray-200 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                </a>
            </div>
        </div>

        
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 class="bg-green-500/10 border border-green-500/20 text-green-600 dark:text-green-400 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center gap-2 shadow-sm backdrop-blur-sm animate-bounce-in">
                <i class="fa-solid fa-circle-check text-lg"></i> {{ session('success') }}
            </div>
        @endif

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in-up">
            @foreach($vehicles as $vehicle)
            <div class="group bg-white dark:bg-[#121212] rounded-3xl overflow-hidden shadow-lg shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-white/5 hover:border-blue-500/30 dark:hover:border-yellow-500/30 transition-all duration-300 hover:-translate-y-1 relative">
                
                
                <div class="absolute top-4 right-4 z-10">
                    @if($vehicle->status == 'available')
                        <span class="px-3 py-1 bg-green-500/20 text-green-600 dark:text-green-400 backdrop-blur-md border border-green-500/20 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm">
                            <i class="fa-solid fa-circle-check mr-1"></i> Sẵn sàng
                        </span>
                    @elseif($vehicle->status == 'rented')
                        <span class="px-3 py-1 bg-blue-500/20 text-blue-600 dark:text-blue-400 backdrop-blur-md border border-blue-500/20 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm animate-pulse">
                            <i class="fa-solid fa-road mr-1"></i> Đang thuê
                        </span>
                    @elseif($vehicle->status == 'maintenance')
                        <span class="px-3 py-1 bg-orange-500/20 text-orange-600 dark:text-orange-400 backdrop-blur-md border border-orange-500/20 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm">
                            <i class="fa-solid fa-screwdriver-wrench mr-1"></i> Bảo trì
                        </span>
                    @endif
                </div>

                
                <div class="h-56 overflow-hidden relative">
                    <img src="{{ str_starts_with($vehicle->image, 'http') ? $vehicle->image : asset('storage/' . $vehicle->image) }}" 
                         class="h-10 w-10 rounded-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=100'"> 
                         alt="{{ $vehicle->name }}" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60"></div>
                    
                    
                    <div class="absolute bottom-4 left-4 text-white">
                        <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest">Giá thuê ngày</p>
                        <p class="text-xl font-black text-yellow-400">{{ number_format($vehicle->price) }} <span class="text-xs text-white/70">VNĐ</span></p>
                    </div>
                </div>

                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ $vehicle->brand->name ?? 'Brand' }}</p>
                            <h3 class="text-lg font-black text-gray-900 dark:text-white leading-tight group-hover:text-blue-600 dark:group-hover:text-yellow-500 transition-colors">
                                {{ $vehicle->name }}
                            </h3>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-400 dark:text-gray-500 border border-gray-100 dark:border-white/5">
                            <i class="fa-solid fa-car"></i>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mt-4 py-4 border-t border-gray-100 dark:border-white/5">
                        <span class="flex items-center gap-1.5" title="Loại xe">
                            <i class="fa-solid fa-filter"></i> {{ $vehicle->type }}
                        </span>
                        <span class="flex items-center gap-1.5" title="Tổng số chuyến">
                            <i class="fa-solid fa-route"></i> {{ $vehicle->bookings_count ?? 0 }} chuyến
                        </span>
                    </div>

                    
                    <div class="flex gap-2 mt-2">
                        
                        <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="flex-1 bg-gray-100 dark:bg-white/10 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 text-gray-700 dark:text-gray-300 py-2.5 rounded-xl font-bold text-xs uppercase flex items-center justify-center gap-2 transition-all">
                            <i class="fa-regular fa-pen-to-square"></i> Sửa
                        </a>
                        
                        
                        <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa xe này?');" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 dark:bg-red-900/20 hover:bg-red-600 hover:text-white dark:hover:bg-red-600 text-red-600 dark:text-red-400 py-2.5 rounded-xl font-bold text-xs uppercase flex items-center justify-center gap-2 transition-all">
                                <i class="fa-regular fa-trash-can"></i> Xóa
                            </button>
                        </form>
                    </div>
                    
                    
                    <div class="mt-2">
                        @if($vehicle->status == 'available')
                            <form action="{{ route('admin.vehicles.maintenance', $vehicle->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="maintenance">
                                <button class="w-full py-2 border border-dashed border-gray-300 dark:border-white/20 text-gray-400 hover:text-orange-500 hover:border-orange-500 rounded-xl text-[10px] font-bold uppercase transition-all">
                                    <i class="fa-solid fa-wrench"></i> Đưa vào bảo trì
                                </button>
                            </form>
                        @elseif($vehicle->status == 'maintenance')
                            <form action="{{ route('admin.vehicles.maintenance', $vehicle->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="available">
                                <button class="w-full py-2 bg-green-500/10 text-green-600 hover:bg-green-500 hover:text-white rounded-xl text-[10px] font-bold uppercase transition-all">
                                    <i class="fa-solid fa-check"></i> Hoàn tất bảo trì
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        
        <div class="mt-8 px-4">
            {{ $vehicles->links() }}
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes bounceIn { 0% { transform: scale(0.9); opacity: 0; } 50% { transform: scale(1.05); opacity: 1; } 100% { transform: scale(1); } }
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-fade-in-down { animation: fadeInDown 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-bounce-in { animation: bounceIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
</style>
@endsection