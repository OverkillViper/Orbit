<script setup>
import Dialog from 'primevue/dialog';
import { ref } from 'vue';
import FileUpload from 'primevue/fileupload';
import Button from '@/Components/OrbitComponents/Button.vue';
import { useForm } from '@inertiajs/vue3';

const visible = ref(false);
const hasError = ref(false);

const pictureForm = useForm({
    coverPhoto : null,
});

const onRemoveTemplatingFile = (removeFileCallback, index) => {
    pictureForm.coverPhoto = null;
    removeFileCallback(index);
};

const onSelectedFiles = (event) => {
    hasError.value = false;
    const file = event.files[0];

    pictureForm.coverPhoto = file;
};

const changeCoverPhoto = () => {
    if(pictureForm.coverPhoto == null) {
        hasError.value = true;
    } else {
        pictureForm.post(route('profile.coverphoto.update'), {
            onFinish: () => {
                pictureForm.coverPhoto = null;
                visible.value = false;
            },
        })
    }
}

const removeCoverPhoto = () => {
    pictureForm.post(route('profile.coverphoto.remove'), {
        onFinish: () => {
            pictureForm.coverPhoto = null;
            visible.value = false;
        },
    })
}

</script>

<template>
    <Button label="Change cover photo" icon="camera" @click="visible = true"/>

    <Dialog v-model:visible="visible" modal header="Update Cover Photo" :style="{ width: '45rem' }">
        <template #header>
            <div class="inline-flex items-center justify-center gap-2 text-white bg-se">
                <span class="font-bold whitespace-nowrap text-white">Update Cover Photo</span>
            </div>
        </template>
        <form @submit.prevent>
            <div>
                <FileUpload mode="advanced" accept="image/*" class="border-0" :multiple="false" @select="onSelectedFiles">
                    <template #header="{ chooseCallback, files }">
                        <div class="flex items-center w-full gap-x-4" v-show="files.length == 0">
                            <button @click="chooseCallback()" class="w-10 h-10 rounded-lg bg-secondary border border-transparent hover:border-neutral-600 transition">
                                <span class="pi pi-images text-white"></span>
                            </button>
                            <div class="h-10 rounded-lg bg-secondary flex-grow flex items-center px-4 text-neutral-500 select-none">
                                {{ hasError ? 'Please select an image' : 'Choose cover photo'}}
                            </div>
                        </div>
                    </template>
                    <template #content="{ files, removeFileCallback }">
                        <div class="flex flex-col">
                            <div v-if="files.length > 0">
                                <div class="relative">
                                    <img role="presentation" :alt="files[0].name" :src="files[0].objectURL" class="w-full aspect-video object-cover rounded-md"/>
                                    <button
                                        @click="onRemoveTemplatingFile(removeFileCallback, 0)"
                                        class="bg-neutral-800 bg-opacity-90 absolute top-0 right-0 rounded-full m-2 text-neutral-400 hover:text-white transition"
                                    ><span class="pi pi-times m-2"></span></button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #empty>
                        <div class="flex flex-col justify-center items-center border border-dashed border-neutral-600 rounded-md p-5 bg-neutral-700 mt-6">
                            <div class="flex">
                                <span class="pi pi-upload rounded-full border bg-neutral-500 border-dashed border-gray-400 p-3 text-white"></span>
                            </div>
                            <div class="mt-2 font-medium text-sm text-white">Drag and drop files here to upload</div>
                        </div>
                    </template>
                </FileUpload>
                <div class="text-center text-neutral-600 text-sm">
                    OR
                </div>
                <div class="flex justify-center my-4">
                    <Button label="Remove Cover photo" icon="times" @click="removeCoverPhoto"/>
                </div>
            </div>
        </form>
        <template #footer>
            <div class="flex items-center gap-x-4 justify-end w-full">
                <Button label="Cancel" @click="visible = false"/>
                <Button label="Change" @click="changeCoverPhoto"/>
            </div>
        </template>
    </Dialog>
</template>

<style>
.p-fileupload {
    background: transparent !important;
    border: none !important;
}
</style>