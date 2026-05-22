@extends('layouts.admin')

@section('title', 'Quản lý địa điểm')

@section('page_title', 'Địa điểm')
@section('page_subtitle', 'Danh sách địa điểm du lịch hướng dẫn viên hoạt động')

@section('content')
    <div class="d-flex flex-wrap justify-content-end mb-4">
        <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Thêm địa điểm
        </a>
    </div>

    <div class="admin-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px">#</th>
                        <th>Tên địa điểm</th>
                        <th>Mô tả</th>
                        <th>Số HDV</th>
                        <th class="text-end" style="width: 120px">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($locations as $location)
                        <tr>
                            <td class="text-muted">{{ $location->id }}</td>
                            <td><strong>{{ $location->name }}</strong></td>
                            <td class="text-muted small">
                                {{ $location->description ? Str::limit($location->description, 80) : '—' }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $location->guides_count }} HDV</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-sm btn-light" title="Sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa địa điểm này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                Chưa có địa điểm nào.
                                <a href="{{ route('admin.locations.create') }}">Thêm ngay</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($locations->hasPages())
            <div class="p-3 border-top">{{ $locations->links() }}</div>
        @endif
    </div>
@endsection
