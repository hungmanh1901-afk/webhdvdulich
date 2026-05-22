@extends('layouts.admin')

@section('title', 'Thống kê')

@section('page_title', 'Thống kê')
@section('page_subtitle', 'Biểu đồ tổng quan hệ thống')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-lg-2">
            <div class="admin-stat-card text-center">
                <p class="text-muted small mb-1">Khách hàng</p>
                <h4 class="fw-bold mb-0 text-primary">{{ $overview['total_customers'] }}</h4>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="admin-stat-card text-center">
                <p class="text-muted small mb-1">HDV</p>
                <h4 class="fw-bold mb-0">{{ $overview['total_guides'] }}</h4>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="admin-stat-card text-center">
                <p class="text-muted small mb-1">Lịch đặt</p>
                <h4 class="fw-bold mb-0">{{ $overview['total_bookings'] }}</h4>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="admin-stat-card text-center">
                <p class="text-muted small mb-1">Chờ xác nhận</p>
                <h4 class="fw-bold mb-0 text-warning">{{ $overview['pending_bookings'] }}</h4>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="admin-stat-card text-center">
                <p class="text-muted small mb-1">Doanh thu</p>
                <h6 class="fw-bold mb-0 text-success">{{ number_format($overview['total_revenue'], 0, ',', '.') }}đ</h6>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="admin-stat-card text-center">
                <p class="text-muted small mb-1">Tháng này</p>
                <h6 class="fw-bold mb-0 text-success">{{ number_format($overview['month_revenue'], 0, ',', '.') }}đ</h6>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="admin-card">
                <h6 class="fw-bold mb-3">Lịch đặt theo trạng thái (Tròn)</h6>
                <div class="chart-wrap"><canvas id="chartBookingsPie"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="admin-card">
                <h6 class="fw-bold mb-3">Doanh thu theo trạng thái (Tròn)</h6>
                <div class="chart-wrap"><canvas id="chartRevenuePie"></canvas></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="admin-card">
                <h6 class="fw-bold mb-3">Số lịch đặt theo tháng (Cột)</h6>
                <div class="chart-wrap chart-wrap--tall"><canvas id="chartBookingsBar"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="admin-card">
                <h6 class="fw-bold mb-3">Doanh thu theo tháng (Cột)</h6>
                <div class="chart-wrap chart-wrap--tall"><canvas id="chartRevenueBar"></canvas></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-12">
            <div class="admin-card">
                <h6 class="fw-bold mb-3">Xu hướng lịch đặt & doanh thu 12 tháng (Đường)</h6>
                <div class="chart-wrap chart-wrap--tall"><canvas id="chartTrendLine"></canvas></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="admin-card">
                <h6 class="fw-bold mb-3">Top 5 hướng dẫn viên (Cột ngang)</h6>
                <div class="chart-wrap"><canvas id="chartTopGuides"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="admin-card">
                <h6 class="fw-bold mb-3">Top 5 khách hàng (Cột ngang)</h6>
                <div class="chart-wrap"><canvas id="chartTopCustomers"></canvas></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
(function () {
    const colors = ['#f59e0b', '#0d9488', '#ef4444', '#3b82f6', '#8b5cf6', '#64748b'];
    const chartDefaults = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
    };

    const bookingsByStatus = @json($bookingsByStatus);
    const revenueByStatus = @json($revenueByStatus);
    const monthlyBookings = @json($monthlyBookings);
    const monthlyRevenue = @json($monthlyRevenue);
    const topGuides = @json($topGuides);
    const topCustomers = @json($topCustomers);

    new Chart(document.getElementById('chartBookingsPie'), {
        type: 'doughnut',
        data: {
            labels: bookingsByStatus.map(i => i.label),
            datasets: [{
                data: bookingsByStatus.map(i => i.value),
                backgroundColor: colors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: chartDefaults
    });

    new Chart(document.getElementById('chartRevenuePie'), {
        type: 'pie',
        data: {
            labels: revenueByStatus.map(i => i.label),
            datasets: [{
                data: revenueByStatus.map(i => i.value),
                backgroundColor: colors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            ...chartDefaults,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: ctx => {
                            const v = ctx.raw || 0;
                            return ctx.label + ': ' + new Intl.NumberFormat('vi-VN').format(v) + ' đ';
                        }
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('chartBookingsBar'), {
        type: 'bar',
        data: {
            labels: monthlyBookings.map(i => i.label),
            datasets: [{
                label: 'Lịch đặt',
                data: monthlyBookings.map(i => i.value),
                backgroundColor: 'rgba(13, 148, 136, 0.75)',
                borderRadius: 6
            }]
        },
        options: {
            ...chartDefaults,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartRevenueBar'), {
        type: 'bar',
        data: {
            labels: monthlyRevenue.map(i => i.label),
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: monthlyRevenue.map(i => i.value),
                backgroundColor: 'rgba(245, 158, 11, 0.8)',
                borderRadius: 6
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: v => new Intl.NumberFormat('vi-VN', { notation: 'compact' }).format(v)
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('chartTrendLine'), {
        type: 'line',
        data: {
            labels: monthlyBookings.map(i => i.label),
            datasets: [
                {
                    label: 'Lịch đặt',
                    data: monthlyBookings.map(i => i.value),
                    borderColor: '#0d9488',
                    backgroundColor: 'rgba(13, 148, 136, 0.1)',
                    fill: true,
                    tension: 0.35,
                    yAxisID: 'y'
                },
                {
                    label: 'Doanh thu (triệu đ)',
                    data: monthlyRevenue.map(i => Math.round(i.value / 1000000 * 10) / 10),
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.08)',
                    fill: true,
                    tension: 0.35,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            scales: {
                y: { type: 'linear', position: 'left', beginAtZero: true, title: { display: true, text: 'Lịch đặt' } },
                y1: { type: 'linear', position: 'right', beginAtZero: true, grid: { drawOnChartArea: false }, title: { display: true, text: 'Triệu VNĐ' } }
            }
        }
    });

    new Chart(document.getElementById('chartTopGuides'), {
        type: 'bar',
        data: {
            labels: topGuides.map(i => i.label),
            datasets: [{
                label: 'Số lịch đặt',
                data: topGuides.map(i => i.value),
                backgroundColor: 'rgba(59, 130, 246, 0.75)',
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            ...chartDefaults,
            scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartTopCustomers'), {
        type: 'bar',
        data: {
            labels: topCustomers.map(i => i.label),
            datasets: [{
                label: 'Số lịch đặt',
                data: topCustomers.map(i => i.value),
                backgroundColor: 'rgba(139, 92, 246, 0.75)',
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            ...chartDefaults,
            scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
})();
</script>
@endpush
