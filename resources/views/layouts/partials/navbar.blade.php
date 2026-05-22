<nav class="navbar navbar-expand-lg site-navbar sticky-top py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('home') }}">
            <img width="30" height="30" src="{{ asset('logo.webp') }}" alt="Nhóm 10" class="admin-sidebar-logo">
            <span class="brand-text">
                {{ __('app.name') }}
                <small>{{ __('app.tagline') }}</small>
            </span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link fw-semibold {{ request()->routeIs('home') ? 'text-primary' : '' }}" href="{{ route('home') }}">
                        {{ __('app.home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold {{ request()->routeIs('guides.*') ? 'text-primary' : '' }}" href="{{ route('guides.index') }}">
                        Hướng dẫn viên
                    </a>
                </li>
                @auth
                    @if (auth()->user()->isCustomer())
                        <li class="nav-item">
                            <a class="nav-link fw-semibold {{ request()->routeIs('bookings.*') ? 'text-primary' : '' }}" href="{{ route('bookings.index') }}">
                                Lịch đặt của tôi
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link fw-semibold {{ request()->routeIs('admin.*') ? 'text-primary' : '' }}" href="{{ route('admin.dashboard') }}">
                                {{ __('app.admin_panel') }}
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->full_name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('password.*') ? 'active' : '' }}"
                                   href="{{ route('password.edit') }}">
                                    <i class="bi bi-shield-lock me-2"></i>Đổi mật khẩu
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('auth.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
