<script setup>
import PeopleCard from '../People/PeopleCard.vue';
import GroupLayout from '@/Layouts/GroupLayout.vue';

const props = defineProps({
    auth    : Object,
    group   : Object,
    members : Array,
});

</script>

<template>
<GroupLayout :group="group" :auth="auth" selected="members">
    <div class="grid grid-cols-3 pb-4">
        <PeopleCard v-for="member in members" :key="member.id" :user="member.member"/>
    </div>
</GroupLayout>
</template>