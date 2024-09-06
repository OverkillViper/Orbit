<script setup>
import UpdateAvatar from './UpdateAvatar.vue';
import UpdateCoverPhoto from './UpdateCoverPhoto.vue';
import ProfileMenuItem from './ProfileMenuItem.vue';

const props = defineProps({
    auth            : Object,
    buddies_count   : Number,
})

</script>

<template>
    <div>
        <div class="relative">
            <img :src="'/storage/' + auth.user.cover_photo" alt="cover_photo" class="h-64 object-cover w-full" v-if="auth.user.cover_photo">
            <img src="/images/background.png" alt="cover_photo" class="h-64 object-cover w-full" v-else>
            <div class="absolute top-0 right-0 m-2">
                <UpdateCoverPhoto />
            </div>
        </div>
        <div class="py-5 bg-secondary">
            <div class="w-2/3 mx-auto flex items-center gap-x-6">
                <div class="relative">
                    <div class="bg-neutral-600 rounded-lg">
                        <img :src="'/storage/' + auth.user.avatar" alt="profile_picture" class="w-40 h-40 rounded-lg -mt-10 object-cover shadow-md border border-neutral-700" v-if="auth.user.avatar">
                        <img src="/images/avatar.svg" alt="profile_picture" class="w-40 h-40 rounded-lg -mt-10 object-cover shadow-md border border-neutral-700" v-else>
                    </div>
                    <div class="absolute bottom-0">
                        <UpdateAvatar />
                    </div>
                </div>
                <div class="flex-grow">
                    <div class="text-white font-bold text-2xl">{{ auth.user.name }}</div>
                    <div>{{ buddies_count }} Buddies</div>
                </div>
                <div class="flex items-center gap-x-4">
                    <ProfileMenuItem icon="info-circle" label="About"   :href="route('profile.posts')"/>
                    <ProfileMenuItem icon="face-smile"  label="Buddies" :href="route('profile.buddies')"/>
                    <ProfileMenuItem icon="images"      label="Photos"  href="#"/>
                    <ProfileMenuItem icon="users"       label="Groups"  :href="route('groups.joined')"/>
                </div>
            </div>
        </div>
    </div>
</template>