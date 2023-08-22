<template>
    <Head title="Perfil" />

    <AuthenticatedLayout>
        <div class="tw-h-full tw-w-full tw-flex tw-flex-col tw-gap-5 tw-p-5 md:tw-p-10">
            <div class="tw-flex tw-flex-col tw-gap-4 tw-text-careful-blue-80">
                <span class="tw-text-3xl tw-font-bold">Perfil</span>
                <span class="tw-text-md">Atualize as informações de perfil e o endereço de e-mail da sua conta.</span>
            </div>
            <div class="tw-w-full tw-flex tw-flex-col tw-items-start tw-justify-start tw-gap-6 tw-mt-10">
                <!-- Accordion -->
                <div class="tw-w-96">
                    <div @click="toogleAccordion(1)" class="tw-w-full tw-py-2 tw-px-4 tw-flex tw-items-center tw-justify-between tw-cursor-pointer hover:tw-text-careful-blue-80 tw-border-r-4 tw-border-transparent hover:tw-border-careful-blue-80" :class="{
                        'tw-border-careful-blue-80 tw-text-careful-blue-80': openAccordion == 1,
                        'tw-text-corporate-black-90 hover:tw-text-careful-blue-80': !openAccordion == 1,
                    }">
                        <div class="tw-flex tw-w-full tw-items-center tw-justify-start">
                            <Icon class="tw-text-2xl" icon="iconoir:verified-user" />
                            <span class="tw-text-md tw-ml-2">Informações de perfil</span>
                        </div>
                        <Icon class="tw-text-xl" icon="material-symbols:arrow-drop-down-rounded" />
                    </div>
                    <UpdateProfileInformationForm v-if="openAccordion == 1" class="tw-px-4 tw-py-2" />
                </div>

                <div class="tw-w-96">
                    <div @click="toogleAccordion(2)" class="tw-w-full tw-py-2 tw-px-4 tw-flex tw-items-center tw-justify-between tw-cursor-pointer hover:tw-text-careful-blue-80 tw-border-r-4 tw-border-transparent hover:tw-border-careful-blue-80" :class="{
                        'tw-border-careful-blue-80 tw-text-careful-blue-80': openAccordion == 2,
                        'tw-text-corporate-black-90 hover:tw-text-careful-blue-80': !openAccordion == 2,
                    }">
                        <div class="tw-flex tw-w-full tw-items-center tw-justify-start">
                            <Icon class="tw-text-2xl" icon="iconoir:password-cursor" />
                            <span class="tw-text-md tw-ml-2">Senhas</span>
                        </div>
                        <Icon class="tw-text-xl" icon="material-symbols:arrow-drop-down-rounded" />
                    </div>
                    <UpdatePasswordForm v-if="openAccordion == 2" class="tw-px-4 tw-py-2" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import { ref, onMounted } from 'vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String
});

const openAccordion = ref(-1);

function toogleAccordion(index){
    if(openAccordion.value == index){
        openAccordion.value = -1;
    }else{
        openAccordion.value = index;
    }
}

</script>
