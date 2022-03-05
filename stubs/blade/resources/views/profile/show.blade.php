<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="grid gap-8">
        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
            <div>
                @include('profile.update-profile-information-form')
            </div>
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div>
                @include('profile.update-password-form')
            </div>
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
            <div>
                @include('profile.two-factor-authentication-form')
            </div>
        @endif
    </div>

    @if (session('status'))
        <div x-data x-init="toast.info(`{{ session('status') }}`)"></div>
    @endif
</x-app-layout>