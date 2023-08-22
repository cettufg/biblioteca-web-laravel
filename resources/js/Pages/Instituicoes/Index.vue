<template>
    <AuthenticatedLayout>
        <Head title="Instituições" />
        <div class="tw-p-5 md:tw-p-10">
            <div class="tw-flex tw-items-center tw-justify-between tw-space-x-4">
                <h1 class="tw-text-2xl tw-font-bold tw-text-careful-blue-80">Instituições</h1>
                <PrimaryButton
                    @click="openModalAction(1)"
                    background="positive"
                    class="tw-px-4 tw-py-2"
                    text="Adicionar Instituição"
                    icon="material-symbols:add-circle-outline"
                />
            </div>
            <div class="tw-mt-4">
                <q-table
                    virtual-scroll
                    :rows="rows"
                    :columns="columns"
                    row-key="id"
                    :pagination="initialPagination"
                    rows-per-page-label="Registros por página"
                    no-data-label="Sem dados cadastrados"
                    no-results-label="A sua pesquisa não retornou dados"
                >

                    <template v-slot:body-cell="props">
                        <q-td :props="props">
                            <div v-if="props.col.name == 'actions'">
                                <div class="tw-inline-flex tw-items-center tw-rounded-md tw-shadow-sm tw-gap-2">
                                    <PrimaryButton
                                        @click="openModalAction(2, props.row)"
                                        background="info"
                                        class="tw-p-2"
                                        icon="ant-design:edit-outlined"
                                    >
                                        <q-tooltip :offset="[10, 10]">
                                            Editar
                                        </q-tooltip>
                                    </PrimaryButton>
                                    <PrimaryButton
                                        @click="openModalAction(3, props.row)"
                                        background="warning"
                                        class="tw-p-2"
                                        icon="mdi:eye-outline"
                                    >
                                        <q-tooltip :offset="[10, 10]">
                                            Detalhes
                                        </q-tooltip>
                                    </PrimaryButton>
                                    <PrimaryButton
                                        @click="openModalAction(4, props.row)"
                                        background="negative"
                                        class="tw-p-2"
                                        icon="uil:trash"
                                    >
                                        <q-tooltip :offset="[10, 10]">
                                            Excluir
                                        </q-tooltip>
                                    </PrimaryButton>
                                </div>
                            </div>
                            <div v-else>
                                {{ props.value }}
                            </div>
                        </q-td>
                    </template>

                    <template v-slot:top-right>
                        <q-input v-model="filter" @update:model-value="val => filtrarTabela(val, ['id', 'nome_fantasia', 'cnpj', 'tipo'], props.instituicoes)" outlined type="search" placeholder="Pesquisar">
                            <template v-slot:append>
                                <q-icon name="search" />
                            </template>
                        </q-input>
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

            <q-dialog
                v-model="openModal"
            >
                <q-card style="width: 700px; max-width: 80vw;">
                    <q-card-section>
                        <div class="text-h6">{{ typeAction == 1 ? "Adicionar" : "Editar" }} Instituição</div>
                    </q-card-section>

                    <q-card-section>
                        <div v-if="!form.processing" class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
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
                        <div v-else>
                            <div class="tw-flex tw-items-center tw-justify-center tw-py-2">
                                <q-spinner
                                    color="primary"
                                    size="3em"
                                />
                            </div>
                        </div>
                    </q-card-section>

                    <q-card-actions align="left" class="tw-space-x-4">

                        <PrimaryButton
                            @click="storeData()"
                            v-if="typeAction == 1"
                            :disabled="form.processing"
                            background="positive"
                            class="tw-px-4 tw-py-2"
                            text="Cadastrar"
                            icon="material-symbols:add-circle-outline"
                        />
                        <PrimaryButton
                            @click="saveData()"
                            v-if="typeAction == 2"
                            :disabled="form.processing"
                            background="positive"
                            class="tw-px-4 tw-py-2"
                            text="Salvar"
                            icon="material-symbols:save-outline"
                        />
                        <PrimaryButton
                            v-close-popup
                            :disabled="form.processing"
                            background="info"
                            class="tw-px-4 tw-py-2"
                            text="Cancelar"
                            icon="material-symbols:cancel-outline"
                        />
                    </q-card-actions>
                </q-card>
            </q-dialog>

            <q-dialog
                v-model="openModalDetails"
            >
                <q-card style="width: 700px; max-width: 80vw;">
                    <q-card-section>
                        <div class="text-h6">Detalhes da Instituição</div>
                    </q-card-section>

                    <q-card-section>
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                            <div>
                                <InputLabel
                                    value="Razão Social"
                                />
                                <q-input
                                    outlined
                                    disable
                                    v-model="form.razao_social"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Nome Fantasia"
                                />
                                <q-input
                                    outlined
                                    disable
                                    v-model="form.nome_fantasia"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="CNPJ"
                                />
                                <q-input
                                    outlined
                                    disable
                                    mask="##.###.###/####-##"
                                    v-model="form.cnpj"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Tipo"
                                />
                                <q-input
                                    outlined
                                    disable
                                    v-model="form.tipo"
                                />
                            </div>
                        </div>
                    </q-card-section>

                    <q-card-actions align="left" class="tw-space-x-4">
                        <PrimaryButton
                            v-close-popup
                            :disabled="form.processing"
                            background="info"
                            class="tw-px-4 tw-py-2"
                            text="Fechar"
                            icon="material-symbols:cancel-outline"
                        />
                    </q-card-actions>
                </q-card>
            </q-dialog>

            <q-dialog
                v-model="openModalDelete"
            >
                <q-card style="width: 700px; max-width: 80vw;">
                    <q-card-section>
                        <div class="text-h6">Deletar dados</div>
                    </q-card-section>

                    <q-card-section class="q-pt-none">
                        <div v-if="!form.processing" class="tw-flex tw-py-2">
                            Você tem certeza que deseja deletar esses dados?
                        </div>

                        <div v-if="form.processing" class="tw-flex tw-items-center tw-justify-center tw-py-2">
                            <q-spinner
                                color="primary"
                                size="3em"
                            />
                        </div>
                    </q-card-section>

                    <q-card-actions align="left" class="tw-space-x-4">
                        <PrimaryButton
                            @click="destroyData()"
                            :disabled="form.processing"
                            background="negative"
                            class="tw-px-4 tw-py-2"
                            text="Excluir"
                            icon="uil:trash"

                        />

                        <PrimaryButton
                            :disabled="form.processing"
                            background="info"
                            class="tw-px-4 tw-py-2"
                            text="Cancelar"
                            icon="material-symbols:cancel-outline"
                            v-close-popup
                        />
                    </q-card-actions>
                </q-card>
            </q-dialog>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    instituicoes: {
        type: Array,
        default: []
    }
})

const columns = [
  { name: 'nome_fantasia', align: 'center', label: 'Nome Fantasia', field: 'nome_fantasia', sortable: true },
  { name: 'cnpj', align: 'center', label: 'CNPJ', field: 'cnpj', sortable: true },
  { name: 'tipo', align: 'center', label: 'Tipo', field: 'tipo', sortable: true },
  { name: 'actions', align: 'center', label: 'Ações', field: 'actions', sortable: false },
];
const initialPagination = ref({
    sortBy: 'desc',
    descending: false,
    page: 1,
    rowsPerPage: 10
});
const form = useForm({
    id: '',
    razao_social: '',
    nome_fantasia: '',
    cnpj: '',
    tipo: '',
    pesquisadores: [],
    obras: [],
});

const rows = ref(props.instituicoes);
const filter = ref('');
const openModal = ref(false);
const openModalDetails = ref(false);
const openModalDelete = ref(false);
const typeAction = ref('');

function openModalAction(type, data = []){
    form.reset();
    typeAction.value = type;
    if(type == 1){
        form.reset();
        openModal.value = true;
    }else if(type == 2){
        form.id = data.id;
        form.razao_social = data.razao_social;
        form.nome_fantasia = data.nome_fantasia;
        form.cnpj = data.cnpj;
        form.tipo = data.tipo;
        openModal.value = true;
    }else if(type == 3){
        form.id = data.id;
        form.razao_social = data.razao_social;
        form.nome_fantasia = data.nome_fantasia;
        form.cnpj = data.cnpj;
        form.tipo = data.tipo;
        openModalDetails.value = true;
    }else if(type == 4){
        form.id = data.id;
        openModalDelete.value = true;
    }
}

function storeData(){
    form.post(route('instituicao.store'), {
        preserveScroll: true,
        onSuccess: (response) => {
            openModal.value = false;
            form.reset();
            rows.value = response.props.instituicoes;
        }, onError: (error) => {
            console.log(error);
        }
    });
}

function saveData(){
    form.patch(route('instituicao.update', form.id), {
        preserveScroll: true,
        onSuccess: (response) => {
            openModal.value = false;
            form.reset();
            rows.value = response.props.instituicoes;
        }
    });
}

function destroyData(){
    form.delete(route('instituicao.destroy', form.id), {
        preserveScroll: true,
        onSuccess: (response) => {
            openModalDelete.value = false;
            form.reset();
            rows.value = response.props.instituicoes;
        }
    });
}

function filtrarTabela(value = null, propriedades = [], dados = []) {
    if (value == null || value == '') {
        rows.value = dados;
    } else {
        rows.value = dados.filter((item) => {
            for (let propriedade of propriedades) {
                propriedade = propriedade.split('.');
                let propriedadeValida = true;
                let itemAtual = item;
                for (let subPropriedade of propriedade) {
                    if (itemAtual && itemAtual.hasOwnProperty(subPropriedade)) {
                        itemAtual = itemAtual[subPropriedade];
                    } else {
                        propriedadeValida = false;
                        break;
                    }
                }

                if (propriedadeValida && itemAtual) {
                    if(typeof itemAtual == 'string'){
                        if(itemAtual.toLowerCase().indexOf(value.toLowerCase()) > -1){
                            return true;
                        }
                    }else if(typeof itemAtual == 'number'){
                        if(itemAtual == value){
                            return true;
                        }
                    }else{
                        return false;
                    }
                }
            }
            return false;
        });
    }
}
</script>
