<script setup>
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';
import Avatar from 'primevue/avatar';
import Dialog from 'primevue/dialog';
import { ref } from 'vue';
import Textarea from 'primevue/textarea';
import FileUpload from 'primevue/fileupload';

const visible = ref(false);

const onUpload = () => {
    console.log('demo');
};

</script>

<template>
    <form @submit.prevent class="rounded-xl bg-secondary p-6">
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
            <Textarea v-model="value" autoResize rows="5" cols="30" class="w-full" placeholder="Whats on your mind?"/>
            <hr class="my-4 border-neutral-700">
            <div>
                <FileUpload mode="advanced" accept="image/*" :maxFileSize="1000000" @upload="onUpload" :auto="true" :multiple="true">
                    <template #header="{ chooseCallback, clearCallback, files }">
                        <div class="flex flex-wrap justify-between items-center flex-1 gap-4">
                            <div class="flex gap-2 ms-5">
                                <button @click="chooseCallback()" class="text-neutral-400 hover:text-white transition"><span class="pi pi-images"></span></button>
                            </div>
                        </div>
                    </template>
                    <template #content="{uploadedFiles, removeUploadedFileCallback}">
                        <div class="flex items-center my-2 gap-4">
                            <div class="relative" v-for="(file, index) of uploadedFiles" :key="file.name + file.type + file.size">
                                <img role="presentation" :alt="file.name" :src="file.objectURL" class="w-12 h-12 rounded-md" />
                                <span @click="removeUploadedFileCallback(index)" class="pi pi-times absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 bg-white rounded-full" style="font-size: .8rem;"></span>
                            </div>
                        </div>
                    </template>
                </FileUpload>
            </div>
        </form>
        <template #footer>
            <div class="flex items-center gap-x-4 justify-end w-full">
                <Button label="Cancel" text severity="secondary" @click="visible = false"/>
                <Button label="Save" outlined severity="secondary" @click="visible = false"/>
            </div>
        </template>
    </Dialog>
</template>

<style>
.p-textarea {
    background-color: transparent !important;
    border-color: transparent !important;
    color: white !important;
    font-weight: 300;
    padding: .5rem;
    font-size: 0.75rem !important;
    line-height: 1rem !important;
}

.p-textarea:focus {
    border-color: #323232 !important;
}

.p-textarea:hover {
    border-color: #323232 !important;
}

.p-fileupload-choose-button {
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
}

.p-fileupload-choose-button svg {
    display: none;
}

.p-fileupload-header {
    padding: 0 !important;
}

.p-fileupload {
    background: transparent !important;
    border: none !important;
}
</style>