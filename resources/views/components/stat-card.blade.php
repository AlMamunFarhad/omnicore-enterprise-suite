@props([
    'label' => 'Metric',
    'value' => '—',
    'trend' => null,
    'up' => true,
    'sub' => null,
    'badge' => null,
    'badgeVariant' => 'primary',
])
{{-- e.g. '+12.4%' --}}
{{-- trend direction --}}
{{-- subtext --}}
{{-- badge text --}}
<div
    {{ $attributes->merge(['class' => 'bg-panel-bg dark:bg-slate-900 border border-border-subtle dark:border-slate-700 rounded shadow-sm p-6 flex flex-col gap-3']) }}>

    <div class="flex items-start justify-between gap-2">
        <span class="text-sm font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 leading-tight">
            {{ $label }}
        </span>
        @if ($badge)
            <x-badge :variant="$badgeVariant">{{ $badge }}</x-badge>
        @endif
    </div>

    <div>
        <span class="text-3xl font-bold text-primary dark:text-slate-100 tracking-tight leading-none">
            {{ $value }}
        </span>

        @if ($trend)
            <span
                class="inline-flex items-center gap-1 mt-2 text-sm font-semibold {{ $up ? 'text-success' : 'text-danger' }}">
                @if ($up)
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7 7 7" />
                    </svg>
                @else
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7-7-7" />
                    </svg>
                @endif
                {{ $trend }}
            </span>
        @endif
    </div>

    @if ($sub)
        <p class="text-sm text-secondary/70 dark:text-slate-500 m-0 font-normal leading-snug">
            {{ $sub }}
        </p>
    @endif
</div>
