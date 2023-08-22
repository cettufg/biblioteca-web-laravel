<template>
    <div class="tw-flex tw-flex-col tw-items-end tw-gap-5 tw-w-full">
        <div class="tw-w-full">
            <InputLabel value="Nome:" class="tw-text-corporate-black-110 tw-mb-1" />
            <q-input
                borderless
                dense
                class="tw-border tw-box-border tw-rounded-[4px] tw-px-3 tw-bg-white"
                :class="{
                    'tw-border-red-500 hover:tw-border-red-700': form.errors.name,
                    'tw-border-corporate-black-40 hover:tw-border-corporate-black-90': !form.errors.name,
                }"
                v-model="form.name"
            >
                <template v-slot:append v-if="form.errors.name">
                    <Icon class="tw-text-red-500" icon="octicon:alert-24" />
                </template>
            </q-input>

            <span v-if="form.errors.name" class="tw-text-red-500">{{ form.errors.name }}</span>
        </div>

        <div class="tw-w-full">
            <InputLabel value="Email:" class="tw-text-corporate-black-110 tw-mb-1" />
            <q-input
                borderless
                dense
                type="email"
                class="tw-border tw-box-border tw-rounded-[4px] tw-px-3 tw-bg-white"
                :class="{
                    'tw-border-red-500 hover:tw-border-red-700': form.errors.email,
                    'tw-border-corporate-black-40 hover:tw-border-corporate-black-90': !form.errors.email,
                }"
                v-model="form.email"
            >
                <template v-slot:append v-if="form.errors.email">
                    <Icon class="tw-text-red-500" icon="octicon:alert-24" />
                </template>
            </q-input>

            <span v-if="form.errors.email" class="tw-text-red-500">{{ form.errors.email }}</span>
        </div>

        <div class="tw-flex tw-items-center tw-gap-4 tw-mt-2">
            <button
                @click="updateData()"
                class="tw-flex tw-items-center tw-justify-center tw-gap-1 tw-bg-careful-blue-60 hover:tw-bg-careful-blue-70 tw-text-white tw-py-2 tw-px-3 tw-rounded-md"
                :disabled="form.processing"
            >
                <Icon class="tw-text-lg" icon="solar:refresh-outline" />
                <span class="tw-text-md">Atualizar</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import { Notify } from 'quasar';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

function updateData(){
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            Notify.create({
                message: 'Dados atualizados com sucesso!',
                color: 'positive',
            })
        },
    });
}
</script>
