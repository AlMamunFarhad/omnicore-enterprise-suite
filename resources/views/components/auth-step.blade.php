@props([
    'step' => 1,
    'title' => '',
])

<div class="flex items-center justify-center gap-2 mb-6">

    <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-semibold">

        {{ $step }}

    </div>

    @if ($title)
        <span class="text-sm text-secondary">
            {{ $title }}
        </span>
    @endif

</div>
