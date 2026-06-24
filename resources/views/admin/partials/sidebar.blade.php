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
    </nav>

    <div class="sidebar-footer">
        <span>Signed in as</span>
        <strong>{{ auth()->user()->email }}</strong>
    </div>
</aside>
