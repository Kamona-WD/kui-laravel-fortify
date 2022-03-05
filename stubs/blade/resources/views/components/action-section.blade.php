<div class="max-w-7xl grid gap-4" {{ $attributes }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="p-4 space-y-6 bg-white shadow-md rounded-md sm:p-6 dark:bg-dark-eval-1">
        {{ $slot }}
    </div>
</div>
