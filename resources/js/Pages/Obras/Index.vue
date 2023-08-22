<template>
    <AuthenticatedLayout>
        <Head title="Obras" />
        <div class="tw-p-5 md:tw-p-10">
            <div class="tw-flex tw-items-center tw-justify-between tw-space-x-4">
                <h1 class="tw-text-2xl tw-font-bold tw-text-careful-blue-80">Obras</h1>
                <PrimaryButton
                    @click="openModalAction(1)"
                    background="positive"
                    class="tw-px-4 tw-py-2"
                    text="Adicionar Obra"
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
                            <div v-if="props.col.name == 'data_publicacao'">
                                {{ props.row.data_publicacao ? props.row.data_publicacao.split('-').reverse().join('/') : '' }}
                            </div>
                            <div v-else-if="props.col.name == 'instituicao_id'">
                                {{ props.row.instituicao ? props.row.instituicao.nome_fantasia : '' }}
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
                        <q-input v-model="filter" @update:model-value="val => filtrarTabela(val, ['titulo', 'data_publicacao', 'nota', 'tipo', 'instituicao_id'], props.obras)" outlined type="search" placeholder="Pesquisar">
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
                        <div class="text-h6">{{ typeAction == 1 ? "Adicionar" : "Editar" }} Obra</div>
                    </q-card-section>

                    <q-card-section>
                        <div v-if="!form.processing" class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                            <div>
                                <InputLabel
                                    value="Título"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    v-model="form.titulo"
                                    :error-message="form.errors.titulo"
                                    :error="!!form.errors.titulo"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Data de publicação"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    type="date"
                                    v-model="form.data_publicacao"
                                    :error-message="form.errors.data_publicacao"
                                    :error="!!form.errors.data_publicacao"
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

                            <div>
                                <InputLabel
                                    value="Assunto"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    autogrow
                                    v-model="form.assunto"
                                    :error-message="form.errors.assunto"
                                    :error="!!form.errors.assunto"
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

                            <div>
                                <InputLabel
                                    value="Nota"
                                    required
                                />
                                <q-rating
                                    v-model="form.nota"
                                    :max="10"
                                    size="1.8rem"
                                    color="green-5"
                                    icon="star_border"
                                    icon-selected="star"
                                    icon-half="star_half"
                                    :error-message="form.errors.nota"
                                    :error="!!form.errors.nota"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Lingua"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    v-model="form.lingua"
                                    :error-message="form.errors.lingua"
                                    :error="!!form.errors.lingua"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Lincença"
                                    required
                                />
                                <q-input
                                    outlined
                                    clearable
                                    v-model="form.licenca"
                                    :error-message="form.errors.licenca"
                                    :error="!!form.errors.licenca"
                                />
                            </div>

                            <div class="tw-col-span-2">
                                <InputLabel
                                    value="Pesquisadores"
                                    required
                                />
                                <q-select
                                    use-input
                                    v-model="form.pesquisadores"
                                    clearable
                                    multiple
                                    outlined
                                    use-chips
                                    stack-label
                                    :options="optionsPesquisadores"
                                    @filter="filterOptionsPesquisadores"
                                    :error-message="form.errors.pesquisadores" :error="!!form.errors.pesquisadores"
                                >
                                    <template v-slot:no-option>
                                        <q-item>
                                            <q-item-section class="text-grey">
                                                Sem dados
                                            </q-item-section>
                                        </q-item>
                                    </template>
                                </q-select>
                            </div>

                            <div>
                                <InputLabel
                                    value="Thumbnail"
                                />
                                <q-file
                                    v-if="form.thumb_url == '' || form.thumb_url == null"
                                    outlined
                                    clearable
                                    accept="image/*"
                                    v-model="form.thumb"
                                    :error-message="form.errors.thumb"
                                    :error="!!form.errors.thumb"
                                >
                                    <template v-slot:prepend>
                                        <q-icon name="attach_file" />
                                    </template>
                                </q-file>

                                <q-list bordered separator v-else>
                                    <q-item clickable v-ripple>
                                        <q-item-section>{{ form.thumb_url != '' || form.thumb_url != null ? form.thumb_url.substring(0, 25) + '...' : form.thumb_url  }}</q-item-section>
                                        <q-item-section side>
                                            <button @click="removeThumb()"><Icon icon="ic:round-close" /></button>
                                        </q-item-section>
                                    </q-item>
                                </q-list>
                            </div>

                            <div>
                                <InputLabel
                                    value="Arquivo"
                                />
                                <q-file
                                    v-if="form.arquivo_url == '' || form.arquivo_url == null"
                                    outlined
                                    clearable
                                    accepted="application/pdf"
                                    v-model="form.arquivo"
                                    :error-message="form.errors.arquivo"
                                    :error="!!form.errors.arquivo"
                                >
                                    <template v-slot:prepend>
                                        <q-icon name="attach_file" />
                                    </template>
                                </q-file>

                                <q-list bordered separator v-else>
                                    <q-item clickable v-ripple>
                                        <q-item-section>{{ form.arquivo_url != '' || form.arquivo_url != null ? form.arquivo_url.substring(0, 25) + '...' : form.arquivo_url  }}</q-item-section>
                                        <q-item-section side>
                                            <button @click="removeArquivo()"><Icon icon="ic:round-close" /></button>
                                        </q-item-section>
                                    </q-item>
                                </q-list>
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
                        <div class="text-h6">Detalhes da Obra</div>
                    </q-card-section>

                    <q-card-section>
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                            <div>
                                <InputLabel
                                    value="Título"
                                />
                                <q-input
                                    outlined
                                    disable
                                    v-model="form.titulo"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Data de publicação"
                                />
                                <q-input
                                    outlined
                                    disable
                                    type="date"
                                    v-model="form.data_publicacao"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Instituição"
                                />
                                <q-select
                                    outlined
                                    disable
                                    :options="optionsInstituicoes"
                                    v-model="form.instituicao_id"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Assunto"
                                />
                                <q-input
                                    outlined
                                    disable
                                    autogrow
                                    v-model="form.assunto"
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

                            <div>
                                <InputLabel
                                    value="Nota"
                                />
                                <q-rating
                                    v-model="form.nota"
                                    :max="10"
                                    size="1.8rem"
                                    color="green-5"
                                    icon="star_border"
                                    icon-selected="star"
                                    icon-half="star_half"
                                    disable
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Lingua"
                                />
                                <q-input
                                    outlined
                                    disable
                                    v-model="form.lingua"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    value="Lincença"
                                />
                                <q-input
                                    outlined
                                    disable
                                    v-model="form.licenca"
                                />
                            </div>

                            <div class="tw-col-span-2">
                                <InputLabel
                                    value="Pesquisadores"
                                />
                                <q-select
                                    use-input
                                    v-model="form.pesquisadores"
                                    disable
                                    multiple
                                    outlined
                                    use-chips
                                    stack-label
                                    :options="optionsPesquisadores"
                                >
                                    <template v-slot:no-option>
                                        <q-item>
                                            <q-item-section class="text-grey">
                                                Sem dados
                                            </q-item-section>
                                        </q-item>
                                    </template>
                                </q-select>
                            </div>

                            <div>
                                <InputLabel
                                    value="Thumbnail"
                                />
                                <q-file
                                    v-if="form.thumb_url == '' || form.thumb_url == null"
                                    outlined
                                    disable
                                    accept="image/*"
                                    v-model="form.thumb"
                                >
                                    <template v-slot:prepend>
                                        <q-icon name="attach_file" />
                                    </template>
                                </q-file>

                                <q-list bordered separator v-else>
                                    <q-item clickable v-ripple>
                                        <q-item-section>
                                            <a :href="'/storage/' + form.thumb_url" target="_blank">
                                                {{ form.thumb_url != '' || form.thumb_url != null ? form.thumb_url.substring(0, 25) + '...' : form.thumb_url  }}
                                            </a>
                                        </q-item-section>
                                    </q-item>
                                </q-list>
                            </div>

                            <div>
                                <InputLabel
                                    value="Arquivo"
                                />
                                <q-file
                                    v-if="form.arquivo_url == '' || form.arquivo_url == null"
                                    outlined
                                    disable
                                    accepted="application/pdf"
                                    v-model="form.arquivo"
                                >
                                    <template v-slot:prepend>
                                        <q-icon name="attach_file" />
                                    </template>
                                </q-file>

                                <q-list bordered separator v-else>
                                    <q-item clickable v-ripple>
                                        <q-item-section>
                                            <a :href="'/storage/' + form.arquivo_url" target="_blank">
                                                {{ form.arquivo_url != '' || form.arquivo_url != null ? form.arquivo_url.substring(0, 25) + '...' : form.arquivo_url  }}
                                            </a>
                                        </q-item-section>
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
import { Icon } from '@iconify/vue';

const props = defineProps({
    obras: {
        type: Array,
        default: []
    },
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
    { name: 'titulo', align: 'center', label: 'Título', field: 'titulo', sortable: true },
    { name: 'data_publicacao', align: 'center', label: 'Data da publicação', field: 'data_publicacao', sortable: true },
    { name: 'nota', align: 'center', label: 'Nota', field: 'nota', sortable: true },
    { name: 'tipo', align: 'center', label: 'Tipo', field: 'tipo', sortable: true },
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
    thumb: [],
    thumb_url: '',
    titulo: '',
    data_publicacao: '',
    instituicao_id: '',
    arquivo: [],
    arquivo_url: '',
    nota: '',
    assunto: '',
    tipo: '',
    lingua: '',
    licenca: '',
    pesquisadores: [],
});

const rows = ref(props.obras);
const filter = ref('');
const openModal = ref(false);
const openModalDetails = ref(false);
const openModalDelete = ref(false);
const optionsInstituicoes = ref([]);
const stringOptionsPesquisadores = ref([]);
const optionsPesquisadores = ref(stringOptionsPesquisadores.value);
const typeAction = ref('');

onMounted(() => {
    props.instituicoes.forEach((item) => {
        optionsInstituicoes.value.push({
            label: item.nome_fantasia,
            value: item.id
        });
    });

    props.pesquisadores.map((item) => {
        stringOptionsPesquisadores.value.push({
            label: item.nome,
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
    } else if(type == 2){
        form.id = data.id;
        form.thumb = '';
        form.thumb_url = data.thumb;
        form.titulo = data.titulo;
        form.data_publicacao = data.data_publicacao;
        form.arquivo = '';
        form.arquivo_url = data.arquivo;
        form.nota = data.nota;
        form.assunto = data.assunto;
        form.tipo = data.tipo;
        form.lingua = data.lingua;
        form.licenca = data.licenca;
        if(data.instituicao && typeof data.instituicao === 'object') {
            form.instituicao_id = {
                label: data.instituicao.nome_fantasia,
                value: data.instituicao.id
            };
        } else {
            form.instituicao_id = null;
        }

        if(data.pesquisadores && typeof data.pesquisadores === 'object') {
            form.pesquisadores = data.pesquisadores.map((item) => {
                return {
                    label: item.nome,
                    value: item.id
                }
            });
        } else {
            form.pesquisadores = null;
        }
        openModal.value = true;
    }else if(type == 3){
        form.id = data.id;
        form.thumb = '';
        form.thumb_url = data.thumb;
        form.titulo = data.titulo;
        form.data_publicacao = data.data_publicacao;
        form.arquivo = '';
        form.arquivo_url = data.arquivo;
        form.nota = data.nota;
        form.assunto = data.assunto;
        form.tipo = data.tipo;
        form.lingua = data.lingua;
        form.licenca = data.licenca;
        if(data.instituicao && typeof data.instituicao === 'object') {
            form.instituicao_id = {
                label: data.instituicao.nome_fantasia,
                value: data.instituicao.id
            };
        } else {
            form.instituicao_id = null;
        }

        if(data.pesquisadores && typeof data.pesquisadores === 'object') {
            form.pesquisadores = data.pesquisadores.map((item) => {
                return {
                    label: item.nome,
                    value: item.id
                }
            });
        } else {
            form.pesquisadores = null;
        }
        openModalDetails.value = true;
    }else if(type == 4){
        form.id = data.id;
        openModalDelete.value = true;
    }
}

function storeData(){
    form.post(route('obra.store'), {
        preserveScroll: true,
        onSuccess: (response) => {
            openModal.value = false;
            form.reset();
            rows.value = response.props.obras;

            Notify.create({
                message: 'Dados cadastrados com sucesso!',
                type: 'positive',
                timeout: 1000
            });
        }, onError: (error) => {
            Notify.create({
                message: 'Erro ao cadastrar dados',
                type: 'negative',
                timeout: 1000
            });
        }
    });
}

function saveData(){
    form.post(route('obra.update', form.id), {
        preserveScroll: true,
        onSuccess: (response) => {
            openModal.value = false;
            form.reset();
            rows.value = response.props.obras;

            Notify.create({
                message: 'Dados atualizados com sucesso!',
                type: 'positive',
                timeout: 1000
            });
        },
        onError: (error) => {
            Notify.create({
                message: 'Erro ao atualizar dados',
                type: 'negative',
                timeout: 1000
            });
        }
    });
}

function destroyData(){
    form.delete(route('obra.destroy', form.id), {
        preserveScroll: true,
        onSuccess: (response) => {
            openModalDelete.value = false;
            form.reset();
            rows.value = response.props.obras;

            Notify.create({
                message: 'Dados excluídos com sucesso!',
                type: 'positive',
                timeout: 1000
            });
        },
        onError: (error) => {
            Notify.create({
                message: 'Erro ao excluir dados',
                type: 'negative',
                timeout: 1000
            });
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

function removeThumb(){
    form.thumb = '';
    form.thumb_url = '';
    axios.post(route('obra.remove.thumb', form.id));
}

function removeArquivo(){
    form.arquivo = '';
    form.arquivo_url = '';
    axios.post(route('obra.remove.arquivo', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            openModal.value = false;
            form.reset();
        }
    });
}

function filterOptionsPesquisadores(val, update) {
        if (val === '') {
        update(() => {
            optionsPesquisadores.value = stringOptionsPesquisadores.value
        })
        return
    }

    update(() => {
        const needle = val.toLowerCase()
        optionsPesquisadores.value = stringOptionsPesquisadores.value.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
    })
}

</script>
