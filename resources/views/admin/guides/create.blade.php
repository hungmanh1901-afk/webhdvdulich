@extends('layouts.admin')

@section('title', 'Thêm hướng dẫn viên')

@section('page_title', 'Thêm hướng dẫn viên')
@section('page_subtitle', 'Nhập thông tin hướng dẫn viên mới')

@section('content')
    <form action="{{ route('admin.guides.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.guides._form')

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i> Lưu
            </button>
            <a href="{{ route('admin.guides.index') }}" class="btn btn-light">Hủy</a>
        </div>
    </form>
@endsection
