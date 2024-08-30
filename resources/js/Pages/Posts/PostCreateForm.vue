<script setup>
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import Dialog from 'primevue/dialog';
import { ref } from 'vue';
import Textarea from 'primevue/textarea';
import FileUpload from 'primevue/fileupload';
import SelectButton from 'primevue/selectbutton';

const visible = ref(false);

const postForm = useForm({
    content     : '',
    images      : null,
    visibility  : 'public'
})

const props = defineProps({
    user : Object,
});

const visibilities = ['public', 'friends', 'private'];

const onSelectedFiles = (event) => {
    const files = event.files;
    
    postForm.images = files;
    console.log(postForm.images);
};

const createPost = () => {
    postForm.post(route('post.store'), {
        onFinish: () => {
            postForm.content = '';
            postForm.images  = null;
            postForm.visibility = 'public';
        }
    })
}

</script>

<template>
    <div class="rounded-xl bg-secondary p-6">
        <div class="flex gap-x-4 items-center">
            <UserAvatar size="large" :user="user" :href="route('profile.posts')"/>
            
            <div class="text-neutral-400 select-none" @click="visible = true">
                <div class="text-sm">Hey</div>
                <div>Whats on your mind?</div>
            </div>
        </div>
    </div>

    <Dialog v-model:visible="visible" modal header="Write Post" :style="{ width: '40rem' }">
        <template #header>
            <div class="inline-flex items-center justify-center gap-2 text-white bg-se">
                <UserAvatar size="large" :user="user" :href="route('profile.posts')"/>
                <span class="font-bold whitespace-nowrap text-white">Write Post</span>
            </div>
        </template>
        <form @submit.prevent enctype="multipart/form-data">
            <div class="font-medium">
                <div class="text-neutral-400 font-medium text-sm mb-2 select-none">Visibility</div>
                <SelectButton v-model="postForm.visibility" :options="visibilities" aria-labelledby="basic" />
            </div>
            <Textarea v-model="postForm.content" autoResize rows="5" cols="30" class="w-full mt-4" placeholder="Whats on your mind?"/>
            <hr class="my-4 border-neutral-700">
            <div>
                <FileUpload mode="advanced" accept="image/*" :maxFileSize="1000000" :multiple="true" @select="onSelectedFiles">
                    <template #header="{ chooseCallback }">
                        <div class="flex flex-wrap justify-between items-center flex-1 gap-4">
                            <div class="flex gap-2 ms-5">
                                <button @click="chooseCallback()" class="text-neutral-400 hover:text-white transition"><span class="pi pi-images"></span></button>
                            </div>
                        </div>
                    </template>
                    <template #content="{files, removeUploadedFileCallback}">
                        <div class="flex items-center my-2 gap-4">
                            <div class="relative" v-for="(file, index) of files" :key="file.name + file.type + file.size">
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
                <Button label="Cancel" @click="visible = false"/>
                <Button label="Post" @click="createPost"/>
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

.p-togglebutton {
    padding: 0.50rem 0.75rem !important;
    text-transform: capitalize;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
    background-color: #282828 !important;
    color: rgb(163 163 163) !important;
    border: none !important;
}

.p-togglebutton-checked::before {
    background-color: #424242 !important;
}

.p-togglebutton-checked {
    color: white !important;
}
</style>