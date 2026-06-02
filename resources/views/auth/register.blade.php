@extends('layouts.guest')

@section('title', __('auth.register'))

@section('content')
    <div class="auth-card">
        <h2 class="mb-1">{{ __('auth.create_account') }}</h2>
        <p class="text-muted mb-4">{{ __('auth.register_subtitle') }}</p>

        @include('components.alert')

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <div class="mb-3">
                <label for="full_name" class="form-label">{{ __('auth.full_name') }}</label>
                <input type="text" name="full_name" id="full_name"
                       class="form-control @error('full_name') is-invalid @enderror"
                       value="{{ old('full_name') }}" required autofocus>
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('auth.email') }}</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">{{ __('auth.phone') }}</label>
                    <input type="text" name="phone" id="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">{{ __('auth.address') }}</label>
                    <input type="text" name="address" id="address"
                           class="form-control @error('address') is-invalid @enderror"
                           value="{{ old('address') }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('auth.password') }}</label>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">{{ __('auth.password_confirmation') }}</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                <i class="bi bi-person-plus me-2"></i>{{ __('auth.register') }}
            </button>
        </form>

        <p class="text-center text-muted mt-4 mb-0">
            {{ __('auth.has_account') }}
            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">{{ __('auth.login') }}</a>
        </p>
    </div>
@endsection
