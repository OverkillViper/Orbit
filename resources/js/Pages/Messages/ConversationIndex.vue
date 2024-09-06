<script setup>
import MessageLayout from '@/Layouts/MessageLayout.vue';

const props = defineProps({
    conversations : Array,
})

</script>

<template>
<MessageLayout title="Conversations" hide-sidebar :conversations="conversations">
    <div class="mt-36">
        <img src="/images/logo.png" alt="logo" class="w-16 h-16">

        <div class="text-2xl font-semibold mt-6">
            Conversations
        </div>
        <div class="text-neutral-400 text-sm mt-2">
            Select a conversation to start messaging
        </div>
    </div>
</MessageLayout>
</template>
