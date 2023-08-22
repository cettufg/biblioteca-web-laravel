<template>
    <Head title="Criar conta" />

    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-font-Poppins">
        <div class="tw-h-full tw-flex tw-flex-col tw-items-center tw-justify-center tw-z-10 tw-py-10 tw-px-10 md:tw-px-0">
            <div class="tw-w-full tw-flex tw-items-center tw-justify-start tw-pl-10">
                <Link
                    :href="route('login')"
                    class="tw-border tw-border-careful-blue-70 tw-px-3 tw-py-2 tw-flex tw-item-center tw-justify-center tw-gap-2 tw-text-careful-blue-70 tw-rounded-md tw-font-bold"
                >
                    <Icon icon="ic:round-arrow-back" class="tw-text-xl" />
                    <span>Voltar para login</span>
                </Link>
            </div>
            <Link :href="route('login')" class="tw-mt-5">
                <ApplicationLogo class="tw-w-52 tw-object-contain" />
            </Link>
            <div class="tw-mx-auto tw-max-w-4xl tw-px-2 md:tw-px-16 lg:tw-px-28 xl:tw-px-40 tw-mt-14 tw-w-full tw-flex tw-flex-col tw-gap-5">
                <form class="tw-w-full tw-flex tw-flex-col tw-gap-4" @submit.prevent="submit">
                    <div>
                        <InputLabel required value="Primeiro Nome:" class="tw-text-corporate-black-110" />

                        <q-input
                            borderless
                            dense
                            required
                            class="tw-border tw-box-border tw-rounded-[4px] tw-px-3"
                            :class="{
                                    'tw-border-immersive-red-700 hover:tw-border-red-700': form.errors.name,
                                    'tw-border-corporate-black-40 hover:tw-border-corporate-black-90': !form.errors.name,
                                }"
                            v-model="form.name"
                        >
                            <template v-slot:append v-if="form.errors.name">
                                <Icon class="tw-text-immersive-red-700" icon="octicon:alert-24" />
                            </template>
                        </q-input>
                        <span v-if="form.errors.name" class="tw-text-immersive-red-700">{{ form.errors.name }}</span>
                    </div>

                    <div>
                        <InputLabel required value="Email:" class="tw-text-corporate-black-110" />

                        <q-input
                            borderless
                            dense
                            required
                            class="tw-border tw-box-border tw-rounded-[4px] tw-px-3"
                            :class="{
                                'tw-border-immersive-red-700 hover:tw-border-red-700': form.errors.email,
                                'tw-border-corporate-black-40 hover:tw-border-corporate-black-90': !form.errors.email,
                            }"
                            type="email"
                            v-model="form.email"
                        >
                            <template v-slot:append>
                                <Icon class="tw-text-immersive-red-700" icon="octicon:alert-24" v-if="form.errors.email" />
                            </template>
                        </q-input>
                        <span v-if="form.errors.email" class="tw-text-immersive-red-700">{{ form.errors.email }}</span>
                    </div>

                    <div>
                        <InputLabel required value="Senha:" class="tw-text-corporate-black-110" />

                        <q-input
                            borderless
                            dense
                            required
                            :type="isPwd ? 'password' : 'text'"
                            class="tw-border tw-box-border tw-rounded-[4px] tw-px-3"
                            :class="{
                                'tw-border-immersive-red-700 hover:tw-border-red-700': form.errors.password,
                                'tw-border-corporate-black-40 hover:tw-border-corporate-black-90': !form.errors.password,
                            }"
                            v-model="form.password"
                        >
                            <template v-slot:append>
                                <q-icon
                                    :name="isPwd ? 'visibility_off' : 'visibility'"
                                    class="cursor-pointer"
                                    @click="isPwd = !isPwd"
                                    v-if="form.password"
                                />
                                <Icon v-if="form.errors.password" class="tw-text-immersive-red-700" icon="octicon:alert-24" />
                            </template>
                        </q-input>
                        <span v-if="form.errors.password" class="tw-text-immersive-red-700">{{ form.errors.password }}</span>
                    </div>

                    <div>
                        <InputLabel required value="Confirmar Senha:" class="tw-text-corporate-black-110" />

                        <q-input
                            required
                            borderless
                            dense
                            :type="isPwd2 ? 'password' : 'text'"
                            class="tw-border tw-box-border tw-rounded-[4px] tw-px-3"
                            :class="{
                                'tw-border-immersive-red-700 hover:tw-border-red-700': form.errors.password_confirmation,
                                'tw-border-corporate-black-40 hover:tw-border-corporate-black-90': !form.errors.password_confirmation,
                            }"
                            v-model="form.password_confirmation"
                        >
                            <template v-slot:append>
                                <q-icon
                                    :name="isPwd2 ? 'visibility_off' : 'visibility'"
                                    class="cursor-pointer"
                                    @click="isPwd2 = !isPwd2"
                                    v-if="form.password_confirmation"
                                />
                                <Icon v-if="form.errors.password_confirmation" class="tw-text-immersive-red-700" icon="octicon:alert-24" />
                            </template>
                        </q-input>
                    </div>

                    <div v-if="successCreate" class="tw-flex tw-items-center tw-justify-center tw-gap-5 tw-text-[#26554D] tw-bg-[#DCFFE6] tw-border tw-border-[#26554D] tw-rounded-md tw-px-1 tw-py-3 tw-w-full">
                        <Icon icon="mingcute:check-circle-fill" class="tw-text-3xl" />
                        <div class="tw-flex tw-flex-col tw-gap-1 tw-text-lg tw-w-[70%]">
                            <span class="tw-font-bold">Quase pronto!</span>
                            <span class="tw-text-[1rem]">Aguarde o email para validar a conta.</span>
                        </div>
                    </div>

                    <div class="tw-flex tw-items-center tw-justify-between">
                        <PrimaryButton
                            type="submit"
                            class="tw-w-full tw-justify-center tw-py-4 tw-rounded-[4px] tw-bg-careful-blue-60 hover:tw-bg-careful-blue-80 tw-text-white tw-font-bold"
                            :disabled="form.processing"
                            text="Criar conta"
                        />
                    </div>
                </form>
            </div>
        </div>
        <div class="tw-h-full tw-w-full tw-hidden md:tw-block">
            <img src="@/Images/cover_login.png" class="tw-h-full tw-w-full" alt="Cover Login">
        </div>

    </div>
</template>

<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import { ref } from 'vue';
import { Notify } from 'quasar';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});
const isPwd = ref(true);
const isPwd2 = ref(true);
const successCreate = ref(false);

const submit = () => {
    form.post(route('register'), {
        preserveScroll: true,
        onSuccess: () => {
           form.reset();
            form.clearErrors();
            successCreate.value = true;
        },
        onError: () => {
            Notify.create({
                message: 'Erro ao criar conta',
                type: 'negative',
                timeout: 1200,
            });
            form.reset('password', 'password_confirmation');
        }
    });
};
</script>

<style>
[type='text']:focus, [type='email']:focus, [type='url']:focus, [type='password']:focus,
[type='number']:focus, [type='date']:focus, [type='datetime-local']:focus, [type='month']:focus,
[type='search']:focus, [type='tel']:focus, [type='time']:focus, [type='week']:focus, [multiple]:focus,
textarea:focus, select:focus{
    --tw-ring-shadow: 0;
}
</style>
