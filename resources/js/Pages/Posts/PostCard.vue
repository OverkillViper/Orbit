<script setup>
import Avatar from 'primevue/avatar';
import { ref } from 'vue';

const collapsed = ref(true);

const props = defineProps({
    grid : [String, Number]
})

</script>

<template>

<div class="rounded-xl bg-accent p-4 flex flex-col gap-y-4">
    <div class="flex items-center">
        <Avatar icon="pi pi-user" size="large"/>
        <div class="ms-4 flex-grow">
            <div class="text-white">Username</div>
            <div class="text-xs text-neutral-400">2 hours ago</div>
        </div>
        <div class="flex items-center gap-x-4 me-2">
            <button class="text-neutral-400 hover:text-white transition"><span class="pi pi-clipboard"></span></button>
            <button class="text-neutral-400 hover:text-white transition"><span class="pi pi-heart"></span></button>
        </div>
    </div>
    <div class="grid" :class="'grid-cols-' + grid">
        <img src="/images/booking_final.png" alt="post_image" class="rounded-xl w-full aspect-video object-cover">
    </div>
    <div class="text-sm" :class="{'line-clamp-2' : collapsed}">
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quo repellendus quasi fugiat nobis laborum temporibus at ipsum nemo eveniet aperiam veritatis labore doloribus necessitatibus expedita repellat, debitis aliquid accusamus ipsam corporis fugit odio quae? Autem, obcaecati voluptatem earum voluptatibus omnis ratione quisquam sed dolores maxime, aspernatur aut voluptatum, assumenda id!
    </div>
    <div class="flex items-center justify-between">
        <div class="flex items-center cursor-default text-neutral-400 hover:text-white transition ">
            <span class="pi pi-comments" style="font-size: 0.7rem;"></span>
            <span class="text-sm ms-2">Comments</span>
        </div>
        <div class="text-xs text-neutral-400 hover:text-white transition cursor-default">
            <span class="pi" style="font-size: 0.5rem;" :class="collapsed ? 'pi-chevron-down' : 'pi-chevron-up'"></span>
            <span class="ms-2" @click="collapsed = !collapsed">Show {{ collapsed ? 'more' : 'less' }}</span>
        </div>
    </div>
    
</div>

</template>