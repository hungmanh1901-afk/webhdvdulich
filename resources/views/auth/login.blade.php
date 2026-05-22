@extends('layouts.guest')

@section('title', __('auth.login'))

@section('content')
    <div class="auth-card">
        <h2 class="mb-1">{{ __('auth.welcome_back') }}</h2>
        <p class="text-muted mb-4">{{ __('auth.login_subtitle') }}</p>

        @include('components.alert')

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('auth.email') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                    <input type="email" name="email" id="email"
                           class="form-control border-start-0 @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autofocus autocomplete="email">
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('auth.password') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" name="password" id="password"
                           class="form-control border-start-0 @error('password') is-invalid @enderror"
                           required autocomplete="current-password">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('auth.login') }}
            </button>
        </form>

        <p class="text-center text-muted mt-4 mb-0">
            {{ __('auth.no_account') }}
            <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">{{ __('auth.register') }}</a>
        </p>
    </div>
@endsection
