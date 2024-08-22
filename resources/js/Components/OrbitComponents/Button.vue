<script setup>

const props = defineProps({
    label : String,
    icon  : String,
    type  : String
})

</script>
<template>
    <button :type="type" class="flex justify-center items-center rounded-lg px-4 py-2 bg-secondary hover:bg-black transition ease-in" :class="[icon ? 'gap-x-2' : '']">
        <span class="pi" :class="'pi-' + icon" v-if="icon" style="font-size: 0.8rem;"></span>
        <div class="text-xs font-medium uppercase text-white text-center">{{ label }}</div>
    </button>
</template>