<script setup>
const props = defineProps({
    value: {
        type: String,
    },
    required: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <label class="tw-block tw-font-medium tw-text-sm tw-text-corporate-black-110">
        <span class="tw-flex tw-items-center tw-justify-start">
            {{ props.value }} <span v-if="props.required" class="tw-text-immersive-red-500 -tw-mt-2 tw-text-lg">*</span>
        </span>
    </label>
</template>
