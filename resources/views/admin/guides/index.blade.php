@extends('layouts.admin')

@section('title', 'Quản lý hướng dẫn viên')

@section('page_title', 'Hướng dẫn viên')
@section('page_subtitle', 'Thêm, sửa, xóa thông tin hướng dẫn viên')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div></div>
        <a href="{{ route('admin.guides.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Thêm hướng dẫn viên
        </a>
    </div>

    <div class="admin-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 70px">Ảnh</th>
                        <th>Họ tên</th>
                        <th>Liên hệ</th>
                        <th>Kinh nghiệm</th>
                        <th>Giá/ngày</th>
                        <th>Ngôn ngữ</th>
                        <th>Địa điểm</th>
                        <th>Trạng thái</th>
                        <th class="text-end" style="width: 120px">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guides as $guide)
                        <tr>
                            <td>
                                @if ($guide->avatarUrl())
                                    <img src="{{ $guide->avatarUrl() }}" alt="" class="guide-table-avatar">
                                @else
                                    <span class="guide-table-avatar guide-table-avatar--empty">
                                        {{ mb_strtoupper(mb_substr($guide->full_name, 0, 1)) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $guide->full_name }}</strong>
                                @if ($guide->gender)
                                    <br><span class="text-muted small">
                                        @if ($guide->gender === 'male') Nam
                                        @elseif ($guide->gender === 'female') Nữ
                                        @else Khác
                                        @endif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="small">{{ $guide->email }}</div>
                                @if ($guide->phone)
                                    <div class="text-muted">{{ $guide->phone }}</div>
                                @endif
                            </td>
                            <td>{{ $guide->experience_years }} năm</td>
                            <td class="fw-semibold text-primary">
                                {{ number_format($guide->price_per_day, 0, ',', '.') }} đ
                            </td>
                            <td>
                                @forelse ($guide->languages as $lang)
                                    <span class="badge bg-light text-dark border me-1">{{ $lang->name }}</span>
                                @empty
                                    <span class="text-muted">—</span>
                                @endforelse
                            </td>
                            <td>
                                @forelse ($guide->locations as $loc)
                                    <span class="badge bg-light text-dark border me-1">{{ $loc->name }}</span>
                                @empty
                                    <span class="text-muted">—</span>
                                @endforelse
                            </td>
                            <td>
                                @if ($guide->status === 'available')
                                    <span class="badge text-bg-success">Sẵn sàng</span>
                                @elseif ($guide->status === 'busy')
                                    <span class="badge text-bg-warning">Bận</span>
                                @else
                                    <span class="badge text-bg-secondary">Ngừng HĐ</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.guides.edit', $guide) }}" class="btn btn-sm btn-light" title="Sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.guides.destroy', $guide) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa hướng dẫn viên này?');">
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
                            <td colspan="9" class="text-center text-muted py-5">
                                <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                                Chưa có hướng dẫn viên nào.
                                <a href="{{ route('admin.guides.create') }}">Thêm ngay</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($guides->hasPages())
            <div class="p-3 border-top">
                {{ $guides->links() }}
            </div>
        @endif
    </div>
@endsection
