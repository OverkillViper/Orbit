<script setup>
import Header from '@/Pages/Common/Header.vue';
import UpdateCoverPhoto from '@/Pages/MyProfile/UpdateCoverPhoto.vue';
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';
import { watch, ref } from 'vue';
import ProgressSpinner from 'primevue/progressspinner';

const loading = ref(false);

const props = defineProps({
    group       : Object,
    requested   : Boolean
})

watch(() => props.requested, requested => {
    loading.value = false;
});

</script>

<template>
    <div class="min-h-screen bg-primary flex flex-col">
        <Header :title="group.name"/>

        <main class="flex-grow mt-20 flex flex-col items-center">
            <div class="w-3/4">
                <div class="relative">
                    <img :src="'/storage/' + group.cover_photo" alt="cover_photo" class="h-64 object-cover w-full rounded-xl" v-if="group.cover_photo">
                    <img src="/images/background.png" alt="cover_photo" class="h-64 object-cover w-full rounded-xl" v-else>
                </div>
            </div>
            <div class="w-3/4 py-4 flex items-center justify-between">
                <div>
                    <div class="text-xl font-semibold">{{ group.name }}</div>
                    <div class="flex items-center gap-x-2 text-neutral-400 text-sm capitalize">
                        <div>{{ group.visibility }} group</div>
                        <span>&#183;</span>
                        <div>
                            {{ group.member_count }} Members
                        </div>
                    </div>
                </div>
                <div v-if="loading">
                    <ProgressSpinner style="width: 15px; height: 15px" strokeWidth="4"/>
                </div>
                <div class="flex items-center gap-x-4" v-else>
                    <Link :href="route('group.request.cancel', group.id)" v-if="requested" as="button" method="post" @click="loading = true">
                        <Button label="Cancel Request" icon="times"/>
                    </Link>
                    <Link :href="route('group.join', group.id)" v-else as="button" method="post" @click="loading = true">
                        <Button label="Request to Join" icon="sign-in"/>
                    </Link>
                </div>
            </div>

            <div class="flex text-neutral-400 text-sm gap-x-4 items-center">
                <span class="pi pi-exclamation-triangle"></span>
                <span>Posts and group members are hidden because this group is private</span>
            </div>
        </main>
    </div>
</template>