<script setup>
import TextInput from '@/Components/OrbitComponents/TextInput.vue';
import Button from '@/Components/OrbitComponents/Button.vue';
import GroupCreateForm from './GroupCreateForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    auth : Object,
    title : String,
})

const searchGroupForm = useForm({
    query : '',
});

const searchGroups = () => {
    searchGroupForm.get(route('groups'));
}

</script>

<template>
    <div>
        <div class="text-2xl font-semibold text-white mt-10">{{ title }}</div>
        <div class="flex items-center mt-4">
            <form @submit.prevent="searchGroups" class="w-1/3 flex items-center gap-x-2">
                <TextInput icon="search" placeholder="Find groups" v-model="searchGroupForm.query"/>
                <Button label="Search"/>
            </form>
            <div class="flex items-center justify-end flex-grow gap-x-4">
                <Link :href="route('groups.discover')">
                    <Button label="Discover Groups"/>
                </Link>
                <Link :href="route('groups.joined')">
                    <Button label="Joined Groups"/>
                </Link>
                <GroupCreateForm :auth="auth">
                    <Button label="Create Group"/>
                </GroupCreateForm>
            </div>
        </div>
    </div>
</template>