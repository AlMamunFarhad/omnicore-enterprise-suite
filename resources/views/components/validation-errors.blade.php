@if ($errors->any())

    <x-alert type="danger">

        <ul class="list-disc pl-5 space-y-1">

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>

    </x-alert>

@endif
