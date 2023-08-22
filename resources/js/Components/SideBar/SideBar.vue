<template>
    <div class="tw-absolute tw-z-20 tw-h-screen tw-bg-white tw-shadow-2xl" :class="{
        'tw-w-60 tw-flex tw-flex-col tw-items-center tw-justify-between': store.open,
        'tw-w-16 tw-hidden md:tw-flex tw-flex-col tw-items-center tw-justify-between': !store.open
    }">
        <div class="tw-w-full tw-h-full tw-overflow-y-auto">
            <div class="tw-w-full tw-mt-4 tw-flex tw-items-center" :class="{
                'tw-justify-center': !store.open,
                'tw-justify-between tw-px-5': store.open
            }">
                <ApplicationLogo v-if="store.open" class="tw-w-24" />
                <button @click="store.toogleMenu()">
                    <Icon v-if="store.open" class="tw-text-2xl tw-cursor-pointer tw-text-corporate-black-90" icon="octicon:sidebar-expand-24" />
                    <Icon v-else class="tw-text-2xl tw-cursor-pointer tw-text-corporate-black-90" icon="octicon:sidebar-collapse-24" />
                </button>
            </div>

            <!-- Menu Item -->
            <div class="tw-flex tw-flex-col tw-gap-1 tw-w-full tw-h-auto tw-overflow-y-auto tw-mt-9">
                <!-- Section Sidebar Menu Item -->
                <div v-for="(item, index) in itemsMenu" :key="index" @click="toogleMenu(index)" class="tw-w-full">
                    <div v-if="item.title_section && item.can" class="tw-flex tw-flex-items tw-mt-5" :class="{
                        'tw-justify-center': !store.open,
                        'tw-justify-start tw-pl-4 tw-pr-2': store.open,
                    }">
                        <span v-if="store.open">{{ item.title_section.full }}</span>
                        <span v-else>{{ item.title_section.short }}</span>
                    </div>
                    <div v-else-if="item.subitems && !item.route && item.can" class="tw-cursor-pointer tw-flex tw-flex-items tw-py-2 tw-border-r-4 hover:tw-text-careful-blue-80" :class="{
                        'tw-justify-center': !store.open,
                        'tw-justify-start tw-pl-4 tw-pr-2': store.open,
                        'tw-text-careful-blue-80 tw-border-transparent': subMenuOpen == index,
                        'tw-border-transparent tw-text-corporate-black-90': subMenuOpen != index,
                    }">
                        <Icon class="tw-text-xl" :icon="item.icon.ref" />
                        <span class="tw-text-md tw-ml-2" v-if="store.open">{{ item.name }}</span>
                        <div class="tw-ml-auto" v-if="store.open && item.subitems">
                            <Icon v-if="subMenuOpen != index" class="tw-text-xl" icon="material-symbols:arrow-drop-down-rounded" />
                            <Icon v-if="subMenuOpen == index" class="tw-text-xl" icon="material-symbols:arrow-drop-up-rounded" />
                        </div>
                        <q-tooltip v-if="!store.open" anchor="center right" self="center left">
                            {{ item.name }}
                        </q-tooltip>
                    </div>
                    <Link v-else-if="item.can" :href="route(item.route)" class="tw-cursor-pointer tw-flex tw-flex-items tw-py-2 tw-border-r-4 hover:tw-text-careful-blue-80" :class="{
                        'tw-justify-center': !store.open,
                        'tw-justify-start tw-pl-4 tw-pr-2': store.open,
                        'tw-text-careful-blue-80 tw-border-careful-blue-80': route().current(item.route),
                        'tw-border-transparent tw-text-corporate-black-90': !route().current(item.route),
                    }">
                        <Icon class="tw-text-xl" :icon="item.icon.ref" />
                        <span class="tw-text-md tw-ml-2" v-if="store.open">{{ item.name }}</span>
                        <div class="tw-ml-auto" v-if="store.open && item.subitems">
                            <Icon v-if="subMenuOpen != index" class="tw-text-xl" icon="material-symbols:arrow-drop-down-rounded" />
                            <Icon v-if="subMenuOpen == index" class="tw-text-xl" icon="material-symbols:arrow-drop-up-rounded" />
                        </div>
                        <q-tooltip v-if="!store.open" anchor="center right" self="center left">
                            {{ item.name }}
                        </q-tooltip>
                    </Link>

                    <div class="tw-w-full tw-flex tw-flex-col tw-items-center">
                        <Link :href="route(subitem.route)" v-for="(subitem, subindex) in item.subitems" :key="subindex" v-if="subMenuOpen == index" class="tw-w-full tw-cursor-pointer tw-flex tw-flex-items tw-py-2 tw-mt-1 tw-bg-corporate-black-10 tw-border-r-4 hover:tw-border-careful-blue-30 hover:tw-text-careful-blue-80 hover:tw-bg-careful-blue-20" :class="{
                            'tw-justify-center': !store.open,
                            'tw-justify-start tw-pl-4': store.open,
                            'tw-text-careful-blue-80 tw-border-careful-blue-30 tw-bg-careful-blue-20': route().current(subitem.route),
                            'tw-border-transparent tw-text-corporate-black-90': !route().current(subitem.route),
                            'tw-hidden': !subitem.can
                        }">
                            <Icon class="tw-text-xl" :icon="subitem.icon.ref" />
                            <span class="tw-text-md tw-ml-2" v-if="store.open">{{ subitem.name }}</span>
                            <div class="tw-ml-auto" v-if="store.open"></div>
                            <q-tooltip v-if="!store.open" anchor="center right" self="center left">
                                {{ subitem.name }}
                            </q-tooltip>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="tw-w-full tw-flex tw-items-center tw-justify-center tw-mb-7" :class="{
            'tw-border-t tw-pt-7 tw-border-corporate-black-10': !store.open,
        }">
            <img v-if="store.open" src="@/Images/logotipo_cett.png" class="tw-w-24" alt="Logo CETT" />
            <img v-else src="@/Images/icone_cett.svg" class="tw-w-full tw-px-4" alt="Icone CETT" />
        </div>
    </div>
</template>

<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { useOpenMenuStore } from '@/Stores/ToogleMenu';
import { Link, usePage } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import { ref } from 'vue';

const subMenuOpen = ref(-1);
const store = useOpenMenuStore();
const itemsMenu = [
    {
        route: 'index',
        icon: {
            type: 'icon',
            ref: 'iconoir:home-simple-door'
        },
        name: 'Início',
        can: true,
    }
];

function toogleMenu(index){
    if(store.open == false){
        store.toogleMenu();
    }
    if(itemsMenu[index].subitems){
        if(subMenuOpen.value == index){
            subMenuOpen.value = -1;
        }else{
            subMenuOpen.value = index;
        }
    }
}

</script>
