<x-layout title="Admin Control Console" subtitle="Unified enterprise overview, system health, and user management."
    :breadcrumbs="['Admin']">

    {{-- ══════════════════════════════════════════════════
     SIDEBAR LINKS SLOT
     ══════════════════════════════════════════════════ --}}
    <x-slot name="sidebarLinks">
        <div class="space-y-0.5" id="sidebar-nav">

            {{-- ── Top-level nav items ── --}}
            @php
                $navItem = fn(
                    string $panel,
                    string $label,
                    string $icon,
                    bool $active = false,
                    string $extra = '',
                ) => "<button
                    type='button'
                    onclick=\"switchPanel('{$panel}',this)\"
                    data-panel='{$panel}'
                    data-tooltip='{$label}'
                    class='sidebar-link group w-full flex items-center gap-3
                           px-3 py-2.5 rounded text-sm font-medium
                           transition-colors duration-150 cursor-pointer
                           " .
                    ($active
                        ? 'bg-white/10 text-white border-l-[4px] border-blue-400'
                        : 'text-slate-300 hover:bg-white/8 hover:text-white border-l-[4px] border-transparent') .
                    " {$extra}'
                >
                    <span class='shrink-0 w-5 h-5 flex items-center justify-center'>{$icon}</span>
                    <span class='sidebar-label whitespace-nowrap overflow-hidden transition-[opacity,width] duration-200'>{$label}</span>
                </button>";
            @endphp

            {{-- Collapsible submenu parent helper --}}
            @php
                $navParent = fn(string $id, string $label, string $icon) => "<button
                    type='button'
                    onclick=\"toggleSubmenu('{$id}',this)\"
                    data-tooltip='{$label}'
                    class='sidebar-link group w-full flex items-center gap-3
                           px-3 py-2.5 rounded text-sm font-medium
                           transition-colors duration-150 cursor-pointer
                           text-slate-300 hover:bg-white/8 hover:text-white border-l-[4px] border-transparent'
                >
                    <span class='shrink-0 w-5 h-5 flex items-center justify-center'>{$icon}</span>
                    <span class='sidebar-label flex-1 whitespace-nowrap overflow-hidden transition-[opacity,width] duration-200 text-left'>{$label}</span>
                    <svg id='submenu-arrow-{$id}' class='sidebar-label w-3.5 h-3.5 shrink-0 transition-transform duration-200 text-slate-500' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2.5'>
                        <path stroke-linecap='round' stroke-linejoin='round' d='M9 5l7 7-7 7'/>
                    </svg>
                </button>";
            @endphp

            {{-- Submenu sub-link helper --}}
            @php
                $subItem = fn(string $panel, string $label, string $icon = '') => "<button
                    type='button'
                    onclick=\"switchPanel('{$panel}',this)\"
                    data-panel='{$panel}'
                    data-tooltip='{$label}'
                    class='sidebar-sublink sidebar-label-item'
                >
                    <span class='w-1.5 h-1.5 rounded-full bg-slate-600 shrink-0'></span>
                    <span class='sidebar-label whitespace-nowrap overflow-hidden'>{$label}</span>
                </button>";
            @endphp

            {{-- SVG Icons --}}
            @php
                $icons = [
                    'admin' =>
                        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>',
                    'manager' =>
                        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
                    'staff' =>
                        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>',
                    'pos' =>
                        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                    'inventory' =>
                        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
                    'reports' =>
                        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
                    'auth' =>
                        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>',
                    'docs' =>
                        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
                ];
            @endphp

            {!! $navItem('admin', 'Admin Panel', $icons['admin'], true) !!}
            {!! $navItem('manager', 'Manager Panel', $icons['manager']) !!}
            {!! $navItem('staff', 'Staff Panel', $icons['staff']) !!}
            {!! $navItem('pos', 'POS Terminal', $icons['pos']) !!}
            {!! $navItem('reports', 'Reports', $icons['reports']) !!}

            {{-- ── Inventory — collapsible parent ── --}}
            {!! $navParent('inventory', 'Inventory', $icons['inventory']) !!}

            {{-- Inventory sub-menu (collapsed by default) --}}
            <div id="submenu-inventory"
                class="sidebar-label-container hidden overflow-hidden transition-all duration-200">
                {!! $subItem('inventory', 'All Products') !!}
                {!! $subItem('inventory-categories', 'Categories') !!}
                {!! $subItem('inventory-suppliers', 'Suppliers') !!}
            </div>

            {{-- Section divider --}}
            <div class="pt-4 pb-1 px-3">
                <span
                    class="sidebar-label text-sm font-semibold uppercase tracking-widest text-slate-500 whitespace-nowrap overflow-hidden block">
                    Design System
                </span>
            </div>

            {!! $navItem('auth', 'Auth Pages', $icons['auth']) !!}
            {!! $navItem('docs', 'Component Docs', $icons['docs']) !!}
        </div>
    </x-slot>

    {{-- ══════════════════════════════════════════════════
     PAGE ACTIONS SLOT (top-right of page header)
     ══════════════════════════════════════════════════ --}}
    <x-slot name="pageActions">
        <x-button variant="outline" size="sm" onclick="omniOpenModal('modal-add-user')">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add User
        </x-button>
        <x-button variant="primary" size="sm" onclick="omniOpenModal('modal-add-user')">
            Quick Action
        </x-button>
    </x-slot>


    {{-- ══════════════════════════════════════════════════════════════
     ① ADMIN PANEL
     ══════════════════════════════════════════════════════════════ --}}
    <div id="panel-admin" class="panel space-y-6">

        {{-- System alert --}}
        <x-alert type="info" dismissible="true">
            <strong>Scheduled Maintenance:</strong> A routine database health scan runs tonight at 02:00 AM UTC. No
            downtime expected.
        </x-alert>

        {{-- ── 4-column stat grid ── --}}
        <div class="omni-grid">
            <x-stat-card label="Total Users" value="1,482" trend="+12.4%" :up="true" badge="Active"
                badge-variant="success" sub="Registered accounts" />
            <x-stat-card label="CPU Load" value="34.8%" trend="-2.1%" :up="false" badge="Stable"
                badge-variant="primary" sub="Avg across 4 cores" />
            <x-stat-card label="Security Alerts" value="0" sub="No active threats detected" badge="Secured"
                badge-variant="success" />
            <x-stat-card label="License" value="Active" sub="Valid through Dec 2026" badge="Enterprise"
                badge-variant="info" />
        </div>

        {{-- ── 2-column layout: user table + form ── --}}
        <div class="omni-grid-2 items-start">

            {{-- User directory card --}}
            <div class="space-y-3">
                {{-- Filter toolbar above the table --}}
                <x-filter-toolbar search-placeholder="Search users…" search-id="admin-user-search">
                    <x-slot name="actions">
                        <x-button variant="outline" size="sm">
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export CSV
                        </x-button>
                        <x-button variant="primary" size="sm" onclick="omniOpenModal('modal-add-user')">
                            + Add User
                        </x-button>
                    </x-slot>
                </x-filter-toolbar>

                {{-- Table inside card, table-scroll-container for sticky header --}}
                <x-card title="System User Directory" subtitle="Manage access tiers and operational panels.">
                    <div class="table-scroll-container">
                        <table class="w-full border-collapse text-left text-sm text-secondary">
                            <thead>
                                <tr>
                                    @foreach (['User Profile', 'Panel', 'Security Tier', 'Status', 'Action'] as $h)
                                        <th
                                            class="px-4 py-3 text-sm font-semibold text-primary uppercase tracking-wider whitespace-nowrap">
                                            {{ $h }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-subtle dark:divide-slate-700">
                                @foreach ([['MF', 'Mamun Farhad', 'farhad@coreaxis.com', 'Admin Panel', 'Level-5 Super', 'success', 'Active'], ['TA', 'Tariq Anwer', 't.anwer@coreaxis.com', 'Manager Panel', 'Level-3 Executive', 'success', 'Active'], ['KB', 'Karim Bhuiyan', 'k.bhuiyan@coreaxis.com', 'POS Terminal', 'Level-1 Staff', 'warning', 'Suspended'], ['NJ', 'Nusrat Jahan', 'n.jahan@coreaxis.com', 'Inventory', 'Level-2 Staff', 'success', 'Active'], ['RH', 'Rahim Hossain', 'r.hossain@coreaxis.com', 'Staff Panel', 'Level-1 Staff', 'danger', 'Inactive']] as [$init, $name, $email, $panel, $tier, $badgeV, $status])
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-primary/10 dark:bg-blue-900/30 text-primary dark:text-blue-400 font-bold text-sm flex items-center justify-center shrink-0">
                                                    {{ $init }}</div>
                                                <div>
                                                    <span
                                                        class="block font-semibold text-primary dark:text-slate-200 text-sm">{{ $name }}</span>
                                                    <span
                                                        class="text-sm text-secondary/60 dark:text-slate-500">{{ $email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-secondary dark:text-slate-400">
                                            {{ $panel }}</td>
                                        <td class="px-4 py-3 text-sm font-mono text-secondary dark:text-slate-500">
                                            {{ $tier }}</td>
                                        <td class="px-4 py-3"><x-badge :variant="$badgeV"
                                                dot="true">{{ $status }}</x-badge></td>
                                        <td class="px-4 py-3"><x-button variant="outline"
                                                size="sm">Manage</x-button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <x-slot name="footer">
                        <span class="text-sm text-secondary dark:text-slate-500">Showing 5 of 1,482 users</span>
                        <div class="flex items-center gap-1 ml-auto">
                            <x-button variant="ghost" size="sm">← Prev</x-button>
                            <x-button variant="ghost" size="sm">Next →</x-button>
                        </div>
                    </x-slot>
                </x-card>
            </div>

            {{-- Provision account form card --}}
            <x-card title="Provision New Account" subtitle="Establish profile specifications and panel roles.">
                <form id="admin-user-form" onsubmit="event.preventDefault(); handleAdminForm()" class="space-y-0">
                    <x-input name="a_name" label="Full Name" placeholder="e.g. Yeasin Arafat" required="true" />
                    <x-input name="a_email" label="Email Address" type="email" placeholder="y.arafat@coreaxis.com"
                        required="true" />
                    <x-input name="a_panel" label="Assigned Panel" type="select" required="true">
                        <option value="">Select panel…</option>
                        <option>Admin Panel</option>
                        <option>Manager Panel</option>
                        <option>POS Terminal</option>
                        <option>Inventory</option>
                        <option>Staff Panel</option>
                    </x-input>
                    <x-input name="a_role" label="Security Tier" type="select">
                        <option>Level-1 Staff</option>
                        <option>Level-2 Staff</option>
                        <option>Level-3 Executive</option>
                        <option>Level-5 Super</option>
                    </x-input>
                    <x-input name="a_notes" label="Notes (optional)" type="textarea"
                        placeholder="Any special access requirements…" />
                    {{-- Form actions — always right-aligned --}}
                    <div class="flex justify-end gap-2 pt-2">
                        <x-button type="button" variant="ghost"
                            onclick="document.getElementById('admin-user-form').reset()">Reset</x-button>
                        <x-button type="submit" variant="primary">Create Account</x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════
     ② MANAGER PANEL
     ══════════════════════════════════════════════════════════════ --}}
    <div id="panel-manager" class="panel hidden space-y-6">

        <div class="omni-grid-3">
            <x-stat-card label="Monthly Target Sales" value="$42,500">
                <x-slot name="sub">
                    <div class="mt-2 space-y-1">
                        <div class="flex justify-between text-sm"><span>84.2% reached</span><span
                                class="font-semibold text-success">$35,805</span></div>
                        <div class="w-full bg-slate-100 dark:bg-slate-700 h-2 rounded overflow-hidden">
                            <div class="bg-success h-full transition-all duration-700" style="width:84.2%"></div>
                        </div>
                    </div>
                </x-slot>
            </x-stat-card>
            <x-stat-card label="Pending Approvals" value="3" badge="Action Required" badge-variant="warning"
                sub="Purchase orders and shift changes" />
            <x-stat-card label="Operational Capacity" value="92.6%">
                <x-slot name="sub">
                    <div class="mt-2 w-full bg-slate-100 dark:bg-slate-700 h-2 rounded overflow-hidden">
                        <div class="bg-primary h-full" style="width:92.6%"></div>
                    </div>
                </x-slot>
            </x-stat-card>
        </div>

        {{-- Approvals table --}}
        <x-card title="Pending Approval Queue" subtitle="Review and action operational expense submissions.">
            <x-filter-toolbar search-placeholder="Search requests…" search-id="mgr-search">
                <x-slot name="actions">
                    <x-button variant="outline" size="sm">Export</x-button>
                </x-slot>
            </x-filter-toolbar>
            <div class="mt-3 table-scroll-container">
                <table class="w-full border-collapse text-left text-sm">
                    <thead>
                        <tr>
                            @foreach (['Requestor', 'Department', 'Amount', 'Description', 'Actions'] as $h)
                                <th
                                    class="px-4 py-3 text-sm font-semibold text-primary uppercase tracking-wider whitespace-nowrap">
                                    {{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle dark:divide-slate-700" id="approvals-tbody">
                        @foreach ([['req-1', 'Abul Hossain', 'Procurement', '$1,250.00', 'Server SSD clusters replenishment'], ['req-2', 'Nusrat Jahan', 'POS Inventory', '$450.00', 'Barcode scanner thermal roll restock'], ['req-3', 'Rahim Hossain', 'Facilities', '$780.00', 'Office chair replacement order']] as [$id, $name, $dept, $amt, $desc])
                            <tr id="{{ $id }}"
                                class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="px-4 py-3 font-semibold text-primary dark:text-slate-200 text-sm">
                                    {{ $name }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-secondary dark:text-slate-400">
                                    {{ $dept }}</td>
                                <td class="px-4 py-3 text-sm font-bold font-mono text-primary dark:text-slate-200">
                                    {{ $amt }}</td>
                                <td class="px-4 py-3 text-sm text-secondary dark:text-slate-400">{{ $desc }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <x-button variant="success" size="sm"
                                            onclick="approveRow('{{ $id }}','{{ $name }}')">Approve</x-button>
                                        <x-button variant="danger" size="sm"
                                            onclick="rejectRow('{{ $id }}','{{ $name }}')">Reject</x-button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>


    {{-- ══════════════════════════════════════════════════════════════
     ③ STAFF PANEL
     ══════════════════════════════════════════════════════════════ --}}
    <div id="panel-staff" class="panel hidden space-y-6">
        <div class="omni-grid-2 items-start">

            {{-- Shift profile --}}
            <x-card title="Active Shift Profile" subtitle="Your current shift assignment and session log.">
                <dl class="divide-y divide-border-subtle dark:divide-slate-700">
                    @foreach ([['Shift Assignment', 'POS Terminal Operator 2'], ['Session Duration', '08h : 15m'], ['Team Lead', 'Tariq Anwer'], ['Location', 'Dhaka Central Branch']] as [$lbl, $val])
                        <div class="py-3 flex items-center justify-between gap-4">
                            <dt class="text-sm font-semibold uppercase tracking-wider text-slate-400">
                                {{ $lbl }}</dt>
                            <dd class="text-sm font-semibold text-primary dark:text-slate-200 text-right">
                                {{ $val }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>

            {{-- Daily checklist --}}
            <x-card title="Daily Operational Checklist" subtitle="Complete all items before and after each shift.">
                <div class="space-y-2" id="staff-checklist">
                    @foreach ([['t1', 'Verify POS register cash drawer float ($150 opening balance)'], ['t2', 'Run diagnostic scan on barcode scanner units'], ['t3', 'Submit daily stock log to Inventory panel'], ['t4', 'Confirm shift handover notes are recorded'], ['t5', 'Check printer ink and thermal paper supply']] as [$tid, $desc])
                        <label for="{{ $tid }}"
                            class="form-check p-3 rounded border border-transparent
                              hover:bg-slate-50 dark:hover:bg-slate-800/50
                              hover:border-border-subtle dark:hover:border-slate-700
                              cursor-pointer transition-all duration-150 gap-2">
                            <input type="checkbox" id="{{ $tid }}" onchange="toggleTask(this)"
                                class="form-check-input shrink-0 cursor-pointer" />
                            <span
                                class="form-check-label text-sm text-secondary dark:text-slate-400 leading-relaxed task-text">{{ $desc }}</span>
                        </label>
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════
     ④ POS TERMINAL
     ══════════════════════════════════════════════════════════════ --}}
    <div id="panel-pos" class="panel hidden">
        <div class="pos-shell">

            {{-- LEFT: Product catalog --}}
            <div class="pos-catalog space-y-4">

                {{-- Category filter bar --}}
                <div class="flex items-center gap-2 flex-wrap" id="pos-categories">
                    @foreach (['All', 'Food & Drink', 'Electronics', 'Accessories'] as $cat)
                        <button type="button" onclick="filterPosCategory(this, '{{ $cat }}')"
                            class="pos-cat-btn px-4 py-2 rounded border text-sm font-medium
                               border-border-subtle dark:border-slate-700
                               bg-panel-bg dark:bg-slate-900
                               text-secondary dark:text-slate-400
                               hover:bg-primary hover:text-white hover:border-primary
                               transition-colors cursor-pointer"
                            data-cat="{{ $cat }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>

                {{-- Product grid --}}
                <div class="omni-grid" id="pos-product-grid">
                    @foreach ([['🍲', 'Organic Salad Bowl', 'Food & Drink', 12.0, 'salad-bowl'], ['☕', 'Premium Roast Coffee', 'Food & Drink', 4.5, 'roast-coffee'], ['⌨️', 'Wireless Keyboard', 'Electronics', 45.0, 'keyboard'], ['🖱️', 'Ergonomic Mouse', 'Electronics', 35.0, 'mouse'], ['🔌', 'USB-C Hub Adapter', 'Accessories', 25.0, 'usb-hub'], ['💻', 'Laptop Desk Stand', 'Accessories', 29.99, 'desk-stand'], ['🎧', 'Noise-Cancel Headset', 'Electronics', 89.0, 'headset'], ['🖨️', 'Portable Printer', 'Electronics', 120.0, 'printer']] as [$emoji, $name, $cat, $price, $sku])
                        <div data-cat="{{ $cat }}"
                            class="pos-product-item bg-panel-bg dark:bg-slate-900
                            border border-border-subtle dark:border-slate-700
                            rounded p-4 flex flex-col gap-3
                            hover:shadow-sm hover:border-primary/30 transition-all duration-150">
                            <div
                                class="w-10 h-10 text-2xl flex items-center justify-center bg-slate-100 dark:bg-slate-800 rounded shrink-0">
                                {{ $emoji }}
                            </div>
                            <div class="flex-1">
                                <h5 class="font-semibold text-primary dark:text-slate-200 m-0 leading-tight">
                                    {{ $name }}</h5>
                                <span
                                    class="text-sm text-secondary/60 dark:text-slate-500 font-normal">{{ $cat }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-auto">
                                <span class="font-bold font-mono text-primary dark:text-slate-200">
                                    ${{ number_format($price, 2) }}
                                </span>
                                <x-button variant="outline" size="sm"
                                    onclick="addToCart('{{ $name }}', {{ $price }})">
                                    + Add
                                </x-button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT: Checkout register --}}
            <div class="pos-register">
                <x-card title="Checkout Register" subtitle="Current transaction cart.">
                    {{-- Cart items list --}}
                    <div id="pos-cart-items" class="min-h-[200px] max-h-[320px] overflow-y-auto space-y-2 pr-1">
                        <div id="pos-empty-state"
                            class="flex flex-col items-center justify-center py-12 text-secondary/30 dark:text-slate-600">
                            <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                            <span class="text-sm font-medium">Cart is empty</span>
                        </div>
                    </div>

                    {{-- Totals --}}
                    <div class="border-t border-border-subtle dark:border-slate-700 mt-4 pt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-secondary dark:text-slate-400">
                            <span>Subtotal</span>
                            <span class="font-mono font-semibold text-primary dark:text-slate-200"
                                id="pos-subtotal">$0.00</span>
                        </div>
                        <div class="flex justify-between text-secondary dark:text-slate-400">
                            <span>VAT (5%)</span>
                            <span class="font-mono font-semibold text-primary dark:text-slate-200"
                                id="pos-tax">$0.00</span>
                        </div>
                        <div
                            class="flex justify-between font-bold text-primary dark:text-slate-100 border-t border-dashed border-border-subtle dark:border-slate-700 pt-2">
                            <span>Grand Total</span>
                            <span class="font-mono text-base" id="pos-total">$0.00</span>
                        </div>
                    </div>

                    {{-- Payment method --}}
                    <div class="grid grid-cols-2 gap-2 mt-4">
                        <label
                            class="flex items-center justify-center gap-2 border border-border-subtle dark:border-slate-700 rounded p-2.5 cursor-pointer hover:border-primary/40 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <input type="radio" name="pos_pay" value="cash" checked class="accent-primary" />
                            <span class="text-sm font-semibold text-primary dark:text-slate-300">Cash</span>
                        </label>
                        <label
                            class="flex items-center justify-center gap-2 border border-border-subtle dark:border-slate-700 rounded p-2.5 cursor-pointer hover:border-primary/40 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <input type="radio" name="pos_pay" value="card" class="accent-primary" />
                            <span class="text-sm font-semibold text-primary dark:text-slate-300">Card</span>
                        </label>
                    </div>

                    <x-button variant="success" size="lg" class="w-full mt-4" onclick="checkoutCart()">
                        Complete Checkout
                    </x-button>

                    <x-slot name="footer">
                        <x-button variant="ghost" size="sm" onclick="clearCart()">Clear Cart</x-button>
                        <span class="text-sm text-secondary dark:text-slate-500" id="pos-item-count">0 items</span>
                    </x-slot>
                </x-card>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════
     ⑤ INVENTORY
     ══════════════════════════════════════════════════════════════ --}}
    <div id="panel-inventory" class="panel hidden space-y-6">
        <x-alert type="warning">
            <strong>Stock Alert:</strong> 3 items are below their safety threshold. Immediate reorder recommended.
        </x-alert>

        <x-filter-toolbar search-placeholder="Search products by SKU or name…" search-id="inv-search">
            <x-slot name="actions">
                <x-button variant="outline" size="sm" id="btn-inv-empty" onclick="toggleInvEmpty()">Simulate
                    Empty State</x-button>
                <x-button variant="primary" size="sm">+ Add Product</x-button>
            </x-slot>
        </x-filter-toolbar>

        <div id="inv-table-wrap">
            <x-card title="Product Stock Directory"
                subtitle="Real-time stock levels, SKU tracking, and replenishment controls.">
                <div class="table-scroll-container">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead>
                            <tr>
                                @foreach (['SKU Code', 'Product', 'On Hand', 'Threshold', 'Status', 'Action'] as $h)
                                    <th
                                        class="px-4 py-3 text-sm font-semibold text-primary uppercase tracking-wider whitespace-nowrap">
                                        {{ $h }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-subtle dark:divide-slate-700">
                            @foreach ([['SKU-49102-SLD', 'Organic Salad Bowl', 145, 30, 'success', 'In Stock'], ['SKU-31294-COF', 'Premium Roast Coffee', 8, 25, 'danger', 'Critical Low'], ['SKU-89241-KBD', 'Wireless Keyboard', 14, 15, 'warning', 'Low Stock'], ['SKU-99201-MSE', 'Ergonomic Mouse', 4, 10, 'danger', 'Critical Low'], ['SKU-72934-HUB', 'USB-C Hub Adapter', 52, 20, 'success', 'In Stock']] as [$sku, $name, $qty, $threshold, $variant, $status])
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-4 py-3 text-sm font-mono font-bold text-primary dark:text-slate-300">
                                        {{ $sku }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-primary dark:text-slate-200">
                                        {{ $name }}</td>
                                    <td
                                        class="px-4 py-3 text-sm font-mono {{ $qty <= $threshold ? 'text-danger font-bold' : 'text-secondary dark:text-slate-400' }}">
                                        {{ $qty }} units</td>
                                    <td class="px-4 py-3 text-sm font-mono text-secondary/60 dark:text-slate-500">
                                        {{ $threshold }} units</td>
                                    <td class="px-4 py-3"><x-badge :variant="$variant"
                                            dot="true">{{ $status }}</x-badge></td>
                                    <td class="px-4 py-3">
                                        <x-button :variant="$variant === 'success' ? 'ghost' : 'primary'" size="sm"
                                            onclick="{{ $variant === 'success' ? 'void(0)' : 'replenish(this,\'' . $name . '\')' }}">
                                            {{ $variant === 'success' ? 'Stocked' : 'Reorder' }}
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
     ⑤.A INVENTORY CATEGORIES
     ══════════════════════════════════════════════════════════════ --}}
    <div id="panel-inventory-categories" class="panel hidden space-y-6">
        <x-filter-toolbar search-placeholder="Search categories..." search-id="cat-search">
            <x-slot name="actions">
                <x-button variant="primary" size="sm">+ Add Category</x-button>
            </x-slot>
        </x-filter-toolbar>

        <div class="omni-grid-2 items-start">
            <x-card title="Product Categories"
                subtitle="Manage taxonomies, parent classes, and active SKU groupings.">
                <div class="table-scroll-container">
                    <table class="w-full border-collapse text-left text-sm text-secondary">
                        <thead>
                            <tr>
                                @foreach (['Category Name', 'Description', 'SKUs Count', 'Status', 'Actions'] as $h)
                                    <th
                                        class="px-4 py-3 text-sm font-semibold text-primary uppercase tracking-wider whitespace-nowrap">
                                        {{ $h }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-subtle dark:divide-slate-700">
                            @foreach ([['Food & Drink', 'Organic meals, specialty coffees, and grab-and-go snacks.', 45, 'success', 'Active'], ['Electronics', 'Peripherals, scanners, terminal systems, and networking components.', 12, 'success', 'Active'], ['Accessories', 'Stands, mounts, charging hubs, and thermal printer rolls.', 8, 'success', 'Active']] as [$cat_name, $desc, $skus, $badge_v, $status])
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-4 py-3 font-semibold text-primary dark:text-slate-200 text-sm">
                                        {{ $cat_name }}</td>
                                    <td class="px-4 py-3 text-sm text-secondary dark:text-slate-400 max-w-[200px] truncate"
                                        title="{{ $desc }}">{{ $desc }}</td>
                                    <td class="px-4 py-3 text-sm font-mono text-secondary dark:text-slate-500">
                                        {{ $skus }} products</td>
                                    <td class="px-4 py-3"><x-badge :variant="$badge_v"
                                            dot="true">{{ $status }}</x-badge></td>
                                    <td class="px-4 py-3"><x-button variant="outline" size="sm">Edit</x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            <x-card title="Create New Category" subtitle="Define taxonomy classification levels.">
                <form id="cat-form"
                    onsubmit="event.preventDefault(); showToast('success', 'Product category created successfully.'); this.reset();"
                    class="space-y-0">
                    <x-input name="cat_name" label="Category Name" placeholder="e.g. Health & Safety"
                        required="true" />
                    <x-input name="cat_desc" label="Description" type="textarea"
                        placeholder="Describe the product taxonomy tier..." />
                    <x-input name="cat_parent" label="Parent Category (optional)" type="select">
                        <option value="">None (Top-Level)</option>
                        <option>Food & Drink</option>
                        <option>Electronics</option>
                        <option>Accessories</option>
                    </x-input>
                    <div class="mb-4">
                        <span
                            class="block text-sm font-semibold text-primary mb-2 uppercase tracking-wider">Status</span>
                        <label
                            class="flex items-center gap-3 cursor-pointer p-3 rounded border border-border-subtle dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <input type="checkbox" class="form-switch" id="cat-status" checked />
                            <span class="text-sm font-medium text-primary dark:text-slate-200">Active and visible to
                                POS</span>
                        </label>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <x-button type="button" variant="ghost"
                            onclick="document.getElementById('cat-form').reset()">Reset</x-button>
                        <x-button type="submit" variant="primary">Create Category</x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
     ⑤.B SUPPLIER DIRECTORY
     ══════════════════════════════════════════════════════════════ --}}
    <div id="panel-inventory-suppliers" class="panel hidden space-y-6">
        <x-filter-toolbar search-placeholder="Search suppliers..." search-id="supplier-search">
            <x-slot name="actions">
                <x-button variant="primary" size="sm" onclick="omniOpenModal('modal-add-user')">+ Add
                    Supplier</x-button>
            </x-slot>
        </x-filter-toolbar>

        <div class="omni-grid-2 items-start">
            <x-card title="Supplier Registry" subtitle="Primary replenishment sources, SLA metrics, and contacts.">
                <div class="table-scroll-container">
                    <table class="w-full border-collapse text-left text-sm text-secondary">
                        <thead>
                            <tr>
                                @foreach (['Supplier', 'Primary Contact', 'Phone / Email', 'Active Orders', 'Status', 'Actions'] as $h)
                                    <th
                                        class="px-4 py-3 text-sm font-semibold text-primary uppercase tracking-wider whitespace-nowrap">
                                        {{ $h }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-subtle dark:divide-slate-700">
                            @foreach ([['Apex Foods Ltd', 'Mamun Hossain', '+880 1711-223344', 2, 'success', 'Active'], ['Global Tech Corp', 'Nusrat Jahan', '+880 1911-556677', 0, 'success', 'Active'], ['Synergy Logistics', 'Rahim Uddin', '+880 1811-990011', 1, 'warning', 'Suspended']] as [$sup_name, $contact, $phone, $orders, $badge_v, $status])
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-4 py-3 font-semibold text-primary dark:text-slate-200 text-sm">
                                        <div>{{ $sup_name }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-secondary dark:text-slate-400">
                                        {{ $contact }}</td>
                                    <td class="px-4 py-3 text-sm font-mono text-secondary/60 dark:text-slate-500">
                                        {{ $phone }}</td>
                                    <td class="px-4 py-3 text-sm font-mono text-secondary dark:text-slate-500">
                                        {{ $orders }} orders</td>
                                    <td class="px-4 py-3"><x-badge :variant="$badge_v"
                                            dot="true">{{ $status }}</x-badge></td>
                                    <td class="px-4 py-3"><x-button variant="outline"
                                            size="sm">Manage</x-button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            <x-card title="Register New Supplier" subtitle="Establish profile specifications and supply SLA.">
                <form id="supplier-form"
                    onsubmit="event.preventDefault(); showToast('success', 'Supplier registered successfully.'); this.reset();"
                    class="space-y-0">
                    <x-input name="sup_name" label="Supplier Name" placeholder="e.g. Acme Supplies Ltd"
                        required="true" />
                    <x-input name="sup_contact" label="Primary Contact Person" placeholder="e.g. Yeasin Arafat"
                        required="true" />
                    <x-input name="sup_phone" label="Phone Number" placeholder="+880 1700-000000" required="true" />
                    <x-input name="sup_email" label="Email Address" type="email"
                        placeholder="y.arafat@acme.com" />
                    <div class="mb-4">
                        <span
                            class="block text-sm font-semibold text-primary mb-2 uppercase tracking-wider">Status</span>
                        <label
                            class="flex items-center gap-3 cursor-pointer p-3 rounded border border-border-subtle dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <input type="checkbox" class="form-switch" id="sup-status" checked />
                            <span class="text-sm font-medium text-primary dark:text-slate-200">Preferred procurement
                                source</span>
                        </label>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <x-button type="button" variant="ghost"
                            onclick="document.getElementById('supplier-form').reset()">Reset</x-button>
                        <x-button type="submit" variant="primary">Register Supplier</x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
     ⑥ REPORTS
     ══════════════════════════════════════════════════════════════ --}}
    <div id="panel-reports" class="panel hidden space-y-6">

        {{-- Report controls toolbar --}}
        <x-filter-toolbar search-placeholder="Search reports…" search-id="report-search">
            <x-slot name="actions">
                <select
                    class="form-control-input w-40 text-sm dark:bg-slate-900 dark:border-slate-700 dark:text-slate-100">
                    <option>Last 7 Days</option>
                    <option>Last 30 Days</option>
                    <option selected>This Month</option>
                    <option>Last Quarter</option>
                </select>
                <x-button variant="outline" size="sm">Export PDF</x-button>
            </x-slot>
        </x-filter-toolbar>

        {{-- Two-column chart layout on desktop --}}
        <div class="omni-grid-2">

            {{-- Revenue Chart (CSS bar chart) --}}
            <x-card title="Monthly Revenue" subtitle="Revenue trend across the last 6 months.">
                <div class="flex items-end justify-between gap-2 h-40 mt-2" aria-label="Monthly revenue bar chart">
                    @foreach ([['Jan', '$28k', 45], ['Feb', '$34k', 55], ['Mar', '$29k', 47], ['Apr', '$41k', 66], ['May', '$38k', 61], ['Jun', '$42.5k', 68]] as [$month, $label, $pct])
                        <div class="flex flex-col items-center gap-1 flex-1">
                            <span
                                class="text-sm font-semibold text-primary dark:text-slate-300">{{ $label }}</span>
                            <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-t overflow-hidden flex items-end"
                                style="height:96px">
                                <div class="w-full bg-primary/80 dark:bg-blue-600 rounded-t transition-all duration-700 hover:bg-primary"
                                    style="height:{{ $pct }}%"></div>
                            </div>
                            <span class="text-sm text-secondary dark:text-slate-500">{{ $month }}</span>
                        </div>
                    @endforeach
                </div>
            </x-card>

            {{-- Top products table --}}
            <x-card title="Top Products by Revenue" subtitle="Best performing SKUs this month.">
                <div class="space-y-3 mt-1">
                    @foreach ([['Ergonomic Mouse', '$12,450', 78], ['Wireless Keyboard', '$9,800', 61], ['USB-C Hub Adapter', '$6,250', 39], ['Laptop Desk Stand', '$4,100', 26], ['Premium Roast Coffee', '$3,600', 22]] as [$prod, $rev, $pct])
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-primary dark:text-slate-300">{{ $prod }}</span>
                                <span
                                    class="font-bold font-mono text-primary dark:text-slate-200">{{ $rev }}</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-700 h-1.5 rounded overflow-hidden">
                                <div class="bg-primary h-full rounded" style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>

        {{-- Summary stats --}}
        <div class="omni-grid">
            <x-stat-card label="Total Revenue" value="$42,500" trend="+18.2%" :up="true"
                sub="vs last month" />
            <x-stat-card label="Transactions" value="1,284" trend="+9.4%" :up="true"
                sub="Completed orders" />
            <x-stat-card label="Avg Order Value" value="$33.10" trend="-2.1%" :up="false"
                sub="Per transaction" />
            <x-stat-card label="Refund Rate" value="1.3%" trend="-0.4%" :up="true"
                sub="Below industry avg" />
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════
     ⑦ AUTH PAGE DEMO
     ══════════════════════════════════════════════════════════════ --}}
    <div id="panel-auth" class="panel hidden space-y-6">
        <x-alert type="info">
            This is a preview of the <strong>Authentication Pages</strong> layout pattern. The real auth pages use the
            standalone <code class="text-sm bg-slate-100 dark:bg-slate-800 px-1 rounded">&lt;x-auth-layout&gt;</code>
            component (max-width 400px centered card).
        </x-alert>

        {{-- Simulated auth cards side by side --}}
        <div class="omni-grid-2">

            {{-- Login card --}}
            <div class="flex justify-center">
                <div class="w-full max-w-[400px] space-y-6">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 rounded bg-primary text-white mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3" />
                            </svg>
                        </div>
                        <h2 class="font-semibold text-primary dark:text-slate-100">OmniCore Enterprise</h2>
                        <p class="text-sm text-secondary dark:text-slate-400 mt-1">Sign in to your workspace</p>
                    </div>
                    <div
                        class="bg-panel-bg dark:bg-slate-900 border border-border-subtle dark:border-slate-700 rounded shadow-sm px-8 py-8">
                        <form onsubmit="event.preventDefault()">
                            <x-input name="auth_email" label="Email Address" type="email"
                                placeholder="admin@coreaxis.com" required="true" />
                            <x-input name="auth_pass" label="Password" type="password" placeholder="••••••••"
                                required="true" />
                            <div class="flex items-center justify-between mb-4">
                                <label class="form-check cursor-pointer text-sm text-secondary dark:text-slate-400">
                                    <input type="checkbox" class="form-check-input" />
                                    <span class="form-check-label">Remember me</span>
                                </label>
                                <a href="#"
                                    class="text-sm text-primary dark:text-blue-400 hover:underline">Forgot
                                    password?</a>
                            </div>
                            <x-button type="submit" variant="primary" class="w-full">Sign In to OmniCore</x-button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Forgot password card --}}
            <div class="flex justify-center">
                <div class="w-full max-w-[400px] space-y-6">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 rounded bg-warning text-white mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <h2 class="font-semibold text-primary dark:text-slate-100">Reset Password</h2>
                        <p class="text-sm text-secondary dark:text-slate-400 mt-1">Enter your email to receive a reset
                            link</p>
                    </div>
                    <div
                        class="bg-panel-bg dark:bg-slate-900 border border-border-subtle dark:border-slate-700 rounded shadow-sm px-8 py-8">
                        <form onsubmit="event.preventDefault(); showForgotSuccess()">
                            <x-input name="forgot_email" label="Registered Email Address" type="email"
                                placeholder="you@coreaxis.com" required="true"
                                helper="We'll send a password reset link to this address." />
                            <x-button type="submit" variant="primary" class="w-full mt-2">Send Reset Link</x-button>
                            <a href="#"
                                class="block text-center text-sm text-secondary dark:text-slate-400 hover:text-primary mt-4">←
                                Back to login</a>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="panel-docs" class="panel hidden space-y-6">

        <x-alert type="info">
            Components are modular Blade files in <code
                class="text-sm bg-slate-100 dark:bg-slate-800 px-1 rounded">resources/views/components/</code>. All
            support light &amp; dark mode, WCAG 2.1 AA contrast, and strict typography (minimum 0.875rem).
        </x-alert>

        {{-- Buttons --}}
        <x-card title="&lt;x-button&gt; System Standards"
            subtitle="Premium button components supporting solid, outline, and ghost variants. Sized uniformly (sm: 32px, md: 38px, lg: 46px).">
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-semibold text-primary dark:text-slate-200 mb-2 uppercase tracking-wider">Solid Button System</p>
                    <div class="flex flex-wrap gap-3 items-center">
                        <x-button variant="primary">Primary Action</x-button>
                        <x-button variant="secondary">Secondary Action</x-button>
                        <x-button variant="success">Success / Confirm</x-button>
                        <x-button variant="danger">Danger / Delete</x-button>
                        <x-button variant="ghost">Ghost Option</x-button>
                        <x-button variant="primary" disabled="true">Disabled Solid</x-button>
                    </div>
                </div>
                
                <div class="border-t border-border-subtle dark:border-slate-700 pt-3">
                    <p class="text-sm font-semibold text-primary dark:text-slate-200 mb-2 uppercase tracking-wider">Outline Button Variants</p>
                    <div class="flex flex-wrap gap-3 items-center">
                        <x-button variant="outline-primary">Outline Primary</x-button>
                        <x-button variant="outline-secondary">Outline Secondary</x-button>
                        <x-button variant="outline-success">Outline Success</x-button>
                        <x-button variant="outline-danger">Outline Danger</x-button>
                        <x-button variant="outline-primary" disabled="true">Disabled Outline</x-button>
                    </div>
                </div>

                <div class="border-t border-border-subtle dark:border-slate-700 pt-3">
                    <p class="text-sm font-semibold text-primary dark:text-slate-200 mb-2 uppercase tracking-wider">Sizing Metrics & Icon Buttons</p>
                    <div class="flex flex-wrap gap-4 items-center">
                        <div class="flex items-center gap-2">
                            <x-button variant="primary" size="sm">Small (32px)</x-button>
                            <x-button variant="primary" size="md">Medium (38px)</x-button>
                            <x-button variant="primary" size="lg">Large (46px)</x-button>
                        </div>
                        <div class="h-6 w-px bg-border-subtle dark:bg-slate-700"></div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-secondary dark:text-slate-400 font-medium">Icon-Only Buttons (38px square):</span>
                            <x-button variant="icon" title="Global Search" aria-label="Search">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </x-button>
                            <x-button variant="icon" title="Filter Records" aria-label="Filter">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                                </svg>
                            </x-button>
                            <x-button variant="icon" title="Export PDF" aria-label="Export">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </x-button>
                            <x-button variant="icon" disabled="true" title="Disabled Action" aria-label="Disabled Action">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        {{-- Badges --}}
        <x-card title="&lt;x-badge&gt;"
            subtitle="Status indicators. Always paired with icon or text label — never color alone.">
            <div class="flex flex-wrap gap-3 items-center">
                <x-badge variant="primary">Primary</x-badge>
                <x-badge variant="success" dot="true">Active</x-badge>
                <x-badge variant="warning" dot="true">Pending</x-badge>
                <x-badge variant="danger" dot="true">Critical</x-badge>
                <x-badge variant="info">Info</x-badge>
            </div>
        </x-card>

        {{-- Alerts --}}
        <x-card title="&lt;x-alert&gt;"
            subtitle="ARIA role=alert, dismissible, semantic icons for all four statuses.">
            <div class="space-y-3">
                <x-alert type="success" dismissible="true"><strong>Success:</strong> Operation completed
                    successfully.</x-alert>
                <x-alert type="warning" dismissible="true"><strong>Warning:</strong> Stock level critically
                    low.</x-alert>
                <x-alert type="danger" dismissible="true"><strong>Error:</strong> Authentication failed from unknown
                    IP.</x-alert>
                <x-alert type="info" dismissible="true"><strong>Info:</strong> System maintenance scheduled
                    tomorrow.</x-alert>
            </div>
        </x-card>

        {{-- Inputs/Selects/Textareas --}}
        <x-card title="&lt;x-input&gt; — Text, Select, Textarea"
            subtitle="Uniform padding 0.75rem. Labels above with font-semibold. Error uses .is-invalid + .invalid-feedback. Valid uses .is-valid.">
            <div class="omni-grid-2">
                <div>
                    <x-input name="doc_name" label="Full Name" placeholder="Enter your name" required="true"
                        helper="Must match your ID document." />
                    <x-input name="doc_select" label="Role" type="select">
                        <option>Administrator</option>
                        <option>Manager</option>
                        <option>Staff</option>
                    </x-input>
                    {{-- Valid state example --}}
                    <x-input name="doc_email_ok" label="Email (Valid State)" type="email"
                        value="admin@coreaxis.com" :valid="true" helper="Email is verified and active." />
                </div>
                <div>
                    {{-- Error state example --}}
                    <x-input name="doc_pass" label="Password (Error State)" type="password" value="short"
                        error="Password must be at least 10 characters long." />
                    <x-input name="doc_notes" label="Notes" type="textarea" placeholder="Additional remarks…" />
                </div>
            </div>
        </x-card>

        {{-- Form Layout, Field Grouping & Spacing Standards --}}
        <x-card title="Form Layout, Field Grouping & Spacing Standards"
            subtitle="Demonstrating fieldset groupings (.form-section), uniform spacing (mb-3), disabled & read-only states, and consistent button alignment.">
            
            <form onsubmit="event.preventDefault(); showToast('success', 'Grouped form submitted successfully!')">
                
                {{-- Section A --}}
                <div class="form-section">
                    <div class="form-section-header">
                        Section A: User Profile & Identity (Gutters & Spacing Standards)
                    </div>
                    <div class="form-section-body">
                        <div class="omni-grid-2">
                            <x-input name="demo_first" label="First Name" placeholder="e.g. Al Mamun" required="true" helper="Uses uniform vertical spacing (mb-3) and multi-column grid gutters." />
                            <x-input name="demo_last" label="Last Name" placeholder="e.g. Farhad" required="true" helper="Required fields are marked with a red asterisk." />
                        </div>
                        <div class="omni-grid-2 mt-3">
                            <x-input name="demo_email" label="Email Address" type="email" placeholder="y.arafat@coreaxis.com" required="true" helper="Validates format automatically on submission." />
                            <x-input name="demo_phone" label="Phone Number" placeholder="+880 1700-000000" helper="Optional contact number." />
                        </div>
                    </div>
                </div>

                {{-- Section B --}}
                <div class="form-section">
                    <div class="form-section-header">
                        Section B: System Status & Security Options (Disabled & Read-Only states)
                    </div>
                    <div class="form-section-body">
                        <div class="omni-grid-2">
                            <x-input name="demo_uuid" label="System Assigned UUID (Read-Only)" value="UUID-99102-SLD-OMNI" readonly="true" helper="Read-only fields retain normal text styling but have no focus outline/ring." />
                            <x-input name="demo_lock" label="Account Security Level (Disabled)" value="RESTRICTED DEEP SECURITY" disabled="true" helper="Disabled inputs use a lighter background (#e9ecef) and a not-allowed cursor." />
                        </div>
                        <div class="mt-3">
                            <x-input name="demo_logs" label="Administrative Notes (Read-Only Textarea)" type="textarea" readonly="true" helper="Multi-line read-only field with disabled focus ring.">Logs are written automatically by server daemons and mapped directly. Under current security standards, modifications to this log-stream are disabled.</x-input>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-between items-center pt-2">
                    <div>
                        <x-button type="button" variant="outline-secondary" onclick="this.closest('form').reset(); showToast('info', 'Form inputs reset.');">
                            Reset Form
                        </x-button>
                    </div>
                    <div class="flex gap-2">
                        <x-button type="button" variant="ghost" onclick="showToast('warning', 'Action cancelled.')">
                            Cancel
                        </x-button>
                        <x-button type="submit" variant="primary">
                            Submit Account Profile
                        </x-button>
                    </div>
                </div>

            </form>
        </x-card>

        {{-- Checkboxes --}}
        <x-card title="Checkbox Controls"
            subtitle="1rem square, 0.5rem gap between control and label. Consistent accent color across the system.">
            <div class="space-y-3">
                <p class="text-sm text-secondary dark:text-slate-400 font-medium mb-3">Standard checkboxes — same size
                    (1rem) throughout:</p>
                <div class="flex flex-wrap gap-x-8 gap-y-3">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" checked id="chk-active" />
                        <span class="form-check-label">Active Account</span>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" id="chk-notify" />
                        <span class="form-check-label">Email Notifications</span>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" id="chk-reports" />
                        <span class="form-check-label">Generate Reports</span>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" disabled id="chk-disabled" />
                        <span class="form-check-label" style="opacity:.5">Disabled Option</span>
                    </label>
                </div>
                {{-- Checkbox group with semantic section --}}
                <div class="mt-4 pt-4 border-t border-border-subtle dark:border-slate-700">
                    <p class="text-sm font-semibold text-primary dark:text-slate-200 mb-2 uppercase tracking-wider">
                        Assign Panel Access:</p>
                    <div class="flex flex-wrap gap-x-8 gap-y-2">
                        <label class="form-check"><input type="checkbox" class="form-check-input" checked /><span
                                class="form-check-label">Admin Panel</span></label>
                        <label class="form-check"><input type="checkbox" class="form-check-input" checked /><span
                                class="form-check-label">Manager Panel</span></label>
                        <label class="form-check"><input type="checkbox" class="form-check-input" /><span
                                class="form-check-label">POS Terminal</span></label>
                        <label class="form-check"><input type="checkbox" class="form-check-input" /><span
                                class="form-check-label">Inventory</span></label>
                        <label class="form-check"><input type="checkbox" class="form-check-input" /><span
                                class="form-check-label">Reports</span></label>
                    </div>
                </div>
            </div>
        </x-card>

        {{-- Radio Buttons --}}
        <x-card title="Radio Controls"
            subtitle="1rem circle, 0.5rem gap. Only one selection allowed per group. Highlight active with primary accent.">
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-semibold text-primary dark:text-slate-200 mb-2 uppercase tracking-wider">
                        Security Tier:</p>
                    <div class="flex flex-wrap gap-x-8 gap-y-2">
                        <label class="form-check"><input type="radio" class="form-check-input" name="doc_tier"
                                value="1" /><span class="form-check-label">Level-1 Staff</span></label>
                        <label class="form-check"><input type="radio" class="form-check-input" name="doc_tier"
                                value="2" /><span class="form-check-label">Level-2 Staff</span></label>
                        <label class="form-check"><input type="radio" class="form-check-input" name="doc_tier"
                                value="3" checked /><span class="form-check-label">Level-3
                                Executive</span></label>
                        <label class="form-check"><input type="radio" class="form-check-input" name="doc_tier"
                                value="5" /><span class="form-check-label">Level-5 Super</span></label>
                    </div>
                </div>
                <div class="border-t border-border-subtle dark:border-slate-700 pt-4">
                    <p class="text-sm font-semibold text-primary dark:text-slate-200 mb-2 uppercase tracking-wider">
                        Report Frequency:</p>
                    <div class="flex flex-wrap gap-x-8 gap-y-2">
                        <label class="form-check"><input type="radio" class="form-check-input" name="doc_freq"
                                value="daily" checked /><span class="form-check-label">Daily</span></label>
                        <label class="form-check"><input type="radio" class="form-check-input" name="doc_freq"
                                value="weekly" /><span class="form-check-label">Weekly</span></label>
                        <label class="form-check"><input type="radio" class="form-check-input" name="doc_freq"
                                value="monthly" /><span class="form-check-label">Monthly</span></label>
                        <label class="form-check"><input type="radio" class="form-check-input" name="doc_freq"
                                value="none" disabled /><span class="form-check-label"
                                style="opacity:.5">Disabled</span></label>
                    </div>
                </div>
            </div>
        </x-card>

        {{-- Switch / Toggle --}}
        <x-card title="Switch / Toggle Controls"
            subtitle="Bootstrap-style .form-switch. Label always to the right of the switch. Consistent primary color when active.">
            <div class="space-y-4">
                <p class="text-sm text-secondary dark:text-slate-400 font-medium mb-2">System feature toggles — label
                    sits right of each switch:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label
                        class="flex items-center gap-3 cursor-pointer p-3 rounded border border-border-subtle dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <input type="checkbox" class="form-switch" id="sw-maintenance" checked />
                        <span class="text-sm font-medium text-primary dark:text-slate-200">Maintenance Mode</span>
                    </label>
                    <label
                        class="flex items-center gap-3 cursor-pointer p-3 rounded border border-border-subtle dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <input type="checkbox" class="form-switch" id="sw-emails" />
                        <span class="text-sm font-medium text-primary dark:text-slate-200">Email Notifications</span>
                    </label>
                    <label
                        class="flex items-center gap-3 cursor-pointer p-3 rounded border border-border-subtle dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <input type="checkbox" class="form-switch" id="sw-2fa" checked />
                        <span class="text-sm font-medium text-primary dark:text-slate-200">Two-Factor Auth (2FA)</span>
                    </label>
                    <label
                        class="flex items-center gap-3 cursor-pointer p-3 rounded border border-border-subtle dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <input type="checkbox" class="form-switch" id="sw-autobackup" checked />
                        <span class="text-sm font-medium text-primary dark:text-slate-200">Auto Database Backup</span>
                    </label>
                    <label
                        class="flex items-center gap-3 cursor-pointer p-3 rounded border border-border-subtle dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors opacity-50">
                        <input type="checkbox" class="form-switch" id="sw-disabled" disabled />
                        <span class="text-sm font-medium text-primary dark:text-slate-200">API Access (Disabled)</span>
                    </label>
                    <label
                        class="flex items-center gap-3 cursor-pointer p-3 rounded border border-border-subtle dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <input type="checkbox" class="form-switch" id="sw-debug" />
                        <span class="text-sm font-medium text-primary dark:text-slate-200">Debug Logging</span>
                    </label>
                </div>
            </div>
        </x-card>

        {{-- Modal trigger demo --}}
        <x-card title="&lt;x-modal&gt;"
            subtitle="Centered, max-width 600px. Header with close button, scrollable body, footer with Cancel/Save.">
            <div class="flex gap-3">
                <x-button variant="primary" onclick="omniOpenModal('modal-demo-sm')">Open Small Modal</x-button>
                <x-button variant="outline" onclick="omniOpenModal('modal-demo-md')">Open Medium Modal</x-button>
                <x-button variant="secondary" onclick="omniOpenModal('modal-demo-lg')">Open Large Modal</x-button>
            </div>
        </x-card>

        {{-- Filter toolbar --}}
        <x-card title="&lt;x-filter-toolbar&gt;"
            subtitle="Search on left, action buttons on right. Consistent above every list/table. Never sticky — secondary element.">
            <x-filter-toolbar search-placeholder="Search anything…" search-id="docs-search">
                <x-slot name="actions">
                    <x-button variant="outline" size="sm">Export</x-button>
                    <x-button variant="primary" size="sm">+ Add New</x-button>
                </x-slot>
            </x-filter-toolbar>
        </x-card>

    </div>


    {{-- ══════════════════════════════════════════════════════════════
     MODALS
     ══════════════════════════════════════════════════════════════ --}}

    {{-- Add User Modal --}}
    <x-modal id="modal-add-user" title="Provision New User Account">
        <form id="modal-user-form" onsubmit="event.preventDefault(); handleModalAdminForm()">
            <x-input name="m_name" label="Full Name" placeholder="e.g. Yeasin Arafat" required="true" />
            <x-input name="m_email" label="Email Address" type="email" placeholder="user@coreaxis.com"
                required="true" />
            <x-input name="m_panel" label="Assigned Panel" type="select" required="true">
                <option value="">Choose Assigned Panel...</option>
                <option value="admin">Admin Panel</option>
                <option value="manager">Manager Panel</option>
                <option value="pos">POS Terminal</option>
                <option value="inventory">Inventory</option>
            </x-input>
        </form>
        <x-slot name="footer">
            <x-button variant="ghost" onclick="omniCloseModal('modal-add-user')">Cancel</x-button>
            <x-button variant="primary" onclick="document.getElementById('modal-user-form').requestSubmit()">Save
                Account</x-button>
        </x-slot>
    </x-modal>

    {{-- Demo modals for docs panel --}}
    <x-modal id="modal-demo-sm" title="Small Modal (sm)" size="sm">
        <p class="text-sm leading-relaxed">This is the <strong>small</strong> modal variant. Used for simple
            confirmations or single-field forms.</p>
        <x-slot name="footer">
            <x-button variant="ghost" onclick="omniCloseModal('modal-demo-sm')">Cancel</x-button>
            <x-button variant="danger" onclick="omniCloseModal('modal-demo-sm')">Confirm Delete</x-button>
        </x-slot>
    </x-modal>

    <x-modal id="modal-demo-md" title="Medium Modal (md) — Default">
        <x-input name="md_field1" label="Product Name" placeholder="Enter product name" />
        <x-input name="md_field2" label="Category" type="select">
            <option>Electronics</option>
            <option>Food & Drink</option>
            <option>Accessories</option>
        </x-input>
        <x-input name="md_field3" label="Description" type="textarea" placeholder="Short product description…" />
        <x-slot name="footer">
            <x-button variant="ghost" onclick="omniCloseModal('modal-demo-md')">Cancel</x-button>
            <x-button variant="primary" onclick="omniCloseModal('modal-demo-md')">Save Product</x-button>
        </x-slot>
    </x-modal>

    <x-modal id="modal-demo-lg" title="Large Modal (lg)" size="lg">
        <x-alert type="info">Large modals are used for complex forms or data-heavy content like reports and
            imports.</x-alert>
        <div class="omni-grid-2 mt-4">
            <x-input name="lg_f1" label="First Name" placeholder="First name" />
            <x-input name="lg_f2" label="Last Name" placeholder="Last name" />
            <x-input name="lg_f3" label="Email" type="email" placeholder="email@example.com" />
            <x-input name="lg_f4" label="Department" type="select">
                <option>IT</option>
                <option>Finance</option>
                <option>Operations</option>
            </x-input>
        </div>
        <x-slot name="footer">
            <x-button variant="ghost" onclick="omniCloseModal('modal-demo-lg')">Cancel</x-button>
            <x-button variant="primary" onclick="omniCloseModal('modal-demo-lg')">Submit Form</x-button>
        </x-slot>
    </x-modal>


    {{-- ══════════════════════════════════════════════════════════════
     MASTER JAVASCRIPT
     ══════════════════════════════════════════════════════════════ --}}
    <script>
        /* ── Panel switcher ── */
        const PANELS = ['admin', 'manager', 'staff', 'pos', 'inventory', 'inventory-categories', 'inventory-suppliers',
            'reports', 'auth', 'docs'
        ];
        const PANEL_META = {
            admin: {
                title: 'Admin Control Console',
                sub: 'Unified enterprise overview, system health, and user management.',
                bc: ['Admin']
            },
            manager: {
                title: 'Manager Analytics Workspace',
                sub: 'Business metrics, performance analysis, and team approvals.',
                bc: ['Manager']
            },
            staff: {
                title: 'Staff Operations Hub',
                sub: 'Daily responsibilities, checklists, and shift information.',
                bc: ['Staff']
            },
            pos: {
                title: 'Point of Sale Terminal',
                sub: 'Real-time sales checkout register and order calculation.',
                bc: ['POS']
            },
            inventory: {
                title: 'Inventory Control Center',
                sub: 'Real-time product stock tracking and replenishment controls.',
                bc: ['Inventory']
            },
            'inventory-categories': {
                title: 'Product Categories',
                sub: 'Manage product categorizations and taxonomies.',
                bc: ['Inventory', 'Categories']
            },
            'inventory-suppliers': {
                title: 'Supplier Directory',
                sub: 'Manage replenishment sources, contact details, and contracts.',
                bc: ['Inventory', 'Suppliers']
            },
            reports: {
                title: 'Reports & Analytics',
                sub: 'Revenue charts, top products, and performance summaries.',
                bc: ['Reports']
            },
            auth: {
                title: 'Authentication Pages Demo',
                sub: 'Login and forgot-password layout patterns (max-width 400px).',
                bc: ['Design System', 'Auth']
            },
            docs: {
                title: 'Component Documentation',
                sub: 'Live component playground with syntax reference.',
                bc: ['Design System', 'Docs']
            },
        };

        function switchPanel(id, triggerBtn) {
            // Hide all panels
            PANELS.forEach(p => {
                const el = document.getElementById('panel-' + p);
                if (el) el.classList.add('hidden');
            });

            // Show selected
            const active = document.getElementById('panel-' + id);
            if (active) active.classList.remove('hidden');

            // Update sidebar links active state
            document.querySelectorAll('.sidebar-link').forEach(btn => {
                btn.classList.remove('bg-white/10', 'text-white', 'border-blue-400');
                btn.classList.add('text-slate-300', 'border-transparent');
            });
            document.querySelectorAll('.sidebar-sublink').forEach(btn => {
                btn.classList.remove('active');
            });

            if (triggerBtn) {
                if (triggerBtn.classList.contains('sidebar-link')) {
                    triggerBtn.classList.add('bg-white/10', 'text-white', 'border-blue-400');
                    triggerBtn.classList.remove('text-slate-300', 'border-transparent');
                } else if (triggerBtn.classList.contains('sidebar-sublink')) {
                    triggerBtn.classList.add('active');
                }
            }

            // Update page header
            const meta = PANEL_META[id] || {};
            const h1 = document.querySelector('#main-content h1');
            const sub = document.querySelector('#main-content p.text-sm');
            if (h1) h1.textContent = meta.title || id;
            if (sub) sub.textContent = meta.sub || '';

            // Rebuild breadcrumbs dynamically
            const bcContainer = document.getElementById('breadcrumb-container');
            if (bcContainer && meta.bc) {
                let html =
                    `<a href="#" onclick="switchPanel('admin', document.querySelector('[data-panel=admin]'))" class="hover:text-primary dark:hover:text-blue-400 transition-colors font-medium">Home</a>`;
                meta.bc.forEach((bcName, index) => {
                    html += ` <span class="text-secondary/40 dark:text-slate-600">/</span> `;
                    if (index === meta.bc.length - 1) {
                        html +=
                            `<span class="font-semibold text-primary dark:text-blue-400" id="breadcrumb-current">${bcName}</span>`;
                    } else {
                        html += `<span class="text-secondary dark:text-slate-400">${bcName}</span>`;
                    }
                });
                bcContainer.innerHTML = html;
            }

            // Scroll main content to top
            const mc = document.getElementById('main-content');
            if (mc) mc.scrollTop = 0;
        }

        /* ── Admin form ── */
        function handleAdminForm() {
            const form = document.getElementById('admin-user-form');
            if (!form) return;

            const nameInput = document.getElementById('input-a_name');
            const emailInput = document.getElementById('input-a_email');
            const roleSelect = document.getElementById('input-a_panel');

            let isValid = true;

            // Clear previous states
            [nameInput, emailInput, roleSelect].forEach(input => {
                if (input) {
                    input.classList.remove('is-invalid', 'is-valid');
                    const err = document.getElementById(input.id + '-error');
                    if (err) err.remove();
                }
            });

            // Name validation
            if (nameInput) {
                if (!nameInput.value || nameInput.value.trim().length < 3) {
                    nameInput.classList.add('is-invalid');
                    const err = document.createElement('p');
                    err.className = 'invalid-feedback mt-1.5 mb-0';
                    err.id = nameInput.id + '-error';
                    err.setAttribute('role', 'alert');
                    err.textContent = 'Name must be at least 3 characters.';
                    nameInput.parentNode.appendChild(err);
                    isValid = false;
                } else {
                    nameInput.classList.add('is-valid');
                }
            }

            // Email validation
            if (emailInput) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailInput.value || !emailRegex.test(emailInput.value.trim())) {
                    emailInput.classList.add('is-invalid');
                    const err = document.createElement('p');
                    err.className = 'invalid-feedback mt-1.5 mb-0';
                    err.id = emailInput.id + '-error';
                    err.setAttribute('role', 'alert');
                    err.textContent = 'Please enter a valid email address.';
                    emailInput.parentNode.appendChild(err);
                    isValid = false;
                } else {
                    emailInput.classList.add('is-valid');
                }
            }

            // Role validation
            if (roleSelect) {
                if (!roleSelect.value) {
                    roleSelect.classList.add('is-invalid');
                    isValid = false;
                } else {
                    roleSelect.classList.add('is-valid');
                }
            }

            if (!isValid) {
                showToast('danger', 'Please correct the validation errors in the form.');
                return;
            }

            showToast('success', 'User account provisioned successfully.');
            setTimeout(() => {
                form.reset();
                [nameInput, emailInput, roleSelect].forEach(input => {
                    if (input) input.classList.remove('is-valid', 'is-invalid');
                });
            }, 1500);
        }

        function handleModalAdminForm() {
            const form = document.getElementById('modal-user-form');
            if (!form) return;

            const nameInput = document.getElementById('input-m_name');
            const emailInput = document.getElementById('input-m_email');
            const roleSelect = document.getElementById('input-m_panel');

            let isValid = true;

            // Clear previous states
            [nameInput, emailInput, roleSelect].forEach(input => {
                if (input) {
                    input.classList.remove('is-invalid', 'is-valid');
                    const err = document.getElementById(input.id + '-error');
                    if (err) err.remove();
                }
            });

            // Name validation
            if (nameInput) {
                if (!nameInput.value || nameInput.value.trim().length < 3) {
                    nameInput.classList.add('is-invalid');
                    const err = document.createElement('p');
                    err.className = 'invalid-feedback mt-1.5 mb-0';
                    err.id = nameInput.id + '-error';
                    err.setAttribute('role', 'alert');
                    err.textContent = 'Name must be at least 3 characters.';
                    nameInput.parentNode.appendChild(err);
                    isValid = false;
                } else {
                    nameInput.classList.add('is-valid');
                }
            }

            // Email validation
            if (emailInput) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailInput.value || !emailRegex.test(emailInput.value.trim())) {
                    emailInput.classList.add('is-invalid');
                    const err = document.createElement('p');
                    err.className = 'invalid-feedback mt-1.5 mb-0';
                    err.id = emailInput.id + '-error';
                    err.setAttribute('role', 'alert');
                    err.textContent = 'Please enter a valid email address.';
                    emailInput.parentNode.appendChild(err);
                    isValid = false;
                } else {
                    emailInput.classList.add('is-valid');
                }
            }

            // Role validation
            if (roleSelect) {
                if (!roleSelect.value) {
                    roleSelect.classList.add('is-invalid');
                    isValid = false;
                } else {
                    roleSelect.classList.add('is-valid');
                }
            }

            if (!isValid) {
                showToast('danger', 'Please correct the validation errors in the form.');
                return;
            }

            showToast('success', 'User account provisioned successfully.');
            omniCloseModal('modal-add-user');
            setTimeout(() => {
                form.reset();
                [nameInput, emailInput, roleSelect].forEach(input => {
                    if (input) input.classList.remove('is-valid', 'is-invalid');
                });
            }, 500);
        }

        /* ── Manager approvals ── */
        function approveRow(id, name) {
            const row = document.getElementById(id);
            if (!row) return;
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                showToast('success', `Approved: ${name}`);
            }, 300);
        }

        function rejectRow(id, name) {
            const row = document.getElementById(id);
            if (!row) return;
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                showToast('danger', `Rejected: ${name}`);
            }, 300);
        }

        /* ── Staff checklist ── */
        function toggleTask(cb) {
            const label = cb.closest('label')?.querySelector('.task-text');
            if (!label) return;
            label.style.textDecoration = cb.checked ? 'line-through' : '';
            label.style.opacity = cb.checked ? '0.45' : '1';
        }

        /* ── POS cart ── */
        let cart = {};

        function addToCart(name, price) {
            if (cart[name]) {
                cart[name].qty++;
            } else {
                cart[name] = {
                    price,
                    qty: 1
                };
            }
            renderCart();
        }

        function changeQty(name, delta) {
            if (!cart[name]) return;
            cart[name].qty += delta;
            if (cart[name].qty <= 0) delete cart[name];
            renderCart();
        }

        function removeItem(name) {
            delete cart[name];
            renderCart();
        }

        function clearCart() {
            cart = {};
            renderCart();
        }

        function renderCart() {
            const container = document.getElementById('pos-cart-items');
            const emptyEl = document.getElementById('pos-empty-state');
            const items = Object.entries(cart);

            if (!container) return;

            if (items.length === 0) {
                container.innerHTML = '';
                if (emptyEl) container.appendChild(emptyEl);
                emptyEl?.classList.remove('hidden');
                document.getElementById('pos-subtotal').textContent = '$0.00';
                document.getElementById('pos-tax').textContent = '$0.00';
                document.getElementById('pos-total').textContent = '$0.00';
                document.getElementById('pos-item-count').textContent = '0 items';
                return;
            }

            let subtotal = 0;
            let html = '';
            items.forEach(([name, {
                price,
                qty
            }]) => {
                const lineTotal = price * qty;
                subtotal += lineTotal;
                html += `
        <div class="flex items-center gap-3 py-2 border-b border-border-subtle dark:border-slate-700 last:border-0">
            <div class="flex-1 min-w-0">
                <span class="block text-sm font-semibold text-primary dark:text-slate-200 truncate">${name}</span>
                <span class="text-sm text-secondary dark:text-slate-500">$${price.toFixed(2)} each</span>
            </div>
            <div class="flex items-center gap-1.5 shrink-0">
                <button onclick="changeQty('${name}', -1)" class="w-6 h-6 rounded border border-border-subtle dark:border-slate-700 flex items-center justify-center text-secondary hover:text-primary hover:border-primary/40 cursor-pointer text-sm font-bold transition-colors">−</button>
                <span class="w-5 text-center text-sm font-bold text-primary dark:text-slate-200">${qty}</span>
                <button onclick="changeQty('${name}', 1)"  class="w-6 h-6 rounded border border-border-subtle dark:border-slate-700 flex items-center justify-center text-secondary hover:text-primary hover:border-primary/40 cursor-pointer text-sm font-bold transition-colors">+</button>
            </div>
            <span class="w-16 text-right text-sm font-bold font-mono text-primary dark:text-slate-200">$${lineTotal.toFixed(2)}</span>
            <button onclick="removeItem('${name}')" class="text-danger hover:text-danger-hover cursor-pointer p-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>`;
            });
            container.innerHTML = html;

            const tax = subtotal * 0.05;
            const total = subtotal + tax;
            const count = items.reduce((s, [, {
                qty
            }]) => s + qty, 0);
            document.getElementById('pos-subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('pos-tax').textContent = '$' + tax.toFixed(2);
            document.getElementById('pos-total').textContent = '$' + total.toFixed(2);
            document.getElementById('pos-item-count').textContent = count + (count === 1 ? ' item' : ' items');
        }

        function checkoutCart() {
            if (!Object.keys(cart).length) return;
            const total = document.getElementById('pos-total').textContent;
            clearCart();
            showToast('success', `Checkout complete! Invoice issued for ${total}.`);
        }

        /* ── POS category filter ── */
        function filterPosCategory(btn, cat) {
            document.querySelectorAll('.pos-cat-btn').forEach(b => {
                b.classList.remove('bg-primary', 'text-white', 'border-primary');
                b.classList.add('border-border-subtle', 'bg-panel-bg', 'text-secondary');
            });
            btn.classList.add('bg-primary', 'text-white', 'border-primary');
            btn.classList.remove('border-border-subtle', 'bg-panel-bg', 'text-secondary');

            document.querySelectorAll('.pos-product-item').forEach(item => {
                item.style.display = (cat === 'All' || item.dataset.cat === cat) ? '' : 'none';
            });
        }
        // Set 'All' active on load
        document.addEventListener('DOMContentLoaded', () => {
            const allBtn = document.querySelector('.pos-cat-btn[data-cat="All"]');
            if (allBtn) filterPosCategory(allBtn, 'All');
        });

        /* ── Inventory empty state toggle ── */
        let invEmpty = false;

        function toggleInvEmpty() {
            invEmpty = !invEmpty;
            const wrap = document.getElementById('inv-table-wrap');
            const btn = document.getElementById('btn-inv-empty');
            if (invEmpty) {
                btn.textContent = 'Restore Catalog';
                wrap.innerHTML = `
            <div class="bg-panel-bg dark:bg-slate-900 border border-border-subtle dark:border-slate-700 rounded shadow-sm">
                <div class="flex flex-col items-center justify-center py-24 text-secondary/30 dark:text-slate-600">
                    <svg class="w-16 h-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <h4 class="text-lg font-semibold mb-1">No Products Found</h4>
                    <p class="text-sm font-normal max-w-xs text-center leading-relaxed">
                        Your warehouse catalog is empty. Add your first product to start tracking inventory.
                    </p>
                </div>
            </div>`;
            } else {
                btn.textContent = 'Simulate Empty State';
                location.reload();
            }
        }

        /* ── Replenish ── */
        function replenish(btn, name) {
            btn.textContent = 'Processing…';
            btn.setAttribute('disabled', true);
            setTimeout(() => {
                btn.textContent = 'Ordered ✓';
                showToast('success', `Restock order placed for: ${name}`);
            }, 900);
        }

        /* ── Forgot password demo ── */
        function showForgotSuccess() {
            showToast('success', 'Password reset link sent! Check your inbox.');
        }

        /* ── Toast notification system ── */
        function showToast(type, message) {
            const colors = {
                success: 'bg-success text-white',
                danger: 'bg-danger text-white',
                warning: 'bg-warning text-white',
                info: 'bg-info text-white',
            };
            const toast = document.createElement('div');
            toast.className =
                `fixed bottom-4 right-4 z-[100] px-5 py-3 rounded shadow-sm text-sm font-semibold max-w-sm ${colors[type] || colors.info} transition-all duration-300`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
    </script>

</x-layout>
