<script setup>
import Avatar from 'primevue/avatar';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    size  : String,
    user  : Object,
    href  : String,
    shape : String,
})

</script>

<template>
    <Link class="rounded-md overflow-hidden aspect-square hover:opacity-80 flex items-center justify-center" :href="href">
        <Avatar :shape="shape" class="p-overlay-badge w-full" :image="'/storage/' + user.avatar" v-if="user.avatar" :size="size"/>
        <Avatar :shape="shape" class="p-overlay-badge w-full" icon="pi pi-user" :size="size" v-else />
    </Link>
</template>