<script setup>
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import PostContext from './PostContext.vue';

const collapsed = ref(true);

const props = defineProps({
    auth        : Object,
    post        : Object,
    showgroup   : Boolean,
});

</script>

<template>

<div class="rounded-xl bg-secondary p-4 flex flex-col gap-y-4">
    <div class="flex items-center">
        <UserAvatar size="large" :user="post.author" :href="route('profile.posts')"/>
        <div class="ms-4 flex-grow">
            
            <div class="flex items-center gap-x-2">
                <div class="text-white font-semibold">{{ post.author.name }}</div>
                <span class="pi pi-angle-right" style="font-size: 0.8rem;" v-if="post.group" v-show="showgroup"></span>
                <Link :href="route('group.posts', post.group.id)" v-show="showgroup" v-if="post.group" class="hover:underline">
                    {{ post.group.name }}
                </Link>
            </div>
            <div class="text-xs text-neutral-400">{{ post.time_difference }}</div>
        </div>
        <div class="flex items-center gap-x-4 me-2">
            <button class="text-neutral-400 hover:text-white transition" v-tooltip.bottom="'Copy Post'"><span class="pi pi-clipboard"></span></button>
            <Link :href="route('posts.likes.toggle', post.id)" as="button" method="post" class="text-neutral-400 hover:text-white transition" v-tooltip.bottom="post.isLiked ? 'Cheered' : 'Cheers'"><span class="pi" :class="post.isLiked ? 'pi-heart-fill' : 'pi-heart'"></span></Link>
        </div>
        <PostContext :post="post" v-if="post.author.id === auth.user.id"/>
    </div>
    <div class="grid gap-4 relative" v-if="post.galleries.length" :class="post.galleries.length < 4 ? 'grid-cols-' + post.galleries.length : 'grid-cols-2'">
        <Link :href="route('post.details.images', [post = post.id, image = gallery.id])" v-for="gallery in post.galleries.slice(0, 4)" :key="gallery.id" >
            <img :src="'/storage/' + gallery.path" alt="post_image" class="rounded-xl w-full aspect-square object-cover">
            <div class="absolute bottom-0 z-10 right-0 w-1/2 h-1/2 flex pt-2 ps-2" v-if="post.galleries.length > 4">
                <div class="bg-neutral-800 bg-opacity-75 w-full rounded-xl flex items-center justify-center text-4xl font-bold">
                    + {{ post.galleries.length - 4 }}
                </div>
            </div>
        </Link>
    </div>
    <div class="text-sm" :class="{'line-clamp-2' : collapsed}">
        {{ post.content }}
    </div>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-x-4">
            <div class="flex items-center cursor-default text-neutral-400 hover:text-white transition text-sm">
                <span class="pi pi-heart-fill me-2" style="font-size: 0.7rem;"></span>
                <span class="me-1">{{ post.likes_count }}</span>
                <span>Cheers</span>
            </div>
            <Link :href="post.galleries.length ? route('post.details.images', post.id) : route('post.details', post.id)" class="flex items-center cursor-default text-neutral-400 hover:text-white transition ">
                <span class="pi pi-comments" style="font-size: 0.7rem;"></span>
                <span class="text-sm ms-2">Comments</span>
            </Link>
        </div>
        
        <div class="text-xs text-neutral-400 hover:text-white transition cursor-default">
            <span class="pi" style="font-size: 0.5rem;" :class="collapsed ? 'pi-chevron-down' : 'pi-chevron-up'"></span>
            <span class="ms-2" @click="collapsed = !collapsed">Show {{ collapsed ? 'more' : 'less' }}</span>
        </div>
    </div>
    
</div>

</template>