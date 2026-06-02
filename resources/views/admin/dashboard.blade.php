@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('page_title', 'Bảng điều khiển')
@section('page_subtitle', 'Tổng quan hệ thống quản lý hướng dẫn viên')

@section('content')
    <div class="row g-4">
        <div class="col-md-4">
            <div class="admin-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Hướng dẫn viên</p>
                        <h4 class="fw-bold mb-0">{{ \App\Models\Guide::count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Lịch đặt</p>
                        <h4 class="fw-bold mb-0">{{ \App\Models\Booking::count() }}</h4>
                        <small class="text-warning">{{ \App\Models\Booking::where('status', 'pending')->count() }} chờ xác nhận</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Khách hàng</p>
                        <h4 class="fw-bold mb-0">{{ \App\Models\User::where('role', 'customer')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card mt-4">
        <h5 class="fw-bold mb-3">Truy cập nhanh</h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.guides.index') }}" class="btn btn-primary">
                <i class="bi bi-person-badge me-1"></i> Hướng dẫn viên
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-calendar-check me-1"></i> Lịch đặt
            </a>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-people me-1"></i> Khách hàng
            </a>
            <a href="{{ route('admin.statistics.index') }}" class="btn btn-accent">
                <i class="bi bi-bar-chart me-1"></i> Thống kê
            </a>
        </div>
    </div>
@endsection
