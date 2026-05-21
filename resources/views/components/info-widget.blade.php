@props(['title', 'value', 'icon' => null])

<x-card>

    <div class="flex items-center gap-3">

        @if ($icon)
            <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">

                {!! $icon !!}

            </div>
        @endif

        <div>

            <div class="text-lg font-semibold leading-none">
                {{ $value }}
            </div>

            <div class="text-sm text-secondary mt-1">
                {{ $title }}
            </div>

        </div>

    </div>

</x-card>





{{-- @props(['title', 'value', 'icon' => 'bi bi-info-circle'])

<x-card>

    <div class="ca-info-widget">

        <div class="ca-info-widget-icon">
            <i class="{{ $icon }}"></i>
        </div>

        <div>

            <div class="ca-info-widget-number">
                {{ $value }}
            </div>

            <div class="ca-info-widget-label">
                {{ $title }}
            </div>

        </div>

    </div>

</x-card> --}}
