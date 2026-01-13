@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/vn.js"></script>

<div class="bg-[#f8f9fa] dark:bg-[#050505] min-h-screen pb-24 transition-colors duration-500 font-sans text-sm relative overflow-hidden">
    
    
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/10 dark:bg-blue-600/5 rounded-full blur-[120px] pointer-events-none mix-blend-multiply dark:mix-blend-screen"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-yellow-500/10 dark:bg-yellow-600/5 rounded-full blur-[100px] pointer-events-none mix-blend-multiply dark:mix-blend-screen"></div>

    
    <div class="bg-white/70 dark:bg-[#121212]/80 backdrop-blur-xl border-b border-gray-200 dark:border-white/5 sticky top-0 z-40 shadow-sm transition-all">
        <div class="container mx-auto px-4 max-w-6xl h-16 flex items-center justify-between">
            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="group flex items-center gap-2 text-gray-500 hover:text-gray-900 dark:hover:text-white transition font-bold text-xs uppercase tracking-wide">
                <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-white/10 flex items-center justify-center group-hover:bg-gray-200 dark:group-hover:bg-white/20 transition">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>
                <span class="hidden sm:inline">Quay lại xe</span>
            </a>
            
            
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 opacity-50 grayscale">
                    <span class="w-6 h-6 rounded-full bg-gray-200 dark:bg-white/10 flex items-center justify-center text-[10px] font-bold">1</span>
                    <span class="text-xs font-bold hidden sm:inline">Chọn xe</span>
                </div>
                <div class="w-8 h-[1px] bg-gray-300 dark:bg-white/10"></div>
                <div class="flex items-center gap-2 text-blue-600 dark:text-yellow-500">
                    <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-yellow-500/20 flex items-center justify-center text-[10px] font-bold ring-2 ring-blue-500/20 dark:ring-yellow-500/20">2</span>
                    <span class="text-xs font-bold hidden sm:inline">Đặt chuyến</span>
                </div>
                <div class="w-8 h-[1px] bg-gray-300 dark:bg-white/10"></div>
                <div class="flex items-center gap-2 opacity-50">
                    <span class="w-6 h-6 rounded-full bg-gray-200 dark:bg-white/10 flex items-center justify-center text-[10px] font-bold">3</span>
                    <span class="text-xs font-bold hidden sm:inline">Thanh toán</span>
                </div>
            </div>
        </div>
    </div>

    
    @if ($errors->any())
    <div class="container mx-auto px-4 max-w-6xl mt-6 animate-fade-in-down">
        <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-500/30 p-4 rounded-2xl flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center flex-shrink-0 text-red-500">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-red-800 dark:text-red-400">Vui lòng kiểm tra lại:</h3>
                <ul class="mt-1 list-disc list-inside text-xs text-red-600 dark:text-red-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="container mx-auto px-4 max-w-6xl mt-8" x-data="bookingWizard()">
        <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm" @submit.prevent="submitForm">
            @csrf
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
            <input type="hidden" id="price_per_day" value="{{ $vehicle->price }}">
            <input type="hidden" id="total_price_input" name="total_price" :value="totalPrice">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- WIZARD MAIN COLUMN --}}
                <div class="lg:col-span-8 space-y-6">
                    
                    {{-- STEP 1: SCHEDULE --}}
                    <div x-show="step === 1" x-transition.duration.500ms class="space-y-6">
                        <div class="bg-white dark:bg-[#121212] rounded-3xl shadow-sm border border-gray-100 dark:border-white/5 p-6 md:p-8 relative overflow-hidden group hover:border-blue-500/30 dark:hover:border-yellow-500/30 transition-all duration-300">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Lịch trình của bạn</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 relative z-10">
                                {{-- Start Date --}}
                                <div class="bg-gray-50 dark:bg-white/5 rounded-2xl p-4 border border-gray-100 dark:border-white/5 hover:border-blue-400 dark:hover:border-yellow-500 transition-colors cursor-pointer" @click="openStartDate">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nhận xe</p>
                                    <div class="flex items-center gap-3">
                                        <i class="fa-regular fa-calendar text-gray-400"></i>
                                        <input type="text" name="start_date" id="start_date_picker" required placeholder="Chọn ngày nhận"
                                            class="bg-transparent border-none p-0 text-sm font-bold text-gray-900 dark:text-white focus:ring-0 w-full cursor-pointer pointer-events-none">
                                    </div>
                                </div>

                                {{-- End Date --}}
                                <div class="bg-gray-50 dark:bg-white/5 rounded-2xl p-4 border border-gray-100 dark:border-white/5 hover:border-blue-400 dark:hover:border-yellow-500 transition-colors cursor-pointer" @click="openEndDate">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Trả xe</p>
                                    <div class="flex items-center gap-3">
                                        <i class="fa-solid fa-arrow-right-from-bracket text-gray-400"></i>
                                        <input type="text" name="end_date" id="end_date_picker" required placeholder="Chọn ngày trả"
                                            class="bg-transparent border-none p-0 text-sm font-bold text-gray-900 dark:text-white focus:ring-0 w-full cursor-pointer pointer-events-none">
                                    </div>
                                </div>
                            </div>

                            {{-- Duration Display --}}
                            <div x-show="days > 0" x-transition class="mt-4">
                                <div class="bg-blue-50 dark:bg-blue-900/10 rounded-xl p-3 flex items-center justify-between border border-blue-100 dark:border-blue-500/20">
                                    <span class="text-xs font-bold text-blue-800 dark:text-blue-300 flex items-center gap-2">
                                        <i class="fa-solid fa-check-circle"></i> Thời gian hợp lệ
                                    </span>
                                    <span class="text-sm font-black text-blue-900 dark:text-white"><span x-text="days"></span> Ngày</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 2: SERVICES --}}
                    <div x-show="step === 2" x-transition.duration.500ms class="space-y-6" style="display: none;">
                        <div class="bg-white dark:bg-[#121212] rounded-3xl shadow-sm border border-gray-100 dark:border-white/5 p-6 md:p-8 group hover:border-purple-500/30 transition-all duration-300">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                                </div>
                                <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Dịch vụ thượng hạng</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Driver --}}
                                <label class="relative block cursor-pointer group">
                                    <input type="checkbox" name="services[]" value="driver" @change="toggleService('driver', 500000)" class="peer sr-only">
                                    <div class="p-5 rounded-2xl border-2 border-gray-100 dark:border-white/10 bg-gray-50 dark:bg-white/5 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 dark:peer-checked:bg-yellow-900/10 transition-all">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="w-8 h-8 rounded-lg bg-white dark:bg-white/10 flex items-center justify-center text-gray-500 dark:text-gray-300 peer-checked:text-yellow-600">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </div>
                                            <span class="text-xs font-bold text-gray-900 dark:text-white bg-white dark:bg-black/50 px-2 py-1 rounded-md shadow-sm">500k/ngày</span>
                                        </div>
                                        <p class="font-bold text-gray-900 dark:text-white text-sm mb-1">Thuê tài xế riêng</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Tài xế chuyên nghiệp, rành đường.</p>
                                    </div>
                                    <div class="absolute top-4 right-4 text-yellow-500 opacity-0 peer-checked:opacity-100 transition-opacity transform scale-0 peer-checked:scale-100 duration-200">
                                        <i class="fa-solid fa-circle-check text-lg"></i>
                                    </div>
                                </label>

                                {{-- Insurance --}}
                                <label class="relative block cursor-pointer group">
                                    <input type="checkbox" name="services[]" value="insurance" checked @change="toggleService('insurance', 200000)" class="peer sr-only">
                                    <div class="p-5 rounded-2xl border-2 border-gray-100 dark:border-white/10 bg-gray-50 dark:bg-white/5 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 dark:peer-checked:bg-yellow-900/10 transition-all">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="w-8 h-8 rounded-lg bg-white dark:bg-white/10 flex items-center justify-center text-gray-500 dark:text-gray-300 peer-checked:text-yellow-600">
                                                <i class="fa-solid fa-shield-halved"></i>
                                            </div>
                                            <span class="text-xs font-bold text-gray-900 dark:text-white bg-white dark:bg-black/50 px-2 py-1 rounded-md shadow-sm">200k/ngày</span>
                                        </div>
                                        <p class="font-bold text-gray-900 dark:text-white text-sm mb-1">Bảo hiểm chuyến đi</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Bảo vệ toàn diện xe và người.</p>
                                    </div>
                                    <div class="absolute top-4 right-4 text-yellow-500 opacity-0 peer-checked:opacity-100 transition-opacity transform scale-0 peer-checked:scale-100 duration-200">
                                        <i class="fa-solid fa-circle-check text-lg"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 3: CONCIERGE --}}
                    <div x-show="step === 3" x-transition.duration.500ms class="space-y-6" style="display: none;">
                        <div class="bg-white dark:bg-[#121212] rounded-3xl shadow-sm border border-gray-100 dark:border-white/5 p-6 md:p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-400 flex items-center justify-center text-lg">
                                    <i class="fa-regular fa-id-badge"></i>
                                </div>
                                <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Thông tin xác nhận</h2>
                            </div>

                            <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/5 mb-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }} • {{ Auth::user()->phone ?? 'Chưa có SĐT' }}</p>
                                </div>
                            </div>

                            <label class="block">
                                <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase ml-1 mb-1 block">Lời nhắn (Tùy chọn)</span>
                                <textarea name="note" rows="2" placeholder="Ví dụ: Tôi muốn nhận xe tại sân bay..." 
                                    class="w-full bg-gray-50 dark:bg-black border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-yellow-500 dark:text-white transition resize-none"></textarea>
                            </label>
                        </div>
                    </div>

                    {{-- NAVIGATION BUTTONS --}}
                    <div class="flex justify-between pt-4">
                         <button type="button" @click="prevStep" x-show="step > 1" class="px-6 py-3 rounded-xl bg-gray-200 dark:bg-white/10 text-black dark:text-white font-bold text-xs uppercase tracking-wider hover:bg-gray-300 dark:hover:bg-white/20 transition">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
                        </button>
                        <div x-show="step === 1" class="flex-1"></div> {{-- Spacer --}}

                        <button type="button" @click="nextStep" x-show="step < 3" :disabled="!isValidStep()" :class="{'opacity-50 cursor-not-allowed': !isValidStep()}" class="px-8 py-3 rounded-xl bg-black dark:bg-white text-white dark:text-black font-bold text-xs uppercase tracking-wider hover:shadow-lg hover:-translate-y-1 transition ml-auto">
                            Tiếp tục <i class="fa-solid fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>

                {{-- RECEIPT STICKY COLUMN --}}
                <div class="lg:col-span-4 lg:sticky lg:top-24 space-y-6">
                    <div class="bg-white dark:bg-[#121212] rounded-[2rem] shadow-2xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-white/5 overflow-hidden">
                        {{-- Vehicle Preview --}}
                        <div class="relative h-48 group">
                            <img src="{{ str_starts_with($vehicle->image, 'http') ? $vehicle->image : asset('storage/' . $vehicle->image) }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#121212] via-transparent to-transparent opacity-90"></div>
                            <div class="absolute bottom-4 left-6">
                                <span class="px-2 py-1 rounded bg-yellow-500 text-black text-[10px] font-black uppercase tracking-wider mb-2 inline-block">
                                    {{ $vehicle->brand->name ?? 'Brand' }}
                                </span>
                                <h3 class="text-xl font-black text-white leading-tight">{{ $vehicle->name }}</h3>
                            </div>
                        </div>

                        {{-- Calculation --}}
                        <div class="p-6">
                            <div class="space-y-3 text-sm mb-6">
                                <div class="flex justify-between items-center text-gray-600 dark:text-gray-400">
                                    <span>Giá thuê (<span x-text="days">1</span> ngày)</span>
                                    <span class="font-bold text-gray-900 dark:text-white" x-text="formatMoney(rentTotal)">0đ</span>
                                </div>
                                
                                <template x-if="services.driver">
                                    <div class="flex justify-between items-center text-xs animate-fade-in-up">
                                        <span class="text-gray-500 dark:text-gray-400">+ Tài xế riêng</span>
                                        <span class="font-bold text-gray-900 dark:text-white" x-text="formatMoney(serviceCosts.driver * days)"></span>
                                    </div>
                                </template>
                                <template x-if="services.insurance">
                                    <div class="flex justify-between items-center text-xs animate-fade-in-up">
                                        <span class="text-gray-500 dark:text-gray-400">+ Bảo hiểm</span>
                                        <span class="font-bold text-gray-900 dark:text-white" x-text="formatMoney(serviceCosts.insurance * days)"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="flex justify-between items-end mb-6 pt-4 border-t border-gray-100 dark:border-white/10">
                                <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Tổng thanh toán</div>
                                <div class="text-2xl font-black text-blue-600 dark:text-yellow-500 tracking-tighter" x-text="formatMoney(totalPrice)">0đ</div>
                            </div>

                            <button type="submit" x-show="step === 3" class="w-full relative group overflow-hidden bg-gray-900 dark:bg-white text-white dark:text-black py-4 rounded-xl font-black text-xs uppercase tracking-widest shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                                <span class="relative z-10 group-hover:text-yellow-500 dark:group-hover:text-blue-600 transition-colors flex items-center justify-center gap-2">
                                    Xác nhận đặt xe <i class="fa-solid fa-arrow-right"></i>
                                </span>
                                <div class="absolute inset-0 bg-gray-800 dark:bg-gray-100 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                            </button>
                            
                            <div class="mt-4 flex justify-center items-center gap-2 text-[10px] text-gray-400">
                                <i class="fa-solid fa-shield-halved text-green-500"></i> Thanh toán an toàn & bảo mật
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-up { animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>

<script>
    function bookingWizard() {
        return {
            step: 1,
            pricePerDay: {{ $vehicle->price }},
            days: 1,
            rentTotal: 0,
            totalPrice: 0,
            startDate: null,
            endDate: null,
            services: {
                driver: false,
                insurance: true
            },
            serviceCosts: {
                driver: 500000,
                insurance: 200000
            },
            startPicker: null,
            endPicker: null,

            init() {
                const fpConfig = {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    time_24hr: true,
                    minDate: "today",
                    locale: "vn",
                    disableMobile: "true",
                    minuteIncrement: 30
                };

                this.startPicker = flatpickr("#start_date_picker", {
                    ...fpConfig,
                    onChange: (selectedDates, dateStr) => {
                        this.startDate = selectedDates[0];
                        this.endPicker.set('minDate', dateStr);
                        this.calculate();
                        if (this.isValidStep()) {
                           // Optional auto open next
                        }
                    }
                });

                this.endPicker = flatpickr("#end_date_picker", {
                    ...fpConfig,
                    onChange: (selectedDates) => {
                        this.endDate = selectedDates[0];
                        this.calculate();
                    }
                });
                
                // Initial Calc
                this.calculate();
            },

            openStartDate() {
                this.startPicker.open();
            },

            openEndDate() {
                this.endPicker.open();
            },

            calculate() {
                if (this.startDate && this.endDate && this.endDate > this.startDate) {
                    const diffTime = Math.abs(this.endDate - this.startDate);
                    this.days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                    if (this.days === 0) this.days = 1;
                } else {
                    this.days = 1;
                }

                this.rentTotal = this.days * this.pricePerDay;
                
                let servicesTotal = 0;
                if (this.services.driver) servicesTotal += this.serviceCosts.driver * this.days;
                if (this.services.insurance) servicesTotal += this.serviceCosts.insurance * this.days;

                this.totalPrice = this.rentTotal + servicesTotal;
            },

            toggleService(service) {
                this.services[service] = !this.services[service];
                this.calculate();
            },

            formatMoney(amount) {
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
            },

            isValidStep() {
                if (this.step === 1) {
                    return this.startDate && this.endDate && this.endDate > this.startDate;
                }
                return true;
            },

            nextStep() {
                if (this.isValidStep()) {
                    this.step++;
                }
            },

            prevStep() {
                if (this.step > 1) {
                    this.step--;
                }
            },
            
            submitForm(e) {
                 e.target.submit();
            }
        }
    }
</script>
@endsection