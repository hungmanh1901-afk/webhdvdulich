@extends('layouts.admin')

@section('title', 'Chi tiết khách hàng')

@section('page_title', $customer->full_name)
@section('page_subtitle', 'Thông tin khách hàng và lịch sử đặt lịch')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-lg-5">
            <div class="admin-card">
                <h5 class="fw-bold mb-3">Thông tin tài khoản</h5>
                <dl class="row mb-0 small">
                    <dt class="col-sm-4 text-muted">Email</dt>
                    <dd class="col-sm-8">{{ $customer->email }}</dd>
                    <dt class="col-sm-4 text-muted">SĐT</dt>
                    <dd class="col-sm-8">{{ $customer->phone ?? '—' }}</dd>
                    <dt class="col-sm-4 text-muted">Địa chỉ</dt>
                    <dd class="col-sm-8">{{ $customer->address ?? '—' }}</dd>
                    <dt class="col-sm-4 text-muted">Ngày tạo</dt>
                    <dd class="col-sm-8">{{ $customer->created_at?->format('d/m/Y H:i') }}</dd>
                    <dt class="col-sm-4 text-muted">Tổng lịch đặt</dt>
                    <dd class="col-sm-8"><strong>{{ $customer->bookings_count }}</strong></dd>
                </dl>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil me-1"></i> Sửa
                    </a>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-light btn-sm">Quay lại</a>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card p-0 overflow-hidden">
        <div class="p-3 border-bottom">
            <h5 class="fw-bold mb-0">Lịch sử đặt lịch</h5>
        </div>
        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>HDV</th>
                        <th>Ngày tour</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            <td>{{ $booking->guide?->full_name }}</td>
                            <td class="small">
                                {{ $booking->start_date->format('d/m/Y') }} — {{ $booking->end_date->format('d/m/Y') }}
                                <span class="text-muted">({{ $booking->daysCount() }} ngày)</span>
                            </td>
                            <td class="fw-semibold">{{ number_format($booking->total_price, 0, ',', '.') }} đ</td>
                            <td>@include('admin.partials.booking-status', ['status' => $booking->status])</td>
                            <td class="text-end">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-light">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Chưa có lịch đặt.</td>
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
