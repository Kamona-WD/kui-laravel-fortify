<x-action-section>
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <form action="{{ route('user-profile-information.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" type="text" name="name" value="{{ old('name') ?? auth()->user()->name }}" class="mt-1 block w-full" required autocomplete="name" />
                <x-input-error bag="updateProfileInformation" for="name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" type="email" name="email" value="{{ old('name') ?? auth()->user()->email }}" class="mt-1 block w-full" required autocomplete="email" />
                <x-input-error bag="updateProfileInformation" for="email" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-button>
                    {{ __('Update Profile') }}
                </x-button>
            </div>
        </div>
    </form>
</x-action-section>