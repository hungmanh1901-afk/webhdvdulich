<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials.head')
</head>
<body>
    @include('layouts.partials.navbar')

    <main class="py-4">
        <div class="container">
            @include('components.alert')
            @yield('content')
        </div>
    </main>

    @include('layouts.partials.scripts')
</body>
</html>
