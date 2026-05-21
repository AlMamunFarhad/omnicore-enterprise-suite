@props([
    'title' => 'Recent Activity',
])

<x-card :title="$title">

    <div class="flex flex-col gap-2">

        {{ $slot }}

    </div>

</x-card>
