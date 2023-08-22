<template>
    <Link
        :href="props.href"
        class="tw-flex tw-gap-2 tw-items-center tw-font-semibold tw-transition tw-ease-in-out tw-duration-150"
        :class="background + ' ' + rounded"
    >
        <span v-if="props.text" :class="fontSize">{{ props.text }}</span>
        <Icon v-if="props.icon" :class="iconSize" :icon="props.icon" />
        <slot />
    </Link>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import { computed } from 'vue';

const props = defineProps({
    href: {
        type: String,
        default: '',
    },
    background: {
        type: String,
        default: 'gray',
    },
    rounded: {
        type: String,
        default: 'md',
    },
    outlined: {
        type: Boolean,
        default: false,
    },
    icon: {
        type: String,
        default: '',
    },
    text: {
        type: String,
        default: '',
    },
    fontSize: {
        type: String,
        default: 'sm',
    },
    iconSize: {
        type: String,
        default: 'lg',
    }
});
const rounded = computed(() => {
    if(props.rounded == 'sm'){
        return 'tw-rounded-sm';
    }else if(props.rounded == 'md'){
        return 'tw-rounded-md';
    }else if(props.rounded == 'lg'){
        return 'tw-rounded-lg';
    }else if(props.rounded == 'xl'){
        return 'tw-rounded-xl';
    }else if(props.rounded == '2xl'){
        return 'tw-rounded-2xl';
    }else if(props.rounded == '3xl'){
        return 'tw-rounded-3xl';
    }else if(props.rounded == 'full'){
        return 'tw-rounded-full';
    }
});
const fontSize = computed(() => {
    if(props.fontSize == 'xs'){
        return 'tw-text-xs';
    }else if(props.fontSize == 'sm'){
        return 'tw-text-sm';
    }else if(props.fontSize == 'base'){
        return 'tw-text-base';
    }else if(props.fontSize == 'lg'){
        return 'tw-text-lg';
    }else if(props.fontSize == 'xl'){
        return 'tw-text-xl';
    }else if(props.fontSize == '2xl'){
        return 'tw-text-2xl';
    }else if(props.fontSize == '3xl'){
        return 'tw-text-3xl';
    }else if(props.fontSize == '4xl'){
        return 'tw-text-4xl';
    }else if(props.fontSize == '5xl'){
        return 'tw-text-5xl';
    }else if(props.fontSize == '6xl'){
        return 'tw-text-6xl';
    }else if(props.fontSize == '7xl'){
        return 'tw-text-7xl';
    }else if(props.fontSize == '8xl'){
        return 'tw-text-8xl';
    }else if(props.fontSize == '9xl'){
        return 'tw-text-9xl';
    }
});
const iconSize = computed(() => {
    if(props.iconSize == 'xs'){
        return 'tw-text-xs';
    }else if(props.iconSize == 'sm'){
        return 'tw-text-sm';
    }else if(props.iconSize == 'base'){
        return 'tw-text-base';
    }else if(props.iconSize == 'lg'){
        return 'tw-text-lg';
    }else if(props.iconSize == 'xl'){
        return 'tw-text-xl';
    }else if(props.iconSize == '2xl'){
        return 'tw-text-2xl';
    }else if(props.iconSize == '3xl'){
        return 'tw-text-3xl';
    }else if(props.iconSize == '4xl'){
        return 'tw-text-4xl';
    }else if(props.iconSize == '5xl'){
        return 'tw-text-5xl';
    }else if(props.iconSize == '6xl'){
        return 'tw-text-6xl';
    }else if(props.iconSize == '7xl'){
        return 'tw-text-7xl';
    }else if(props.iconSize == '8xl'){
        return 'tw-text-8xl';
    }else if(props.iconSize == '9xl'){
        return 'tw-text-9xl';
    }
});
const background = computed(() => {
    if(props.background == 'none' && props.outlined == false){
        return 'tw-text-gray-500 hover:tw-text-gray-700 focus:tw-text-gray-700 active:tw-text-gray-700';
    }else if(props.background == 'none' && props.outlined == true){
        return 'tw-text-gray-500 hover:tw-text-gray-700 focus:tw-text-gray-700 active:tw-text-gray-700 tw-border tw-border-gray-300 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-indigo-500';
    }else if(props.background == 'positive' && props.outlined == false){
        return 'tw-text-white tw-bg-green-70 hover:tw-bg-green-80 focus:tw-bg-green-80 active:tw-bg-green-80';
    }else if(props.background == 'positive' && props.outlined == true){
        return 'tw-text-green-80 tw-border tw-border-green-80 hover:tw-bg-green-80 focus:tw-bg-green-80 active:tw-bg-green-80 hover:tw-text-white focus:tw-text-white active:tw-text-white';
    }else if(props.background == 'negative' && props.outlined == false){
        return 'tw-text-white tw-bg-immersive-red-700 hover:tw-bg-immersive-red-900 focus:tw-bg-immersive-red-900 active:tw-bg-immersive-red-900';
    }else if(props.background == 'negative' && props.outlined == true){
        return 'tw-text-immersive-red-700 tw-border tw-border-immersive-red-700 hover:tw-bg-immersive-red-900 focus:tw-bg-immersive-red-900 active:tw-bg-immersive-red-900 hover:tw-text-white focus:tw-text-white active:tw-text-white';
    }else if(props.background == 'info' && props.outlined == false){
        return 'tw-text-white tw-bg-careful-blue-60 hover:tw-bg-careful-blue-80 focus:tw-bg-careful-blue-80 active:tw-bg-careful-blue-80';
    }else if(props.background == 'info' && props.outlined == true){
        return 'tw-text-careful-blue-60 tw-border tw-border-careful-blue-60 hover:tw-bg-careful-blue-80 focus:tw-bg-careful-blue-80 active:tw-bg-careful-blue-80 hover:tw-text-white focus:tw-text-white active:tw-text-white';
    }else if(props.background == 'warning' && props.outlined == false){
        return 'tw-text-white tw-bg-orange-500 hover:tw-bg-orange-700 focus:tw-bg-orange-700 active:tw-bg-orange-700';
    }else if(props.background == 'warning' && props.outlined == true){
        return 'tw-text-orange-500 tw-border tw-border-orange-500 hover:tw-bg-orange-700 focus:tw-bg-orange-700 active:tw-bg-orange-700 hover:tw-text-white focus:tw-text-white active:tw-text-white';
    }else if(props.background == 'primary' && props.outlined == false){
        return 'tw-text-white tw-bg-primary-1 hover:tw-bg-primary-2 focus:tw-bg-primary-2 active:tw-bg-primary-2';
    }else if(props.background == 'primary' && props.outlined == true){
        return 'tw-text-primary-1 tw-border tw-border-primary-1 hover:tw-bg-primary-2 focus:tw-bg-primary-2 active:tw-bg-primary-2 hover:tw-text-white focus:tw-text-white active:tw-text-white';
    }else if(props.background == 'secondary' && props.outlined == false){
        return 'tw-text-white tw-bg-secondary hover:tw-bg-secondary-1 focus:tw-bg-secondary-1 active:tw-bg-secondary_hover';
    }else if(props.background == 'secondary' && props.outlined == true){
        return 'tw-text-secondary tw-border tw-border-secondary hover:tw-bg-secondary-1 focus:tw-bg-secondary-1 active:tw-bg-secondary-1 hover:tw-text-white focus:tw-text-white active:tw-text-white';
    }else if(props.background == 'white' && props.outlined == false){
        return 'tw-text-black tw-bg-white hover:tw-bg-white-3 focus:tw-bg-white-3 active:tw-bg-white-3';
    }else if(props.background == 'white' && props.outlined == true){
        return 'tw-text-white tw-border tw-border-white';
    }
});
</script>
