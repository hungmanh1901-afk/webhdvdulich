<header class="admin-topbar">
    <button type="button" class="btn btn-light btn-sm admin-sidebar-toggle d-lg-none" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
    <div class="admin-topbar-title">
        <h1 class="h5 mb-0 fw-bold">@yield('page_title', 'Quản trị')</h1>
        @hasSection('page_subtitle')
            <p class="text-muted small mb-0">@yield('page_subtitle')</p>
        @endif
    </div>
    <div class="admin-topbar-actions">
        <span class="text-muted small d-none d-md-inline">{{ auth()->user()->full_name }}</span>
        <a href="{{ route('password.edit') }}" class="btn btn-light btn-sm">
            <i class="bi bi-shield-lock"></i>
            <span class="d-none d-sm-inline">Đổi mật khẩu</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i>
                <span class="d-none d-sm-inline">Đăng xuất</span>
            </button>
        </form>
    </div>
</header>
