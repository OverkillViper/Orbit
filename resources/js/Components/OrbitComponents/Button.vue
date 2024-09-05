<script setup>

const props = defineProps({
    label      : String,
    icon       : String,
    type       : String,
    compact    : Boolean,
    background : String,
})

</script>
<template>
    <button :type="type" class="flex justify-center items-center border border-transparent rounded-lg hover:border-neutral-600 transition ease-in" :class="[icon ? 'gap-x-2' : '', compact ? 'px-3 py-1' : 'px-4 py-2', background ? background : 'bg-accent']">
        <span class="pi text-white" :class="'pi-' + icon" v-if="icon" style="font-size: 0.8rem;"></span>
        <div class="text-xs font-medium uppercase text-white text-center">{{ label }}</div>
    </button>
</template>