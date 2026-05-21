<x-layouts.auth>

    <x-auth-step step="2" title="Reset Password" />

    <h1 class="text-2xl font-bold text-center mb-6">
        Reset Password
    </h1>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">

        @csrf

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div>

            <label class="block text-sm font-medium mb-2">
                Email Address
            </label>

            <input type="email" name="email" value="{{ old('email') }}" class="form-input w-full">

        </div>

        <div>

            <label class="block text-sm font-medium mb-2">
                New Password
            </label>

            <input type="password" name="password" class="form-input w-full">

        </div>

        <div>

            <label class="block text-sm font-medium mb-2">
                Confirm Password
            </label>

            <input type="password" name="password_confirmation" class="form-input w-full">

        </div>

        <button type="submit" class="btn btn-primary w-full min-h-[44px]">

            Reset Password

        </button>

    </form>

</x-layouts.auth>
