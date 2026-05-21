<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ config('app.name') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-background text-primary min-h-screen">

    <div class="min-h-screen flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-[360px]">

            <div class="bg-panel-bg border border-border-subtle rounded-xl shadow-sm overflow-hidden">

                <div class="p-8">

                    <div class="flex justify-center mb-6">

                        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-12 w-auto">

                    </div>

                    {{ $slot }}

                </div>

            </div>

        </div>

    </div>

</body>

</html>
