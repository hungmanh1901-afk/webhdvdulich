@extends('layouts.admin')

@section('title', 'Chi tiết lịch đặt #' . $booking->id)

@section('page_title', 'Lịch đặt #' . $booking->id)
@section('page_subtitle', $booking->statusLabel())

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
                    <h5 class="fw-bold mb-0">Thông tin đặt lịch</h5>
                    @include('admin.partials.booking-status', ['status' => $booking->status])
                </div>
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Ngày đặt</dt>
                    <dd class="col-sm-8">{{ $booking->booking_date->format('d/m/Y') }}</dd>
                    <dt class="col-sm-4 text-muted">Ngày bắt đầu</dt>
                    <dd class="col-sm-8">{{ $booking->start_date->format('d/m/Y') }}</dd>
                    <dt class="col-sm-4 text-muted">Ngày kết thúc</dt>
                    <dd class="col-sm-8">{{ $booking->end_date->format('d/m/Y') }}</dd>
                    <dt class="col-sm-4 text-muted">Số ngày</dt>
                    <dd class="col-sm-8">{{ $booking->daysCount() }} ngày</dd>
                    <dt class="col-sm-4 text-muted">Tổng tiền</dt>
                    <dd class="col-sm-8 fs-5 fw-bold text-primary">{{ number_format($booking->total_price, 0, ',', '.') }} đ</dd>
                    <dt class="col-sm-4 text-muted">Ghi chú</dt>
                    <dd class="col-sm-8">{{ $booking->note ?: '—' }}</dd>
                    <dt class="col-sm-4 text-muted">Ngày tạo</dt>
                    <dd class="col-sm-8">{{ $booking->created_at?->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="admin-card h-100">
                        <h6 class="fw-bold mb-3"><i class="bi bi-person me-1"></i> Khách hàng</h6>
                        <p class="mb-1"><strong>{{ $booking->user->full_name }}</strong></p>
                        <p class="mb-1 small">{{ $booking->user->email }}</p>
                        <p class="mb-1 small">{{ $booking->user->phone ?? '—' }}</p>
                        <a href="{{ route('admin.customers.show', $booking->user) }}" class="btn btn-sm btn-outline-primary mt-2">
                            Xem khách hàng
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="admin-card h-100">
                        <h6 class="fw-bold mb-3"><i class="bi bi-person-badge me-1"></i> Hướng dẫn viên</h6>
                        <div class="d-flex gap-3 align-items-center mb-2">
                            @if ($booking->guide->avatarUrl())
                                <img src="{{ $booking->guide->avatarUrl() }}" class="guide-table-avatar" alt="">
                            @endif
                            <div>
                                <p class="mb-0 fw-bold">{{ $booking->guide->full_name }}</p>
                                <p class="mb-0 small text-muted">{{ number_format($booking->guide->price_per_day, 0, ',', '.') }} đ/ngày</p>
                            </div>
                        </div>
                        <p class="small mb-1">
                            <strong>Ngôn ngữ:</strong>
                            {{ $booking->guide->languages->pluck('name')->join(', ') ?: '—' }}
                        </p>
                        <p class="small mb-0">
                            <strong>Địa điểm:</strong>
                            {{ $booking->guide->locations->pluck('name')->join(', ') ?: '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card">
                <h6 class="fw-bold mb-3">Xử lý lịch đặt</h6>
                <div class="d-grid gap-2">
                    @if ($booking->canConfirm())
                        <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check-circle me-1"></i> Xác nhận
                            </button>
                        </form>
                    @endif
                    @if ($booking->canComplete())
                        <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-flag me-1"></i> Hoàn thành
                            </button>
                        </form>
                    @endif
                    @if ($booking->canCancel())
                        <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST"
                              onsubmit="return confirm('Bạn có chắc muốn hủy lịch đặt này?');">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-x-circle me-1"></i> Hủy lịch
                            </button>
                        </form>
                    @endif
                    @if (! $booking->canConfirm() && ! $booking->canCancel() && ! $booking->canComplete())
                        <p class="text-muted small mb-0">Lịch đặt đã ở trạng thái cuối, không thể thay đổi.</p>
                    @endif
                </div>
                <hr>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-light w-100">Quay lại danh sách</a>
            </div>
        </div>
    </div>
@endsection
