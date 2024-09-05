<script setup>
import GroupLayout from '@/Layouts/GroupLayout.vue';
import PostCreateForm from '../Posts/PostCreateForm.vue';
import PostCard from '../Posts/PostCard.vue';

const props = defineProps({
    group : Object,
    auth  : Object,
    posts : Array,
})

</script>

<template>
<GroupLayout :group="group" :auth="auth" selected="posts">
    <div class="w-3/4 mx-auto flex flex-col gap-y-4 pb-4">
        <PostCreateForm :user="auth.user" :group="group"/>

        <PostCard v-for="post in posts" :key="post.id" :post="post" :auth="auth"/>
    </div>
</GroupLayout>
</template>