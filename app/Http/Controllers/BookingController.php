<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * Booking management controller
 * Handles rental booking creation, history, and status management
 */
class BookingController extends Controller
{
    public function create($vehicle_id)
    {
        $vehicle = Vehicle::with('brand')->findOrFail($vehicle_id);

        if ($vehicle->status !== 'available') {
            return redirect()
                ->back()
                ->with('error', 'Rất tiếc, xe này hiện không khả dụng.');
        }

        return view('bookings.create', compact('vehicle'));
    }

    /**
     * Store new booking with automatic price calculation
     * Price = number_of_days * vehicle_daily_price (minimum 1 day)
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
        ], [
            'start_date.after_or_equal' => 'Ngày nhận xe không được chọn trong quá khứ.',
            'end_date.after'            => 'Ngày trả xe phải sau ngày nhận xe.',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end);

        if ($days < 1) {
            $days = 1;
        }

        $totalPrice = $days * $vehicle->price;

        $booking = Booking::create([
            'user_id'     => Auth::id(),
            'vehicle_id'  => $vehicle->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'total_price' => $totalPrice,
            'status'      => 'pending',
            'note'        => $request->note,
        ]);

        return redirect()->route(
            'payment.create',
            ['booking' => $booking->id]
        );
    }

    public function history()
    {
        $bookings = Booking::with(['vehicle', 'review'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(5);

        return view('bookings.history', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['vehicle.brand', 'user'])
            ->findOrFail($id);

        if (
            $booking->user_id !== Auth::id()
            && Auth::user()->role !== 'admin'
        ) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này.');
        }

        return view('bookings.show', compact('booking'));
    }

    public function showContract($id)
    {
        $booking = Booking::with(['vehicle', 'user'])
            ->findOrFail($id);

        if (
            $booking->user_id !== Auth::id()
            && Auth::user()->role !== 'admin'
        ) {
            abort(403, 'Bạn không có quyền xem hợp đồng này.');
        }

        return view('bookings.contract', compact('booking'));
    }

    // API Methods

    public function apiStore(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end);
        
        if ($days < 1) {
            $days = 1;
        }

        $totalPrice = $days * $vehicle->price;

        $booking = Booking::create([
            'user_id'     => Auth::id(),
            'vehicle_id'  => $vehicle->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'total_price' => $totalPrice,
            'status'      => 'pending',
            'note'        => $request->note,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Đặt xe thành công!',
            'data'    => $booking->load('vehicle')
        ], 201);
    }

    public function apiHistory()
    {
        $bookings = Booking::with('vehicle')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $bookings
        ], 200);
    }

    public function apiAllBookings()
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(
                ['message' => 'Forbidden'],
                403
            );
        }

        return response()->json([
            'data' => Booking::with(['vehicle', 'user'])
                ->latest()
                ->get()
        ]);
    }

    /**
     * Update booking status and sync vehicle availability
     * - confirmed: vehicle becomes 'rented'
     * - completed/cancelled: vehicle returns to 'available'
     */
    public function apiUpdateStatus(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(
                ['message' => 'Forbidden'],
                403
            );
        }

        $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        if ($request->status === 'confirmed') {
            $booking->vehicle->update(['status' => 'rented']);
        } elseif (in_array($request->status, ['completed', 'cancelled'])) {
            $booking->vehicle->update(['status' => 'available']);
        }

        return response()->json([
            'message' => 'Success',
            'data'    => $booking
        ]);
    }
}
