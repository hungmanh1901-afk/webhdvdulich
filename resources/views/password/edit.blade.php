@extends('layouts.app')

@section('title', 'Đổi mật khẩu')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-5">
            <div class="admin-card">
                <h1 class="h4 fw-bold mb-1">Đổi mật khẩu</h1>
                <p class="text-muted small mb-4">Cập nhật mật khẩu cho tài khoản {{ auth()->user()->email }}</p>

                @include('components.alert')

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" id="current_password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               required autocomplete="current-password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control" required autocomplete="new-password">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-shield-lock me-1"></i> Lưu mật khẩu
                        </button>
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}" class="btn btn-light">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
