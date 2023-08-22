<template>
    <AuthenticatedLayout>
        <div class="tw-py-12">
            <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
                <div class="tw-bg-white tw-overflow-hidden tw-shadow-sm sm:tw-rounded-lg">
                    <q-table
                        flat
                        bordered
                        :rows="props.pesquisadores"
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
                                <div v-if="props.col.name == 'data_nascimento'">
                                    {{ props.row.data_nascimento ? props.row.data_nascimento.split('-').reverse().join('/') : '' }}
                                </div>
                                <div v-else-if="props.col.name == 'instituicao_id'">
                                    {{ props.row.instituicao.nome_fantasia }}
                                </div>
                                <div v-else-if="props.col.name == 'actions'">
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
                        <div class="text-h6" v-if="typeModal == 1">Adicionar pesquisador</div>
                        <div class="text-h6" v-if="typeModal == 2">Editar pesquisador</div>
                    </q-card-section>

                    <q-card-section>
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
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
                        <div class="tw-mt-5 tw-flex">
                            <button v-if="typeModal == 1" @click="storePesquisador()" class="tw-mr-5 tw-flex tw-items-center tw-justify-center tw-bg-primary tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
                                <span class="tw-mr-1">Cadastrar</span>
                                <Icon icon="material-symbols:add-circle" />
                            </button>
                            <button v-if="typeModal == 2" @click="savePesquisador()" class="tw-mr-5 tw-flex tw-items-center tw-justify-center tw-bg-primary tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
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
                        <div class="text-h6">Detalhes pesquisador</div>
                    </q-card-section>

                    <q-card-section>
                        <div>
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
                                        <q-item v-for="(obra, index) in form.obras">
                                            <q-item-section>{{ index + 1 }} - {{ obra.titulo }}</q-item-section>
                                        </q-item>
                                    </q-list>
                                </div>
                            </div>
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
                        <div class="text-h6">Excluir pesquisador</div>
                    </q-card-section>

                    <q-card-section>
                        <div>
                            Você tem certeza que deseja deletar esse registro?
                        </div>
                        <div class="tw-mt-5 tw-flex">
                            <button @click="destroyPesquisador()" class="tw-mr-5 tw-flex tw-items-center tw-justify-center tw-bg-red-500 tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
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
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Notify } from 'quasar'

const props = defineProps({
    pesquisadores: {
        type: Array,
        default: ''
    },
    instituicoes: {
        type: Array,
        default: ''
    }
});

const columns = [
  { name: 'nome', align: 'center', label: 'Nome', field: 'nome', sortable: true },
  { name: 'data_nascimento', align: 'center', label: 'Data de nascimento', field: 'data_nascimento', sortable: true },
  { name: 'universidade', align: 'center', label: 'Universidade', field: 'universidade', sortable: true },
  { name: 'instituicao_id', align: 'center', label: 'Instituição', field: 'instituicao_id', sortable: true },
  { name: 'actions', align: 'center', label: 'Ações', field: 'actions', sortable: true },
]
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
const filter = ref('');
const selected = ref([]);
const openModal = ref(false);
const openModalDetails = ref(false);
const openModalDelete = ref(false);
const optionsInstituicoes = ref([]);
const typeModal = ref(1);

onMounted(() => {
    optionsInstituicoes.value = props.instituicoes.map((item) => {
        return {
            label: item.nome_fantasia,
            value: item.id
        }
    });
})

function openModalAction(type, data = []){
    openModal.value = true;
    if(type == 1){
        typeModal.value = 1;
        form.reset();
    }else{
        if(data){
            typeModal.value = 2;
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

        }
    }
}
function openModalDetailsAction(data){
    openModalDetails.value = true;
    form.id = data.id;
    form.nome = data.nome;
    form.data_nascimento = data.data_nascimento;
    form.sexo = data.sexo;
    form.cpf = data.cpf;
    form.universidade = data.universidade;
    if(data.instituicao && typeof data.instituicao === 'object') {
        form.instituicao_id = data.instituicao.nome_fantasia;
    } else {
        form.instituicao_id = null;
    }
    form.obras = data.obras;
}
function openModalDeleteAction(item){
    openModalDelete.value = true;
    form.id = item.id;
}
function storePesquisador(){
    form.post(route('pesquisador.store'), {
        preserveScroll: true,
        onSuccess: () => {
            openModal.value = false;
            form.reset();
            Notify.create({
                type: 'positive',
                message: 'Pesquisador cadastrado com sucesso!',
                position: 'top-right'
            });
        },onError: (error) => {
            Notify.create({
                type: 'negative',
                message: 'Erro ao adicionar pesquisador!',
                position: 'top-right'
            });
            console.log(error);
        }
    });

}
function savePesquisador(){
    form.patch(route('pesquisador.update', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            openModal.value = false;
            form.reset();
            Notify.create({
                type: 'positive',
                message: 'Pesquisador atualizado com sucesso!',
                position: 'top-right'
            });
        }, onError: () => {
            openModal.value = true;
            Notify.create({
                type: 'negaitve',
                message: 'Erro ao atualizar pesquisador!',
                position: 'top-right'
            });
        },
    });
}
function destroyPesquisador(){
    form.delete(route('pesquisador.destroy', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            openModalDelete.value = false;
            form.reset();
        }
    });
}
</script>
