<script setup>
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    request : Object,
})

const acceptedDate = computed(() => {
  const date = new Date(props.request.accepted_on); // Convert the string to a Date object
  
  // Format the date to "Aug 2024" using toLocaleDateString
  return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
});

</script>

<template>
    <div class="flex items-center p-5 bg-secondary rounded-xl gap-x-4">
        <UserAvatar size="xlarge" shape="circle" :user="request.buddy" href="#"/>
        <div>
            <div class="text-white font-semibold line-clamp-1">{{ request.buddy.name }}</div>
            <div class="text-neutral-400 text-xs">Buddy since {{ acceptedDate }}</div>

            <div class="flex mt-2 gap-x-4">
                <Link href="#" class="text-neutral-400 hover:text-white transition" v-tooltip.bottom="'Message'">
                    <span class="pi pi-comment"></span>
                </Link>
                <Link :href="route('buddies.request.decline', request.id)" class="text-neutral-400 hover:text-white transition" v-tooltip.bottom="'Remove Buddy'" as="bnutton" method="post">
                    <span class="pi pi-user-minus"></span>
                </Link>
            </div>
        </div>
    </div>
</template>