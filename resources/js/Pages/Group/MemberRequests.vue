<script setup>
import GroupLayout from '@/Layouts/GroupLayout.vue';
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';

const props = defineProps({
    group       : Object, 
    auth        : Object,
    requests    : Array,
})

</script>

<template>
<GroupLayout :group="group" :auth="auth">
<div class="grid grid-cols-3 2xl:grid-cols-4" v-if="requests.length">
    <div v-for="request in requests" :key="request.id" class="bg-secondary rounded-xl pb-4">
        <div>
            <img :src="'/storage/' + request.member.cover_photo" alt="" v-if="request.member.cover_photo" class="rounded-xl object-cover w-full aspect-video">
            <img src="/images/background.png" alt="" v-else class="rounded-xl object-cover w-full aspect-video">
        </div>
        <div class="relative w-full h-12">
            <div class="abosulte top-0 w-24 h-24 mx-auto -translate-y-1/2 rounded-full overflow-hidden border-2 border-neutral-600">
                <img :src="'/storage/' + request.member.avatar" alt="profile_picture" v-if="request.member.avatar">
                <img src="/images/avatar.svg" alt="profile_picture" v-else>
            </div>
        </div>
        <div class="text-white text-center mt-4 line-clamp-1 font-medium">{{ request.member.name }}</div>
        <div class="text-sm text-neutral-400 text-center">{{ request.time_difference }}</div>
        <div class="mt-4 flex items-center justify-center gap-x-4">
            <Link :href="route('group.members.request.accept', request.id)" as="button" method="post">
                <Button label="Accept"/>
            </Link>
            <Link :href="route('group.members.request.decline', request.id)" as="button" method="post">
                <Button label="Decline"/>
            </Link>
        </div>
    </div>
</div>
<div v-else class="flex items-center justify-center text-neutral-400 text-sm">
    <span class="pi pi-exclamation-triangle me-2"></span>
    <span>No pending request for this group</span>
</div>
</GroupLayout>
</template>