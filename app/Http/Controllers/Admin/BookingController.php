<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Booking::query()
            ->with(['user', 'guide']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn ($u) => $u->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"))
                    ->orWhereHas('guide', fn ($g) => $g->where('full_name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('end_date', '<=', $request->input('to_date'));
        }

        $bookings = $query->latest('id')->paginate(15)->withQueryString();
        $statusLabels = Booking::statusLabels();

        return view('admin.bookings.index', compact('bookings', 'statusLabels'));
    }

    public function show(Booking $booking): View
    {
        $booking->load(['user', 'guide.languages', 'guide.locations']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking): RedirectResponse
    {
        if (! $booking->canConfirm()) {
            return back()->withErrors(['error' => 'Không thể xác nhận lịch đặt này.']);
        }

        $booking->update(['status' => Booking::STATUS_CONFIRMED]);

        return back()->with('success', 'Đã xác nhận lịch đặt #' . $booking->id);
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        if (! $booking->canCancel()) {
            return back()->withErrors(['error' => 'Không thể hủy lịch đặt này.']);
        }

        $booking->update(['status' => Booking::STATUS_CANCELLED]);

        return back()->with('success', 'Đã hủy lịch đặt #' . $booking->id);
    }

    public function complete(Booking $booking): RedirectResponse
    {
        if (! $booking->canComplete()) {
            return back()->withErrors(['error' => 'Không thể đánh dấu hoàn thành lịch đặt này.']);
        }

        $booking->update(['status' => Booking::STATUS_COMPLETED]);

        return back()->with('success', 'Đã hoàn thành lịch đặt #' . $booking->id);
    }
}
