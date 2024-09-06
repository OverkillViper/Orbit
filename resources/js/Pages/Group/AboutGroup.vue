<script setup>
import GroupLayout from '@/Layouts/GroupLayout.vue';
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';

const props = defineProps({
    auth : Object,
    group : Object,
});

function formatDate(dateString) {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    }).format(date);
}

</script>

<template>
<GroupLayout :group="group" :auth="auth">
<div class="pb-4">
    <div class="text-white text-lg font-semibold">About this group</div>

    <div class="text-sm mt-4 text-neutral-400">
        Created On
    </div>
    <div class="text-white font-semibold mt-2">
        {{ formatDate(group.created_at) }}
    </div>

    <div class="text-sm mt-4 text-neutral-400">
        Group Admin
    </div>
    <div class="text-white font-semibold mt-2">
        <div class="flex px-4 py-2 items-center rounded-xl bg-secondary w-1/2">
            <div>
                <UserAvatar size="large" :user="group.admin"/>
            </div>
            <div class="ms-4">
                <div class="text-white">{{ group.admin.name }}</div>
                <div class="mt-2">
                    <Link href="#">
                        <Button label="View Profile"/>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</div>
</GroupLayout>
</template>