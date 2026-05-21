@props([
    'type' => 'info',
    'dismissible' => false,
])

@php

    $variants = [
        'success' =>
            'bg-emerald-50 border-emerald-200 text-emerald-700 dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:text-emerald-400',
        'danger' => 'bg-red-50 border-red-200 text-red-700 dark:bg-red-500/10 dark:border-red-500/20 dark:text-red-400',
        'warning' =>
            'bg-amber-50 border-amber-200 text-amber-700 dark:bg-amber-500/10 dark:border-amber-500/20 dark:text-amber-400',
        'info' =>
            'bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-500/10 dark:border-blue-500/20 dark:text-blue-400',
    ];

    $icons = [
        'success' => '✅',
        'danger' => '❌',
        'warning' => '⚠️',
        'info' => 'ℹ️',
    ];

@endphp

<div
    {{ $attributes->merge([
        'class' => 'flex items-start gap-3 rounded-lg border px-4 py-3 ' . ($variants[$type] ?? $variants['info']),
    ]) }}>

    <div class="shrink-0">

        {{ $icons[$type] ?? 'ℹ️' }}

    </div>

    <div class="flex-1">

        {{ $slot }}

    </div>

    @if ($dismissible)
        <button type="button" onclick="this.parentElement.remove()"
            class="opacity-70 hover:opacity-100 transition shrink-0">

            ✕

        </button>
    @endif

</div>







{{-- @props([
    'type' => 'info',
    'dismissible' => false,
    'id' => null,
])

@php
    $id = $id ?? 'alert-' . uniqid();

    $baseStyles = 'relative p-4 rounded border flex gap-3 text-sm transition-all duration-200 ease-in-out';

    $variants = [
        'success' => 'bg-emerald-50 text-success border-emerald-200/80',
        'warning' => 'bg-amber-50 text-warning border-amber-200/80',
        'danger' => 'bg-red-50 text-danger border-red-200/80',
        'info' => 'bg-sky-50 text-info border-sky-200/80',
    ];

    $icons = [
        'success' =>
            '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        'warning' =>
            '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>',
        'danger' =>
            '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        'info' =>
            '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
    ];

    $classes = $baseStyles . ' ' . ($variants[$type] ?? $variants['info']);
@endphp

<div id="{{ $id }}" role="alert" aria-live="polite" {{ $attributes->merge(['class' => $classes]) }}>
    <div class="shrink-0 opacity-90 select-none">
        {!! $icons[$type] ?? $icons['info'] !!}
    </div>

    <div class="flex-1 leading-normal pr-4 font-normal">
        {{ $slot }}
    </div>

    @if ($dismissible)
        <button type="button"
            onclick="const alertEl = document.getElementById('{{ $id }}'); alertEl.style.opacity = '0'; setTimeout(() => alertEl.remove(), 200);"
            class="absolute top-4 right-4 p-0.5 rounded hover:bg-black/5 text-current opacity-70 hover:opacity-100 cursor-pointer focus:outline-none focus:ring-1 focus:ring-current"
            aria-label="Dismiss alert">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div> --}}
