<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\StatisticsService;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    public function __construct(
        private readonly StatisticsService $statistics
    ) {}

    public function index(): View
    {
        return view('admin.statistics.index', [
            'overview' => $this->statistics->overview(),
            'bookingsByStatus' => $this->statistics->bookingsByStatus(),
            'revenueByStatus' => $this->statistics->revenueByStatus(),
            'monthlyBookings' => $this->statistics->monthlyBookings(),
            'monthlyRevenue' => $this->statistics->monthlyRevenue(),
            'topGuides' => $this->statistics->topGuides(),
            'topCustomers' => $this->statistics->topCustomers(),
        ]);
    }
}
