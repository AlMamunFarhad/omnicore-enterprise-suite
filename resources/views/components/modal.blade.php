@props([
    'id',
    'title'  => 'Modal Title',
    'size'   => 'md',   {{-- sm | md | lg --}}
    'static' => false,
])

@php
    $maxWidths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-[600px]',
        'lg' => 'max-w-3xl',
    ];
    $mw = $maxWidths[$size] ?? $maxWidths['md'];
@endphp

<div
    id="{{ $id }}"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $id }}-title"
    tabindex="-1"
    class="omni-modal fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6"
>
    {{-- Backdrop --}}
    <div
        class="omni-modal-backdrop absolute inset-0 bg-black/50 backdrop-blur-[2px]"
        @unless($static)
            onclick="omniCloseModal('{{ $id }}')"
        @endunless
    ></div>

    {{-- Panel --}}
    <div class="omni-modal-panel relative w-full {{ $mw }} bg-panel-bg dark:bg-slate-900 rounded border border-border-subtle dark:border-slate-700 shadow-sm flex flex-col overflow-hidden"
         style="max-height: calc(100vh - 3rem);">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-border-subtle dark:border-slate-700 bg-slate-50/60 dark:bg-slate-800/60 shrink-0">
            <h5 id="{{ $id }}-title" class="m-0 font-semibold text-primary dark:text-slate-100 leading-snug">
                {{ $title }}
            </h5>
            <button
                type="button"
                onclick="omniCloseModal('{{ $id }}')"
                class="p-1.5 rounded hover:bg-slate-200 dark:hover:bg-slate-700 text-secondary hover:text-primary dark:text-slate-400 cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-primary/30"
                aria-label="Close modal"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 flex-1 overflow-y-auto text-secondary dark:text-slate-300">
            {{ $slot }}
        </div>

        {{-- Footer (optional slot) --}}
        @if(isset($footer))
            <div class="px-6 py-4 border-t border-border-subtle dark:border-slate-700 bg-slate-50/60 dark:bg-slate-800/60 flex items-center justify-end gap-3 shrink-0">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
