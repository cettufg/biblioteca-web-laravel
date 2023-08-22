<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">Obras</h2>
        </template>

        <div class="tw-py-12">
            <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
                <div class="tw-bg-white tw-overflow-hidden tw-shadow-sm sm:tw-rounded-lg">
                    <q-table
                        flat
                        bordered
                        :rows="props.obras"
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
                                <div v-if="props.col.name == 'data_publicacao'">
                                    {{ props.row.data_publicacao ? props.row.data_publicacao.split('-').reverse().join('/') : '' }}
                                </div>
                                <div v-else-if="props.col.name == 'instituicao_id'">
                                    <span v-if="props.row.instituicao">{{ props.row.instituicao.nome_fantasia }}</span>
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
                        <div class="text-h6" v-if="typeModal == 1">Adicionar obra</div>
                        <div class="text-h6" v-if="typeModal == 2">Editar obra</div>
                    </q-card-section>

                    <q-card-section>
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
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
                                    max="10"
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
                        <div class="tw-mt-5 tw-flex">
                            <button v-if="typeModal == 1" @click="storeObra()" class="tw-mr-5 tw-flex tw-items-center tw-justify-center tw-bg-primary tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
                                <span class="tw-mr-1">Cadastrar</span>
                                <Icon icon="material-symbols:add-circle" />
                            </button>
                            <button v-if="typeModal == 2" @click="saveObra()" class="tw-mr-5 tw-flex tw-items-center tw-justify-center tw-bg-primary tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
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
                        <div class="text-h6">Detalhes obra</div>
                    </q-card-section>

                    <q-card-section>
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                            <div>
                                <InputLabel
                                    value="Título"
                                />
                                <span class="tw-text-lg">{{ form.titulo }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Data de publicação"
                                />
                                <span class="tw-text-lg">{{ form.data_publicacao ? form.data_publicacao.split('-').reverse().join('/') : '' }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Instituição"
                                />
                                <span class="tw-text-lg">{{ form.instituicao_id.label }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Assunto"
                                />
                                <span class="tw-text-lg">{{ form.assunto }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Tipo"
                                />
                                <span class="tw-text-lg">{{ form.tipo }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Nota"
                                />
                                <span class="tw-text-lg">{{ form.nota }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Lingua"
                                />
                                <span class="tw-text-lg">{{ form.lingua }}</span>
                            </div>

                            <div>
                                <InputLabel
                                    value="Lincença"
                                />
                                <span class="tw-text-lg">{{ form.licenca }}</span>
                            </div>

                            <div class="tw-col-span-2">
                                <InputLabel
                                    value="Thumbnail"
                                />
                                <span class="tw-text-lg">{{ form.thumb }}</span>
                            </div>

                            <div class="tw-col-span-2">
                                <InputLabel
                                    value="Arquivo"
                                />
                                <span class="tw-text-lg">{{ form.arquivo }}</span>
                            </div>

                            <div class="tw-mt-5" v-if="form.pesquisadores.length > 0">
                                <span class="tw-text-xl">Pesquisadores</span>
                                <q-list bordered separator class="tw-mt-3">
                                    <q-item v-for="(pesquisador, index) in form.pesquisadores">
                                        <q-item-section>{{ index + 1 }} - {{ pesquisador.nome }}</q-item-section>
                                    </q-item>
                                </q-list>
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
                        <div class="text-h6">Excluir obra</div>
                    </q-card-section>

                    <q-card-section>
                        <div>
                            Você tem certeza que deseja deletar esse registro?
                        </div>
                        <div class="tw-mt-5 tw-flex">
                            <button @click="destroyObra()" class="tw-mr-5 tw-flex tw-items-center tw-justify-center tw-bg-red-500 tw-px-3 tw-py-2 tw-rounded-md tw-text-white">
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

const props = defineProps({
    obras: {
        type: Array,
        default: ''
    },
    instituicoes: {
        type: Array,
        default: ''
    },
    pesquisadores: {
        type: Array,
        default: ''
    },
})
const columns = [
  { name: 'titulo', align: 'center', label: 'Título', field: 'titulo', sortable: true },
  { name: 'data_publicacao', align: 'center', label: 'Data da publicação', field: 'data_publicacao', sortable: true },
  { name: 'nota', align: 'center', label: 'Nota', field: 'nota', sortable: true },
  { name: 'tipo', align: 'center', label: 'Tipo', field: 'tipo', sortable: true },
  { name: 'instituicao_id', align: 'center', label: 'Instituição', field: 'instituicao_id', sortable: true },
  { name: 'actions', align: 'center', label: 'Ações', field: 'actions', sortable: true },
]
const form = useForm({
    id: '',
    thumb: '',
    thumb_url: '',
    titulo: '',
    data_publicacao: '',
    instituicao_id: '',
    arquivo: '',
    arquivo_url: '',
    nota: '',
    assunto: '',
    tipo: '',
    lingua: '',
    licenca: '',
    pesquisadores: [],
});
const filter = ref('');
const selected = ref([]);
const openModal = ref(false);
const openModalDetails = ref(false);
const openModalDelete = ref(false);
const optionsInstituicoes = ref([]);
const stringOptionsPesquisadores = ref([]);
const optionsPesquisadores = ref(stringOptionsPesquisadores.value);
const typeModal = ref(1);

onMounted(() => {
    optionsInstituicoes.value = props.instituicoes.map((item) => {
        return {
            label: item.nome_fantasia,
            value: item.id
        }
    });

    stringOptionsPesquisadores.value = props.pesquisadores.map((item) => {
        return {
            label: item.nome,
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
        }
    }
}
function openModalDetailsAction(data){
    openModalDetails.value = true;
    form.id = data.id;
    form.thumb = data.thumb;
    form.titulo = data.titulo;
    form.data_publicacao = data.data_publicacao;
    form.arquivo = data.arquivo;
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
    form.pesquisadores = data.pesquisadores;
}
function openModalDeleteAction(item){
    openModalDelete.value = true;
    form.id = item.id;
}
function storeObra(){
    form.post(route('obra.store'), {
        preserveScroll: true,
        onSuccess: () => {
            openModal.value = false;
            form.reset();
        }
    });

}
function saveObra(){
    form.post(route('obra.update', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            openModal.value = false;
            form.reset();
        }
    });
}
function destroyObra(){
    form.delete(route('obra.destroy', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            openModalDelete.value = false;
            form.reset();
        }
    });
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
