<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-brand">
        <img width="30" height="30" src="{{ asset('logo.webp') }}" alt="Nhóm 10" class="admin-sidebar-logo">
        <div>
            <strong>Nhóm 10</strong>
            <small>Quản trị hệ thống</small>
        </div>
    </div>

    <nav class="admin-nav">
        <a href="{{ route('admin.dashboard') }}"
           class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Bảng điều khiển</span>
        </a>
        <a href="{{ route('admin.guides.index') }}"
           class="admin-nav-link {{ request()->routeIs('admin.guides.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i>
            <span>Hướng dẫn viên</span>
        </a>
        <a href="{{ route('admin.languages.index') }}"
           class="admin-nav-link {{ request()->routeIs('admin.languages.*') ? 'active' : '' }}">
            <i class="bi bi-translate"></i>
            <span>Ngôn ngữ</span>
        </a>
        <a href="{{ route('admin.locations.index') }}"
           class="admin-nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
            <i class="bi bi-geo-alt"></i>
            <span>Địa điểm</span>
        </a>
        <a href="{{ route('admin.customers.index') }}"
           class="admin-nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Khách hàng</span>
        </a>
        <a href="{{ route('admin.bookings.index') }}"
           class="admin-nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            <span>Lịch đặt</span>
        </a>
        <a href="{{ route('admin.statistics.index') }}"
           class="admin-nav-link {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i>
            <span>Thống kê</span>
        </a>
    </nav>

    <div class="admin-sidebar-footer">
        <a href="{{ route('home') }}" class="admin-nav-link">
            <i class="bi bi-house"></i>
            <span>Về trang chủ</span>
        </a>
    </div>
</aside>
