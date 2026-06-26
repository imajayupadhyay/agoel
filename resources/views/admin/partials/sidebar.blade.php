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
            class="sidebar-link {{ request()->routeIs('admin.header.*') ? 'is-active' : '' }}"
            href="{{ route('admin.header.edit') }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 5h16v4H4V5Zm0 6h4v8H4v-8Zm6 0h10v2H10v-2Zm0 4h10v2H10v-2Z"/>
            </svg>
            <span>Header</span>
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

        <a
            class="sidebar-link {{ request()->routeIs('admin.philanthropy.*') ? 'is-active' : '' }}"
            href="{{ route('admin.philanthropy.edit') }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 21s-7-4.4-7-10.2C5 7.6 7.2 5 10.2 5c1.1 0 2.1.4 2.8 1.2C13.7 5.4 14.7 5 15.8 5 18.8 5 21 7.6 21 10.8 21 16.6 14 21 14 21h-2Zm1-2.4c1.9-1.3 6-4.6 6-7.8C19 8.7 17.7 7 15.8 7c-1.1 0-2.1.7-2.8 1.7C12.3 7.7 11.3 7 10.2 7 8.3 7 7 8.7 7 10.8c0 3.2 4.1 6.5 6 7.8Z"/>
            </svg>
            <span>Philanthropy</span>
        </a>

        <a
            class="sidebar-link {{ request()->routeIs('admin.news.*') ? 'is-active' : '' }}"
            href="{{ route('admin.news.edit') }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 5h16v14H4V5Zm2 2v10h12V7H6Zm1 1h5v4H7V8Zm0 5h10v1.5H7V13Zm7-5h3v1.5h-3V8Zm0 2.5h3V12h-3v-1.5Z"/>
            </svg>
            <span>In the News</span>
        </a>

        <a
            class="sidebar-link {{ request()->routeIs('admin.books.*') ? 'is-active' : '' }}"
            href="{{ route('admin.books.edit') }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v17H8a2 2 0 0 0-2 2H4V6.5c0-1.1.9-2 2-2Zm1 13.1c.6-.4 1.3-.6 2-.6h10V4H7.5C6.7 4 6 4.7 6 5.5v12.1ZM8 6h8v2H8V6Zm0 3h8v1.5H8V9Z"/>
            </svg>
            <span>Books</span>
        </a>

        <a
            class="sidebar-link {{ request()->routeIs('admin.research.*') ? 'is-active' : '' }}"
            href="{{ route('admin.research.edit') }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 4h14v2H5V4Zm0 4h8v2H5V8Zm0 4h14v2H5v-2Zm0 4h8v2H5v-2Zm10-8h4v10h-4V8Z"/>
            </svg>
            <span>Research</span>
        </a>

        <a
            class="sidebar-link {{ request()->routeIs('admin.about.*') ? 'is-active' : '' }}"
            href="{{ route('admin.about.edit') }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm0-6a2 2 0 1 1 0 4 2 2 0 0 1 0-4Zm7 15H5v-1c0-3.3 3.1-6 7-6s7 2.7 7 6v1Zm-11.8-2h9.6c-.6-1.7-2.5-3-4.8-3s-4.2 1.3-4.8 3Z"/>
            </svg>
            <span>About Anmol</span>
        </a>

        <a
            class="sidebar-link {{ request()->routeIs('admin.seo.*') ? 'is-active' : '' }}"
            href="{{ route('admin.seo.edit') }}"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M9.5 3a6.5 6.5 0 1 0 3.94 11.67L18.77 20 20 18.77l-5.33-5.33A6.5 6.5 0 0 0 9.5 3Zm0 2a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z"/>
            </svg>
            <span>SEO Settings</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <span>Signed in as</span>
        <strong>{{ auth()->user()->email }}</strong>
    </div>
</aside>
