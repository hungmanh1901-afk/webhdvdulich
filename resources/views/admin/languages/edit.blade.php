@extends('layouts.admin')

@section('title', 'Sửa ngôn ngữ')

@section('page_title', 'Sửa ngôn ngữ')
@section('page_subtitle', $language->name)

@section('content')
    <div class="admin-card" style="max-width: 520px">
        <form action="{{ route('admin.languages.update', $language) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Tên ngôn ngữ <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $language->name) }}" required maxlength="50">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Cập nhật</button>
                <a href="{{ route('admin.languages.index') }}" class="btn btn-light">Hủy</a>
            </div>
        </form>
    </div>
@endsection
