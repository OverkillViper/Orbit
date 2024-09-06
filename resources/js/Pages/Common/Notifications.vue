<script setup>
import { ref, watch } from 'vue';
import Popover from 'primevue/popover';
import UserAvatar from '@/Components/OrbitComponents/UserAvatar.vue';
import { Link, usePage } from '@inertiajs/vue3';
import OverlayBadge from 'primevue/overlaybadge';

// const props = defineProps({
//     notifications : Array,
// });

const notifications = ref(usePage().props.notifications);
const unseen_notifications = ref(usePage().props.unseen_notifications);

const menu = ref();

const toggle = (event) => {
    menu.value.toggle(event);
}

const mydt = ref({
    background: '#252525',
    borderRadius: '2rem',
})

watch(
    () => usePage().props.notifications,
    (newNotifications) => {
        notifications.value = newNotifications;
    },
    { deep: true }
);

watch(() => usePage().props.unseen_notifications, (newUnseenNotifications) => {
    unseen_notifications.value = newUnseenNotifications;
});

</script>

<template>
    <div>
        <OverlayBadge severity="success" v-if="unseen_notifications">
            <button class="text-neutral-500 hover:text-white transition flex items-center w-4 h-12" @click="toggle"><span class="pi pi-bell"></span></button>
        </OverlayBadge>
        <button v-else class="text-neutral-500 hover:text-white transition flex items-center w-4 h-12" @click="toggle"><span class="pi pi-bell"></span></button>

        <Popover ref="menu" :dt="mydt">
            <div class="w-[25rem] 2xl:w-[30rem] p-4">
                <div class="flex items-center justify-between">
                    <div class="text-white font-semibold">Notifications</div>
                    <Link href="#" class="text-neutral-400 hover:text-white transition text-sm">
                        See All
                    </Link>
                </div>
                <div class="flex flex-col gap-y-2 mt-4" v-if="notifications.length">
                    <div class="flex items-center hover:bg-neutral-800 py-2 px-4 rounded-xl transition gap-x-2" v-for="notification in notifications" :key="notification.id">
                        <span class="pi text-green-400" :class="notification.seen ? 'pi-circle' : 'pi-circle-fill'" style="font-size: 0.7rem;"></span>
                        <Link :href="route('notification.visit', notification.id)" class="flex items-center gap-x-4 flex-grow">
                            <UserAvatar size="large"  :user="notification.sender" href="#"/>
                            <div>
                                <div class="font-semibold text-white line-clamp-1">{{ notification.title }}</div>
                                <div class="text-sm text-neutral-400 line-clamp-1">{{ notification.content }}</div>
                            </div>
                        </Link>
                        <Link :href="route('notification.delete', notification.id)" as="button" method="post">
                            <span class="pi pi-trash text-neutral-400 hover:text-white transition"></span>
                        </Link>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-neutral-400 justify-center" v-else>
                    <span class="pi pi-exclamation-triangle me-2"></span>
                    <span class="font-medium">You have no notifications</span>
                </div>
            </div>
        </Popover>
    </div>
</template>

<style>

.p-popover {
    padding: 0 !important;
    background-color: #151515 !important;
    border-color: #353535 !important;
    overflow: hidden;
}

.p-popover-content {
    padding: 0rem !important;
}

.p-popover::before, .p-popover::after {
    display: none !important;
}
</style>