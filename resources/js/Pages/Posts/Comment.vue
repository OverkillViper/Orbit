<script setup>
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import CommentForm from './CommentForm.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import CommentContext from './CommentContext.vue';

const props = defineProps({
    auth    : Object,
    comment : Object,
});

const replying = ref(false);
const showReplies = ref(false);

</script>

<template>
    <div class="flex gap-x-3">
        <div>
            <UserAvatar :user="comment.author" :href="route('dashboard')"/>
        </div>
        <div class="flex flex-col gap-y-2 w-full">
            <div class="flex items-center justify-between">
                <div class="text-sm font-medium">
                    {{ comment.author.name }}
                </div>
                <div>
                    <CommentContext :comment="comment" v-if="comment.author.id === auth.user.id"/>
                </div>
            </div>
            
            <div class="bg-accent p-3 rounded-lg flex-grow text-sm" v-if="comment.content">
                {{ comment.content }}
            </div>
            <div v-if="comment.gallery && comment.gallery.length">
                <img :src="'/storage/' + comment.gallery[0].path" alt="image" class="rounded-xl w-40">
            </div>
            <div class="flex items-center text-xs gap-x-4">
                <span>{{ comment.time_difference }}</span>
                <span>{{ comment.likes_count }} Cheers</span>
                <Link :href="route('comments.likes.toggle', comment.id)" as="button" method="post">
                    <button class="hover:underline">{{ comment.isLiked ? 'Cheered' : 'Cheers'}}</button>
                </Link>
                <button class="hover:underline" @click="replying = !replying">Reply</button>
                <button class="hover:underline" @click="showReplies = !showReplies" v-if="comment.replies && comment.replies.length">Show replies</button>
            </div>

            <CommentForm :auth="auth" :post="comment.post_id" :parent="comment" v-show="replying"/>

            <div v-if="comment.replies" v-show="showReplies">
                <Comment v-for="reply in comment.replies" :key="reply.id" :comment="reply" :auth="auth"/>
            </div>
        </div>
    </div>
</template>