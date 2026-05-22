@extends('layouts.admin')

@section('title', 'Quản lý ngôn ngữ')

@section('page_title', 'Ngôn ngữ')
@section('page_subtitle', 'Danh sách ngôn ngữ / kỹ năng của hướng dẫn viên')

@section('content')
    <div class="d-flex flex-wrap justify-content-end mb-4">
        <a href="{{ route('admin.languages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Thêm ngôn ngữ
        </a>
    </div>

    <div class="admin-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px">#</th>
                        <th>Tên ngôn ngữ</th>
                        <th>Số HDV</th>
                        <th class="text-end" style="width: 120px">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($languages as $language)
                        <tr>
                            <td class="text-muted">{{ $language->id }}</td>
                            <td><strong>{{ $language->name }}</strong></td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $language->guides_count }} HDV</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.languages.edit', $language) }}" class="btn btn-sm btn-light" title="Sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.languages.destroy', $language) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa ngôn ngữ này?');">
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
                            <td colspan="4" class="text-center text-muted py-5">
                                Chưa có ngôn ngữ nào.
                                <a href="{{ route('admin.languages.create') }}">Thêm ngay</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($languages->hasPages())
            <div class="p-3 border-top">{{ $languages->links() }}</div>
        @endif
    </div>
@endsection
