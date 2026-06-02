@php
    $class = match ($status) {
        'pending' => 'text-bg-warning',
        'confirmed' => 'text-bg-primary',
        'cancelled' => 'text-bg-danger',
        'completed' => 'text-bg-success',
        default => 'text-bg-secondary',
    };
    $label = \App\Models\Booking::statusLabels()[$status] ?? $status;
@endphp
<span class="badge {{ $class }}">{{ $label }}</span>
