<script setup>
import Header from '../Common/Header.vue';
import GroupHeader from './GroupHeader.vue';

const props = defineProps({
    auth : Object,
});

</script>

<template>
    <div class="min-h-screen bg-primary flex flex-col">
        <Header title="Groups"/>

        <main class="flex-grow mt-16">
            <div class="w-2/3 mx-auto">
                <GroupHeader title="Groups" :auth="auth"/>
            </div>
        </main>
    </div>
</template>