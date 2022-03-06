<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title>
            {{ $t(`Profile Information`) }}
        </template>

        <template #description>
            {{ $t(`Update your account's profile information and email address.`) }}
        </template>

        <template #form>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <Label for="name" :value="$t(`Name`)" />
                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <Label for="email" :value="$t(`Email`)" />
                <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <InputError :message="form.errors.email" class="mt-2" />
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
import { useForm } from '@inertiajs/inertia-vue3'
import { trans } from 'laravel-vue-i18n'
import Button from '@/Components/Button'
import FormSection from '@/Components/FormSection'
import Input from '@/Components/Input'
import InputError from '@/Components/InputError'
import Label from '@/Components/Label'
import { successToast } from '@/Toast'

const props = defineProps(['user'])

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
})

const updateProfileInformation = () => {
    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => {
            successToast({
                text: trans(`Profile Information Updated successfully! :)`)
            })
        },
    });
}
</script>
