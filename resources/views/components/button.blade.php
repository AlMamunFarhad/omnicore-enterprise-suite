@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false
])

@php
    // Determine the base class
    $isIcon = ($variant === 'icon');
    $baseClass = $isIcon ? 'btn-icon' : 'btn';
    
    // Map variants
    $variantClass = '';
    if (!$isIcon) {
        if ($variant === 'primary') {
            $variantClass = 'btn-primary';
        } elseif ($variant === 'secondary') {
            $variantClass = 'btn-secondary';
        } elseif ($variant === 'success') {
            $variantClass = 'btn-success';
        } elseif ($variant === 'danger') {
            $variantClass = 'btn-danger';
        } elseif ($variant === 'outline') {
            $variantClass = 'btn-outline-primary';
        } elseif (str_starts_with($variant, 'outline-')) {
            $variantClass = 'btn-' . $variant;
        } elseif ($variant === 'ghost') {
            $variantClass = 'btn-ghost';
        } else {
            $variantClass = 'btn-primary';
        }
    }
    
    // Map sizes (for non-icon buttons)
    $sizeClass = '';
    if (!$isIcon) {
        $sizeClass = match ($size) {
            'sm' => 'btn-sm',
            'lg' => 'btn-lg',
            default => 'btn-md',
        };
    }
    
    // Combine classes
    $classes = trim($baseClass . ' ' . $variantClass . ' ' . $sizeClass);
@endphp

<button 
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button>
