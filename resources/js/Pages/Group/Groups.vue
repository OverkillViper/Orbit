<script setup>
import Header from '../Common/Header.vue';
import TextInput from '@/Components/OrbitComponents/TextInput.vue';
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';

const props = defineProps({
    auth : Object,
})

</script>

<template>
    <div class="min-h-screen bg-primary flex flex-col">
        <Header title="Groups"/>

        <main class="flex-grow mt-16 flex flex-col items-center">
            <div class="text-2xl font-semibold text-white mt-10 w-2/3">Groups</div>
            <div class="flex items-center mt-4 w-2/3">
                <form @submit.prevent class="w-1/3">
                    <TextInput icon="search" placeholder="Find groups"/>
                </form>
                <div class="flex items-center justify-end flex-grow gap-x-4">
                    <Link href="#">
                        <Button label="Discover Groups"/>
                    </Link>
                    <Link href="#">
                        <Button label="Joined Groups"/>
                    </Link>
                    <Button label="Create Group"/>
                </div>
            </div>
        </main>
    </div>
</template>