<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            {{ $t(`Update Password`) }}
        </template>

        <template #description>
            {{ $t(`Ensure your account is using a long, random password to stay secure.`) }}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <Label for="current_password" :value="$t(`Current Password`)" />
                <Input id="current_password" type="password" class="mt-1 block w-full" v-model="form.current_password" ref="current_password" autocomplete="current-password" />
                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <Label for="password" :value="$t(`New Password`)" />
                <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password" ref="password" autocomplete="new-password" />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <Label for="password_confirmation" :value="$t(`Confirm Password`)" />
                <Input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <Button :disabled="form.processing">
                {{ $t(`Save`) }}
            </Button>
        </template>
    </FormSection>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { trans } from 'laravel-vue-i18n'
import Button from '@/Components/Button'
import FormSection from '@/Components/FormSection'
import Input from '@/Components/Input'
import InputError from '@/Components/InputError'
import Label from '@/Components/Label'
import { successToast } from '@/Toast'

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const password = ref(null)
const current_password = ref(null)

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            successToast({
                text: trans(`Password Updated successfully! :)`)
            })
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation')
                password.value.focus()
            }

            if (form.errors.current_password) {
                form.reset('current_password')
                current_password.value.focus()
            }
        }
    })
}
</script>
