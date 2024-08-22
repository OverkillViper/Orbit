<script setup>
import Header from '@/Pages/Common/Header.vue';
import BuddyRequestCardLinear from '@/Pages/Buddies/BuddyRequestCardLinear.vue';

const props = defineProps({
    title : String
});

</script>

<template>
    <div class="min-h-screen bg-primary">
        <Header :title="title"/>
        <div class="flex">
            <div class="basis-1/5 2xl:basis-1/6">
                <div class="flex flex-col gap-y-2 p-4">
                    <BuddyRequestCardLinear />
                </div>
            </div>
            <div class="basis-3/5 2xl:basis-4/6">
                <slot />
            </div>
            <div class="basis-1/5 2xl:basis-1/6">
                right bar
            </div>
        </div>
    </div>
</template>