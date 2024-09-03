<script setup>
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import OverlayBadge from 'primevue/overlaybadge';

const props = defineProps({
    buddy  : Object,
})

</script>

<template>
    <div class="flex items-center border border-transparent rounded-lg hover:border-neutral-700 cursor-default transition">
        <OverlayBadge severity="success" class="inline-flex" v-if="buddy.is_active">
            <UserAvatar :user="buddy" :href="route('dashboard')"/>
        </OverlayBadge>
        <UserAvatar :user="buddy" :href="route('dashboard')" v-else/>

        <div class="ms-4 text-sm font-medium select-none">{{ buddy.name }}</div>
    </div>
</template>