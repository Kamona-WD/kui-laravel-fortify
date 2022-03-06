<template>
    <AuthenticatedLayout :title="$t(`Profile`)">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800  dark:text-gray-200"
            >
                {{ $t('Profile Settings') }}
            </h2>
        </template>

        <div>
            <TabGroup as="div" class="grid gap-6 lg:grid-cols-4">
                <TabList class="flex flex-col items-start gap-2 lg:col-span-1">
                    <TabButton
                        v-if="$page.props.auth.canUpdateProfileInformation"
                        :title="$t('Profile Information')"
                    />

                    <TabButton
                        v-if="$page.props.auth.canUpdatePassword"
                        :title="$t('Update Password')"
                    />

                    <TabButton
                        v-if="
                            $page.props.auth
                                .canManageTwoFactorAuthentication
                        "
                        :title="$t('2FA')"
                    />
                </TabList>

                <TabPanels class="lg:col-span-3">
                    <TabPanel
                        v-if="$page.props.auth.canUpdateProfileInformation"
                    >
                        <UpdateProfileInformationForm
                            :user="$page.props.auth.user"
                        />
                    </TabPanel>

                    <TabPanel v-if="$page.props.auth.canUpdatePassword">
                        <UpdatePasswordForm />
                    </TabPanel>

                    <TabPanel
                        v-if="
                            $page.props.auth
                                .canManageTwoFactorAuthentication
                        "
                    >
                        <TwoFactorAuthenticationForm />
                    </TabPanel>
                </TabPanels>
            </TabGroup>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { TabGroup, TabList, TabPanels, TabPanel } from '@headlessui/vue'
import AuthenticatedLayout from '@/Layouts/Authenticated'
import TabButton from '@/Pages/Profile/Partials/TabButton'
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm'
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm'
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm'

const props = defineProps({
    sessions: {
        type: Array,
    },
})
</script>
