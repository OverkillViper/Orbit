<script setup>
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';

const props = defineProps({
    user : Object,
    status : String,
})

</script>

<template>
    <div class="rounded-xl bg-secondary pb-4">
        <div>
            <img :src="'/storage/' + user.cover_photo" alt="" v-if="user.cover_photo" class="rounded-xl object-cover w-full aspect-video">
            <img src="/images/background.png" alt="" v-else class="rounded-xl object-cover w-full aspect-video">
        </div>
        <div class="relative w-full h-12">
            <div class="abosulte top-0 w-24 h-24 mx-auto -translate-y-1/2 rounded-full overflow-hidden border-2 border-neutral-600">
                <img :src="'/storage/' + user.avatar" alt="profile_picture" v-if="user.avatar">
                <img src="/images/avatar.svg" alt="profile_picture" v-else>
            </div>
        </div>
        <div class="text-white text-center my-4 line-clamp-1 font-medium">{{ user.name }}</div>
        <div class="relative">
            <div class="flex justify-center items-center gap-x-2 w-full -mt-1">
                <Link href="#" v-tooltip.bottom="'View Profile'" class="bg-accent w-10 h-10 flex items-center justify-center rounded-xl text-neutral-400 hover:text-white transition">
                    <span class="pi pi-user"></span>
                </Link>
                <Link href="#" v-tooltip.bottom="'Send Message'" class="bg-accent w-10 h-10 flex items-center justify-center rounded-xl text-neutral-400 hover:text-white transition">
                    <span class="pi pi-comment"></span>
                </Link>
                <Link :href="route('buddies.request.cancel', user.id)" v-tooltip.bottom="'Cancel Request'" class="bg-accent w-10 h-10 flex items-center justify-center rounded-xl text-neutral-400 hover:text-white transition"  v-if="status == 'request_sent'" as="button" method="post">
                    <span class="pi pi-times"></span>
                </Link>
                <Link :href="route('buddies.request', user.id)" v-tooltip.bottom="'Request Buddy'" class="bg-accent w-10 h-10 flex items-center justify-center rounded-xl text-neutral-400 hover:text-white transition" as="button" method="post" v-else-if="status == 'none'">
                    <span class="pi pi-face-smile"></span>
                </Link>
            </div>
        </div>
    </div>
</template>