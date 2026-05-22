@extends('layouts.admin')

@section('title', 'Sửa khách hàng')

@section('page_title', 'Sửa khách hàng')
@section('page_subtitle', $customer->full_name)

@section('content')
    <div class="admin-card" style="max-width: 640px">
        <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="full_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" name="full_name" id="full_name" class="form-control @error('full_name') is-invalid @enderror"
                       value="{{ old('full_name', $customer->full_name) }}" required>
                @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $customer->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" name="phone" id="phone" class="form-control"
                       value="{{ old('phone', $customer->phone) }}">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" name="address" id="address" class="form-control"
                       value="{{ old('address', $customer->address) }}">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Cập nhật</button>
                <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-light">Hủy</a>
            </div>
        </form>
    </div>
@endsection
