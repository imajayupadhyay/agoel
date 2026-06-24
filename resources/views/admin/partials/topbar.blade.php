<header class="admin-topbar">
    <div class="topbar-heading">
        <button
            class="sidebar-toggle"
            type="button"
            aria-label="Open navigation"
            aria-controls="adminSidebar"
            aria-expanded="false"
            data-sidebar-toggle
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div>
            <span class="topbar-kicker">Admin panel</span>
            <h1>@yield('page-title', 'Dashboard')</h1>
        </div>
    </div>

    <div class="topbar-actions">
        <div class="admin-identity">
            <span class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div>
                <strong>{{ auth()->user()->name }}</strong>
                <span>Administrator</span>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="logout-button" type="submit">Logout</button>
        </form>
    </div>
</header>
