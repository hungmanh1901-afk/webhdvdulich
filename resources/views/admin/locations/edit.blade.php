@extends('layouts.admin')

@section('title', 'Sửa địa điểm')

@section('page_title', 'Sửa địa điểm')
@section('page_subtitle', $location->name)

@section('content')
    <div class="admin-card" style="max-width: 640px">
        <form action="{{ route('admin.locations.update', $location) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Tên địa điểm <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $location->name) }}" required maxlength="100">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" rows="4"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $location->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Cập nhật</button>
                <a href="{{ route('admin.locations.index') }}" class="btn btn-light">Hủy</a>
            </div>
        </form>
    </div>
@endsection
