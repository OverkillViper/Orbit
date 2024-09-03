<script setup>
import Textarea from 'primevue/textarea';
import Button from '@/Components/OrbitComponents/Button.vue';
import FileUpload from 'primevue/fileupload';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';

const props = defineProps({
    auth    : Object,
    post    : Object,
    parent  : Object,
})

const commentForm = useForm({
    content     : '',
    image       : null,
    post_id     : '',
    parent_id   : null,
});

const commentImagePreview = ref();

const onSelectedFiles = (event) => {
    const files = event.files;
    
    commentImagePreview.value = files[0].objectURL
    commentForm.image = files;
};

const cancelUpload = () => {
    commentImagePreview.value = null;
    commentForm.image = null;
}

const postComment = () => {
    commentForm.parent_id   = props.parent  ? props.parent.id  : null;
    commentForm.post(route('comment.store', props.post.id));
}

</script>

<template>
    <form @submit.prevent="postComment" class="w-full">
        <div class="flex gap-x-2">
            <div class="mt-1">
                <UserAvatar :user="auth.user" :href="route('dashboard')"/>
            </div>
            <Textarea fluid autoResize rows="2" placeholder="Make a comment" v-model="commentForm.content">

            </Textarea>
        </div>
        <div v-if="commentImagePreview" class="ms-10 mt-2 flex items-center gap-x-2">
            <img :src="commentImagePreview" alt="image" class="w-10 h-10 object-cover rounded-lg">
            <button class="flex items-center justify-center w-10 h-10 bg-accent rounded-lg" @click="cancelUpload">
                <span class="pi pi-times"></span>
            </button>
        </div>
        <div class="flex justify-between items-center mt-2">
            <div class="flex overflow-hidden flex-grow">
                <FileUpload mode="basic" accept="image/*" :maxFileSize="1000000" :multiple="false" @select="onSelectedFiles" v-if="commentImagePreview == null"/>
            </div>
            <Button label="Comment" icon="send" type="submit"/>
        </div>
    </form>
</template>