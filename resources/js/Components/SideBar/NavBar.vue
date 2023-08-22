<template>
    <div class="tw-absolute tw-w-screen tw-z-10 tw-h-12 tw-bg-white tw-flex tw-items-center tw-justify-between tw-px-10">
        <div class="tw-flex tw-gap-4 tw-items-center">
            <button @click="store.toogleMenu()" class="md:tw-hidden tw-block">
                <Icon v-if="store.open" class="tw-text-2xl tw-cursor-pointer tw-text-corporate-black-90" icon="octicon:sidebar-expand-24" />
                <Icon v-else class="tw-text-2xl tw-cursor-pointer tw-text-corporate-black-90" icon="octicon:sidebar-collapse-24" />
            </button>

            <ApplicationLogo class="tw-w-20" :class="{
                'md:tw-ml-12': !store.open
            }" />
        </div>


        <div class="tw-flex tw-items-center tw-gap-7">
            <Link :href="route('profile.edit')" class="tw-flex tw-items-center tw-gap-2 tw-cursor-pointer">
                <Icon class="tw-text-2xl" icon="iconoir:verified-user" />
                <span>{{ $page.props.auth.user.name }}</span>
                <q-tooltip>
                    Perfil
                </q-tooltip>
            </Link>
            <Link :href="route('logout')" method="post" as="button" class="tw-cursor-pointer">
                <Icon class="tw-text-2xl" icon="ion:exit-outline" />
                <q-tooltip>
                    Sair do Sistema
                </q-tooltip>
            </Link>
        </div>
    </div>
</template>

<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { useOpenMenuStore } from '@/Stores/ToogleMenu';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';

const store = useOpenMenuStore();
const openSettings = ref(false);
</script>
