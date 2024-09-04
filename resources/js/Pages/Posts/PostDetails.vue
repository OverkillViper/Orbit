<script setup>

import Header from '../Common/Header.vue';
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import CommentForm from './CommentForm.vue';
import Comment from './Comment.vue';

const props = defineProps({
    auth            : Object,
    post            : Object,
    currentimage    : Object,
    previousimage   : Object,
    nextimage       : Object,
    comments        : Array,
});

const collapsed = ref(true);
const showComments = ref(true);

</script>

<template>
    <div class="min-h-screen bg-primary flex flex-col">
        <Header title="Post Details"/>
        <main class="flex flex-grow">
            <div class="w-4/6 mt-16" v-if="post.galleries.length">
                <div class="fixed w-4/6 flex" style="height: 93.5%;">
                    <div class="min-w-16 flex items-center justify-center">
                        <Link :href="route('post.details.images', { post: post.id, image: previousimage.id })" v-if="previousimage">
                            <button class="w-10 h-10 flex items-center justify-center bg-secondary rounded-full border border-transparent hover:border-accent transition"><span class="pi pi-arrow-left"></span></button>
                        </Link>
                    </div>
                    <div class="w-full">
                        <img :src="'/storage/' + currentimage.path" alt="image" class="w-full h-full object-contain" v-if="currentimage">
                    </div>
                    <div class="min-w-16 flex items-center justify-center">
                        <Link :href="route('post.details.images', { post: post.id, image: nextimage.id })" v-if="nextimage">
                            <button class="w-10 h-10 flex items-center justify-center bg-secondary rounded-full border border-transparent hover:border-accent transition"><span class="pi pi-arrow-right"></span></button>
                        </Link>
                    </div>
                </div>
            </div>
            <div class="w-2/6 mt-16 bg-secondary min-h-full p-6" :class="{'mx-auto' : post.galleries.length == 0}">
                <div class="flex items-center">
                    <UserAvatar :user="post.author" :href="route('dashboard')" size="large"/>
                    <div class="ms-2">
                        <div class="text-white">{{ post.author.name }}</div>
                        <div class="text-xs text-neutral-400">{{ post.time_difference }}</div>
                    </div>
                </div>

                <div class="mt-4" :class="{'line-clamp-2' : collapsed}">
                    {{ post.content }}
                </div>
                
                <button class="text-xs text-neutral-400 hover:text-white transition cursor-default">
                    <span class="pi" style="font-size: 0.5rem;" :class="collapsed ? 'pi-chevron-down' : 'pi-chevron-up'"></span>
                    <span class="ms-2" @click="collapsed = !collapsed">Show {{ collapsed ? 'more' : 'less' }}</span>
                </button>

                <div class="flex border border-neutral-800 rounded-xl items-center justify-around p-3 mt-4">
                    <Link :href="route('posts.likes.toggle', post.id)" as="button" method="post" class="text-neutral-400 hover:text-white transition flex items-center gap-x-2">
                        <span class="pi" :class="post.isLiked ? 'pi-heart-fill' : 'pi-heart'"></span>
                        <span>{{ post.isLiked ? 'Cheered' : 'Cheers' }}</span>
                    </Link>
                    <button class="text-neutral-400 hover:text-white transition flex items-center gap-x-2" @click="showComments = !showComments">
                        <span class="pi pi-comment"></span>
                        <span>Comments</span>
                    </button>
                    <button class="text-neutral-400 hover:text-white transition flex items-center gap-x-2">
                        <span class="pi pi-clipboard"></span>
                        <span>Copy</span>
                    </button>
                </div>

                <div class="my-4">
                    <CommentForm :auth="auth" :post="post.id" />
                </div>
                
                <hr class="border-neutral-700">
                
                <div class="my-4" v-show="showComments" v-if="comments.length">
                    <Comment  v-for="comment in comments" :key="comment.id" :comment="comment" :auth="auth" class="my-4"/>
                </div>
            </div>
        </main>
    </div>
</template>

<style>

.p-textarea {
    background-color: #252525 !important;
    border: 2px solid transparent !important;
    color: white !important;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
}

.p-textarea:focus, .p-textarea:hover {
    border-color: #303030 !important;
}

.p-fileupload .p-button {
    font-size: 0.75rem !important;
    line-height: 1rem !important;
    text-transform: uppercase;
}

.p-fileupload .p-button .p-icon {
    font-size: 0.5rem !important;
    line-height: 1rem !important;
}

.p-fileupload span {
    display: none;
}

</style>