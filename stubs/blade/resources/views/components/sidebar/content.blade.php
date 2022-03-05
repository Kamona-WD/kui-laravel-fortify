<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="{{ __('Dashboard') }}" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="{{ __('Template') }}" href="https://www.github.com/kamona-ui" target="_blank">
        <x-slot name="icon">
            <x-heroicon-o-template class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="{{ __('Figma File') }}" href="https://www.figma.com/community/file/1019844542917981418" target="_blank">
        <x-slot name="icon">
            <x-icons.figma class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    {{-- Dropdown link example --}}
    {{-- <x-sidebar.dropdown title="Components" :active="Str::startsWith(request()->route()->uri(), 'components')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink title="Alerts" href="{{ route('components.alerts') }}"
            :active="request()->routeIs('components.alerts')" />
        <x-sidebar.sublink title="Buttons" href="{{ route('components.buttons') }}"
            :active="request()->routeIs('components.buttons')" />
    </x-sidebar.dropdown> --}}
       
</x-perfect-scrollbar>