<template>
    <Head title="Redefinir senha" />

    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-font-Poppins">
        <div class="tw-h-screen tw-flex tw-flex-col tw-items-center tw-justify-start tw-z-10 tw-px-10 md:tw-px-24">
            <div class="tw-w-full tw-flex tw-items-center tw-justify-start tw-pt-10">
                <Link
                    :href="route('login')"
                    class="tw-border tw-border-careful-blue-70 tw-px-3 tw-py-2 tw-flex tw-item-center tw-justify-center tw-gap-2 tw-text-careful-blue-70 tw-rounded-md tw-font-bold"
                >
                    <Icon icon="ic:round-arrow-back" class="tw-text-xl" />
                    <span>Voltar para login</span>
                </Link>
            </div>

            <div class="tw-h-full tw-flex tw-flex-col tw-gap-2 tw-items-center tw-justify-center">
                <Link :href="route('login')" class="tw-mb-10">
                    <ApplicationLogo class="tw-w-52 tw-object-contain" />
                </Link>

                <div class="tw-text-careful-blue-80 tw-flex tw-flex-col tw-items-start tw-gap-2 tw-w-full tw-mb-5">
                    <div class="tw-text-2xl tw-font-bold">
                        Redefinir senha
                    </div>


                    <div>
                        Um link para redefinir sua senha será enviado para seu email cadastrado no sistema.
                    </div>
                </div>

                <form class="tw-w-full tw-flex tw-flex-col tw-gap-2" @submit.prevent="submit">
                    <div>
                        <InputLabel required value="Email:" class="tw-text-corporate-black-110" />

                        <q-input
                            borderless
                            dense
                            required
                            @change="validateEmail()"
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

                    <div v-if="successSend" class="tw-flex tw-items-center tw-justify-center tw-gap-5 tw-text-[#26554D] tw-bg-[#DCFFE6] tw-border tw-border-[#26554D] tw-rounded-md tw-px-1 tw-py-3 tw-w-full">
                        <Icon icon="mingcute:check-circle-fill" class="tw-text-3xl" />
                        <div class="tw-flex tw-flex-col tw-gap-1 tw-text-lg tw-w-[70%]">
                            <span class="tw-font-bold">Cheque seu email.</span>
                            <span class="tw-text-[1rem]">Você já pode redefinir sua senha.</span>
                        </div>
                    </div>

                    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-gap-4 tw-mt-4">
                        <PrimaryButton
                            :disabled="form.processing"
                            @click="submit()"
                            type="submit"
                            class="tw-w-full tw-justify-center tw-py-3 tw-rounded-[4px] tw-bg-careful-blue-60 hover:tw-bg-careful-blue-80 tw-text-white tw-font-bold"
                            fontSize="lg"
                            text="Enviar link"
                        />

                    </div>
                </form>
            </div>
        </div>
        <div class="tw-h-screen tw-w-full tw-hidden md:tw-block">
            <img src="@/Images/cover_login.png" class="tw-h-full tw-w-full" alt="Cover Login">
        </div>
    </div>
</template>

<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import { ref } from 'vue';


defineProps({
    status: String,
});

const successSend = ref(false);
const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            successSend.value = true;
        },
        onError: () => {
            successSend.value = false;
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
