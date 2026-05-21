@props([
    'title' => null,
    'subtitle' => null,
    'variant' => 'default'
])

@php
    $baseStyles = "bg-panel-bg rounded border border-border-subtle shadow-sm flex flex-col overflow-hidden";
    
    $variants = [
        'default' => 'bg-panel-bg border-border-subtle shadow-sm',
        'flat' => 'bg-panel-bg border-border-subtle',
        'outlined' => 'bg-transparent border-border-subtle shadow-none',
    ];

    $classes = $baseStyles . ' ' . ($variants[$variant] ?? $variants['default']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($title || isset($header_action) || $subtitle)
        <div class="px-6 py-4 border-b border-border-subtle bg-slate-50/50 flex items-center justify-between gap-4 select-none">
            <div class="flex-1">
                @if($title)
                    <h3 class="text-sm font-semibold text-primary m-0 tracking-tight leading-normal">
                        {{ $title }}
                    </h3>
                @endif
                @if($subtitle)
                    <p class="text-sm text-secondary mt-1 mb-0 leading-normal">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
            @if(isset($header_action))
                <div class="flex items-center gap-2 shrink-0">
                    {{ $header_action }}
                </div>
            @endif
        </div>
    @endif

    <div class="p-6 flex-1 flex flex-col">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-3 border-t border-border-subtle bg-slate-50/50 flex items-center justify-end gap-2 text-sm text-secondary shrink-0">
            {{ $footer }}
        </div>
    @endif
</div>
