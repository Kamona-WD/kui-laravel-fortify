<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    {{ $t(`Dashboard`) }}
                </h2>

                <Button
                    external
                    variant="black"
                    target="_blank"
                    class="justify-center gap-2 max-w-xs"
                    v-slot="{ iconSizeClasses }"
                    href="https://github.com/kamona-wd/kui-laravel-fortify"
                >
                    <GithubIcon aria-hidden="true" :class="iconSizeClasses" />
                    <span>{{ $t(`Star on Github`) }}</span>
                </Button>
            </div>
        </template>

        <div
            class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1"
        >
            {{ $t(`You're logged in!`) }}
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated'
import Button from '@/Components/Button'
import { GithubIcon } from '@/Components/Icons/brands'
</script>
