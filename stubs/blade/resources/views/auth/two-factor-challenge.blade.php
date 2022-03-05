<x-guest-layout>
    <x-auth-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="/two-factor-challenge">
            @csrf

            <div class="grid gap-6" x-data="{ tab: 'code' }">
                <div class="flex gap-2 items-center">
                    <x-button type="button" variant="info" size="sm" @click="tab = 'code'">{{ __('Use an authentication code') }}</x-button>
                    <x-button type="button" variant="info" size="sm" @click="tab = 'recovery_code'">{{ __('Use a recovery code') }}</x-button>
                </div>

                {{-- Code --}}
                <div class="space-y-2" x-show="tab == 'code'">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                    </p>

                    <x-label for="code" :value="__('Code')" />

                    <x-input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-qrcode aria-hidden="true" class="w-5 h-5" />
                        </x-slot>
                        <x-input withicon id="code" class="block w-full" type="text" name="code"
                            :value="old('code')" placeholder="{{ __('Code') }}" autofocus />
                    </x-input-with-icon-wrapper>
                </div>

                {{-- Recovery Code --}}
                <div class="space-y-2" x-show="tab == 'recovery_code'">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                    </p>

                    <x-label for="recovery_code" :value="__('Recovery Code')" />

                    <x-input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-clipboard aria-hidden="true" class="w-5 h-5" />
                        </x-slot>
                        <x-input withicon id="recovery_code" class="block w-full" type="text" name="recovery_code"
                            :value="old('recovery_code')" placeholder="{{ __('Recovery Code') }}" />
                    </x-input-with-icon-wrapper>
                </div>

                <x-button class="justify-center w-full gap-2">
                    <x-heroicon-o-login class="w-6 h-6" aria-hidden="true" />
                    <span>{{ __('Log in') }}</span>
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>