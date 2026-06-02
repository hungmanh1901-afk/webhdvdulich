@extends('layouts.admin')

@section('title', 'Sửa hướng dẫn viên')

@section('page_title', 'Sửa hướng dẫn viên')
@section('page_subtitle', $guide->full_name)

@section('content')
    <form action="{{ route('admin.guides.update', $guide) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.guides._form', ['guide' => $guide])

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i> Cập nhật
            </button>
            <a href="{{ route('admin.guides.index') }}" class="btn btn-light">Hủy</a>
        </div>
    </form>
@endsection
