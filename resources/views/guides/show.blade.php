@extends('layouts.app')

@section('title', $guide->full_name)

@section('content')
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('guides.index') }}">Hướng dẫn viên</a></li>
            <li class="breadcrumb-item active">{{ $guide->full_name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="admin-card text-center guide-detail-photo">
                @if ($guide->avatarUrl())
                    <img src="{{ $guide->avatarUrl() }}" alt="{{ $guide->full_name }}" class="guide-detail-img">
                @else
                    <span class="guide-detail-placeholder">{{ mb_strtoupper(mb_substr($guide->full_name, 0, 1)) }}</span>
                @endif
                <span class="badge mt-3 {{ $guide->status === 'available' ? 'text-bg-success' : 'text-bg-warning' }}">
                    {{ $guide->statusLabel() }}
                </span>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="admin-card h-100">
                <h1 class="h3 fw-bold mb-2">{{ $guide->full_name }}</h1>
                <p class="guide-detail-price mb-3">
                    {{ number_format($guide->price_per_day, 0, ',', '.') }} <span>đ / ngày</span>
                </p>
                <div class="row g-3 mb-3 small">
                    @if ($guide->genderLabel())
                        <div class="col-sm-6"><i class="bi bi-person text-primary me-2"></i>{{ $guide->genderLabel() }}</div>
                    @endif
                    <div class="col-sm-6"><i class="bi bi-award text-primary me-2"></i>{{ $guide->experience_years }} năm kinh nghiệm</div>
                    @if ($guide->phone)
                        <div class="col-sm-6"><i class="bi bi-telephone text-primary me-2"></i>{{ $guide->phone }}</div>
                    @endif
                    @if ($guide->email)
                        <div class="col-sm-6"><i class="bi bi-envelope text-primary me-2"></i>{{ $guide->email }}</div>
                    @endif
                    @if ($guide->address)
                        <div class="col-12"><i class="bi bi-geo text-primary me-2"></i>{{ $guide->address }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <strong class="d-block mb-2">Ngôn ngữ</strong>
                    @forelse ($guide->languages as $lang)
                        <span class="badge bg-primary bg-opacity-10 text-primary me-1 mb-1">{{ $lang->name }}</span>
                    @empty
                        <span class="text-muted">—</span>
                    @endforelse
                </div>
                <div class="mb-3">
                    <strong class="d-block mb-2">Địa điểm hoạt động</strong>
                    @forelse ($guide->locations as $loc)
                        <span class="badge bg-light text-dark border me-1 mb-1">{{ $loc->name }}</span>
                    @empty
                        <span class="text-muted">—</span>
                    @endforelse
                </div>
                @if ($guide->description)
                    <div>
                        <strong class="d-block mb-2">Giới thiệu</strong>
                        <p class="text-muted mb-0" style="white-space: pre-line">{{ $guide->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="admin-card mt-4" id="dat-lich">
        <h4 class="fw-bold mb-3"><i class="bi bi-calendar-plus me-2 text-primary"></i>Đặt lịch hướng dẫn</h4>

        @guest
            <div class="alert alert-info border-0">
                <a href="{{ route('login') }}" class="alert-link">Đăng nhập</a> hoặc
                <a href="{{ route('register') }}" class="alert-link">đăng ký</a> để đặt lịch hướng dẫn viên.
            </div>
        @else
            @if (! auth()->user()->isCustomer())
                <p class="text-muted mb-0">Tài khoản quản trị không thể đặt lịch. Vui lòng dùng tài khoản khách hàng.</p>
            @elseif (! $guide->canBeBooked())
                <div class="alert alert-warning border-0 mb-0">
                    Hướng dẫn viên hiện không ở trạng thái nhận đặt lịch.
                </div>
            @else
                <form action="{{ route('bookings.store', $guide) }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date"
                               class="form-control @error('start_date') is-invalid @enderror"
                               value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" id="end_date"
                               class="form-control @error('end_date') is-invalid @enderror"
                               value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" required>
                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <p class="small text-muted mb-2 w-100" id="priceEstimate">
                            Giá: <strong>{{ number_format($guide->price_per_day, 0, ',', '.') }} đ/ngày</strong>
                        </p>
                    </div>
                    <div class="col-12">
                        <label for="note" class="form-label">Ghi chú</label>
                        <textarea name="note" id="note" rows="3" class="form-control"
                                  placeholder="Yêu cầu đặc biệt, số người, điểm đón...">{{ old('note') }}</textarea>
                    </div>
                    @error('guide')<div class="col-12"><div class="alert alert-danger py-2 mb-0">{{ $message }}</div></div>@enderror
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-1"></i> Gửi yêu cầu đặt lịch
                        </button>
                    </div>
                </form>
            @endif
        @endguest
    </div>
@endsection

@push('scripts')
<script>
(function () {
    const pricePerDay = {{ (float) $guide->price_per_day }};
    const start = document.getElementById('start_date');
    const end = document.getElementById('end_date');
    const estimate = document.getElementById('priceEstimate');
    function updateEstimate() {
        if (!start?.value || !end?.value || !estimate) return;
        const s = new Date(start.value);
        const e = new Date(end.value);
        if (e < s) return;
        const days = Math.ceil((e - s) / (1000 * 60 * 60 * 24)) + 1;
        const total = days * pricePerDay;
        estimate.innerHTML = 'Ước tính: <strong>' + days + ' ngày</strong> × ' +
            new Intl.NumberFormat('vi-VN').format(pricePerDay) + ' đ = <strong class="text-primary">' +
            new Intl.NumberFormat('vi-VN').format(total) + ' đ</strong>';
    }
    start?.addEventListener('change', function () {
        if (end && start.value) end.min = start.value;
        updateEstimate();
    });
    end?.addEventListener('change', updateEstimate);
})();
</script>
@endpush
