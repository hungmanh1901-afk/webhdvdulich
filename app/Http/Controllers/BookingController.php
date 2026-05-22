<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Guide;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $bookings = $request->user()
            ->bookings()
            ->with('guide')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('bookings.index', [
            'bookings' => $bookings,
            'statusLabels' => Booking::statusLabels(),
        ]);
    }

    public function store(StoreBookingRequest $request, Guide $guide): RedirectResponse
    {
        $start = Carbon::parse($request->input('start_date'));
        $end = Carbon::parse($request->input('end_date'));
        $days = $start->diffInDays($end) + 1;

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'guide_id' => $guide->id,
            'booking_date' => now()->toDateString(),
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'total_price' => $guide->price_per_day * $days,
            'note' => $request->input('note'),
            'status' => Booking::STATUS_PENDING,
        ]);

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Đặt lịch thành công! Mã đặt lịch #' . $booking->id . ' — đang chờ xác nhận.');
    }
}
