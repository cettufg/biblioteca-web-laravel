<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">Instituições</h2>
        </template>

        <div class="tw-py-12">
            <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
                <div class="tw-bg-white tw-overflow-hidden tw-shadow-sm sm:tw-rounded-lg">
                    <q-table
                        flat
                        bordered
                        :rows="instituicoes"
                        :columns="columns"
                        :filter="filter"
                        row-key="name"
                        selection="multiple"
                        v-model:selected="selected"
                        no-data-label="Sem dados cadastrados"
                        no-results-label="A sua pesquisa não retornou dados"
                    >
                        <template v-slot:top-left>
                            <button @click="openModalAction(1)" class="tw-flex tw-items-center tw-justify-center tw-bg-primary tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
                                <span class="tw-mr-1">Adicionar</span>
                                <Icon icon="material-symbols:add-circle" />
                            </button>
                        </template>

                        <template v-slot:top-right>
                            <q-input borderless dense v-model="filter" placeholder="Pesquisar" class="tw-border tw-border-gray-400 tw-rounded-md tw-px-2">
                                <template v-slot:append>
                                    <q-icon name="search" />
                                </template>
                            </q-input>
                        </template>

                        <template v-slot:body-cell="props">
                            <q-td :props="props">
                                <div v-if="props.col.name == 'actions'">
                                    <div class="tw-inline-flex tw-items-center tw-rounded-md tw-shadow-sm">
                                        <button @click="openModalAction(2, props.row)" class="tw-text-slate-800 hover:tw-text-green-500 tw-text-sm tw-bg-white hover:tw-bg-slate-100 tw-border tw-border-slate-200 tw-rounded-l-lg tw-font-medium tw-px-4 tw-py-2 tw-inline-flex tw-space-x-1 tw-items-center">
                                            <Icon icon="tabler:edit" />
                                        </button>
                                        <button @click="openModalDetailsAction(props.row)" class="tw-text-slate-800 hover:tw-text-cyan-500 tw-text-sm tw-bg-white hover:tw-bg-slate-100 tw-border tw-border-slate-200 tw-font-medium tw-px-4 tw-py-2 tw-inline-flex tw-space-x-1 tw-items-center">
                                            <Icon icon="ic:round-remove-red-eye" />
                                        </button>
                                        <button @click="openModalDeleteAction(props.row)" class="tw-text-slate-800 hover:tw-text-red-500 tw-text-sm tw-bg-white hover:tw-bg-slate-100 tw-border tw-border-slate-200 tw-rounded-r-lg tw-font-medium tw-px-4 tw-py-2 tw-inline-flex tw-space-x-1 tw-items-center">
                                            <Icon icon="uil:trash" />
                                        </button>
                                    </div>
                                </div>
                                <div v-else>{{ props.value }}</div>
                            </q-td>
                        </template>

                        <template v-slot:no-data="{ icon, message, filter }">
                            <div class="tw-w-full tw-flex tw-justify-center tw-items-center">
                                <span>
                                    {{ message }}
                                </span>
                                <q-icon size="2em" name="sentiment_dissatisfied" />
                            </div>
                        </template>
                    </q-table>
                </div>
            </div>

            <q-dialog
                v-model="openModal"
            >
                <q-card style="width: 700px; max-width: 80vw;">
                    <q-card-section>
                        <div class="text-h6" v-if="typeModal == 1">Adicionar Instituição</div>
                        <div class="text-h6" v-if="typeModal == 2">Editar Instituição</div>
                    </q-card-section>

                    <q-card-section>
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                            <div>
                                <InputLabel
                                    value="Razão Social"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    v-model="form.razao_social"
                                    :error="!!form.errors.razao_social"
                                    :error-message="form.errors.razao_social"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Nome Fantasia"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    v-model="form.nome_fantasia"
                                    :error-message="form.errors.nome_fantasia"
                                    :error="!!form.errors.nome_fantasia"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="CNPJ"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    mask="##.###.###/####-##"
                                    v-model="form.cnpj"
                                    :error-message="form.errors.cnpj"
                                    :error="!!form.errors.cnpj"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Tipo"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    v-model="form.tipo"
                                    :error-message="form.errors.tipo"
                                    :error="!!form.errors.tipo"
                                />
                            </div>
                        </div>
                        <div class="tw-mt-5 tw-flex">
                            <button v-if="typeModal == 1" @click="storeInstituicao()" class="tw-mr-5 tw-flex tw-items-center tw-justify-center tw-bg-primary tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
                                <span class="tw-mr-1">Cadastrar</span>
                                <Icon icon="material-symbols:add-circle" />
                            </button>
                            <button v-if="typeModal == 2" @click="saveInstituicao()" class="tw-mr-5 tw-flex tw-items-center tw-justify-center tw-bg-primary tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
                                <span class="tw-mr-1">Salvar</span>
                                <Icon icon="ic:baseline-save" />
                            </button>
                            <button v-close-popup class="tw-flex tw-items-center tw-justify-center tw-bg-red-500 tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
                                <span class="tw-mr-1">Cancelar</span>
                                <Icon icon="material-symbols:cancel-outline" />
                            </button>
                        </div>
                    </q-card-section>
                </q-card>
            </q-dialog>

            <q-dialog
                v-model="openModalDetails"
            >
                <q-card style="width: 700px; max-width: 80vw;">
                    <q-card-section>
                        <div class="text-h6">Detalhes Instituição</div>
                    </q-card-section>

                    <q-card-section>
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                            <div>
                                <InputLabel
                                    value="Razão Social"
                                />
                                <span class="tw-text-lg">{{ form.razao_social }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Nome Fantasia"
                                />
                                <span class="tw-text-lg">{{ form.nome_fantasia }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="CNPJ"
                                />
                                <span class="tw-text-lg">{{ form.cnpj }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Tipo"
                                />
                                <span class="tw-text-lg">{{ form.tipo }}</span>
                            </div>
                        </div>

                        <div class="tw-mt-5" v-if="form.pesquisadores.length > 0">
                            <span class="tw-text-xl">Pesquisadores</span>
                            <q-list bordered separator class="tw-mt-3">
                                <q-item v-for="(pesquisador, index) in form.pesquisadores" :key="index">
                                    <q-item-section>{{ index + 1 }} - {{ pesquisador.nome }}</q-item-section>
                                </q-item>
                            </q-list>
                        </div>

                        <div class="tw-mt-5" v-if="form.obras.length > 0">
                            <span class="tw-text-xl">Obras</span>
                            <q-list bordered separator class="tw-mt-3">
                                <q-item v-for="(obra, index) in form.obras" :key="index">
                                    <q-item-section>{{ index + 1 }} - {{ obra.titulo }}</q-item-section>
                                </q-item>
                            </q-list>
                        </div>
                        <div class="tw-mt-5 tw-flex">
                            <button v-close-popup class="tw-flex tw-items-center tw-justify-center tw-bg-red-500 tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
                                <span class="tw-mr-1">Fechar</span>
                                <Icon icon="material-symbols:cancel-outline" />
                            </button>
                        </div>
                    </q-card-section>
                </q-card>
            </q-dialog>

            <q-dialog
                v-model="openModalDelete"
            >
                <q-card style="width: 700px; max-width: 80vw;">
                    <q-card-section>
                        <div class="text-h6">Excluir Instituição</div>
                    </q-card-section>

                    <q-card-section>
                        <div>
                            Você tem certeza que deseja deletar esse registro?
                        </div>
                        <div class="tw-mt-5 tw-flex">
                            <button @click="destroyInstituicao()" class="tw-mr-5 tw-flex tw-items-center tw-justify-center tw-bg-red-500 tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
                                <span class="tw-mr-1">Excluir</span>
                                <Icon icon="uil:trash" />
                            </button>
                            <button v-close-popup class="tw-flex tw-items-center tw-justify-center tw-bg-cyan-500 tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
                                <span class="tw-mr-1">Cancelar</span>
                                <Icon icon="material-symbols:cancel-outline" />
                            </button>
                        </div>
                    </q-card-section>
                </q-card>
            </q-dialog>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Icon } from '@iconify/vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    instituicoes: {
        type: Array,
        default: []
    }
})

const columns = [
  { name: 'nome_fantasia', align: 'center', label: 'Nome Fantasia', field: 'nome_fantasia', sortable: true },
  { name: 'cnpj', align: 'center', label: 'CNPJ', field: 'cnpj', sortable: true },
  { name: 'tipo', align: 'center', label: 'Tipo', field: 'tipo', sortable: true },
  { name: 'actions', align: 'center', label: 'Ações', field: 'actions', sortable: true },
]
const form = useForm({
    id: '',
    razao_social: '',
    nome_fantasia: '',
    cnpj: '',
    tipo: '',
    pesquisadores: [],
    obras: [],
});

const filter = ref('');
const selected = ref([]);
const openModal = ref(false);
const openModalDetails = ref(false);
const openModalDelete = ref(false);
const typeModal = ref(1);

function openModalAction(type, data = []){
    openModal.value = true;
    if(type == 1){
        typeModal.value = 1;
        form.reset();
    }else{
        if(data){
            typeModal.value = 2;
            form.id = data.id;
            form.razao_social = data.razao_social;
            form.nome_fantasia = data.nome_fantasia;
            form.cnpj = data.cnpj;
            form.tipo = data.tipo;
        }
    }
}
function openModalDetailsAction(item){
    openModalDetails.value = true;
    form.id = item.id;
    form.razao_social = item.razao_social;
    form.nome_fantasia = item.nome_fantasia;
    form.cnpj = item.cnpj;
    form.tipo = item.tipo;
    form.pesquisadores = item.pesquisadores;
    form.obras = item.obras;
}
function openModalDeleteAction(item){
    openModalDelete.value = true;
    form.id = item.id;
}
function storeInstituicao(){
    form.post(route('instituicao.store'), {
        preserveScroll: true,
        onSuccess: () => {
            openModal.value = false;
            form.reset();
        }, onError: (error) => {
            console.log(error);
        }
    });
}
function saveInstituicao(){
    form.patch(route('instituicao.update', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            openModal.value = false;
            form.reset();
        }
    });
}
function destroyInstituicao(){
    form.delete(route('instituicao.destroy', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            openModalDelete.value = false;
            form.reset();
        }
    });
}
</script>
