<script setup>
import { Link } from '@inertiajs/vue3';

import { useToast } from 'primevue/usetoast';
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';

const toast = useToast();
const $page = usePage();

watch(() => $page.props.errors, errors => {
    if (errors) {
        Object.keys(errors).forEach(key => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: errors[key],
                life: 3000
            });
        });
    }
});

</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-primary">
        <div>
            <Link href="/">
                <img src="/images/logo.png" alt="logo" class="w-16 h-16">
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 p-6 border border-neutral-800 shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
        <Toast position="bottom-right"></Toast>
    </div>
</template>
