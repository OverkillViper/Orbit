<script setup>
import Button from '@/Components/OrbitComponents/Button.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    request : Object
});


</script>

<template>
    <div class="rounded-lg bg-secondary pb-4 border-b-8 border-b-neutral-500">
        <div>
            <img :src="'/storage/' + request.sender.cover_photo" alt="" v-if="request.sender.cover_photo" class="overflow-hidden rounded-xl object-cover w-full h-36">
            <img src="/images/background.png" alt="" v-else class="overflow-hidden rounded-xl object-cover w-full h-36">
        </div>
        <div class="relative w-full h-12">
            <div class="abosulte top-0 w-24 h-24 mx-auto -translate-y-1/2 rounded-full overflow-hidden border-2 border-neutral-600">
                <Link href="#">
                    <img :src="'/storage/' + request.sender.avatar" alt="profile_picture" v-if="request.sender.avatar">
                    <img src="/images/avatar.svg" alt="profile_picture" v-else>
                </Link>
            </div>
        </div>
        <Link href="#" class="text-white text-center mt-4 line-clamp-1">{{ request.sender.name }}</Link>
        <div class="flex items-center justify-center gap-x-2 mt-4">
            <Link :href="route('buddies.request.accept', request.id)" as="button" method="post">
                <Button label="Accept" icon="user" class="w-full"/>
            </Link>
            <Link :href="route('buddies.request.decline', request.id)" as="button" method="post">
                <Button label="Decline" icon="user" class="w-full"/>
            </Link>
        </div>
    </div>
</template>