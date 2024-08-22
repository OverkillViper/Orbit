<script setup>
import FeedLayout from '@/Layouts/FeedLayout.vue';
import PostCreateForm from '../Posts/PostCreateForm.vue';

</script>

<template>

<FeedLayout title="Home">
    <div class="mx-auto w-3/4 2xl:w-2/3 mt-6">
        <PostCreateForm />
    </div>
</FeedLayout>

</template>