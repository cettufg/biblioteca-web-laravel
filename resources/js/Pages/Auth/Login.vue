<template>
    <Head title="Entrar" />
    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-font-Poppins">
        <div class="tw-h-full tw-flex tw-flex-col tw-items-center tw-justify-center tw-z-10 tw-px-10 md:tw-px-0">
            <Link :href="route('login')">
                <ApplicationLogo class="tw-w-52 tw-object-contain" />
            </Link>
            <div class="tw-mx-auto tw-max-w-4xl tw-px-2 md:tw-px-16 lg:tw-px-28 xl:tw-px-40 tw-mt-14 tw-w-full tw-flex tw-flex-col tw-gap-5">
                <form class="tw-w-full tw-flex tw-flex-col tw-gap-4" @submit.prevent="submit">
                    <div>
                        <InputLabel required value="Email:" class="tw-text-corporate-black-110" />

                        <q-input
                            borderless
                            dense
                            required
                            class="tw-border tw-box-border tw-rounded-[4px] tw-px-3"
                            :class="{
                                'tw-border-immersive-red-700 hover:tw-border-red-700': form.errors.email,
                                'tw-border-corporate-black-40 hover:tw-border-corporate-black-90': !form.errors.email
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

                    <div class="tw-flex tw-items-center tw-justify-between tw-mt-3">
                        <div class="tw-flex tw-items-center">
                            <q-checkbox
                                keep-color
                                color= info
                                label="Lembrar-me"
                                class="tw-m-0 tw-p-0 tw-text-careful-blue-80 tw-font-semibold"
                                v-model="form.remember"
                            />
                        </div>

                        <Link
                            v-if="props.canResetPassword"
                            :href="route('password.request')"
                            class="tw-underline tw-text-sm tw-text-corporate-black-70 hover:tw-text-corporate-black-100 tw-rounded-md focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-corporate-black-110"
                        >
                            Perdi minha senha
                        </Link>
                    </div>

                    <div v-if="accountBlocked" class="tw-flex tw-items-center tw-justify-center tw-gap-5 tw-text-[#9F5600] tw-bg-[#FFF5D6] tw-border tw-border-[#9F5600] tw-rounded-md tw-px-1 tw-py-3 tw-w-full">
                        <Icon icon="fluent:warning-24-filled" class="tw-text-3xl" />
                        <div class="tw-flex tw-flex-col tw-gap-1 tw-text-lg tw-w-[70%]">
                            <span class="tw-font-bold">Conta em validação!</span>
                            <span class="tw-text-[1rem]">Aguarde a validação da sua conta.</span>
                        </div>
                    </div>


                    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-gap-4 tw-mt-4">
                        <PrimaryButton
                            :disabled="form.processing"
                            @click="submit()"
                            type="submit"
                            class="tw-w-full tw-justify-center tw-py-3 tw-rounded-[4px] tw-bg-careful-blue-60 hover:tw-bg-careful-blue-80 tw-text-white tw-font-bold"
                            fontSize="lg"
                            text="Login"
                        />

                        <PrimaryLink
                            :href="route('register')"
                            class="tw-w-full tw-justify-center tw-py-3 tw-rounded-[4px] tw-border tw-border-careful-blue-60 hover:tw-bg-careful-blue-60 hover:tw-text-white tw-text-careful-blue-60 tw-font-bold"
                            fontSize="lg"
                            text="Criar Conta"
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
import PrimaryLink from '@/Components/PrimaryLink.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Notify } from 'quasar';
import { Icon } from '@iconify/vue';

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
});
const isPwd = ref(true);
const accountBlocked = ref(false);
const form = useForm({
    email: '',
    password: '',
    remember: false,
});


const submit = () => {
    form.post(route('login'), {
        preserveScroll: true,
        onSuccess: (response) => {
            form.clearErrors();
            form.reset('password');
            if(response.props.status) {
                accountBlocked.value = true;
            }
        },
        onError: (errors) => {
            accountBlocked.value = false;
            form.reset('password');
            Notify.create({
                type: 'negative',
                message: 'Erro ao fazer login!',
            });
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
