<div class="guide-card">
    <a href="{{ route('guides.show', $guide) }}" class="guide-card-image">
        @if ($guide->avatarUrl())
            <img src="{{ $guide->avatarUrl() }}" alt="{{ $guide->full_name }}">
        @else
            <span class="guide-card-placeholder">{{ mb_strtoupper(mb_substr($guide->full_name, 0, 1)) }}</span>
        @endif
        <span class="guide-card-status badge {{ $guide->status === 'available' ? 'text-bg-success' : 'text-bg-warning' }}">
            {{ $guide->statusLabel() }}
        </span>
    </a>
    <div class="guide-card-body">
        <h3 class="guide-card-title">
            <a href="{{ route('guides.show', $guide) }}" class="text-decoration-none text-dark">{{ $guide->full_name }}</a>
        </h3>
        @if ($guide->genderLabel())
            <p class="text-muted small mb-2"><i class="bi bi-person me-1"></i>{{ $guide->genderLabel() }} · {{ $guide->experience_years }} năm KN</p>
        @else
            <p class="text-muted small mb-2"><i class="bi bi-award me-1"></i>{{ $guide->experience_years }} năm kinh nghiệm</p>
        @endif
        <p class="guide-card-price mb-2">{{ number_format($guide->price_per_day, 0, ',', '.') }} <small>đ/ngày</small></p>
        <div class="guide-card-tags mb-3">
            @foreach ($guide->locations->take(2) as $loc)
                <span class="badge bg-light text-dark border">{{ $loc->name }}</span>
            @endforeach
            @foreach ($guide->languages->take(2) as $lang)
                <span class="badge bg-primary bg-opacity-10 text-primary border-0">{{ $lang->name }}</span>
            @endforeach
        </div>
        <a href="{{ route('guides.show', $guide) }}" class="btn btn-primary w-100 btn-sm">Xem chi tiết</a>
    </div>
</div>
