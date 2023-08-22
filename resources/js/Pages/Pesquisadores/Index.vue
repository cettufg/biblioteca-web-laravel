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
                            <div v-if="props.col.name == 'data_nascimento'">
                                {{ props.row.data_nascimento ? props.row.data_nascimento.split('-').reverse().join('/') : '' }}
                            </div>
                            <div v-else-if="props.col.name == 'instituicao_id'">
                                {{ props.row.instituicao.nome_fantasia }}
                            </div>
                            <div v-else-if="props.col.name == 'actions'">
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
                        <div class="text-h6">{{ typeAction == 1 ? "Adicionar" : "Editar" }} Pesquisador</div>
                    </q-card-section>

                    <q-card-section>
                        <div v-if="!form.processing" class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                            <div>
                                <InputLabel
                                    value="Nome"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    v-model="form.nome"
                                    :error-message="form.errors.nome"
                                    :error="!!form.errors.nome"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Data de nascimento"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    type="date"
                                    v-model="form.data_nascimento"
                                    :error-message="form.errors.data_nascimento"
                                    :error="!!form.errors.data_nascimento"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Sexo"
                                    required
                                />
                                <q-select
                                    outlined
                                    clearable
                                    :options="[ 'Masculino', 'Feminino' ]"
                                    v-model="form.sexo"
                                    :error-message="form.errors.sexo"
                                    :error="!!form.errors.sexo"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="CPF"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    v-model="form.cpf"
                                    mask="###.###.###-##"
                                    :error-message="form.errors.cpf"
                                    :error="!!form.errors.cpf"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Universidade"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    v-model="form.universidade"
                                    :error-message="form.errors.universidade"
                                    :error="!!form.errors.universidade"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Instituição"
                                    required
                                />
                                <q-select
                                    outlined
                                    clearable
                                    :options="optionsInstituicoes"
                                    v-model="form.instituicao_id"
                                    :error-message="form.errors.instituicao_id"
                                    :error="!!form.errors.instituicao_id"
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
                        <div class="text-h6">Detalhes da Pesquisador</div>
                    </q-card-section>

                    <q-card-section>
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                            <div>
                                <InputLabel
                                    value="Nome"
                                />
                                <span class="tw-text-lg">{{ form.nome }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Data de nascimento"
                                />
                                <span class="tw-text-lg">{{ form.data_nascimento ? form.data_nascimento.split('-').reverse().join('/') : '' }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Sexo"
                                />
                                <span class="tw-text-lg">{{ form.sexo }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="CPF"
                                />
                                <span class="tw-text-lg">{{ form.cpf }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Universidade"
                                />
                                <span class="tw-text-lg">{{ form.universidade }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Instituição"
                                />
                                <span class="tw-text-lg">{{ form.instituicao_id }}</span>
                            </div>

                            <div class="tw-mt-5" v-if="form.obras.length > 0">
                                <span class="tw-text-xl">Obras</span>
                                <q-list bordered separator class="tw-mt-3">
                                    <q-item v-for="(obra, index) in form.obras" :key="index">
                                        <q-item-section>{{ index + 1 }} - {{ obra.titulo }}</q-item-section>
                                    </q-item>
                                </q-list>
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
import { ref, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Notify } from 'quasar';

const props = defineProps({
    pesquisadores: {
        type: Array,
        default: []
    },
    instituicoes: {
        type: Array,
        default: []
    }
})

const columns = [
    { name: 'nome', align: 'center', label: 'Nome', field: 'nome', sortable: true },
    { name: 'data_nascimento', align: 'center', label: 'Data de nascimento', field: 'data_nascimento', sortable: true },
    { name: 'universidade', align: 'center', label: 'Universidade', field: 'universidade', sortable: true },
    { name: 'instituicao_id', align: 'center', label: 'Instituição', field: 'instituicao_id', sortable: true },
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
    nome: '',
    data_nascimento: '',
    sexo: '',
    cpf: '',
    universidade: '',
    instituicao_id: '',
    obras: [],
});

const rows = ref(props.pesquisadores);
const filter = ref('');
const openModal = ref(false);
const openModalDetails = ref(false);
const openModalDelete = ref(false);
const optionsInstituicoes = ref([]);
const typeAction = ref('');

onMounted(() => {
    props.instituicoes.forEach((item) => {
        optionsInstituicoes.value.push({
            label: item.nome_fantasia,
            value: item.id
        });
    });
})


function openModalAction(type, data = []){
    form.reset();
    typeAction.value = type;
    if(type == 1){
        form.reset();
        openModal.value = true;
    }else if(type == 2){
        form.id = data.id;
        form.nome = data.nome;
        form.data_nascimento = data.data_nascimento;
        form.sexo = data.sexo;
        form.cpf = data.cpf;
        form.universidade = data.universidade;
        if(data.instituicao && typeof data.instituicao === 'object') {
            form.instituicao_id = {
                label: data.instituicao.nome_fantasia,
                value: data.instituicao.id
            };
        } else {
            form.instituicao_id = null;
        }
        openModal.value = true;
    }else if(type == 3){
        form.id = data.id;
        form.nome = data.nome;
        form.data_nascimento = data.data_nascimento;
        form.sexo = data.sexo;
        form.cpf = data.cpf;
        form.universidade = data.universidade;
        if(data.instituicao && typeof data.instituicao === 'object') {
            form.instituicao_id = {
                label: data.instituicao.nome_fantasia,
                value: data.instituicao.id
            };
        } else {
            form.instituicao_id = null;
        }
        openModalDetails.value = true;
    }else if(type == 4){
        form.id = data.id;
        openModalDelete.value = true;
    }
}

function storeData(){
    form.post(route('pesquisador.store'), {
        preserveScroll: true,
        onSuccess: (response) => {
            openModal.value = false;
            form.reset();
            rows.value = response.props.pesquisadores;
        }, onError: (error) => {
            console.log(error);
        }
    });
}

function saveData(){
    form.patch(route('pesquisador.update', form.id), {
        preserveScroll: true,
        onSuccess: (response) => {
            openModal.value = false;
            form.reset();
            rows.value = response.props.pesquisadores;
        }
    });
}

function destroyData(){
    form.delete(route('pesquisador.destroy', form.id), {
        preserveScroll: true,
        onSuccess: (response) => {
            openModalDelete.value = false;
            form.reset();
            rows.value = response.props.pesquisadores;
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
