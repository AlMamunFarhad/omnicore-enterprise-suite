@props([
    'searchPlaceholder' => 'Search records…',
    'searchId'          => 'filter-search',
])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3
            bg-slate-50 dark:bg-slate-800/60
            border border-border-subtle dark:border-slate-700
            rounded px-4 py-3">

    {{-- Left: Search Box --}}
    <div class="relative flex-1 max-w-sm">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-secondary/50 dark:text-slate-500">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input
            type="search"
            id="{{ $searchId }}"
            placeholder="{{ $searchPlaceholder }}"
            class="w-full pl-9 pr-4 form-control-input text-sm
                   dark:bg-slate-900 dark:border-slate-700 dark:text-slate-100
                   dark:placeholder:text-slate-500"
        />
    </div>

    {{-- Right: Action Buttons (Export, Add New, etc.) --}}
    @if(isset($actions))
        <div class="flex items-center gap-2 shrink-0">
            {{ $actions }}
        </div>
    @endif
</div>
