@extends('layouts.admin')

@section('title', 'Quản lý khách hàng')

@section('page_title', 'Khách hàng')
@section('page_subtitle', 'Danh sách tài khoản khách hàng')

@section('content')
    <form method="GET" class="admin-card mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-8">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="q" class="form-control" value="{{ request('q') }}"
                       placeholder="Họ tên, email, số điện thoại...">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-search me-1"></i> Tìm</button>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-light">Xóa lọc</a>
            </div>
        </div>
    </form>

    <div class="admin-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Lịch đặt</th>
                        <th>Ngày đăng ký</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td class="text-muted">{{ $customer->id }}</td>
                            <td><strong>{{ $customer->full_name }}</strong></td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?? '—' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $customer->bookings_count }}</span></td>
                            <td class="text-muted small">{{ $customer->created_at?->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-light" title="Chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-light" title="Sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Xóa khách hàng này?');">
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
                            <td colspan="7" class="text-center text-muted py-5">Chưa có khách hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($customers->hasPages())
            <div class="p-3 border-top">{{ $customers->links() }}</div>
        @endif
    </div>
@endsection
