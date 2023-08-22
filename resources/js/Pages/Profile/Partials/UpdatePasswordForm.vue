<template>
    <div class="tw-flex tw-flex-col tw-items-end tw-gap-5 tw-w-full">
        <div class="tw-w-full">
            <InputLabel value="Senha atual:" class="tw-text-corporate-black-110 tw-mb-1" />
            <q-input
                borderless
                dense
                class="tw-border tw-box-border tw-rounded-[4px] tw-px-3 tw-bg-white"
                :type="isPwd ? 'password' : 'text'"
                :class="{
                    'tw-border-red-500 hover:tw-border-red-700': form.errors.current_password,
                    'tw-border-corporate-black-40 hover:tw-border-corporate-black-90': !form.errors.current_password,
                }"
                v-model="form.current_password"
            >
                <template v-slot:append>
                    <q-icon
                        :name="isPwd ? 'visibility_off' : 'visibility'"
                        class="cursor-pointer"
                        @click="isPwd = !isPwd"
                        v-if="form.current_password"
                    />
                    <Icon v-if="form.errors.current_password" class="tw-text-red-500" icon="octicon:alert-24" />
                </template>
            </q-input>

            <span v-if="form.errors.current_password" class="tw-text-red-500">{{ form.errors.current_password }}</span>
        </div>

        <div class="tw-w-full">
            <InputLabel value="Nova senha:" class="tw-text-corporate-black-110 tw-mb-1" />
            <q-input
                borderless
                dense
                :type="isPwd2 ? 'password' : 'text'"
                class="tw-border tw-box-border tw-rounded-[4px] tw-px-3 tw-bg-white"
                :class="{
                    'tw-border-red-500 hover:tw-border-red-700': form.errors.password,
                    'tw-border-corporate-black-40 hover:tw-border-corporate-black-90': !form.errors.password,
                }"
                v-model="form.password"
            >
                <template v-slot:append>
                    <q-icon
                        :name="isPwd2 ? 'visibility_off' : 'visibility'"
                        class="cursor-pointer"
                        @click="isPwd2 = !isPwd2"
                        v-if="form.password"
                    />
                    <Icon v-if="form.errors.password" class="tw-text-red-500" icon="octicon:alert-24" />
                </template>
            </q-input>

            <span v-if="form.errors.password" class="tw-text-red-500">{{ form.errors.password }}</span>
        </div>

        <div class="tw-w-full">
            <InputLabel value="Confirmar senha:" class="tw-text-corporate-black-110 tw-mb-1" />
            <q-input
                borderless
                dense
                class="tw-border tw-box-border tw-rounded-[4px] tw-px-3 tw-bg-white"
                :type="isPwd3 ? 'password' : 'text'"
                :class="{
                    'tw-border-red-500 hover:tw-border-red-700': form.errors.password_confirmation,
                    'tw-border-corporate-black-40 hover:tw-border-corporate-black-90': !form.errors.password_confirmation,
                }"
                v-model="form.password_confirmation"
            >
                <template v-slot:append>
                    <q-icon
                        :name="isPwd3 ? 'visibility_off' : 'visibility'"
                        class="cursor-pointer"
                        @click="isPwd3 = !isPwd3"
                        v-if="form.password_confirmation"
                    />
                    <Icon v-if="form.errors.password_confirmation" class="tw-text-red-500" icon="octicon:alert-24" />
                </template>
            </q-input>

            <span v-if="form.errors.password_confirmation" class="tw-text-red-500">{{ form.errors.password_confirmation }}</span>
        </div>

        <div class="tw-flex tw-items-center tw-gap-4 tw-mt-2">
            <button
                @click="updatePassword()"
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
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Icon } from '@iconify/vue';
import { Notify } from 'quasar';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const isPwd = ref(true);
const isPwd2 = ref(true);
const isPwd3 = ref(true);
const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            Notify.create({
                message: 'Senha atualizada com sucesso!',
                color: 'positive',
            });
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }

            Notify.create({
                message: 'Ocorreu um erro ao atualizar a senha!',
                color: 'negative',
            });
        },
    });
};
</script>
