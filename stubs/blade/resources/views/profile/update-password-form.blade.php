<x-action-section>
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <form action="{{ route('user-password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="current_password" value="{{ __('Current Password') }}" />
                <x-input id="current_password" type="password" name="current_password" class="mt-1 block w-full" autocomplete="current-password" placeholder="{{ __('Current Password') }}" />
                <x-input-error bag="updatePassword" for="current_password" class="mt-2" />
            </div>
    
            <div class="col-span-6 sm:col-span-4">
                <x-label for="password" value="{{ __('New Password') }}" />
                <x-input id="password" type="password" name="password" class="mt-1 block w-full" autocomplete="new-password" placeholder="{{ __('Password') }}" />
                <x-input-error bag="updatePassword" for="password" class="mt-2" />
            </div>
    
            <div class="col-span-6 sm:col-span-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" type="password" name="password_confirmation" class="mt-1 block w-full" autocomplete="new-password" placeholder="{{ __('Confirm Password') }}" />
                <x-input-error bag="updatePassword" for="password_confirmation" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-button>
                    {{ __('Save') }}
                </x-button>
            </div>
        </div>
    </form>
</x-action-section>
