<script setup>
import FeedLayout from '@/Layouts/FeedLayout.vue';
import PostCreateForm from '../Posts/PostCreateForm.vue';
import PostCard from '../Posts/PostCard.vue';

</script>

<template>

<FeedLayout title="Home">
    <div class="w-2/3 2xl:w-1/2 mt-20">
        <PostCreateForm />

        <div class="mt-6 flex flex-col gap-y-4">
            <PostCard grid="1"/>
            <PostCard grid="1"/>
            <PostCard grid="1"/>
        </div>
        
    </div>
</FeedLayout>

</template>