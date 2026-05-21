@props([
    'title'       => 'Dashboard',
    'subtitle'    => null,
    'breadcrumbs' => [],
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — OmniCore Enterprise Suite</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    {{-- Blocking dark-mode flash prevention --}}
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-neutral-bg dark:bg-[#0b0f19] font-sans antialiased text-secondary dark:text-slate-400 overflow-hidden">

{{-- ====================================================
     APP SHELL: sidebar + main column
     ==================================================== --}}
<div class="flex h-full w-full overflow-hidden" id="app-wrapper">

    {{-- ---- MOBILE OVERLAY (shown when sidebar open on small screens) ---- --}}
    <div id="sidebar-overlay"
         onclick="closeMobileSidebar()"
         class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden"
         aria-hidden="true">
    </div>

    {{-- ======================================================
         SIDEBAR — fixed 240 px, dark #343a40, icons-only 60 px
         ====================================================== --}}
    <aside
        id="sidebar"
        aria-label="Sidebar Navigation"
        class="sidebar-shell
               fixed lg:relative inset-y-0 left-0 z-30
               flex flex-col shrink-0
               h-full w-[240px]
               bg-[#343a40] text-white
               border-r border-[#2c3036]
               transition-[width,transform] duration-200 ease-in-out
               -translate-x-full lg:translate-x-0
               overflow-hidden"
    >
        {{-- Logo row — always 60 px tall --}}
        <div class="h-[60px] flex items-center px-4 border-b border-[#2c3036] shrink-0 overflow-hidden">
            {{-- Icon always visible --}}
            <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-.778.099-1.533.284-2.253"/>
                </svg>
            </div>
            {{-- Brand text — hides when collapsed --}}
            <span id="sidebar-brand"
                  class="ml-3 font-bold text-sm tracking-widest uppercase whitespace-nowrap text-white
                         transition-[opacity,width] duration-200 opacity-100 overflow-hidden">
                OmniCore
            </span>
        </div>

        {{-- Navigation — scrollable --}}
        <nav class="flex-1 px-2 py-3 overflow-y-auto overflow-x-hidden" aria-label="Main navigation">
            {{ $sidebarLinks ?? '' }}
        </nav>

        {{-- Sidebar Footer — hides when collapsed --}}
        <div id="sidebar-footer"
             class="px-4 py-3 border-t border-[#2c3036] shrink-0 overflow-hidden
                    transition-[opacity] duration-200 opacity-100">
            <span class="block text-sm font-semibold uppercase tracking-widest text-slate-500 whitespace-nowrap">
                OmniCore Suite v1.0
            </span>
            <span class="block text-sm font-mono text-slate-500 mt-0.5">
                Session: Stable
            </span>
        </div>
    </aside>

    {{-- ======================================================
         MAIN COLUMN — navbar + scrollable content
         ====================================================== --}}
    <div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden">

        {{-- ---- TOP NAVBAR — fixed 60 px ---- --}}
        <header id="top-navbar"
                class="h-[60px] shrink-0 z-20
                       bg-panel-bg dark:bg-slate-900
                       border-b border-border-subtle dark:border-slate-800
                       flex items-center justify-between px-4 md:px-6">

            {{-- Left: hamburger --}}
            <div class="flex items-center gap-3">
                <button type="button"
                        id="sidebar-toggle"
                        aria-label="Toggle Sidebar"
                        class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-800
                               text-secondary hover:text-primary dark:text-slate-400
                               cursor-pointer transition-colors
                               focus:outline-none focus:ring-2 focus:ring-primary/25 shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <span class="font-bold text-sm tracking-wider uppercase text-primary dark:text-slate-200 hidden sm:inline-block">OmniCore Suite</span>
            </div>

            {{-- Right: search, theme, bell, profile --}}
            <div class="flex items-center gap-2 md:gap-3 shrink-0">

                {{-- Global search with autocomplete --}}
                <div class="relative hidden md:block" id="global-search-wrapper">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-secondary/40 dark:text-slate-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="search" id="global-search" placeholder="Search panels or docs…"
                           class="pl-9 pr-4 h-9 w-44 focus:w-64 text-sm rounded
                                  bg-slate-50 dark:bg-slate-800
                                  border border-border-subtle dark:border-slate-700
                                  text-primary dark:text-slate-100
                                  placeholder:text-secondary/40 dark:placeholder:text-slate-600
                                  focus:outline-none focus:border-primary/40 focus:ring-2 focus:ring-primary/10
                                  transition-all duration-200" autocomplete="off"/>
                    
                    {{-- Autocomplete Dropdown --}}
                    <div id="search-autocomplete-menu" 
                         class="hidden absolute left-0 mt-2 w-64 rounded bg-panel-bg dark:bg-slate-900 border border-border-subtle dark:border-slate-700 shadow-lg py-1 z-50 text-sm">
                        <div class="px-3 py-1 text-xs font-semibold text-secondary/50 uppercase tracking-wider border-b border-border-subtle dark:border-slate-800">
                            Suggestions
                        </div>
                        <div class="divide-y divide-border-subtle dark:divide-slate-800" id="search-suggestions-list">
                            {{-- Populated dynamically --}}
                        </div>
                    </div>
                </div>

                {{-- Dark / Light toggle --}}
                <button type="button"
                        id="theme-toggle-btn"
                        aria-label="Toggle Theme"
                        onclick="document.documentElement.classList.toggle('dark');
                                 localStorage.setItem('darkMode', document.documentElement.classList.contains('dark') ? 'enabled' : 'disabled');"
                        class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-800
                               text-secondary dark:text-slate-400 hover:text-primary
                               transition-colors cursor-pointer
                               focus:outline-none focus:ring-2 focus:ring-primary/25">
                    {{-- Moon shown in light mode --}}
                    <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    {{-- Sun shown in dark mode --}}
                    <svg class="w-5 h-5 hidden dark:block text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                </button>

                {{-- Notification bell with dropdown --}}
                <div class="relative" id="notification-dropdown-wrapper">
                    <button type="button"
                            aria-label="Notifications"
                            id="notification-btn"
                            class="relative p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-800
                                   text-secondary dark:text-slate-400 hover:text-primary
                                   transition-colors cursor-pointer
                                   focus:outline-none focus:ring-2 focus:ring-primary/25">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute -top-1 -right-1 flex items-center justify-center min-w-[16px] h-4 px-1 rounded-full bg-danger text-white text-[10px] font-bold border border-panel-bg dark:border-slate-900 leading-none">3</span>
                    </button>
                    {{-- Dropdown Menu --}}
                    <div id="notification-dropdown-menu" 
                         class="dropdown-menu hidden absolute right-0 mt-2 w-72 rounded bg-panel-bg dark:bg-slate-900 border border-border-subtle dark:border-slate-700 shadow-lg py-1 z-50 text-sm">
                        <div class="px-4 py-2 font-semibold text-primary dark:text-slate-200 border-b border-border-subtle dark:border-slate-800">
                            Notifications (3)
                        </div>
                        <div class="max-h-64 overflow-y-auto divide-y divide-border-subtle dark:divide-slate-800">
                            <div class="px-4 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer" onclick="switchPanel('inventory-products')">
                                <div class="flex items-start gap-2">
                                    <span class="w-2 h-2 rounded-full bg-danger mt-1.5 shrink-0"></span>
                                    <div>
                                        <p class="font-medium text-primary dark:text-slate-200 m-0 leading-normal">System Alert</p>
                                        <p class="text-secondary dark:text-slate-400 m-0 text-xs mt-0.5 leading-normal">3 products have fallen below their safety threshold.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer" onclick="switchPanel('admin')">
                                <div class="flex items-start gap-2">
                                    <span class="w-2 h-2 rounded-full bg-success mt-1.5 shrink-0"></span>
                                    <div>
                                        <p class="font-medium text-primary dark:text-slate-200 m-0 leading-normal">Backup Complete</p>
                                        <p class="text-secondary dark:text-slate-400 m-0 text-xs mt-0.5 leading-normal">Database auto-backup completed successfully.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer" onclick="switchPanel('reports')">
                                <div class="flex items-start gap-2">
                                    <span class="w-2 h-2 rounded-full bg-info mt-1.5 shrink-0"></span>
                                    <div>
                                        <p class="font-medium text-primary dark:text-slate-200 m-0 leading-normal">Update Scheduled</p>
                                        <p class="text-secondary dark:text-slate-400 m-0 text-xs mt-0.5 leading-normal">Maintenance window scheduled for Dec 2026.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-2 text-center border-t border-border-subtle dark:border-slate-800">
                            <a href="#" class="text-primary dark:text-blue-400 hover:underline font-medium text-xs">Mark all as read</a>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="h-5 w-px bg-border-subtle dark:bg-slate-700 hidden sm:block"></div>

                {{-- User profile chip with dropdown --}}
                <div class="relative" id="profile-dropdown-wrapper">
                    <div class="flex items-center gap-2 p-1 rounded cursor-pointer
                                hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                         id="profile-btn" aria-label="User profile">
                        <div class="w-8 h-8 rounded-full bg-primary text-white
                                    font-bold text-sm flex items-center justify-center shrink-0">
                            SA
                        </div>
                        <div class="hidden sm:block text-left">
                            <span class="block text-sm font-semibold text-primary dark:text-slate-100 leading-none">
                                Sajjad Admin
                            </span>
                            <span class="block text-sm text-secondary dark:text-slate-500 mt-0.5 leading-none">
                                Enterprise Admin
                            </span>
                        </div>
                    </div>
                    {{-- Dropdown Menu --}}
                    <div id="profile-dropdown-menu" 
                         class="dropdown-menu hidden absolute right-0 mt-2 w-48 rounded bg-panel-bg dark:bg-slate-900 border border-border-subtle dark:border-slate-700 shadow-lg py-1 z-50 text-sm">
                        <a href="#" class="block px-4 py-2 text-primary dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/50" onclick="switchPanel('admin')">My Profile</a>
                        <a href="#" class="block px-4 py-2 text-primary dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/50" onclick="switchPanel('docs')">Settings</a>
                        <div class="border-t border-border-subtle dark:border-slate-800 my-1"></div>
                        <a href="#" class="block px-4 py-2 text-danger hover:bg-red-50 dark:hover:bg-red-950/20" onclick="alert('Logged out successfully.')">Logout</a>
                    </div>
                </div>

            </div>
        </header>

        {{-- ---- PAGE CONTENT — scrollable ---- --}}
        <main class="flex-1 overflow-y-auto flex flex-col h-full" id="main-content">
            
            {{-- Sticky Page Header Row --}}
            <div class="sticky top-0 z-10 shrink-0 bg-panel-bg/95 dark:bg-slate-900/95 backdrop-blur-md px-4 md:px-6 py-4 border-b border-border-subtle dark:border-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 shadow-sm select-none">
                <div class="min-w-0">
                    {{-- Breadcrumbs (render only if more than 0 levels) --}}
                    @if(count($breadcrumbs) > 0)
                        <nav class="flex items-center gap-1.5 text-sm text-secondary dark:text-slate-400 mb-1.5 select-none" aria-label="Breadcrumb" id="breadcrumb-container">
                            <a href="#" onclick="switchPanel('admin', document.querySelector('[data-panel=admin]'))" class="hover:text-primary dark:hover:text-blue-400 transition-colors font-medium">Home</a>
                            @foreach($breadcrumbs as $index => $bc)
                                <span class="text-secondary/40 dark:text-slate-600">/</span>
                                @if($index === count($breadcrumbs) - 1)
                                    <span class="font-semibold text-primary dark:text-blue-400" id="breadcrumb-current">{{ $bc }}</span>
                                @else
                                    <span class="text-secondary dark:text-slate-400">{{ $bc }}</span>
                                @endif
                            @endforeach
                        </nav>
                    @endif
                    <h1 class="text-2xl font-semibold text-primary dark:text-slate-100 m-0 leading-tight tracking-tight">
                        {{ $title }}
                    </h1>
                    @if($subtitle)
                        <p class="text-sm text-secondary dark:text-slate-400 mt-1 mb-0 leading-normal font-normal">
                            {{ $subtitle }}
                        </p>
                    @endif
                </div>
                @if(isset($pageActions))
                    <div class="flex items-center gap-2 shrink-0">
                        {{ $pageActions }}
                    </div>
                @endif
            </div>

            {{-- Main Scrollable Content --}}
            <div class="flex-1 w-full px-4 md:px-6 py-6 space-y-6">
                {{-- Actual page content --}}
                <div class="space-y-6">
                    {{ $slot }}
                </div>
            </div>
        </main>

    </div>{{-- /main column --}}

</div>{{-- /app-wrapper --}}


{{-- ====================================================
     GLOBAL MODAL UTILITIES (JS)
     ==================================================== --}}
<script>
function omniOpenModal(id) {
    const m = document.getElementById(id);
    if (!m) return;
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
    // Focus first focusable element
    setTimeout(() => {
        const focusable = m.querySelector('input, select, textarea, button:not([aria-label="Close modal"])');
        if (focusable) focusable.focus();
    }, 80);
}

function omniCloseModal(id) {
    const m = document.getElementById(id);
    if (!m) return;
    m.classList.add('hidden');
    m.classList.remove('flex');
    document.body.style.overflow = '';
}

// Close modals with Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.omni-modal.flex').forEach(m => {
            if (!m.querySelector('[data-static]')) omniCloseModal(m.id);
        });
    }
});
</script>

{{-- ====================================================
     GLOBAL INTERACTION SHELL CONTROLLER (JS)
     Handles Sidebar, Tooltips, Dropdowns & Search Autocomplete
     ==================================================== --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Sidebar Collapse / Drawer Handler
    const sidebar      = document.getElementById('sidebar');
    const overlay      = document.getElementById('sidebar-overlay');
    const toggleBtn    = document.getElementById('sidebar-toggle');
    const brand        = document.getElementById('sidebar-brand');
    const footerMeta   = document.getElementById('sidebar-footer');
    const navLabels    = sidebar ? sidebar.querySelectorAll('.sidebar-label') : [];
    const isLg         = () => window.innerWidth >= 1024;

    let desktopCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

    function updateSidebarTooltips(collapsed) {
        const links = document.querySelectorAll('.sidebar-link, .sidebar-sublink');
        links.forEach(link => {
            if (collapsed) {
                const tooltipText = link.getAttribute('data-tooltip');
                if (tooltipText) {
                    link.setAttribute('title', tooltipText);
                }
            } else {
                link.removeAttribute('title');
            }
        });
    }

    function applyDesktopState() {
        if (isLg()) {
            if (desktopCollapsed) {
                sidebar.classList.remove('w-[240px]');
                sidebar.classList.add('w-[60px]');
                if (brand)      { brand.classList.add('opacity-0', 'w-0', 'ml-0'); brand.classList.remove('opacity-100'); }
                if (footerMeta) { footerMeta.classList.add('opacity-0'); footerMeta.classList.remove('opacity-100'); }
                navLabels.forEach(l => l.classList.add('hidden'));
                
                // Hide submenus when sidebar is collapsed
                document.querySelectorAll('.sidebar-label-container').forEach(c => c.classList.add('hidden'));
                
                updateSidebarTooltips(true);
            } else {
                sidebar.classList.add('w-[240px]');
                sidebar.classList.remove('w-[60px]');
                if (brand)      { brand.classList.remove('opacity-0', 'w-0', 'ml-0'); brand.classList.add('opacity-100'); }
                if (footerMeta) { footerMeta.classList.remove('opacity-0'); footerMeta.classList.add('opacity-100'); }
                navLabels.forEach(l => l.classList.remove('hidden'));
                
                // Restore submenu state
                // Keep submenus visible if they were toggled open
                document.querySelectorAll('.sidebar-label-container').forEach(c => {
                    const subId = c.id;
                    const arrow = document.getElementById('submenu-arrow-' + subId.replace('submenu-', ''));
                    if (arrow && arrow.classList.contains('rotate-180')) {
                        c.classList.remove('hidden');
                    }
                });

                updateSidebarTooltips(false);
            }
        }
    }

    applyDesktopState();

    function closeMobileSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }
    window.closeMobileSidebar = closeMobileSidebar;

    window.toggleSubmenu = function(id, btn) {
        if (desktopCollapsed) {
            desktopCollapsed = false;
            localStorage.setItem('sidebarCollapsed', false);
            applyDesktopState();
        }
        const sub = document.getElementById('submenu-' + id);
        const arrow = document.getElementById('submenu-arrow-' + id);
        if (sub) {
            const isHidden = sub.classList.contains('hidden');
            if (isHidden) {
                sub.classList.remove('hidden');
                if (arrow) arrow.classList.add('rotate-180');
            } else {
                sub.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        }
    };

    toggleBtn.addEventListener('click', () => {
        if (!isLg()) {
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('w-[240px]');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                closeMobileSidebar();
            }
        } else {
            desktopCollapsed = !desktopCollapsed;
            localStorage.setItem('sidebarCollapsed', desktopCollapsed);
            applyDesktopState();
        }
    });

    window.addEventListener('resize', () => {
        if (isLg()) {
            overlay.classList.add('hidden');
            sidebar.classList.remove('-translate-x-full');
            document.body.style.overflow = '';
            applyDesktopState();
        }
    });

    // 2. Dropdown Menus
    const profileBtn = document.getElementById('profile-btn');
    const profileMenu = document.getElementById('profile-dropdown-menu');
    const notifyBtn = document.getElementById('notification-btn');
    const notifyMenu = document.getElementById('notification-dropdown-menu');

    profileBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        profileMenu?.classList.toggle('dropdown-menu-open');
        notifyMenu?.classList.remove('dropdown-menu-open');
    });

    notifyBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        notifyMenu?.classList.toggle('dropdown-menu-open');
        profileMenu?.classList.remove('dropdown-menu-open');
    });

    document.addEventListener('click', (e) => {
        if (profileMenu && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
            profileMenu.classList.remove('dropdown-menu-open');
        }
        if (notifyMenu && !notifyBtn.contains(e.target) && !notifyMenu.contains(e.target)) {
            notifyMenu.classList.remove('dropdown-menu-open');
        }
    });

    // 3. Search Autocomplete (Typeahead)
    const searchInput = document.getElementById('global-search');
    const searchMenu = document.getElementById('search-autocomplete-menu');
    const searchList = document.getElementById('search-suggestions-list');

    const panelsData = [
        { id: 'admin',     name: 'Admin Panel',     category: 'Dashboard' },
        { id: 'manager',   name: 'Manager Panel',   category: 'Dashboard' },
        { id: 'staff',     name: 'Staff Panel',     category: 'Dashboard' },
        { id: 'pos',       name: 'POS Terminal',    category: 'Sales' },
        { id: 'inventory-products', name: 'Inventory Products', category: 'Stock' },
        { id: 'inventory-categories', name: 'Inventory Categories', category: 'Stock' },
        { id: 'reports',   name: 'Reports & Analytics', category: 'Analytics' },
        { id: 'auth',      name: 'Auth Pages Demo', category: 'Design System' },
        { id: 'docs',      name: 'Component Documentation', category: 'Design System' }
    ];

    searchInput?.addEventListener('focus', () => {
        showSuggestions(searchInput.value);
    });

    searchInput?.addEventListener('input', () => {
        showSuggestions(searchInput.value);
    });

    document.addEventListener('click', (e) => {
        if (searchMenu && !searchInput.contains(e.target) && !searchMenu.contains(e.target)) {
            searchMenu.classList.add('hidden');
        }
    });

    function showSuggestions(query) {
        if (!searchList || !searchMenu) return;
        
        const filtered = panelsData.filter(item => 
            item.name.toLowerCase().includes(query.toLowerCase()) ||
            item.category.toLowerCase().includes(query.toLowerCase())
        );

        if (filtered.length === 0) {
            searchList.innerHTML = `<div class="px-4 py-2.5 text-xs text-secondary/50">No panels found</div>`;
        } else {
            searchList.innerHTML = filtered.map(item => `
                <div class="px-4 py-2 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer flex items-center justify-between" onclick="handleSearchSelect('${item.id}', '${item.name}')">
                    <span class="font-medium text-primary dark:text-slate-200">${item.name}</span>
                    <span class="text-[10px] uppercase font-bold tracking-wider px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-secondary text-xs">${item.category}</span>
                </div>
            `).join('');
        }
        searchMenu.classList.remove('hidden');
    }

    window.handleSearchSelect = function(id, name) {
        if (searchInput) searchInput.value = '';
        if (searchMenu) searchMenu.classList.add('hidden');
        
        let cleanId = id;
        if (id.startsWith('inventory-')) {
            cleanId = 'inventory';
            // Open inventory submenu if collapsed
            const sub = document.getElementById('submenu-inventory');
            if (sub) {
                sub.classList.remove('hidden');
                const arrow = document.getElementById('submenu-arrow-inventory');
                if (arrow) arrow.classList.add('rotate-180');
            }
        }
        
        // Find corresponding trigger and switch panel
        const trigger = document.querySelector(`[data-panel="${id}"]`) || document.querySelector(`[data-panel="${cleanId}"]`);
        if (window.switchPanel) {
            window.switchPanel(id, trigger);
        }
    };
});
</script>

</body>
</html>
