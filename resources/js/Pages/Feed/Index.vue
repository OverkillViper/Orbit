<script setup>
import FeedLayout from '@/Layouts/CoreLayout.vue';
import PostCreateForm from '../Posts/PostCreateForm.vue';
import PostCard from '../Posts/PostCard.vue';
import BuddyRequestCardLinear from '@/Pages/Buddies/BuddyRequestCardLinear.vue';
import SidebarItem from '@/Pages/Common/NavbarItem.vue';
import { Link } from '@inertiajs/vue3';
import BuddyContactCard from '@/Pages/Buddies/BuddyContactCard.vue';

const props = defineProps({
    auth            : Object,
    buddy_requests  : Array,
    buddies         : Array,
    posts           : Array,
})

</script>

<template>

<FeedLayout title="Home">
    <template #leftSidebar>
        <div class="flex flex-col gap-y-2 p-4">
            <!-- <div class="text-white font-bold mb-2">Menu</div>
            <div class="grid grid-cols-3 gap-4 mb-6">

            </div> -->
            <div class="flex items-center justify-between">
                <div class="text-white font-bold">Buddy Requests</div>
                <Link href="#" class="text-sm text-neutral-500 hover:text-white transition">
                    See All
                </Link>
            </div>
            <BuddyRequestCardLinear v-for="request in buddy_requests" :key="request.id" :request="request"/>
        </div>
    </template>

    <div class="w-2/3 2xl:w-1/2">
        <PostCreateForm :user="auth.user"/>

        <div class="mt-4 flex flex-col gap-y-4">
            <PostCard v-for="post in posts" :key="post.id" :post="post" showgroup />
        </div>
    </div>
    
    <template #rightSidebar>
        <div class="flex items-center justify-between mb-2">
            <div class="text-white font-bold">Buddies</div>
            <Link href="#" class="text-sm text-neutral-500 hover:text-white transition">
                See All
            </Link>
        </div>
        <div class="flex flex-col gap-y-4">
            <BuddyContactCard v-for="buddy in buddies" :key="buddy.id" :buddy="buddy.buddy"/>
        </div>
    </template>

</FeedLayout>

</template>