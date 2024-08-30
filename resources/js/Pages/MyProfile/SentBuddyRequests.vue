<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import ProfileHeader from './ProfileHeader.vue';
import PeopleCard from '../People/PeopleCard.vue';
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';

const props = defineProps({
    auth                 : Object,
    sent_buddy_requests  : Array,
    buddies_count        : Number,
});

</script>

<template>
<ProfileLayout title="Sent Requests">
    <ProfileHeader :auth="auth" :buddies_count="buddies_count"/>

    <div class="w-2/3 mx-auto mt-6">
        <div class="flex items-center justify-between">
            <div class="font-bold text-lg">
                <span class="text-neutral-400">{{ sent_buddy_requests.length }}</span>
                Sent Buddy Requests
            </div>

            <div class="flex items-center gap-x-4">
                <Link :href="route('profile.buddies')">
                    <Button label="Buddies" icon="face-smile"/>
                </Link>
                <Link :href="route('profile.buddies.requests')">
                    <Button label="Buddy Requests" icon="user-plus"/>
                </Link>
            </div>
        </div>
        
        <div class="mt-6 grid grid-cols-3 2xl:grid-cols-4 px-1" v-if="sent_buddy_requests.length">
            <PeopleCard :user="request.recipient" v-for="request in sent_buddy_requests" :key="request.id" status="request_sent"/>
        </div>
    </div>
</ProfileLayout>
</template>