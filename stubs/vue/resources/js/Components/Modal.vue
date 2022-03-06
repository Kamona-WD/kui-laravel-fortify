<template>
    <TransitionRoot appear :show="show" as="template">
        <Dialog as="div" @close="close">
            <div class="fixed inset-0 z-50 overflow-y-auto">
                <div class="min-h-screen px-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <DialogOverlay class="fixed inset-0 bg-black/50" />
                    </TransitionChild>

                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <div class="mb-6 bg-white rounded-lg text-gray-800 dark:text-gray-200 overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto dark:bg-dark-eval-2" :class="maxWidthClass">
                            <slot v-if="show"></slot>
                        </div>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { computed } from "vue"
import { TransitionRoot, TransitionChild, Dialog, DialogOverlay } from "@headlessui/vue"

const emit = defineEmits(['close'])

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    maxWidth: {
        type: String,
        default: '2xl'
    },
    closeable: {
        type: Boolean,
        default: true
    },
})

const close = () => {
    if (props.closeable) {
        emit('close')
    }
}

const maxWidthClass = computed(() => {
    return {
        'sm': 'sm:max-w-sm',
        'md': 'sm:max-w-md',
        'lg': 'sm:max-w-lg',
        'xl': 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
    }[props.maxWidth]
})
</script>
