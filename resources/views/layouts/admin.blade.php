<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.favicon')
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') — Sanchalak</title>
    <link rel="stylesheet" href="{{ asset_version('css/admin.css') }}">
    @stack('styles')
</head>
<body>
    <div class="admin-shell">
        @include('admin.partials.sidebar')

        <div class="admin-main">
            @include('admin.partials.topbar')

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <div class="sidebar-backdrop" data-sidebar-close></div>

    <script src="{{ asset_version('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>
