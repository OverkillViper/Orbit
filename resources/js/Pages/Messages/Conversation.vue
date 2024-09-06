<script setup>
import MessageLayout from '@/Layouts/MessageLayout.vue';

const props = defineProps({
    conversations : Array,
})

</script>

<template>
<MessageLayout title="Conversations" hide-sidebar :conversations="conversations">
    
</MessageLayout>
</template>