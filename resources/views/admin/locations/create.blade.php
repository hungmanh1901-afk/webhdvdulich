@extends('layouts.admin')

@section('title', 'Thêm địa điểm')

@section('page_title', 'Thêm địa điểm')

@section('content')
    <div class="admin-card" style="max-width: 640px">
        <form action="{{ route('admin.locations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên địa điểm <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required maxlength="100"
                       placeholder="Ví dụ: Hà Nội">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" rows="4"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Mô tả ngắn về địa điểm">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Lưu</button>
                <a href="{{ route('admin.locations.index') }}" class="btn btn-light">Hủy</a>
            </div>
        </form>
    </div>
@endsection
