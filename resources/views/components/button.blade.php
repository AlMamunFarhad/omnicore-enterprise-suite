@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false
])

@php
    $baseStyles = "inline-flex items-center justify-center font-medium border transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-primary rounded select-none cursor-pointer disabled:pointer-events-none disabled:opacity-60";
    
    $variants = [
        'primary' => 'bg-primary text-white border-primary hover:bg-primary-hover active:bg-primary-active',
        'secondary' => 'bg-secondary text-white border-secondary hover:bg-secondary-hover active:bg-secondary-active',
        'success' => 'bg-success text-white border-success hover:bg-success-hover active:bg-success-active',
        'danger' => 'bg-danger text-white border-danger hover:bg-danger-hover active:bg-danger-active',
        'outline' => 'bg-transparent text-primary border-primary hover:bg-slate-50 active:bg-slate-100',
        'ghost' => 'bg-transparent text-secondary border-transparent hover:bg-slate-50 hover:text-primary',
    ];

    $sizes = [
        'sm' => 'h-8 px-3 text-sm',
        'md' => 'h-10 px-4 text-sm',
        'lg' => 'h-12 px-6 text-base',
    ];

    $classes = $baseStyles . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<button 
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button>
