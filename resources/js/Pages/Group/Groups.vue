<script setup>
import Header from '../Common/Header.vue';
import GroupHeader from './GroupHeader.vue';
import GroupCard from './GroupCard.vue';

const props = defineProps({
    auth    : Object,
    request : String,
    groups  : Array,
});

</script>

<template>
    <div class="min-h-screen bg-primary flex flex-col">
        <Header title="Groups"/>

        <main class="flex-grow w-2/3 mt-16 mx-auto">
            <GroupHeader title="Groups" :auth="auth"/>

            <div v-if="request" class="mt-6">
                Search result for: {{ request }}
            </div>
            <div class="mt-4" v-if="request">
                <div class="grid grid-cols-3 2xl:grid-cols-4" v-if="groups.length">
                    <GroupCard :group="group" v-for="group in groups" :key="group.id" />
                </div>
                <div v-else class="flex justify-center items-center gap-x-2 text-sm text-neutral-400">
                    <span class="pi pi-exclamation-triangle"></span>
                    <span>No result found</span>
                </div>
            </div>

        </main>
    </div>
</template>