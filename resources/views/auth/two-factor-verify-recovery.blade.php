<x-guest-layout>
    <h2 class="text-sm font-bold text-gray-900 dark:text-gray-100">
        {{ __('2fa.verify_recovery_title') }}
    </h2>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('two-factor.verify.recovery') }}">
        @csrf
        <div class="mt-4">
            <x-input-label for="code" :value="__('2fa.label_recovery')" />

            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus
                placeholder="{{ __('2fa.verify_placeholder') }}" />

            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('two-factor.verify.form.otp'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('two-factor.verify.form.otp') }}">
                    {{ __('Forgot your recovery code?') }}
                </a>
            @endif
            <x-primary-button class="ms-3">
                {{ __('2fa.verify_2fa') }}
            </x-primary-button>
        </div>

    </form>
</x-guest-layout>
