<script setup>
import Popover from 'primevue/popover';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const pop = ref();

const toggle = (event) => {
    pop.value.toggle(event);
}

const props = defineProps({
    comment : Object,
})

</script>

<template>
    <button @click="toggle">
        <span class="pi pi-ellipsis-v" style="font-size: 0.7rem;"></span>
    </button>

    <Popover ref="pop">
        <Link :href="route('comment.delete', comment.id)" as="button" method="post">
            <div class="flex items-center text-xs text-neutral-400 hover:text-white transition gap-x-2">
                <span class="pi pi-trash" style="font-size: 0.7rem;"></span>
                <span>Delete</span>
            </div>
        </Link>
    </Popover>
</template>

<style>
.p-popover-content {
    padding: .5rem .75rem !important;
    background-color: #323232 !important;
}
</style>