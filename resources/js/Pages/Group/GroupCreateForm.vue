<script setup>
import { useForm } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import { ref } from 'vue';
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import TextInput from '@/Components/OrbitComponents/TextInput.vue';
import ProgressSpinner from 'primevue/progressspinner';
import SelectButton from 'primevue/selectbutton';
import Button from '@/Components/OrbitComponents/Button.vue';

const visible = ref(false);
const loading = ref(false);

const groupForm = useForm({
    name : '',
    visibility : 'public',
})

const props = defineProps({
    auth : Object,
})

const visibilities = ['public', 'private']

const createGroup = () => {
    groupForm.post(route('group.create'), {
        onFinish: () => {
            groupForm.name = '';
            groupForm.visibility = 'public';
        }
    })
}

</script>

<template>

<div>
    <div @click="visible = true">
        <slot/>
    </div>

    <Dialog v-model:visible="visible" modal header="Create Group" :style="{ width: '20rem' }">
        <template #header>
            <div class="inline-flex items-center justify-center gap-2 text-white bg-se">
                <UserAvatar size="large" :user="auth.user" :href="route('profile.posts')"/>
                <span class="font-semibold whitespace-nowrap text-white">Create Group</span>
            </div>
        </template>
        <form @submit.prevent>
            <div class="text-white">
                <TextInput v-model="groupForm.name" placeholder="Group name"/>
            </div>
            <div class="font-medium mt-4">
                <div class="text-neutral-400 font-medium text-sm mb-2 select-none">Visibility</div>
                <SelectButton v-model="groupForm.visibility" :options="visibilities" aria-labelledby="basic" />
            </div>
        </form>
        <template #footer>
            <div class="flex items-center gap-x-4 justify-end w-full">
                <Button label="Cancel" @click="visible = false"/>
                <div v-if="groupForm.processing">
                    <ProgressSpinner style="width: 15px; height: 15px" strokeWidth="3"/>
                </div>
                <Button label="Create" @click="createGroup" v-else/>
            </div>
        </template>
    </Dialog>
</div>

</template>

<style>
.p-togglebutton {
    padding: 0.50rem 0.75rem !important;
    text-transform: capitalize;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
    background-color: #282828 !important;
    color: rgb(163 163 163) !important;
    border: none !important;
}

.p-togglebutton-checked::before {
    background-color: #424242 !important;
}

.p-togglebutton-checked {
    color: white !important;
}
</style>