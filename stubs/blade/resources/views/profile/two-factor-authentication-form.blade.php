<x-action-section>
    <x-slot name="title">
        {{ __('Two Factor Authentication') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Add additional security to your account using two factor authentication.') }}
    </x-slot>

    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-300">
        @if (auth()->user()->two_factor_secret)
            {{ __('You have enabled two factor authentication.') }}
        @else
            {{ __('You have not enabled two factor authentication.') }}
        @endif
    </h3>

    <p class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
        {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during
        authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
    </p>

    @if (!auth()->user()->two_factor_secret)
        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
            @csrf
            <x-button>
                {{ __('Enable Two-Factor') }}
            </x-button>
        </form>
    @else
        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
            @csrf
            @method('DELETE')

            <x-button variant="danger">
                {{ __('Disable Two-Factor') }}
            </x-button>
        </form>

        @if (session('status') == 'two-factor-authentication-enabled')
            <p class="max-w-xl text-sm font-semibold text-gray-600 dark:text-gray-300">
                {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s
                authenticator application.') }}
            </p>

            <div>
                {!! auth()
                ->user()
                ->twoFactorQrCodeSvg() !!}
            </div>
        @endif
        <p class="max-w-xl text-sm font-semibold text-gray-600 dark:text-gray-300">
            {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to
            your account if your two factor authentication device is lost.') }}
        </p>
        
        <div class="p-3 rounded-md bg-gray-100 dark:bg-dark-eval-3">
            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                    <pre>{{ $code }}</pre>
            @endforeach
        </div>

        <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
            @csrf
            <x-button variant="info">
                {{ __('Regenerate Recovery Codes') }}
            </x-button>
        </form>
    @endif
</x-action-section>
