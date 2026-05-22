@extends('layouts.app')

@section('title', 'Hướng dẫn viên')

@section('content')
    <div class="page-header mb-4">
        <h1 class="h3 fw-bold mb-1">Hướng dẫn viên du lịch</h1>
        <p class="text-muted mb-0">Tìm theo địa điểm, ngôn ngữ và mức giá phù hợp với bạn</p>
    </div>

    <div class="search-panel admin-card mb-4">
        <form method="GET" action="{{ route('guides.index') }}" id="searchForm">
            <div class="row g-3">
                <div class="col-lg-4">
                    <label class="form-label">Từ khóa</label>
                    <input type="text" name="q" class="form-control" value="{{ $filters['q'] ?? '' }}"
                           placeholder="Tên, mô tả, địa chỉ...">
                </div>
                <div class="col-md-6 col-lg-4">
                    <label class="form-label">Địa điểm</label>
                    <select name="location_id" class="form-select">
                        <option value="">Tất cả địa điểm</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}" @selected(($filters['location_id'] ?? '') == $location->id)>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 col-lg-4">
                    <label class="form-label">Ngôn ngữ</label>
                    <select name="language_id" class="form-select">
                        <option value="">Tất cả ngôn ngữ</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}" @selected(($filters['language_id'] ?? '') == $language->id)>
                                {{ $language->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-lg-3">
                    <label class="form-label">Giá tối thiểu (đ/ngày)</label>
                    <input type="number" name="price_min" class="form-control" min="0" step="50000"
                           value="{{ $filters['price_min'] ?? '' }}"
                           placeholder="{{ number_format($priceBounds->min_price ?? 0, 0, ',', '.') }}">
                </div>
                <div class="col-md-4 col-lg-3">
                    <label class="form-label">Giá tối đa (đ/ngày)</label>
                    <input type="number" name="price_max" class="form-control" min="0" step="50000"
                           value="{{ $filters['price_max'] ?? '' }}"
                           placeholder="{{ number_format($priceBounds->max_price ?? 0, 0, ',', '.') }}">
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label">KN tối thiểu</label>
                    <input type="number" name="experience_min" class="form-control" min="0" max="50"
                           value="{{ $filters['experience_min'] ?? '' }}" placeholder="0">
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="male" @selected(($filters['gender'] ?? '') === 'male')>Nam</option>
                        <option value="female" @selected(($filters['gender'] ?? '') === 'female')>Nữ</option>
                        <option value="other" @selected(($filters['gender'] ?? '') === 'other')>Khác</option>
                    </select>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label">Sắp xếp</label>
                    <select name="sort" class="form-select">
                        <option value="" @selected(empty($filters['sort']))>Mới nhất</option>
                        <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Giá thấp → cao</option>
                        <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Giá cao → thấp</option>
                        <option value="experience_desc" @selected(($filters['sort'] ?? '') === 'experience_desc')>Kinh nghiệm</option>
                        <option value="name_asc" @selected(($filters['sort'] ?? '') === 'name_asc')>Tên A-Z</option>
                    </select>
                </div>
            </div>

            @if ($priceBounds && $priceBounds->min_price !== null)
                <div class="mt-3">
                    <label class="form-label small text-muted mb-1">
                        Khoảng giá tham khảo: {{ number_format($priceBounds->min_price, 0, ',', '.') }} — {{ number_format($priceBounds->max_price, 0, ',', '.') }} đ/ngày
                    </label>
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <input type="range" class="form-range" id="rangeMin"
                                   min="{{ (int) $priceBounds->min_price }}"
                                   max="{{ (int) $priceBounds->max_price }}"
                                   step="50000"
                                   value="{{ $filters['price_min'] ?? (int) $priceBounds->min_price }}">
                        </div>
                        <div class="col">
                            <input type="range" class="form-range" id="rangeMax"
                                   min="{{ (int) $priceBounds->min_price }}"
                                   max="{{ (int) $priceBounds->max_price }}"
                                   step="50000"
                                   value="{{ $filters['price_max'] ?? (int) $priceBounds->max_price }}">
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-flex flex-wrap gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i> Tìm kiếm</button>
                <a href="{{ route('guides.index') }}" class="btn btn-light">Xóa bộ lọc</a>
                <span class="text-muted small align-self-center ms-auto">{{ $guides->total() }} hướng dẫn viên</span>
            </div>
        </form>
    </div>

    @if ($guides->count())
        <div class="row g-4">
            @foreach ($guides as $guide)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    @include('guides.partials.card', ['guide' => $guide])
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $guides->links() }}</div>
    @else
        <div class="admin-card text-center py-5">
            <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
            <h5 class="fw-bold">Không tìm thấy hướng dẫn viên phù hợp</h5>
            <p class="text-muted mb-3">Thử đổi bộ lọc hoặc xóa điều kiện tìm kiếm.</p>
            <a href="{{ route('guides.index') }}" class="btn btn-primary">Xem tất cả</a>
        </div>
    @endif
@endsection

@push('scripts')
<script>
(function () {
    const form = document.getElementById('searchForm');
    const minInput = form?.querySelector('[name="price_min"]');
    const maxInput = form?.querySelector('[name="price_max"]');
    const rangeMin = document.getElementById('rangeMin');
    const rangeMax = document.getElementById('rangeMax');
    if (!rangeMin || !rangeMax || !minInput || !maxInput) return;
    rangeMin.addEventListener('input', () => { minInput.value = rangeMin.value; });
    rangeMax.addEventListener('input', () => { maxInput.value = rangeMax.value; });
    minInput.addEventListener('change', () => { rangeMin.value = minInput.value || rangeMin.min; });
    maxInput.addEventListener('change', () => { rangeMax.value = maxInput.value || rangeMax.max; });
})();
</script>
@endpush
