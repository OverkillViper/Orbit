<script setup>
import Header from '@/Pages/Common/Header.vue';
import ConversationCard from '@/Pages/Messages/ConversationCard.vue';

const props = defineProps({
    title           : String,
    conversations   : Array,
    hideSidebar     : Boolean,
})

</script>

<template>
    <div class="min-h-screen bg-primary">
        <Header :title="title"/>
        <main class="flex relative">
            <div class="w-1/5 2xl:w-1/6 fixed mt-16 bg-secondary h-full flex">
                <div class="flex flex-col gap-y-2 p-2 w-full" v-if="conversations.length">
                    <ConversationCard :conversation="conversation" v-for="conversation in conversations" :key="conversation.id"/>
                </div>
                <div v-else class="w-2/3 m-auto text-center text-neutral-400 text-sm">
                    <div class="mb-2"><span class="pi pi-exclamation-triangle"></span></div>
                    You don't have any active conversation
                </div>
            </div>
            <div class="w-3/5 2xl:w-4/6 flex flex-col items-center mx-auto mt-16">
                <div class="w-2/3">
                    <slot />
                </div>
            </div>
            <div class="w-1/5 2xl:w-1/6 p-4 fixed right-0 mt-16 bg-secondary h-full" v-if="!hideSidebar">
                <slot name="rightSidebar"/>
            </div>
        </main>
    </div>
</template>