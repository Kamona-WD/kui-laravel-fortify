<div class="flex justify-between">
    <div class="space-y-1">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">
            {{ $title }}
        </h3>

        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ $description }}
        </p>
    </div>

    <div class="px-4 sm:px-0">
        {{ $aside ?? '' }}
    </div>
</div>
