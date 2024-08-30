<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import ProfileHeader from './ProfileHeader.vue';
import BuddyRequestCard from '../Buddies/BuddyRequestCard.vue';
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';

const props = defineProps({
    auth            : Object,
    buddy_requests  : Array,
    buddies_count   : Number,
});

</script>

<template>
<ProfileLayout title="Buddy Requests">
    <ProfileHeader :auth="auth" :buddies_count="buddies_count"/>

    <div class="w-2/3 mx-auto mt-6">
        <div class="flex items-center justify-between">
            <div class="font-bold text-lg">
                <span class="text-neutral-400">{{ buddy_requests.length }}</span>
                Buddy Requests
            </div>

            <div class="flex items-center gap-x-4">
                <Link :href="route('profile.buddies')">
                    <Button label="Buddies" icon="face-smile"/>
                </Link>
                <Link :href="route('profile.buddies.requests.sent')">
                    <Button label="Sent Requests" icon="user-plus"/>
                </Link>
            </div>
        </div>
        

        <div class="mt-6 grid grid-cols-3 2xl:grid-cols-4" v-if="buddy_requests.length">
            <BuddyRequestCard :request="request" v-for="request in buddy_requests" :key="request.id"/>
        </div>
    </div>
</ProfileLayout>
</template>