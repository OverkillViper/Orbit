<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/OrbitComponents/TextInput.vue';
import Button from '@/Components/OrbitComponents/Button.vue';
import Notifications from './Notifications.vue';
import NavbarItem from './NavbarItem.vue';

const searchForm = useForm({
    query : '',
})

const props = defineProps({
    title : String
});

const search = () => {
    searchForm.get(route('search'));
}

</script>

<template>
    <div class="fixed bg-primary z-10 w-full">
        <Head :title="title" />
        <header class="flex items-center h-16 px-6 border border-t-0 border-l-0 border-r-0 border-b-neutral-800">
            <div class="basis-1/5 2xl:basis-1/6">
                <Link href="/" class="flex items-center">
                    <img src="/images/logo.png" alt="logo" class="w-10 h-10">
                    <div class="font-bold ms-4">Orbit</div>
                </Link>
            </div>
            <div class="basis-3/5 2xl:basis-4/6 flex justify-between">
                <form @submit.prevent="search" class="flex items-center flex-grow">
                    <TextInput v-model="searchForm.query" class="w-1/3" placeholder="Lets find something"/>
                    <Button label="Search" icon="search" class="h-10 ms-4" type="submit"/>
                </form>
                <div class="flex items-center">
                    <NavbarItem icon="user"        label="My Profile" :href="route('profile.posts')"/>
                    <NavbarItem icon="comment"     label="Messages"   :href="route('dashboard')"/>
                    <NavbarItem icon="face-smile"  label="Friends"    :href="route('profile.buddies')"/>
                    <NavbarItem icon="users"       label="Groups"     :href="route('dashboard')"/>
                    <NavbarItem icon="calendar"    label="Events"     :href="route('dashboard')"/>
                    <NavbarItem icon="cog"         label="Settings"   :href="route('dashboard')"/>
                </div>
            </div>
            <div class="flex items-center justify-end basis-1/5 2xl:basis-1/6 gap-x-4">
                <Notifications />
                <Link :href="route('logout')" method="post" as="button">
                    <span class="pi pi-power-off text-neutral-500 hover:text-white transition" style="font-size: 0.9rem;"></span>
                </Link>
            </div>
        </header>
    </div>
</template>