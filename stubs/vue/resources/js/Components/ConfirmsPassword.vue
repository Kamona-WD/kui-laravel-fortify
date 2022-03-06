<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot />
        </span>

        <DialogModal :show="confirmingPassword" @close="closeModal">
            <template #title>
                {{ title }}
            </template>

            <template #content>
                {{ content }}

                <div class="mt-4">
                    <Input type="password" class="mt-1 block w-3/4" placeholder="Password"
                                ref="password"
                                v-model="form.password"
                                @keyup.enter="confirmPassword" />

                    <InputError :message="form.error" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <Button variant="info" @click="closeModal">
                    {{ $t('Cancel') }}
                </Button>

                <Button class="ml-2" @click="confirmPassword" :disabled="form.processing">
                    {{ button }}
                </Button>
            </template>
        </DialogModal>
    </span>
</template>

<script setup>
import { ref, nextTick } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { trans } from 'laravel-vue-i18n'
import Button from '@/Components/Button'
import DialogModal from '@/Components/DialogModal'
import Input from '@/Components/Input'
import InputError from '@/Components/InputError'

const emit = defineEmits(['confirmed'])

defineProps({
    title: {
        type: String,
        default: trans(`Confirm Password`),
    },
    content: {
        type: String,
        default: trans(`For your security, please confirm your password to continue.`),
    },
    button: {
        type: String,
        default: trans(`Confirm`),
    }
})

const confirmingPassword = ref(false)

const password = ref(null)

const form = useForm({
    password: '',
    error: '',
})

const closeModal = () => {
    confirmingPassword.value = false
    form.password = ''
    form.error = ''
}

const startConfirmingPassword = () => {
    axios.get(route('password.confirmation')).then(response => {
        if (response.data.confirmed) {
            emit('confirmed');
        } else {
            confirmingPassword.value = true;

            setTimeout(() => password.value.focus(), 250)
        }
    })
}

const confirmPassword = () => {
    form.processing = true

    axios.post(route('password.confirm'), {
        password: form.password,
    }).then(() => {
        form.processing = false;
        closeModal()
        nextTick(() => emit('confirmed'))
    }).catch(error => {
        form.processing = false;
        form.error = error.response.data.errors.password[0];
        password.value.focus()
    });
}
</script>
