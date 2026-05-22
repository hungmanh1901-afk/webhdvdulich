<!DOCTYPE html>
<html lang="vi">
<head>
    @include('layouts.partials.head')
    @stack('styles')
</head>
<body class="admin-body">
    <div class="admin-shell">
        @include('admin.partials.sidebar')

        <div class="admin-main">
            @include('admin.partials.topbar')

            <div class="admin-content">
                @include('admin.partials.alert')
                @yield('content')
            </div>
        </div>
    </div>

    <div class="admin-sidebar-overlay" id="sidebarOverlay"></div>

    @include('layouts.partials.scripts')
    <script>
        (function () {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.getElementById('sidebarToggle');
            if (!sidebar || !toggle) return;
            toggle.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
            overlay?.addEventListener('click', function () {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
