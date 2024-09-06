<script setup>
import Header from '@/Pages/Common/Header.vue';
import UpdateCoverPhoto from '@/Pages/MyProfile/UpdateCoverPhoto.vue';
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';

const props = defineProps({
    auth        : Object,
    group       : Object,
    selected    : String,
})

</script>

<template>
    <div class="min-h-screen bg-primary flex flex-col">
        <Header :title="group.name"/>

        <main class="flex-grow mt-20 flex flex-col items-center">
            <div class="w-3/4">
                <div class="relative">
                    <img :src="'/storage/' + group.cover_photo" alt="cover_photo" class="h-64 object-cover w-full rounded-xl" v-if="auth.user.cover_photo">
                    <img src="/images/background.png" alt="cover_photo" class="h-64 object-cover w-full rounded-xl" v-else>
                    <div class="absolute top-0 right-0 m-2">
                        <UpdateCoverPhoto />
                    </div>
                </div>
            </div>
            <div class="w-3/4 py-4 flex items-center justify-between">
                <div>
                    <div class="text-xl font-semibold">{{ group.name }}</div>
                    <div class="flex items-center gap-x-2 text-neutral-400 text-sm capitalize">
                        <div>{{ group.visibility }} group</div>
                        <span>&#183;</span>
                        <div>
                            {{ group.member_count }} Members
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-x-4">
                    <Link :href="route('group.delete', group.id)" as="button" method="delete" v-if="group.admin_id === auth.user.id">
                        <Button label="Delete Group" icon="trash" background="bg-red-700" />
                    </Link>
                    <Link :href="route('group.members.requests', group.id)" v-if="group.admin_id === auth.user.id">
                        <Button :label="group.requests + ' Member Requests'"/>
                    </Link>
                    <Link href="#">
                        <Button label="Leave group" icon="sign-out"/>
                    </Link>
                </div>
            </div>
            <div class="flex w-3/4 gap-x-2 mt-4">
                <div class="basis-1/4 flex flex-col gap-y-4">
                    <Link :href="route('group.posts', group.id)" class="flex items-center hover:text-white transition-all gap-x-2" :class="selected === 'posts' ? 'text-white' : 'text-neutral-400'">
                        <span class="pi pi-receipt" style="font-size: 0.95rem;"></span>
                        <span class="text-sm">Posts</span>
                    </Link>
                    <Link :href="route('group.members', group.id)" class="flex items-center hover:text-white transition-all gap-x-2" :class="selected === 'members' ? 'text-white' : 'text-neutral-400'">
                        <span class="pi pi-users" style="font-size: 0.95rem;"></span>
                        <span class="text-sm">Members</span>
                    </Link>
                    <Link :href="route('group.about', group.id)" class="flex items-center hover:text-white transition-all gap-x-2" :class="selected === 'about' ? 'text-white' : 'text-neutral-400'">
                        <span class="pi pi-info-circle" style="font-size: 0.95rem;"></span>
                        <span class="text-sm">About</span>
                    </Link>
                </div>
                <div class="basis-3/4">
                    <slot/>
                </div>
            </div>
        </main>
    </div>
</template>