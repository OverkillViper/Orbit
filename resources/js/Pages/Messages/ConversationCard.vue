<script setup>
import { Link } from '@inertiajs/vue3';
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';

const props = defineProps({
    conversation : Object,
})

</script>

<template>
    <Link :href="route('messages.conversation', conversation.id)" class="flex items-center p-3 hover:bg-accent transition gap-x-3 rounded-xl">
        <div>
            <UserAvatar :user="conversation.other_user" shape="circle" :href="route('dashboard')" />
        </div>
        <div>
            <div class="text-white font-semibold text-sm">{{ conversation.other_user.name }}</div>
            <div class="line-clamp-1 text-xs text-neutral-400">asdsd</div>
        </div>
    </Link>
</template>