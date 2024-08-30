<script setup>
import FeedLayout from '@/Layouts/CoreLayout.vue';
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import UserResults from './UserResults.vue';


const props = defineProps({
    users : Array
})

</script>

<template>
<FeedLayout title="Search Results">
    <div class="w-3/4 2xl:w-2/3 mx-auto">
        <div class="text-sm text-neutral-400 text-center">Showing results for</div>
        <Tabs value="0">
            <TabList>
                <Tab value="0">People</Tab>
                <Tab value="1">Posts</Tab>
                <Tab value="2">Groups</Tab>
                <Tab value="3">Events</Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="0">
                    <UserResults :users="users"/>
                </TabPanel>
                <TabPanel value="1">
                    nothing
                </TabPanel>
                <TabPanel value="2">
                    nothing
                </TabPanel>
                <TabPanel value="3">
                    nothing
                </TabPanel>
            </TabPanels>
        </Tabs>
    </div>
</FeedLayout>
</template>

<style>

.p-tab {
    color: #555555 !important;
    font-weight: 300 !important;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
}

.p-tablist-tab-list {
    background-color: transparent !important;
    justify-content: center;
    border-color: #252525 !important;
}

.p-tabpanels {
    background-color: transparent !important;
}

.p-tab {
    border-color: #252525 !important;
    padding: .7rem 1.5rem !important;
}

.p-tab-active {
    border-color: white !important;
    color: white !important;
}
</style>