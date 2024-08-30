<script setup>
import Header from '@/Pages/Common/Header.vue';

const props = defineProps({
    title : String,
})

</script>

<template>
    <div class="min-h-screen bg-primary">
        <Header :title="title"/>

        <main class="flex relative">
            <div class="mt-16 w-full pb-10">
                <slot />
            </div>
        </main>
    </div>
</template>