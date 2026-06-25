<aside class="admin-sidebar" id="adminSidebar" aria-label="Admin navigation">
    <div class="sidebar-brand">
        <span class="brand-mark">A</span>
        <div>
            <strong>Sanchalak</strong>
            <span>Administration</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <p class="sidebar-label">Workspace</p>

        <a
            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"
            href="{{ route('admin.dashboard') }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3 13h8V3H3v10Zm0 8h8v-6H3v6Zm10 0h8V11h-8v10Zm0-18v6h8V3h-8Z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a
            class="sidebar-link {{ request()->routeIs('admin.homepage.*') ? 'is-active' : '' }}"
            href="{{ route('admin.homepage.edit') }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3 2 12h3v9h6v-6h2v6h6v-9h3L12 3Zm5 16h-2v-6H9v6H7v-7.8l5-4.5 5 4.5V19Z"/>
            </svg>
            <span>Homepage</span>
        </a>

        <a
            class="sidebar-link {{ request()->routeIs('admin.industries.*') ? 'is-active' : '' }}"
            href="{{ route('admin.industries.edit') }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 20h16v2H4v-2Zm1-2V9l5 3V9l5 3V4h4v14H5Zm2-2h10V8h0v7.4l-5-3V16l-5-3v3Z"/>
            </svg>
            <span>Industries</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <span>Signed in as</span>
        <strong>{{ auth()->user()->email }}</strong>
    </div>
</aside>
