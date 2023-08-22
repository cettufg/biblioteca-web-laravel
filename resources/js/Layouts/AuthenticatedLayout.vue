<script setup>
import { useOpenMenuStore } from '@/Stores/ToogleMenu';
import SideBar from '@/Components/SideBar/SideBar.vue';
import NavBar from '@/Components/SideBar/NavBar.vue';

const store = useOpenMenuStore();

const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    description: {
        type: String,
        default: ''
    }
});
</script>

<template>
    <!-- Content -->
    <div class="tw-h-screen tw-w-screen tw-bg-[#f2f2f2]">
        <!-- Navbar -->
        <NavBar />
        <!-- Sidebar -->
        <SideBar />
        <!-- Main content -->
        <div class="tw-relative tw-z-0 tw-pt-12 tw-left-0 tw-w-full tw-h-full tw-overflow-y-auto" :class="{
            'md:tw-pl-60': store.open,
            'md:tw-pl-16': !store.open
        }">
            <div class="tw-h-full tw-w-full tw-flex tw-flex-col tw-gap-5 tw-p-5 md:tw-p-10" v-if="props.title">
                <div class="tw-flex tw-flex-col tw-gap-4 tw-text-careful-blue-80">
                    <span class="tw-text-3xl tw-font-bold">{{ props.title }}</span>
                    <span class="tw-text-md">{{ props.description }}</span>
                </div>
                <slot />
            </div>
            <div class="tw-h-full tw-w-full" v-else>
                <slot />
            </div>
        </div>
    </div>
</template>

<style>
[type='text']:focus, [type='email']:focus, [type='url']:focus, [type='password']:focus,
[type='number']:focus, [type='date']:focus, [type='datetime-local']:focus, [type='month']:focus,
[type='search']:focus, [type='tel']:focus, [type='time']:focus, [type='week']:focus, [multiple]:focus,
textarea:focus, select:focus{
    --tw-ring-shadow: 0;
}
</style>
