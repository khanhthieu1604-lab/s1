<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    
    private function checkAdmin()
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'master')) {
            return false;
        }
        return true;
    }

    public function stats()
    {
        if (!$this->checkAdmin()) abort(403);

        $revenue = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalVehicles = Vehicle::count();
        $availableCars = Vehicle::where('status', 'available')->count();
        $rentedCars    = Vehicle::where('status', 'rented')->count();
        $totalUsers = User::where('role', 'user')->count();

        // Revenue Chart Data (Last 7 Days)
        $revenueData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayRevenue = Booking::whereIn('status', ['confirmed', 'completed'])
                ->whereDate('created_at', $date)
                ->sum('total_price');
            
            $revenueData[] = $dayRevenue;
            $chartLabels[] = $date->format('D'); // Mon, Tue...
        }

        return response()->json([
            'revenue' => number_format($revenue),
            'pendingBookings' => $pendingBookings,
            'totalVehicles' => $totalVehicles,
            'availableCars' => $availableCars,
            'rentedCars' => $rentedCars,
            'totalUsers' => $totalUsers,
            'revenueData' => $revenueData,
            'chartLabels' => $chartLabels
        ]);
    }

    
    public function index()
    {
        if (!$this->checkAdmin()) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập!');
        }

        
        $revenue = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $pendingBookings = Booking::where('status', 'pending')->count();

        
        $totalVehicles = Vehicle::count();
        $availableCars = Vehicle::where('status', 'available')->count();
        $rentedCars    = Vehicle::where('status', 'rented')->count();

        
        $totalUsers = User::where('role', 'user')->count();

        
        $recentBookings = Booking::with(['user', 'vehicle'])
            ->latest()
            ->take(5)
            ->get();

        
        $allUsers = User::latest()->paginate(10);

        // Revenue Chart Data (Last 7 Days)
        $revenueData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayRevenue = Booking::whereIn('status', ['confirmed', 'completed'])
                ->whereDate('created_at', $date)
                ->sum('total_price');
            
            $revenueData[] = $dayRevenue;
            $chartLabels[] = $date->format('D'); // Mon, Tue...
        }

        return view('admin.dashboard', compact(
            'revenue', 
            'pendingBookings', 
            'totalVehicles', 
            'availableCars', 
            'rentedCars', 
            'totalUsers', 
            'recentBookings',
            'allUsers',
            'revenueData',
            'chartLabels'
        ));
    }

    
    public function serviceReviews()
    {
        if (!$this->checkAdmin()) abort(403);

        $reviews = Review::with(['user', 'vehicle'])->latest()->paginate(15);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    
    public function updateAbout(Request $request)
    {
        if (!$this->checkAdmin()) abort(403);

        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_desc' => 'required|string',
            'hero_bg' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        
        if ($request->hasFile('hero_bg')) {
            $path = $request->file('hero_bg')->store('about', 'public');
            
        }

        return back()->with('success', 'Đã cập nhật nội dung trang Về chúng tôi thành công!');
    }

    
    public function updateStatus(Request $request, $id)
    {
        if (!$this->checkAdmin()) abort(403);

        $booking = Booking::findOrFail($id);
        $status = $request->status;

        $booking->update(['status' => $status]);

        if ($status == 'confirmed') {
            $booking->vehicle->update(['status' => 'rented']);
        } elseif ($status == 'completed' || $status == 'cancelled') {
            $booking->vehicle->update(['status' => 'available']);
        }

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng #' . $id);
    }

    
    public function usersIndex()
    {
        if (!$this->checkAdmin()) abort(403);

        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    
    public function updateUserRole($id)
    {
        if (!$this->checkAdmin()) abort(403);

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể thay đổi quyền của chính mình!');
        }

        
        $user->role = ($user->role === 'admin') ? 'user' : 'admin';
        $user->save();

        return back()->with('success', "Đã thay đổi quyền của {$user->name} thành " . strtoupper($user->role));
    }

    
    public function deleteUser($id)
    {
        if (!$this->checkAdmin()) abort(403);

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể xóa chính mình!');
        }

        $user->delete();
        return back()->with('success', 'Đã xóa thành viên khỏi hệ thống.');
    }
}