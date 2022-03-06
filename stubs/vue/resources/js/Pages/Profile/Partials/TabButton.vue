<template>
  <Tab as="template" v-slot="{ selected }">
      <button :class="[
                'block w-full max-w-xs text-left px-4 py-2 rounded-md text-gray-600 transition-colors',
                {
                    'bg-purple-500 text-white hover:text-white dark:text-white dark:hover:text-white': selected,
                    'hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200': !selected
                },
            ]"
        >
          {{ title }}
      </button>
  </Tab>
</template>

<script setup>
import { Tab } from '@headlessui/vue'

const props = defineProps({
    title: {
        type: String,
    }
})
</script>
