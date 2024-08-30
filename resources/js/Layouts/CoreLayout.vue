<script setup>
import Header from '@/Pages/Common/Header.vue';

const props = defineProps({
    title           : String,
});

</script>

<template>
    <div class="min-h-screen bg-primary">
        <Header :title="title"/>
        <main class="flex relative">
            <div class="2xl:w-1/6 fixed mt-14">
                <slot name="leftSidebar"/>
            </div>
            <div class="w-3/5 2xl:w-4/6 flex flex-col items-center mx-auto pt-20">
                <slot />
            </div>
            <div class="w-1/5 2xl:w-1/6 p-4 fixed right-0 mt-14">
                <slot name="rightSidebar"/>
            </div>
        </main>
    </div>
</template>