<script setup>
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';
import Avatar from 'primevue/avatar';
import Dialog from 'primevue/dialog';
import { ref } from 'vue';
import Textarea from 'primevue/textarea';
const visible = ref(false);

</script>

<template>
    <form @submit.prevent class="rounded-lg bg-secondary p-6">
        <div class="flex gap-x-4 items-center">
            <Avatar icon="pi pi-user" size="large"/>
            <div class="text-neutral-400 select-none" @click="visible = true">
                <div class="text-sm">Hey</div>
                <div>Whats on your mind?</div>
            </div>
        </div>
    </form>

    <Dialog v-model:visible="visible" modal header="Write Post" :style="{ width: '40rem' }">
        <template #header>
            <div class="inline-flex items-center justify-center gap-2 text-white bg-se">
                <Avatar icon="pi pi-user"/>
                <span class="font-bold whitespace-nowrap text-white">Write Post</span>
            </div>
        </template>
        <form @submit.prevent>
            <Textarea v-model="value" autoResize rows="5" cols="30" class="w-full"/>
        </form>
        <template #footer>
            <div class="flex items-center gap-x-4">
                <Button label="Cancel" text severity="secondary" @click="visible = false" autofocus />
                <Button label="Save" outlined severity="secondary" @click="visible = false" autofocus />
            </div>
        </template>
    </Dialog>
</template>

<style>
.p-textarea {
    background-color: transparent;
    border-color: transparent;
    color: white;
    font-weight: 300;
    @apply text-xs;
}

.p-textarea:focus {
    border-color: #323232 !important;
}

.p-textarea:hover {
    border-color: #323232 !important;
}
</style>