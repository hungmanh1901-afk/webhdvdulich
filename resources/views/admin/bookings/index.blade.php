@extends('layouts.admin')

@section('title', 'Quản lý lịch đặt')

@section('page_title', 'Lịch đặt')
@section('page_subtitle', 'Xác nhận, hủy và theo dõi lịch đặt hướng dẫn viên')

@section('content')
    <form method="GET" class="admin-card mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả</option>
                    @foreach ($statusLabels as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Từ ngày</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Đến ngày</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="q" class="form-control" value="{{ request('q') }}"
                       placeholder="Khách, HDV...">
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Lọc</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-light">Xóa lọc</a>
            </div>
        </div>
    </form>

    <div class="admin-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Khách hàng</th>
                        <th>Hướng dẫn viên</th>
                        <th>Ngày đặt</th>
                        <th>Ngày tour</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td><strong>#{{ $booking->id }}</strong></td>
                            <td>
                                <a href="{{ route('admin.customers.show', $booking->user) }}" class="text-decoration-none">
                                    {{ $booking->user?->full_name }}
                                </a>
                            </td>
                            <td>{{ $booking->guide?->full_name }}</td>
                            <td class="small">{{ $booking->booking_date->format('d/m/Y') }}</td>
                            <td class="small">
                                {{ $booking->start_date->format('d/m/Y') }} — {{ $booking->end_date->format('d/m/Y') }}
                            </td>
                            <td class="fw-semibold">{{ number_format($booking->total_price, 0, ',', '.') }} đ</td>
                            <td>@include('admin.partials.booking-status', ['status' => $booking->status])</td>
                            <td class="text-end">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-primary">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">Không có lịch đặt phù hợp.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($bookings->hasPages())
            <div class="p-3 border-top">{{ $bookings->links() }}</div>
        @endif
    </div>
@endsection
