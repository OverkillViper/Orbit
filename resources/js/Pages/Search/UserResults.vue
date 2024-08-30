<script setup>
import PeopleCard from '../People/PeopleCard.vue';
import NoResultFound from '@/Components/OrbitComponents/NoResultFound.vue';

const props = defineProps({
    users : Array,
})

</script>

<template>
    <div class="grid grid-cols-2 2xl:grid-cols-3 gap-4" v-if="users.length">
        <PeopleCard v-for="user in users" :key="user.id" :user="user" :status="user.buddy_status"/>
    </div>
    <div class="flex justify-center" v-else>
        <NoResultFound />
    </div>
</template>