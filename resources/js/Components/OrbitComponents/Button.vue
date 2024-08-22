<script setup>

const props = defineProps({
    label   : String,
    icon    : String,
    type    : String,
    compact : Boolean
})

</script>
<template>
    <button :type="type" class="flex justify-center items-center border border-transparent rounded-lg bg-accent hover:border-neutral-600 transition ease-in" :class="[icon ? 'gap-x-2' : '', compact ? 'px-3 py-1' : 'px-4 py-2']">
        <span class="pi" :class="'pi-' + icon" v-if="icon" style="font-size: 0.8rem;"></span>
        <div class="text-xs font-medium uppercase text-white text-center">{{ label }}</div>
    </button>
</template>