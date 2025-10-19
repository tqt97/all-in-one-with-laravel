@if($user->two_factor_secret || $user->two_factor_confirmed_at)
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-white">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('2fa.disable_title') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('2fa.disable_description') }}
                    </p>
                </header>
                <x-danger-button class="mt-4" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-disable-2fa')"
                    x-on:close.window="
                        if ($el.__x) {
                            $dispatch('clear-otp-error')
                        }
                    ">
                    {{ __('2fa.disable_2fa_btn') }}
                </x-danger-button>
                <x-modal name="confirm-disable-2fa" :show="$errors->has('otp')" focusable>
                    <div class="p-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('2fa.disable_title') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('2fa.disable_description') }}
                            </p>
                        </header>
                        <form method="POST" action="{{ route('two-factor.disable') }}" class="space-y-6"
                            x-on:clear-otp-error.window="
                        const el = $refs.otp_error;
                        if (el) el.remove();
                    ">
                            @csrf
                            <div class="mt-4">
                                <x-input-label for="otp" :value="__('2fa.2fa_label')" />
                                <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autofocus
                                    placeholder="{{ __('2fa.verify_placeholder') }}" />
                                <div x-ref="otp_error">
                                    <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                                </div>
                            </div>
                            <div class="flex items-center gap-4 justify-end">
                                <x-secondary-button type="button" x-on:click="
                            $dispatch('close');
                            $dispatch('clear-otp-error');
                        ">
                                    {{ __('Cancel') }}
                                </x-secondary-button>
                                <x-danger-button>{{ __('2fa.disable_2fa_btn') }}</x-danger-button>
                            </div>
                        </form>
                    </div>
                </x-modal>
            </div>
        </div>
    </div>
@else
    <div>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('2fa.enable_title') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('2fa.enable_description') }}
            </p>
        </header>
        <div class="w-full flex gap-6">
            <div class="w-2/5">
                <div class="my-4">
                    <p>{{ __('2fa.scan_text') }}</p>

                    <img src="{{ $QR_Image }}" alt="2FA QR Code">
                    <p>{{ __('2fa.manual_text') }}: <strong>{{ $secret }}</strong></p>
                </div>
                <form action="{{ route('two-factor.enable') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div class="mt-6">
                        <x-input-label for="otp" :value="__('2fa.2fa_label')" />
                        <x-text-input id="otp" name="otp" type="text" class="mt-1 block w-full"
                            placeholder="{{ __('2fa.2fa_placeholder') }}" />
                        @error('otp')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('2fa.enable_2fa') }}</x-primary-button>
                    </div>
                </form>
            </div>
            <div class="w-3/5">
                <div class="mt-4">
                    <p>{{ __('2fa.recovery_code_title') }}
                        <br>
                        <small>{{ __('2fa.recovery_code_description') }}</small>
                    </p>
                    <ul class="grid grid-cols-2 gap-2 mt-4">
                        @foreach ($recoveryCodes as $code)
                            <li>{{ $code }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
