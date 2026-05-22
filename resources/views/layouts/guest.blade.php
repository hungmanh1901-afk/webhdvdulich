<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials.head')
</head>
<body>
    <div class="auth-wrapper">
        <aside class="auth-hero">
            <div class="auth-hero-content">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-white text-decoration-none mb-4">
                    <img width="30" height="30" src="{{ asset('logo.webp') }}" alt="Nhóm 10" class="admin-sidebar-logo">
                    <span class="fw-bold fs-5">{{ __('app.name') }}</span>
                </a>
                <h1>{{ __('auth.guest_hero_title') }}</h1>
                <p class="opacity-75 mt-3 mb-0">{{ __('auth.guest_hero_text') }}</p>
                <div class="d-flex gap-4 mt-5 opacity-90">
                    <div>
                        <i class="bi bi-geo-alt fs-4"></i>
                        <p class="small mb-0 mt-1">{{ __('app.feature_search') }}</p>
                    </div>
                    <div>
                        <i class="bi bi-calendar-check fs-4"></i>
                        <p class="small mb-0 mt-1">{{ __('app.feature_book') }}</p>
                    </div>
                    <div>
                        <i class="bi bi-shield-check fs-4"></i>
                        <p class="small mb-0 mt-1">{{ __('app.feature_trust') }}</p>
                    </div>
                </div>
            </div>
        </aside>
        <section class="auth-panel">
            @yield('content')
        </section>
    </div>
    @include('layouts.partials.scripts')
</body>
</html>
