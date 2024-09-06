<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import ProfileHeader from '../MyProfile/ProfileHeader.vue';
import GroupCard from './GroupCard.vue';

const props = defineProps({
    auth            : Object,
    buddies_count   : Number,
    groups          : Array,
})

</script>

<template>
<ProfileLayout title="Joined Groups">
    <ProfileHeader :auth="auth" :buddies_count="buddies_count"/>

    <div class="w-2/3 mx-auto mt-4" v-if="groups.length">
        <div class="font-semibold text-lg">
            <span class="text-neutral-400 me-1">{{ groups.length }}</span>
            Joined Groups
        </div>

        <div class="grid grid-cols-3 2xl:grid-cols-4 gap-4 mt-4">
            <GroupCard :group="group" v-for="group in groups" :key="group.id"/>
        </div>
    </div>
    <div class="w-2/3 mx-auto justify-center text-sm text-neutral-400 flex items-center mt-4" v-else>
        <span class="pi pi-exclamation-triangle me-2"></span>
        <span>You have not joined any groups</span>
    </div>
</ProfileLayout>
</template>