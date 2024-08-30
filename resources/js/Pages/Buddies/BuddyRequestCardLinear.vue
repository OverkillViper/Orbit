<script setup>
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import Button from '@/Components/OrbitComponents/Button.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    request : Object
});

</script>

<template>
    <div class="bg-secondary rounded-xl overflow-hidden">
        <div class="flex border-l-4 border-l-neutral-500 transition p-3 w-full h-full">
            <div>
                <!-- <Avatar icon="pi pi-user" size="large" shape="circle" /> -->
                <UserAvatar size="large" shape="circle" :user="request.sender" href="#"/>
            </div>
            <div class="ms-3 2xl:ms-4 flex-grow">
                <div class="text-sm text-white font-medium">{{ request.sender.name }}</div>
                <div class="text-xs text-neutral-400">{{ request.time_difference }}</div>
                <div class="flex items-center mt-2 gap-x-4">
                    <Link :href="route('buddies.request.accept', request.id)" as="button" method="post">
                        <Button label="Accept" class="bg-neutral-700" compact/>
                    </Link>
                    <Link :href="route('buddies.request.decline', request.id)" as="button" method="post">
                        <Button label="Decline" compact/>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>