<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import ProfileHeader from './ProfileHeader.vue';
import BuddyCard from '../Buddies/BuddyCard.vue';
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';

const props = defineProps({
    auth            : Object,
    buddies_count   : Number,
    buddies         : Array,
    buddy_requests  : Number,
})

</script>

<template>
<ProfileLayout title="Buddies">
    <ProfileHeader :auth="auth" :buddies_count="buddies_count"/>

    <div class="w-2/3 mx-auto mt-6">
        <div class="flex items-center justify-between">
            <div class="font-bold text-lg">
                <span class="text-neutral-400">{{ buddies_count }}</span>
                Buddies
            </div>

            <div class="flex items-center gap-x-4">
                <Link :href="route('profile.buddies.requests')">
                    <Button :label="buddy_requests + ' Buddy Requests'" icon="user-plus"/>
                </Link>
                <Link :href="route('profile.buddies.requests.sent')">
                    <Button label="Sent Requests" icon="user-plus"/>
                </Link>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-3 2xl:grid-cols-4 gap-4" v-if="buddies_count">
            <BuddyCard v-for="buddy in buddies" :key="buddy.id" :request="buddy"/>
        </div>
    </div>
</ProfileLayout>
</template>