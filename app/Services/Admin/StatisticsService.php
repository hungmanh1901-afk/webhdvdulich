<?php

namespace App\Services\Admin;

use App\Models\Booking;
use App\Models\Guide;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsService
{
    public function overview(): array
    {
        $revenueStatuses = [Booking::STATUS_CONFIRMED, Booking::STATUS_COMPLETED];

        return [
            'total_customers' => User::where('role', User::ROLE_CUSTOMER)->count(),
            'total_guides' => Guide::count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', Booking::STATUS_PENDING)->count(),
            'total_revenue' => (float) Booking::whereIn('status', $revenueStatuses)->sum('total_price'),
            'month_revenue' => (float) Booking::whereIn('status', $revenueStatuses)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_price'),
        ];
    }

    public function bookingsByStatus(): array
    {
        $labels = [
            Booking::STATUS_PENDING => 'Chờ xác nhận',
            Booking::STATUS_CONFIRMED => 'Đã xác nhận',
            Booking::STATUS_CANCELLED => 'Đã hủy',
            Booking::STATUS_COMPLETED => 'Hoàn thành',
        ];

        $counts = Booking::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $data = [];
        foreach ($labels as $status => $label) {
            $data[] = [
                'label' => $label,
                'value' => (int) ($counts[$status] ?? 0),
            ];
        }

        return $data;
    }

    public function revenueByStatus(): array
    {
        $labels = [
            Booking::STATUS_PENDING => 'Chờ xác nhận',
            Booking::STATUS_CONFIRMED => 'Đã xác nhận',
            Booking::STATUS_CANCELLED => 'Đã hủy',
            Booking::STATUS_COMPLETED => 'Hoàn thành',
        ];

        $sums = Booking::query()
            ->select('status', DB::raw('SUM(total_price) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $data = [];
        foreach ($labels as $status => $label) {
            $data[] = [
                'label' => $label,
                'value' => (float) ($sums[$status] ?? 0),
            ];
        }

        return $data;
    }

    public function monthlyBookings(int $months = 12): array
    {
        $start = now()->subMonths($months - 1)->startOfMonth();

        $rows = Booking::query()
            ->where('created_at', '>=', $start)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return $this->fillMonths($start, $months, $rows, 'value');
    }

    public function monthlyRevenue(int $months = 12): array
    {
        $start = now()->subMonths($months - 1)->startOfMonth();

        $rows = Booking::query()
            ->whereIn('status', [Booking::STATUS_CONFIRMED, Booking::STATUS_COMPLETED])
            ->where('created_at', '>=', $start)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return $this->fillMonths($start, $months, $rows, 'value', true);
    }

    public function topGuides(int $limit = 5): array
    {
        return Guide::query()
            ->withCount('bookings')
            ->orderByDesc('bookings_count')
            ->limit($limit)
            ->get()
            ->map(fn ($guide) => [
                'label' => $guide->full_name,
                'value' => $guide->bookings_count,
            ])
            ->all();
    }

    public function topCustomers(int $limit = 5): array
    {
        return User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->withCount('bookings')
            ->orderByDesc('bookings_count')
            ->limit($limit)
            ->get()
            ->map(fn ($user) => [
                'label' => $user->full_name,
                'value' => $user->bookings_count,
            ])
            ->all();
    }

    private function fillMonths(Carbon $start, int $months, $rows, string $valueKey, bool $float = false): array
    {
        $result = [];
        for ($i = 0; $i < $months; $i++) {
            $month = $start->copy()->addMonths($i)->format('Y-m');
            $label = $start->copy()->addMonths($i)->format('m/Y');
            $value = $rows[$month] ?? 0;
            $result[] = [
                'label' => $label,
                $valueKey => $float ? (float) $value : (int) $value,
            ];
        }

        return $result;
    }
}
