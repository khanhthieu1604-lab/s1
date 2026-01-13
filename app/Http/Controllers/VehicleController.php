<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    /**
     * Homepage vehicle showcase - displays 8 latest available vehicles
     */
    public function home()
    {
        $vehicles = Vehicle::with('brand')
            ->where('status', 'available')
            ->latest()
            ->take(8)
            ->get();

        return view('welcome', compact('vehicles'));
    }

    /**
     * Vehicle listing with search, category, and price filters
     * Supports AJAX requests for dynamic filtering
     */
    public function index(Request $request)
    {
        $query = Vehicle::with('brand')->where('status', 'available');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('category')) {
            $query->where('type', $request->category);
        }

        if ($request->filled('price')) {
            if ($request->price == 'under_1m') {
                $query->where('price', '<', 1000000);
            } elseif ($request->price == 'above_2m') {
                $query->where('price', '>', 2000000);
            }
        }

        $vehicles = $query->latest()->paginate(12)->withQueryString();

        if ($request->ajax()) {
            return view('vehicles._grid', compact('vehicles'));
        }

        return view('vehicles.index', compact('vehicles'));
    }

    public function show($id)
    {
        $vehicle = Vehicle::with(['brand', 'reviews.user'])->findOrFail($id);
        return view('vehicles.show', compact('vehicle'));
    }

    

    public function adminIndex()
    {
        $vehicles = Vehicle::with('brand')->latest()->paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('admin.vehicles.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'brand_id' => 'required',
            'type'     => 'required',
            'price'    => 'required|numeric',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->all();
        $data['status'] = 'available';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        } else {
            $data['image'] = 'https://images.unsplash.com/photo-1503376763036-066120622c74?q=80&w=800';
        }

        Vehicle::create($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Thêm siêu xe thành công!');
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $brands  = Brand::all();
        return view('admin.vehicles.edit', compact('vehicle', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $vehicle = Vehicle::findOrFail($id);
        $data    = $request->all();

        if ($request->hasFile('image')) {
            if ($vehicle->image && !str_starts_with($vehicle->image, 'http')) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Cập nhật thông tin xe thành công!');
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        if ($vehicle->image && !str_starts_with($vehicle->image, 'http')) {
            Storage::disk('public')->delete($vehicle->image);
        }
        $vehicle->delete();
        return back()->with('success', 'Đã xóa xe khỏi hệ thống.');
    }

    public function manage($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('admin.vehicles.manage', compact('vehicle'));
    }

    public function updateMaintenance(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        
        if ($vehicle->status == 'rented') {
            return back()->with('error', 'Xe đang được thuê, không thể bảo trì!');
        }

        $vehicle->update(['status' => $request->status]);
        return back()->with('success', 'Đã cập nhật trạng thái xe!');
    }

    /**
     * Development helper: Auto-generate sample vehicles and brands
     * Creates 6 luxury brands and 20 sample vehicles with random data
     * WARNING: Only accessible in local environment
     */
    public function autoGenerate()
    {
        if (Brand::count() == 0) {
            $brands = ['Rolls-Royce', 'Mercedes-Maybach', 'Ferrari', 'Lamborghini', 'Porsche', 'Bentley'];
            foreach ($brands as $b) {
                Brand::create(['name' => $b, 'logo' => 'https://placehold.co/100']);
            }
        }

        $luxuryImages = [
            'https://images.unsplash.com/photo-1617788138017-80ad40651399?q=80&w=800',
            'https://images.unsplash.com/photo-1503376763036-066120622c74?q=80&w=800',
            'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=800',
            'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=800',
            'https://images.unsplash.com/photo-1562141989-c5c79ac8f576?q=80&w=800',
            'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?q=80&w=800',
            'https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=800',
            'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=800',
        ];

        $types = ['Sedan', 'Coupe', 'SUV', 'Convertible'];
        $brandIds = Brand::pluck('id')->toArray();

        for ($i = 1; $i <= 20; $i++) {
            Vehicle::create([
                'name'        => 'Elite Supercar ' . $i . ' Edition',
                'brand_id'    => $brandIds[array_rand($brandIds)],
                'type'        => $types[array_rand($types)],
                'price'       => rand(2000, 20000) * 1000,
                'status'      => 'available',
                'image'       => $luxuryImages[array_rand($luxuryImages)],
                'description' => 'Trải nghiệm đỉnh cao với động cơ V8 Twin-Turbo, nội thất da Nappa thủ công.'
            ]);
        }

        return redirect()->route('home')->with('success', 'Đã khởi tạo hệ thống xe Elite thành công!');
    }
}