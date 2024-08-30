<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    icon    : String,
    label   : String,
    href    : String,
})

</script>

<template>
    <Link :href="href" class="border w-10 h-10 flex items-center justify-center text-neutral-400 hover:text-white transition rounded-xl border-neutral-700" v-tooltip.bottom="label">
        <span class="pi" :class="'pi-' + icon"></span>
    </Link>
</template>