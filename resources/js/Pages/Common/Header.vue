<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/OrbitComponents/TextInput.vue';
import Button from '@/Components/OrbitComponents/Button.vue';
import Notifications from './Notifications.vue';

const searchForm = useForm({
    query : '',
})

const props = defineProps({
    title : String
});

</script>

<template>
    <Head :title="title" />
    <div class="flex items-center h-16 px-6 border border-t-0 border-l-0 border-r-0 border-b-gray-800">
        <div class="basis-1/5 2xl:basis-1/6">
            <Link href="/" class="flex">
                <img src="/images/logo.png" alt="logo" class="w-6 h-6">
                <div class="font-bold ms-4">Orbit</div>
            </Link>
        </div>
        <div class="basis-3/5 2xl:basis-4/6">
            <form @submit.prevent class="flex items-center">
                <TextInput v-model="searchForm.query" class="w-1/3"/>
                <Button label="Search" icon="search" class="h-10 ms-4"/>
            </form>
        </div>
        <div class="flex items-center justify-end basis-1/5 2xl:basis-1/6 gap-x-4">
            <Notifications />
            <Link :href="route('logout')" method="post" as="button">
                Log Out
            </Link>
        </div>
    </div>
</template>