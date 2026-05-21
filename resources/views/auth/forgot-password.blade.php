<x-layouts.auth>

    <h1 class="text-2xl font-bold text-center mb-6">
        Forgot Password
    </h1>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">

        @csrf

        <div>

            <label class="block text-sm font-medium mb-2">
                Email Address
            </label>

            <input type="email" name="email" class="form-input w-full @error('email') input-error @enderror">

            @error('email')
                <div class="error-text">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <button type="submit" class="btn btn-primary w-full min-h-[44px]">

            Send Reset Link

        </button>

    </form>

</x-layouts.auth>
