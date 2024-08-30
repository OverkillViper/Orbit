<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import ProfileHeader from './ProfileHeader.vue';
import PostCard from '../Posts/PostCard.vue';
import PostCreateForm from '../Posts/PostCreateForm.vue';

const props = defineProps({
    auth            : Object,
    buddies_count   : Number,
    posts           : Array,
})

</script>

<template>
<ProfileLayout title="My Posts">
    <ProfileHeader :auth="auth" :buddies_count="buddies_count"/>

    <div class="flex w-3/5 mx-auto mt-10">
        <div class="basis-2/5">

        </div>
        <div class="basis-3/5 flex flex-col gap-y-6">
            <PostCreateForm :user="auth.user"/>

            <PostCard v-for="post in posts" :key="post.id" :post="post" :grid="post.galleries.length > 4 ? 4 : post.galleries.length"/>
        </div>
    </div>
    
</ProfileLayout>
</template>