@props([
    'variant' => 'primary',
    'dot' => false
])

@php
    $baseStyles = "inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-sm font-semibold select-none border";
    
    $variants = [
        'primary' => 'bg-slate-100 text-primary border-slate-200',
        'secondary' => 'bg-slate-100 text-secondary border-slate-200',
        'success' => 'bg-emerald-50 text-success border-emerald-200/60',
        'warning' => 'bg-amber-50 text-warning border-amber-200/60',
        'danger' => 'bg-red-50 text-danger border-red-200/60',
        'info' => 'bg-sky-50 text-info border-sky-200/60',
    ];

    $dotColors = [
        'primary' => 'bg-primary',
        'secondary' => 'bg-secondary',
        'success' => 'bg-success',
        'warning' => 'bg-warning',
        'danger' => 'bg-danger',
        'info' => 'bg-info',
    ];

    $classes = $baseStyles . ' ' . ($variants[$variant] ?? $variants['primary']);
    $dotClass = "w-1.5 h-1.5 rounded-full shrink-0 " . ($dotColors[$variant] ?? $dotColors['primary']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="{{ $dotClass }}"></span>
    @endif
    {{ $slot }}
</span>
