<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * Admin vehicle management controller
 * Handles CRUD operations for vehicles with image upload functionality
 */
class VehicleManagerController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    /**
     * Store new vehicle with optional image upload
     * Images are stored in public/uploads/vehicles/
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'brand'              => 'required|string|max:255',
            'type'               => 'required|string',
            'rent_price_per_day' => 'required|numeric|min:0',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description'        => 'nullable',
        ]);

        $data = $request->all();
        $data['status'] = 'available';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/vehicles');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $file->move($path, $filename);
            $data['image'] = 'uploads/vehicles/' . $filename;
        }

        Vehicle::create($data);

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Thêm xe thành công!');
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update vehicle and optionally replace image
     * Old image will be deleted if new one is uploaded
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'name'               => 'required|string|max:255',
            'brand'              => 'required|string|max:255',
            'rent_price_per_day' => 'required|numeric|min:0',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'             => 'required|in:available,rented,maintenance',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            if ($vehicle->image && File::exists(public_path($vehicle->image))) {
                File::delete(public_path($vehicle->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/vehicles'), $filename);
            $data['image'] = 'uploads/vehicles/' . $filename;
        }

        $vehicle->update($data);

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Cập nhật thông tin xe thành công!');
    }

    /**
     * Delete vehicle and its associated image file
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if ($vehicle->image && File::exists(public_path($vehicle->image))) {
            File::delete(public_path($vehicle->image));
        }

        $vehicle->delete();

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Đã xóa xe khỏi hệ thống!');
    }

    public function manage($id)
    {
        $vehicle = Vehicle::with('maintenances')->findOrFail($id);
        return view('admin.vehicles.manage', compact('vehicle'));
    }
}
