<script setup>
import Popover from 'primevue/popover';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import PostEditForm from './PostEditForm.vue';
import ProgressSpinner from 'primevue/progressspinner';

const pop = ref();
const loading = ref(false);

const toggle = (event) => {
    pop.value.toggle(event);
}

const dismissable = ref(true);

function handleVisibilityChange(isVisible) {
  dismissable.value = !isVisible;
}

const props = defineProps({
    post : Object,
})

</script>

<template>
    <button @click="toggle" class="text-neutral-400 hover:text-white transition">
        <span class="pi pi-ellipsis-v" style="font-size: 0.9rem;"></span>
    </button>

    <Popover ref="pop" :dismissable="dismissable">
        <div class="flex flex-col gap-y-2 w-20">
            <PostEditForm :post="post" @update-visible="handleVisibilityChange">
                <div class="flex items-center font-medium text-xs text-neutral-400 hover:text-white transition gap-x-2">
                    <span class="pi pi-pencil" style="font-size: 0.7rem;"></span>
                    <span>Edit</span>
                </div>
            </PostEditForm>
            <Link :href="route('post.delete', post.id)" as="button" method="delete" @click="loading = true" v-if="loading == false">
                <div class="flex items-center font-medium text-xs text-neutral-400 hover:text-white transition gap-x-2">
                    <span class="pi pi-trash" style="font-size: 0.7rem;"></span>
                    <span>Delete</span>
                </div>
            </Link>
            <ProgressSpinner v-else style="width: 15px; height: 15px" strokeWidth="3"/>
        </div>
        
    </Popover>
</template>

<style>
.p-popover-content {
    padding: .5rem .75rem !important;
    background-color: #323232 !important;
}
</style>