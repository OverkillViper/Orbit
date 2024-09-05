<script setup>
import GroupHeader from './GroupHeader.vue';
import Header from '../Common/Header.vue';
import GroupCard from './GroupCard.vue';

const props = defineProps({
    auth : Object,
    groups : Array,
})

</script>

<template>
    <div class="min-h-screen bg-primary flex flex-col">
        <Header title="Discover Groups"/>

        <main class="flex-grow mt-16">
            <div class="w-2/3 mx-auto">
                <GroupHeader title="Discover Groups" :auth="auth"/>
            </div>

            <div class="mt-6 grid grid-cols-3 2xl:grid-cols-4 mx-auto w-2/3 gap-4">
                <GroupCard v-for="group in groups" :key="group.id" :group="group" />
            </div>
        </main>
    </div>
</template>