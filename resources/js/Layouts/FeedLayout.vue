<script setup>
import Header from '@/Pages/Common/Header.vue';
import BuddyRequestCardLinear from '@/Pages/Buddies/BuddyRequestCardLinear.vue';
import { Link } from '@inertiajs/vue3';
import SidebarItem from '@/Pages/Common/SidebarItem.vue';
import BuddyCard from '@/Pages/Buddies/BuddyCard.vue';

const props = defineProps({
    title : String
});

</script>

<template>
    <div class="min-h-screen bg-primary">
        <Header :title="title"/>
        <div class="flex">
            <div class="basis-1/5 2xl:basis-1/6">
                <div class="flex flex-col gap-y-2 p-4">
                    <div class="text-white font-bold mb-2">Menu</div>
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <SidebarItem icon="user" label="My Profile"/>
                        <SidebarItem icon="comment" label="Messages"/>
                        <SidebarItem icon="face-smile" label="Friends"/>
                        <SidebarItem icon="users" label="Groups"/>
                        <SidebarItem icon="calendar" label="Events"/>
                        <SidebarItem icon="cog" label="Settings"/>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="text-white font-bold">Buddy Requests</div>
                        <Link href="#" class="text-sm text-neutral-500 hover:text-white transition">
                            See All
                        </Link>
                    </div>
                    <BuddyRequestCardLinear />
                    <BuddyRequestCardLinear />
                    <BuddyRequestCardLinear />
                </div>
            </div>
            <div class="basis-3/5 2xl:basis-4/6">
                <slot />
            </div>
            <div class="basis-1/5 2xl:basis-1/6 p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-white font-bold">Buddies</div>
                    <Link href="#" class="text-sm text-neutral-500 hover:text-white transition">
                        See All
                    </Link>
                </div>
                <div class="flex flex-col gap-y-4">
                    
                    <BuddyCard active/>
                    <BuddyCard />
                    <BuddyCard />
                </div>
            </div>
        </div>
    </div>
</template>