@extends('layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div x-data="adminDashboard()" x-init="init()" class="bg-white dark:bg-[#050505] min-h-screen py-12 font-sans transition-colors duration-500 relative overflow-hidden">
    
    {{-- Background Glows --}}
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-yellow-500/5 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-zinc-500/5 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2 pointer-events-none"></div>

    <div class="container mx-auto px-8 max-w-7xl relative z-10">

        {{-- Header --}}
        <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6 animate-page-entry">
            <div>
                <p class="text-[10px] font-black text-amber-600 dark:text-amber-500 uppercase tracking-[0.4em] mb-3">Management Console</p>
                <h1 class="text-5xl font-black text-zinc-900 dark:text-white tracking-tighter uppercase">
                    Admin <span class="opacity-20 italic">Portal</span>
                </h1>
                <p class="text-zinc-500 mt-4 text-xs uppercase tracking-widest font-medium flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Hệ thống đang hoạt động. Chào bro, <span class="text-zinc-900 dark:text-zinc-100 font-black">{{ Auth::user()->name }}</span>.
                </p>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="group px-6 py-3 bg-zinc-50 dark:bg-white/5 border border-zinc-200 dark:border-white/5 rounded-full text-[10px] font-black uppercase tracking-widest text-zinc-600 dark:text-zinc-400 hover:bg-zinc-900 hover:text-white dark:hover:bg-white dark:hover:text-black transition-all duration-500 flex items-center gap-3">
                    <i class="fa-solid fa-eye text-sm"></i> 
                    <span>Live View</span>
                </a>
                <button @click="fetchStats(true)" class="w-12 h-12 flex items-center justify-center bg-zinc-900 dark:bg-white text-white dark:text-black rounded-full shadow-2xl hover:scale-110 transition-transform duration-500 relative overflow-hidden">
                    <i class="fa-solid fa-rotate-right text-sm" :class="{ 'animate-spin': loading }"></i>
                </button>
            </div>
        </div>

        {{-- LIVE GPS MAP MOCKUP --}}
        <div class="relative w-full h-64 rounded-[2.5rem] overflow-hidden mb-12 border border-zinc-100 dark:border-white/5 group shadow-2xl">
            <div class="absolute inset-0 bg-zinc-900">
                <div class="absolute inset-0 opacity-30" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg'); background-size: cover; background-position: center; filter: invert(1);"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#050505] to-transparent"></div>
            </div>
            
            <div class="absolute top-6 left-8">
                 <span class="flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/20 text-red-500 border border-red-500/30 text-[9px] font-black uppercase tracking-widest animate-pulse">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Live Tracking
                 </span>
            </div>

            <div class="absolute top-1/2 left-1/3 w-3 h-3 bg-amber-500 rounded-full animate-ping"></div>
            <div class="absolute top-1/2 left-1/3 w-3 h-3 bg-amber-500 rounded-full border-2 border-white"></div>
            <div class="absolute top-1/2 left-1/3 transform -translate-x-1/2 -translate-y-[150%] bg-white text-black text-[8px] font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                Ferrari 488 <br> <span class="text-zinc-500">200km/h</span>
            </div>

            <div class="absolute top-1/3 right-1/4 w-3 h-3 bg-blue-500 rounded-full animate-ping" style="animation-delay: 0.5s"></div>
            <div class="absolute top-1/3 right-1/4 w-3 h-3 bg-blue-500 rounded-full border-2 border-white"></div>

            <div class="absolute bottom-8 right-8 text-right">
                <h3 class="text-2xl font-black text-white tracking-tighter">Global Fleet</h3>
                <p class="text-zinc-500 text-[10px] uppercase tracking-widest"><span x-text="rentedCars"></span> Active Trips</p>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            
            {{-- Revenue --}}
            <div class="bg-zinc-900 dark:bg-white rounded-[2rem] p-8 shadow-2xl group relative overflow-hidden transition-all duration-500 hover:-translate-y-2">
                <div class="relative z-10">
                    <p class="text-zinc-400 dark:text-zinc-500 text-[9px] font-black uppercase tracking-[0.3em] mb-2">Doanh thu tổng</p>
                    <h3 class="text-3xl font-black text-white dark:text-black tracking-tighter flex items-baseline">
                        <span x-text="revenue">{{ number_format($revenue) }}</span><span class="text-sm ml-1 opacity-50">đ</span>
                    </h3>
                    <div class="mt-6 flex items-center gap-2 text-[9px] font-black uppercase tracking-widest text-amber-500">
                        <i class="fa-solid fa-chart-line"></i> +12.5% Growth
                    </div>
                </div>
                <i class="fa-solid fa-coins absolute -bottom-4 -right-4 text-8xl opacity-10 dark:opacity-5 rotate-12"></i>
            </div>

            {{-- Pending --}}
            <div class="bg-white dark:bg-[#0a0a0a] border border-zinc-100 dark:border-white/5 rounded-[2rem] p-8 transition-all duration-500 hover:border-amber-500/50 group">
                <div class="flex justify-between items-start mb-6">
                    <p class="text-zinc-400 text-[9px] font-black uppercase tracking-[0.3em]">Đơn chờ duyệt</p>
                    <div class="text-amber-500 group-hover:animate-pulse"><i class="fa-solid fa-hourglass-half"></i></div>
                </div>
                <h3 class="text-4xl font-black text-zinc-900 dark:text-white tracking-tighter" x-text="pendingBookings">{{ $pendingBookings }}</h3>
                <div class="mt-6 h-[1px] w-full bg-zinc-100 dark:bg-zinc-900 overflow-hidden">
                    <div class="h-full bg-amber-500 transition-all duration-1000" :style="'width: ' + (pendingBookings > 0 ? '70%' : '0%')"></div>
                </div>
            </div>

            {{-- Fleet --}}
            <div class="bg-white dark:bg-[#0a0a0a] border border-zinc-100 dark:border-white/5 rounded-[2rem] p-8 transition-all duration-500 hover:border-zinc-900 dark:hover:border-white/50 group">
                <div class="flex justify-between items-start mb-6">
                    <p class="text-zinc-400 text-[9px] font-black uppercase tracking-[0.3em]">Tổng đội xe</p>
                    <div class="text-zinc-400 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors"><i class="fa-solid fa-car-side"></i></div>
                </div>
                <h3 class="text-4xl font-black text-zinc-900 dark:text-white tracking-tighter" x-text="totalVehicles">{{ $totalVehicles }}</h3>
                <div class="mt-6 flex gap-4 text-[9px] font-black uppercase tracking-widest">
                    <span class="text-emerald-500"><span x-text="availableCars">{{ $availableCars }}</span> Ready</span>
                    <span class="text-rose-500"><span x-text="rentedCars">{{ $rentedCars }}</span> Active</span>
                </div>
            </div>

            {{-- Users --}}
            <div class="bg-white dark:bg-[#0a0a0a] border border-zinc-100 dark:border-white/5 rounded-[2rem] p-8 transition-all duration-500 group overflow-hidden">
                <p class="text-zinc-400 text-[9px] font-black uppercase tracking-[0.3em] mb-6">Cộng đồng VIP</p>
                <div class="flex items-center gap-4">
                    <h3 class="text-4xl font-black text-zinc-900 dark:text-white tracking-tighter" x-text="totalUsers">{{ $totalUsers }}</h3>
                    <div class="flex -space-x-3">
                        <img class="h-8 w-8 rounded-full border-2 border-white dark:border-[#0a0a0a] object-cover" src="https://i.pravatar.cc/100?img=1" alt=""/>
                        <img class="h-8 w-8 rounded-full border-2 border-white dark:border-[#0a0a0a] object-cover" src="https://i.pravatar.cc/100?img=2" alt=""/>
                        <div class="h-8 w-8 rounded-full border-2 border-white dark:border-[#0a0a0a] bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-[8px] font-black text-zinc-500">
                             +<span x-text="totalUsers > 2 ? totalUsers - 2 : 0">0</span>
                        </div>
                    </div>
                </div>
                <p class="mt-6 text-[9px] text-zinc-400 uppercase tracking-widest italic">Membership Tier: Elite</p>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Chart --}}
                <div class="bg-white dark:bg-[#0a0a0a] rounded-[2.5rem] p-10 border border-zinc-100 dark:border-white/5 shadow-sm relative group">
                    <div class="flex justify-between items-center mb-10">
                        <h3 class="font-black text-zinc-900 dark:text-white uppercase text-sm tracking-[0.2em] flex items-center gap-2">
                            Revenue Analytics
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse" x-show="!loading"></span>
                        </h3>
                    </div>
                    <div class="h-72 w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                {{-- Recent Transactions --}}
                <div class="bg-white dark:bg-[#0a0a0a] rounded-[2.5rem] border border-zinc-100 dark:border-white/5 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-zinc-50 dark:border-white/5 flex justify-between items-center">
                        <h3 class="font-black text-zinc-900 dark:text-white uppercase text-sm tracking-[0.2em]">Giao dịch gần đây</h3>
                        <a href="{{ route('admin.bookings.index') }}" class="text-[10px] font-black uppercase tracking-widest text-amber-600 hover:text-amber-500 transition-colors">Xem tất cả —</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-zinc-50/50 dark:bg-zinc-900/20 text-zinc-400 uppercase text-[9px] font-black tracking-[0.2em]">
                                    <th class="px-8 py-5">Thành viên</th>
                                    <th class="px-8 py-5">Kiệt tác</th>
                                    <th class="px-8 py-5 text-center">Trạng thái</th>
                                    <th class="px-8 py-5 text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-50 dark:divide-white/5 text-[11px] font-medium">
                                @forelse($recentBookings as $booking)
                                <tr class="group hover:bg-zinc-50/50 dark:hover:bg-white/[0.02] transition-all duration-300">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-9 h-9 rounded-full bg-zinc-900 dark:bg-white text-white dark:text-black flex items-center justify-center font-black text-[10px] uppercase">
                                                {{ substr($booking->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-black text-zinc-900 dark:text-zinc-100 uppercase tracking-tighter">{{ $booking->user->name }}</div>
                                                <div class="text-[9px] text-zinc-400 uppercase tracking-widest mt-1">{{ $booking->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 uppercase tracking-widest text-zinc-400">{{ $booking->vehicle->name }}</td>
                                    <td class="px-8 py-6 text-center">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['bg' => 'bg-amber-100 dark:bg-amber-500/10', 'text' => 'text-amber-700 dark:text-amber-500', 'label' => 'Waiting'],
                                                'confirmed' => ['bg' => 'bg-zinc-900 dark:bg-white/10', 'text' => 'text-white dark:text-white', 'label' => 'Elite Access'],
                                                'completed' => ['bg' => 'bg-zinc-100 dark:bg-white/5', 'text' => 'text-zinc-500', 'label' => 'Finished'],
                                                'cancelled' => ['bg' => 'bg-rose-100 dark:bg-rose-500/10', 'text' => 'text-rose-700 dark:text-rose-500', 'label' => 'Revoked'],
                                            ];
                                            $conf = $statusConfig[$booking->status] ?? $statusConfig['pending'];
                                        @endphp
                                        <span class="inline-block px-3 py-1.5 rounded-full text-[8px] font-black uppercase tracking-[0.2em] {{ $conf['bg'] }} {{ $conf['text'] }}">
                                            {{ $conf['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-2 group-hover:translate-x-0">
                                            @if($booking->status == 'pending')
                                                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button class="w-8 h-8 rounded-full bg-amber-500 text-black flex items-center justify-center hover:scale-110 transition-transform"><i class="fa-solid fa-check"></i></button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="w-8 h-8 rounded-full bg-zinc-100 dark:bg-white/10 text-zinc-600 dark:text-zinc-400 flex items-center justify-center hover:bg-zinc-900 dark:hover:bg-white hover:text-white dark:hover:text-black transition-all"><i class="fa-solid fa-chevron-right text-[10px]"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-8 py-20 text-center text-zinc-400 uppercase tracking-[0.3em] text-[10px]">No luxury orders found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Quick Actions --}}
                <div class="bg-zinc-900 dark:bg-white rounded-[2.5rem] p-10 text-white dark:text-black relative overflow-hidden group">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-amber-500/20 rounded-full blur-3xl transition-all duration-1000 group-hover:scale-150"></div>
                    <h3 class="font-black text-sm uppercase tracking-[0.3em] mb-8 relative z-10">Quick Control</h3>
                    <div class="grid grid-cols-1 gap-4 relative z-10">
                        <a href="{{ route('admin.vehicles.create') }}" class="flex items-center justify-between p-5 bg-white/5 dark:bg-zinc-900/5 rounded-2xl hover:bg-amber-500 dark:hover:bg-amber-500 hover:text-black transition-all duration-500">
                            <span class="text-[10px] font-black uppercase tracking-widest">Thêm xe mới</span>
                            <i class="fa-solid fa-plus text-xs"></i>
                        </a>
                        <button class="flex items-center justify-between p-5 bg-white/5 dark:bg-zinc-900/5 rounded-2xl hover:bg-zinc-100 dark:hover:bg-zinc-100 transition-all duration-500">
                            <span class="text-[10px] font-black uppercase tracking-widest">Xuất báo cáo PDF</span>
                            <i class="fa-solid fa-file-pdf text-xs"></i>
                        </button>
                    </div>
                </div>

                {{-- Availability --}}
                <div class="bg-white dark:bg-[#0a0a0a] rounded-[2.5rem] p-10 border border-zinc-100 dark:border-white/5 shadow-sm">
                    <h3 class="font-black text-zinc-900 dark:text-white uppercase text-[10px] tracking-[0.4em] mb-10 text-center">Fleet Availability</h3>
                    <div class="relative flex items-center justify-center mb-10">
                        <svg class="w-32 h-32 transform -rotate-90">
                            <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="4" fill="transparent" class="text-zinc-100 dark:text-zinc-900" />
                            <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="4" fill="transparent" 
                                stroke-dasharray="377" 
                                :stroke-dashoffset="377 - (377 * (totalVehicles > 0 ? (availableCars/totalVehicles)*100 : 0) / 100)"
                                class="text-amber-500 transition-all duration-1000" />
                        </svg>
                        <span class="absolute text-2xl font-black text-zinc-900 dark:text-white">
                            <span x-text="totalVehicles > 0 ? Math.round((availableCars/totalVehicles)*100) : 0">0</span>%
                        </span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between text-[10px] font-black uppercase tracking-widest"><span class="text-zinc-400">Ready</span><span class="text-zinc-900 dark:text-white" x-text="availableCars">{{ $availableCars }}</span></div>
                        <div class="flex justify-between text-[10px] font-black uppercase tracking-widest"><span class="text-zinc-400">Active</span><span class="text-zinc-900 dark:text-white" x-text="rentedCars">{{ $rentedCars }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="bg-white dark:bg-[#0a0a0a] rounded-[2.5rem] border border-zinc-100 dark:border-white/5 shadow-sm overflow-hidden animate-page-entry" style="animation-delay: 0.2s">
            <div class="p-8 border-b border-zinc-50 dark:border-white/5 flex justify-between items-center bg-zinc-50/30 dark:bg-zinc-900/10">
                <div>
                    <h3 class="font-black text-zinc-900 dark:text-white uppercase text-sm tracking-[0.2em]">Quản trị thành viên</h3>
                    <p class="text-[10px] text-zinc-400 uppercase tracking-widest mt-1">Quản lý phân quyền và dữ liệu thành viên tinh hoa</p>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-zinc-400 uppercase text-[9px] font-black tracking-[0.2em] border-b border-zinc-50 dark:border-white/5">
                            <th class="px-8 py-5">Thành viên</th>
                            <th class="px-8 py-5">Email & Liên hệ</th>
                            <th class="px-8 py-5 text-center">Vai trò</th>
                            <th class="px-8 py-5 text-center">Gia nhập</th>
                            <th class="px-8 py-5 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-white/5 text-[11px]">
                        @foreach($allUsers as $user)
                        <tr class="group hover:bg-zinc-50/50 dark:hover:bg-white/[0.02] transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center font-black text-xs text-zinc-500 uppercase">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="font-black text-zinc-900 dark:text-zinc-100 uppercase tracking-tighter">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-zinc-500 dark:text-zinc-400 lowercase tracking-widest">{{ $user->email }}</td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest border {{ $user->role === 'admin' ? 'bg-zinc-900 dark:bg-white text-white dark:text-black border-transparent' : 'border-zinc-200 dark:border-zinc-800 text-zinc-400' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center text-zinc-400 uppercase">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-2 group-hover:translate-x-0">
                                    <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button class="w-8 h-8 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 flex items-center justify-center hover:bg-amber-500 hover:text-black transition-all"><i class="fa-solid fa-user-shield text-[10px]"></i></button>
                                    </form>
                                    @if($user->id !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Xóa thành viên này?')">
                                        @csrf @method('DELETE')
                                        <button class="w-8 h-8 rounded-full bg-rose-500/10 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all"><i class="fa-solid fa-trash-can text-[10px]"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-zinc-50 dark:border-white/5 bg-zinc-50/20 dark:bg-zinc-900/10">
                {{ $allUsers->links() }}
            </div>
        </div>

    </div>
</div>


<script>
    function adminDashboard() {
        return {
            loading: false,
            revenue: '{{ number_format($revenue) }}',
            pendingBookings: {{ $pendingBookings }},
            totalVehicles: {{ $totalVehicles }},
            availableCars: {{ $availableCars }},
            rentedCars: {{ $rentedCars }},
            totalUsers: {{ $totalUsers }},
            chartInstance: null,

            init() {
                this.initChart();
                // Polling every 30 seconds
                setInterval(() => {
                    this.fetchStats();
                }, 30000);
            },

            async fetchStats(manual = false) {
                if (manual) this.loading = true;
                
                try {
                    const response = await fetch('{{ route('admin.dashboard.stats') }}', { headers: { 'Accept': 'application/json' } });
                    const data = await response.json();
                    
                    this.revenue = data.revenue;
                    this.pendingBookings = data.pendingBookings;
                    this.totalVehicles = data.totalVehicles;
                    this.availableCars = data.availableCars;
                    this.rentedCars = data.rentedCars;
                    this.totalUsers = data.totalUsers;

                    this.updateChart(data.revenueData, data.chartLabels);
                } catch (error) {
                    console.error('Failed to fetch stats', error);
                } finally {
                    if (manual) setTimeout(() => this.loading = false, 500);
                }
            },

            initChart() {
                const ctx = document.getElementById('revenueChart').getContext('2d');
                let gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(245, 158, 11, 0.5)'); 
                gradient.addColorStop(1, 'rgba(245, 158, 11, 0.0)'); 

                const initialData = @json($revenueData);
                const initialLabels = @json($chartLabels);

                this.chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: initialLabels,
                        datasets: [{
                            data: initialData, 
                            borderColor: '#f59e0b',
                            backgroundColor: gradient,
                            borderWidth: 4,
                            pointRadius: 4,
                            pointHoverRadius: 8,
                            pointBackgroundColor: '#fff',
                            fill: true,
                            tension: 0.4 
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { 
                                display: true, 
                                grid: { color: 'rgba(255,255,255,0.05)' },
                                ticks: { callback: (val) => val / 1000000 + 'M' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: '#71717a', font: { size: 10, weight: 'bold' } }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                    }
                });
            },

            updateChart(data, labels) {
                if (this.chartInstance) {
                    this.chartInstance.data.labels = labels;
                    this.chartInstance.data.datasets[0].data = data;
                    this.chartInstance.update();
                }
            }
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('adminDashboard', adminDashboard);
    });
</script>

<style>
    @keyframes pageEntry {
        from { opacity: 0; transform: translateY(20px); filter: blur(10px); }
        to { opacity: 1; transform: translateY(0); filter: blur(0); }
    }
    .animate-page-entry {
        animation: pageEntry 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
@endsection