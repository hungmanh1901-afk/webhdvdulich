@extends('layouts.app')

@section('title', __('app.home'))

@section('content')
    <section class="hero-section mb-5">
        <div class="hero-content col-lg-8">
            <span class="badge bg-warning text-dark mb-3 px-3 py-2">{{ __('app.tagline') }}</span>
            <h1 class="display-5 fw-bold mb-3">{{ __('app.hero_title') }}</h1>
            <p class="lead opacity-90 mb-4">{{ __('app.hero_subtitle') }}</p>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('guides.index') }}" class="btn btn-accent btn-lg">
                    <i class="bi bi-search me-2"></i>{{ __('app.explore_guides') }}
                </a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-person-plus me-2"></i>{{ __('app.get_started') }}
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                        {{ __('auth.login') }}
                    </a>
                @elseif (auth()->user()->isCustomer())
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-light btn-lg">
                        Lịch đặt của tôi
                    </a>
                @endif
            </div>
        </div>
    </section>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <article class="feature-card">
                <div class="feature-icon"><i class="bi bi-search"></i></div>
                <h5 class="fw-bold">{{ __('app.feature_search') }}</h5>
                <p class="text-muted mb-0">{{ __('app.feature_search_desc') }}</p>
            </article>
        </div>
        <div class="col-md-4">
            <article class="feature-card">
                <div class="feature-icon"><i class="bi bi-calendar2-week"></i></div>
                <h5 class="fw-bold">{{ __('app.feature_book') }}</h5>
                <p class="text-muted mb-0">{{ __('app.feature_book_desc') }}</p>
            </article>
        </div>
        <div class="col-md-4">
            <article class="feature-card">
                <div class="feature-icon"><i class="bi bi-award"></i></div>
                <h5 class="fw-bold">{{ __('app.feature_trust') }}</h5>
                <p class="text-muted mb-0">{{ __('app.feature_trust_desc') }}</p>
            </article>
        </div>
    </div>
@endsection
