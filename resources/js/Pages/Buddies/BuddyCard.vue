<script setup>
import Avatar from 'primevue/avatar';
import OverlayBadge from 'primevue/overlaybadge';

const props = defineProps({
    buddy  : Object,
    active : Boolean
})

</script>

<template>
    <div class="flex items-center border border-transparent rounded-lg hover:border-neutral-700 cursor-default transition">
        <OverlayBadge severity="success" class="inline-flex" v-if="active">
            <Avatar class="p-overlay-badge" icon="pi pi-user" />
        </OverlayBadge>
        <Avatar class="p-overlay-badge" icon="pi pi-user" v-else/>

        <div class="ms-4 text-sm font-medium select-none">Buddy Name</div>
    </div>
</template>