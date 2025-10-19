<x-guest-layout>
    <h2 class="text-sm font-bold text-gray-900 dark:text-gray-100">
        {{ __('2fa.verify_title') }}
    </h2>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('two-factor.verify') }}">
        @csrf
        <div class="mt-4">
            <x-input-label for="otp" :value="__('2fa.2fa_label')" />

            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autofocus
                placeholder="{{ __('2fa.verify_placeholder') }}" />

            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('2fa.verify_2fa') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
