@if(isset($vehicles) && $vehicles->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" id="vehicle-grid-content">
        @foreach($vehicles as $index => $vehicle)
            <x-ui.card variant="glass" padding="p-0" class="group h-full !bg-white dark:!bg-[#111] !border-gray-100 dark:!border-white/5 animate-fade-in-up hover:-translate-y-2 hover:shadow-[0_20px_40px_-5px_rgba(0,0,0,0.2)] dark:hover:shadow-[0_20px_40px_-5px_rgba(234,179,8,0.1)] transition-all duration-500" 
                 style="animation-delay: {{ $index * 0.1 }}s;">
                
                {{-- Image Container --}}
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ str_starts_with($vehicle->image, 'http') ? $vehicle->image : asset('storage/' . $vehicle->image) }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 group-hover:rotate-1"
                         onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=800'">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-60 group-hover:opacity-40 transition-opacity"></div>
                    
                    {{-- Brand Badge --}}
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[10px] font-bold text-white uppercase tracking-wider">
                            {{ $vehicle->brand->name ?? 'Elite' }}
                        </span>
                    </div>
                    
                    <div class="absolute bottom-4 left-4 flex gap-2">
                         <span class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-[10px] text-white" title="Auto"><i class="fa-solid fa-gears"></i></span>
                         <span class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-[10px] text-white" title="Petrol"><i class="fa-solid fa-gas-pump"></i></span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white mb-2 truncate group-hover:text-yellow-500 transition-colors">{{ $vehicle->name }}</h3>
                        <div class="h-0.5 w-10 bg-gray-100 dark:bg-white/10 group-hover:bg-yellow-500 group-hover:w-full transition-all duration-500 mb-4"></div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xl font-black text-gray-900 dark:text-white">{{ number_format($vehicle->price) }} <span class="text-xs font-normal text-gray-400">VND</span></p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Mỗi ngày</p>
                        </div>
                        <x-ui.button href="{{ route('vehicles.show', $vehicle->id) }}" variant="outline" size="sm" class="!rounded-full !w-10 !h-10 !p-0 flex items-center justify-center !border-gray-200 dark:!border-white/10 !text-gray-900 dark:!text-white group-hover:!bg-yellow-500 group-hover:!text-black group-hover:!border-yellow-500">
                            <i class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform"></i>
                        </x-ui.button>
                    </div>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-20 flex justify-center">
        <div class="bg-white dark:bg-[#121212] rounded-full shadow-lg px-6 py-2 border border-gray-100 dark:border-gray-800">
            {{ $vehicles->links() }}
        </div>
    </div>
@else
    <div class="py-32 text-center">
        <div class="inline-block p-6 rounded-full bg-gray-100 dark:bg-white/5 mb-4 animate-float">
            <i class="fa-solid fa-car-tunnel text-4xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Chưa tìm thấy xe phù hợp</h3>
        <p class="text-gray-500 text-sm">Hãy thử thay đổi tiêu chí xe bạn cần nhé.</p>
    </div>
@endif
