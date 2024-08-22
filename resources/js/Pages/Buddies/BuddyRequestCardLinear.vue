<script setup>
import Avatar from 'primevue/avatar';
import Button from '@/Components/OrbitComponents/Button.vue';

const props = defineProps({
    buddy : Object
});

</script>

<template>
    <div class="bg-secondary rounded-md overflow-hidden">
        <div class="flex border-l-4 border-l-neutral-500 transition p-3 w-full h-full">
            <Avatar icon="pi pi-user" size="large" shape="circle" />
            <div class="ms-4 flex-grow">
                <div class="text-sm text-white font-medium">User name</div>
                <div class="text-xs text-neutral-400">2 days ago</div>
                <div class="flex items-center mt-2 gap-x-4">
                    <Button label="Accept" class="bg-neutral-700" compact/>
                    <Button label="Decline" compact/>
                </div>
            </div>
        </div>
    </div>
</template>