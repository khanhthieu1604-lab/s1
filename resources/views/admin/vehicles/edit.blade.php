@extends('layouts.app')

@section('content')
<div class="bg-gray-100 dark:bg-[#0a0a0a] min-h-screen py-8 font-sans text-sm transition-colors duration-300">
    <div class="container mx-auto px-4 max-w-7xl">
        
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white flex items-center gap-2 uppercase">
                    <i class="fa-solid fa-pen-to-square text-blue-600"></i> Cập nhật thông tin xe
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">Chỉnh sửa thông tin chi tiết cho xe: <span class="font-bold text-blue-600">{{ $vehicle->name }}</span></p>
            </div>
            <a href="{{ route('admin.vehicles.index') }}" class="bg-white dark:bg-[#121212] border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-800 font-bold py-2.5 px-5 rounded-xl shadow-sm transition flex items-center text-xs uppercase">
                <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
            </a>
        </div>

        <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm p-6 border border-gray-200 dark:border-gray-800">
                        <h3 class="text-lg font-black text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-800 pb-2 uppercase">Thông tin cơ bản</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="col-span-2">
                                <label class="block text-[10px] font-black text-gray-500 uppercase mb-2">Tên xe <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $vehicle->name) }}" required 
                                    class="w-full bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition font-bold text-gray-900 dark:text-white placeholder-gray-400"
                                    placeholder="Ví dụ: Mazda CX-5 Premium">
                            </div>

                            
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase mb-2">Hãng sản xuất</label>
                                <select name="brand_id" class="w-full bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-600 dark:text-white font-medium">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $vehicle->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase mb-2">Phân khúc</label>
                                <select name="type" class="w-full bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-600 dark:text-white font-medium">
                                    <option value="Sedan" {{ $vehicle->type == 'Sedan' ? 'selected' : '' }}>Sedan (4 chỗ)</option>
                                    <option value="SUV" {{ $vehicle->type == 'SUV' ? 'selected' : '' }}>SUV (5-7 chỗ)</option>
                                    <option value="Hatchback" {{ $vehicle->type == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                    <option value="Luxury" {{ $vehicle->type == 'Luxury' ? 'selected' : '' }}>Xe Sang / Mui trần</option>
                                    <option value="Limousine" {{ $vehicle->type == 'Limousine' ? 'selected' : '' }}>Limousine VIP</option>
                                </select>
                            </div>

                            
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase mb-2">Giá thuê / ngày <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="price" value="{{ old('price', $vehicle->price) }}" required 
                                        class="w-full bg-blue-50 dark:bg-blue-900/10 border border-blue-200 dark:border-blue-800 rounded-lg pl-4 pr-12 py-3 focus:outline-none focus:border-blue-600 text-blue-700 dark:text-blue-400 font-black text-lg" placeholder="0">
                                    <span class="absolute right-4 top-4 text-blue-600 dark:text-blue-400 text-xs font-bold">VNĐ</span>
                                </div>
                            </div>

                            
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase mb-2">Trạng thái hiện tại</label>
                                <div class="w-full bg-gray-100 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg px-4 py-3 text-gray-500 dark:text-gray-400 font-bold cursor-not-allowed flex justify-between items-center">
                                    <span>{{ strtoupper($vehicle->status) }}</span>
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </div>
                                <p class="text-[9px] text-gray-400 mt-1 italic">* Để đổi trạng thái (Bảo trì/Mở lại), vui lòng dùng chức năng "Bảo trì".</p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm p-6 border border-gray-200 dark:border-gray-800">
                        <label class="block text-[10px] font-black text-gray-500 uppercase mb-2">Mô tả chi tiết</label>
                        <textarea name="description" rows="5" class="w-full bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-600 dark:text-white transition" placeholder="Nhập thông tin chi tiết về xe (màu sắc, biển số, tiện nghi...)...">{{ old('description', $vehicle->description) }}</textarea>
                    </div>
                </div>

                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm p-6 border border-gray-200 dark:border-gray-800">
                        <h3 class="text-lg font-black text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-800 pb-2 uppercase">Hình ảnh xe</h3>
                        
                        <div class="mb-6">
                            <label class="block text-[10px] font-black text-gray-500 uppercase mb-2">Ảnh hiện tại</label>
                            <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 relative group">
                                <img src="{{ str_starts_with($vehicle->image, 'http') ? $vehicle->image : asset('storage/' . $vehicle->image) }}" 
                                     class="h-40 w-full object-cover rounded-md" onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=400'"> 
                                     class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase mb-2">Cập nhật ảnh mới</label>
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl cursor-pointer bg-gray-50 dark:bg-zinc-900 hover:bg-blue-50 dark:hover:bg-blue-900/10 hover:border-blue-400 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400 mb-2"></i>
                                    <p class="text-xs text-gray-500 font-semibold">Click để chọn ảnh mới</p>
                                </div>
                                <input name="image" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm p-6 border border-gray-200 dark:border-gray-800">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl shadow-lg shadow-blue-600/30 transform active:scale-95 transition duration-200 uppercase tracking-wide text-xs flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
                        </button>
                        <a href="{{ route('admin.vehicles.index') }}" class="block text-center mt-4 text-xs font-bold text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                            Hủy bỏ
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection