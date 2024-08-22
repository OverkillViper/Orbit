<script setup>

const props = defineProps({
    icon    : String,
    label   : String, 
    link    : String,
})

</script>

<template>
    <div class="rounded-full w-14 h-14 flex justify-center items-center m-auto bg-accent border border-transparent hover:border-neutral-600 transition" v-tooltip.bottom="label">
        <span class="pi" :class="'pi-' + icon"></span>
    </div>
</template>