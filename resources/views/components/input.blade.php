@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'error' => null,
    'helper' => null,
    'required' => false,
    'id' => null,
    'options' => [],
    'valid' => false
])

@php
    $id = $id ?? 'input-' . $name;
    $labelStyles = "block text-sm font-semibold text-primary mb-2 select-none uppercase tracking-wider";
    $inputBaseStyles = "w-full form-control-input text-sm text-secondary disabled:bg-slate-50 disabled:opacity-60";
    if ($error) {
        $inputBaseStyles .= " is-invalid";
    } elseif ($valid) {
        $inputBaseStyles .= " is-valid";
    }
@endphp

<div class="mb-4">
    @if($label)
        <label for="{{ $id }}" class="{{ $labelStyles }}">
            {{ $label }}
            @if($required)
                <span class="text-danger ml-0.5" title="Required">*</span>
            @endif
        </label>
    @endif

    @if($type === 'textarea')
        <textarea 
            id="{{ $id }}" 
            name="{{ $name }}" 
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full form-control-input text-sm text-secondary disabled:bg-slate-50 disabled:opacity-60' . ($error ? ' is-invalid' : ($valid ? ' is-valid' : ''))]) }}
        >{{ $value ?? $slot }}</textarea>
    
    @elseif($type === 'select')
        <select 
            id="{{ $id }}" 
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => $inputBaseStyles]) }}
        >
            @if($placeholder)
                <option value="" disabled {{ empty($value) ? 'selected' : '' }}>{{ $placeholder }}</option>
            @endif
            @if(!empty($options))
                @foreach($options as $val => $text)
                    <option value="{{ $val }}" {{ (string)$value === (string)$val ? 'selected' : '' }}>{{ $text }}</option>
                @endforeach
            @endif
            {{ $slot }}
        </select>
        
    @else
        <input 
            type="{{ $type }}" 
            id="{{ $id }}" 
            name="{{ $name }}" 
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => $inputBaseStyles]) }}
        />
    @endif

    @if($error)
        <p class="invalid-feedback mt-1.5 mb-0" id="{{ $id }}-error" role="alert">
            {{ $error }}
        </p>
    @elseif($helper)
        <p class="text-sm text-secondary/70 font-normal mt-1.5 mb-0" id="{{ $id }}-helper">
            {{ $helper }}
        </p>
    @endif
</div>
