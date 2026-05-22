@extends('layouts.app')

@section('title', 'Lịch đặt của tôi')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Lịch đặt của tôi</h1>
            <p class="text-muted mb-0">Theo dõi trạng thái các lịch hướng dẫn viên đã đặt</p>
        </div>
        <a href="{{ route('guides.index') }}" class="btn btn-primary">
            <i class="bi bi-search me-1"></i> Tìm HDV
        </a>
    </div>

    @include('components.alert')

    <form method="GET" class="admin-card mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Lọc trạng thái</label>
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    @foreach ($statusLabels as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    @forelse ($bookings as $booking)
        <div class="booking-history-card admin-card mb-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-2 col-lg-1 text-muted small">#{{ $booking->id }}</div>
                <div class="col-md-3 col-lg-2">
                    @if ($booking->guide?->avatarUrl())
                        <img src="{{ $booking->guide->avatarUrl() }}" class="guide-table-avatar" alt="">
                    @endif
                </div>
                <div class="col-md-7 col-lg-4">
                    <h5 class="fw-bold mb-1">
                        <a href="{{ route('guides.show', $booking->guide) }}" class="text-decoration-none text-dark">
                            {{ $booking->guide?->full_name }}
                        </a>
                    </h5>
                    <p class="small text-muted mb-0">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $booking->start_date->format('d/m/Y') }} — {{ $booking->end_date->format('d/m/Y') }}
                        ({{ $booking->daysCount() }} ngày)
                    </p>
                    <p class="small text-muted mb-0">Đặt ngày: {{ $booking->booking_date->format('d/m/Y') }}</p>
                </div>
                <div class="col-6 col-lg-2">
                    <span class="fw-bold text-primary">{{ number_format($booking->total_price, 0, ',', '.') }} đ</span>
                </div>
                <div class="col-6 col-lg-2">
                    @include('admin.partials.booking-status', ['status' => $booking->status])
                </div>
                <div class="col-lg-1 text-lg-end">
                    <a href="{{ route('guides.show', $booking->guide) }}" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                </div>
            </div>
            @if ($booking->note)
                <p class="small text-muted mb-0 mt-2 border-top pt-2"><strong>Ghi chú:</strong> {{ $booking->note }}</p>
            @endif
        </div>
    @empty
        <div class="admin-card text-center py-5">
            <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
            <h5 class="fw-bold">Chưa có lịch đặt nào</h5>
            <p class="text-muted mb-3">Hãy tìm hướng dẫn viên và đặt lịch ngay.</p>
            <a href="{{ route('guides.index') }}" class="btn btn-primary">Khám phá hướng dẫn viên</a>
        </div>
    @endforelse

    @if ($bookings->hasPages())
        <div class="mt-3">{{ $bookings->links() }}</div>
    @endif
@endsection
