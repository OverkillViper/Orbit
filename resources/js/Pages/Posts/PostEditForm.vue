<script setup>
import Dialog from 'primevue/dialog';
import { useForm, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import Textarea from 'primevue/textarea';
import SelectButton from 'primevue/selectbutton';
import FileUpload from 'primevue/fileupload';
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import Button from '@/Components/OrbitComponents/Button.vue';
import ProgressSpinner from 'primevue/progressspinner';

const props = defineProps({
    post : Object,
});

const visible = ref(false);
const emit = defineEmits(['update-visible']);

watch(visible, (newVal) => {
  emit('update-visible', newVal);
});

const postForm = useForm({
    content     : props.post.content,
    images      : props.post.galleries,
    visibility  : props.post.visibility,
});

const visibilities = ['public', 'friends', 'private'];

const onSelectedFiles = (event) => {
    const files = event.files;
    
    postForm.images = files;
};

const updatePost = () => {
    postForm.put(route('post.update', props.post.id), {
        onFinish: () => {
            visible.value = false;
        }
    })
}

</script>

<template>
    <button @click="visible = true">
        <slot />
    </button>
    <Dialog v-model:visible="visible" modal header="Edit Post" :style="{ width: '40rem' }">
        <template #header>
            <div class="inline-flex items-center justify-center gap-2 text-white bg-se">
                <UserAvatar size="large" :user="post.author" :href="route('profile.posts')"/>
                <span class="font-bold whitespace-nowrap text-white">Edit Post</span>
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
                <div class="flex items-center my-2 gap-4">
                    <div class="relative" v-for="image of post.galleries" :key="image.path">
                        <img :alt="image.path" :src="'/storage/' + image.path" class="w-12 h-12 rounded-md" />
                        <Link :href="route('post.image.remove', image.id)" class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2" as="button" method="delete">
                            <span class="pi pi-times bg-white rounded-full" style="font-size: .8rem;"></span>
                        </Link>
                    </div>
                </div>
            </div>
        </form>
        <template #footer>
            <div class="flex items-center gap-x-4 justify-end w-full">
                <Button label="Cancel" @click="visible = false"/>
                <div v-if="postForm.processing">
                    <ProgressSpinner style="width: 15px; height: 15px" strokeWidth="3"/>
                </div>
                <Button label="Save" @click="updatePost" v-else/>
                
            </div>
        </template>
    </Dialog>
</template>