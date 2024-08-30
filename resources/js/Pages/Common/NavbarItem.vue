<script setup>
import { Link } from '@inertiajs/vue3';


const props = defineProps({
    icon    : String,
    label   : String, 
    href    : String,
})

</script>

<template>
    <Link :href="href" class="w-12 h-12 flex text-neutral-500 justify-center items-center m-auto hover:text-white transition" v-tooltip.bottom="label">
        <span class="pi" :class="'pi-' + icon"></span>
    </Link>
</template>