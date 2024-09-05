<script setup>
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';

const props = defineProps({
    group : Object
});

</script>

<template>
    <div class="rounded-xl flex flex-col overflow-hidden">
        <img src="/images/background.png" alt="group_cover" class="h-28 object-cover">
        <div class="p-4 bg-secondary">
            <div class="text-white font-semibold line-clamp-1">{{ group.name }}</div>
            <div class="text-neutral-400 text-xs capitalize flex items-center gap-x-1">
                <span>{{ group.visibility }} Group</span>
                <span>&#183;</span>
                <span>{{ group.members_count }} Members</span>
            </div>

            <div class="mt-4 flex justify-center gap-x-2">
                <Link :href="route('group.posts', group.id)">
                    <Button label="Visit group"/>
                </Link>
                <Link href="#" v-if="group.is_member">
                    <Button label="Leave group"/>
                </Link>
                <Link :href="route('group.join', group.id)" v-else>
                    <Button label="Request to Join" v-if="group.visibility === 'private'" />
                    <Button label="Join Group" v-else/>
                </Link>
            </div>
        </div>
    </div>
</template>