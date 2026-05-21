@props([
    'title'    => 'OmniCore',
    'subtitle' => 'Sign in to your account',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — OmniCore Enterprise Suite</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-neutral-bg dark:bg-[#0b0f19] font-sans antialiased flex items-center justify-center p-4">

    <div class="w-full max-w-[400px] space-y-6">

        {{-- Brand Logo Block --}}
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded bg-primary text-white mx-auto">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-.778.099-1.533.284-2.253" />
                </svg>
            </div>
            <h1 class="text-2xl font-semibold text-primary dark:text-slate-100 m-0">
                {{ $title }}
            </h1>
            <p class="text-sm text-secondary dark:text-slate-400 m-0">
                {{ $subtitle }}
            </p>
        </div>

        {{-- Auth Card --}}
        <div class="bg-panel-bg dark:bg-slate-900 border border-border-subtle dark:border-slate-700 rounded shadow-sm px-8 py-8">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <p class="text-center text-sm text-secondary/60 dark:text-slate-500">
            &copy; {{ date('Y') }} OmniCore Enterprise Suite. All rights reserved.
        </p>
    </div>

</body>
</html>
