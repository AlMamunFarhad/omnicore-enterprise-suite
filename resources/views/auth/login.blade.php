<x-layouts.auth>

    <h1 class="text-2xl font-bold text-center mb-6">
        Sign In
    </h1>

    @if (session('error'))
        <x-alert type="danger" dismissible class="mb-4">

            {{ session('error') }}

        </x-alert>
    @endif

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">

        @csrf

        <div>

            <label class="block text-sm font-medium mb-2">
                Email Address
            </label>

            <input type="email" name="email" value="{{ old('email') }}"
                class="form-input w-full @error('email') input-error @enderror">

            @error('email')
                <div class="error-text">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div>

            <label class="block text-sm font-medium mb-2">
                Password
            </label>

            <input type="password" name="password" class="form-input w-full @error('password') input-error @enderror">

            @error('password')
                <div class="error-text">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <button type="submit" class="btn btn-primary w-full min-h-[44px]">

            Sign In

        </button>

    </form>

    <div class="mt-4 text-center">

        <a href="{{ route('password.request') }}" class="text-sm text-secondary hover:text-primary transition">

            Forgot Password?

        </a>

    </div>

</x-layouts.auth>
