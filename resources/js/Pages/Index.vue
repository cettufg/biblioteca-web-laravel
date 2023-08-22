<template>
    <Head title="Início" />
    <AuthenticatedLayout :title="`Olá, ${$page.props.auth.user.name}`" description="Acesse as nossas funcionalidades pelo menu lateral">
        <div class="tw-w-full tw-flex tw-items-center tw-justify-center tw-mt-10">
            <img src="@/Images/cover_home.png" class="tw-w-[80%] tw-max-w-[80%] sm:tw-w-[70%] sm:tw-max-w-[70%] md:tw-w-[50%] md:tw-max-w-[50%] tw-object-contain" alt="Cover Home" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
