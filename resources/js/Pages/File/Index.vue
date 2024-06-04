<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, defineProps, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import FileForm from "./FileForm.vue";
import Swal from "sweetalert2";

let fileObj = ref(null);
let showModal = ref(false);

const props = defineProps({
    indicators: Object,
    toolIndicators: Array,
    tool: Object,
});

const addFile = () => {
    fileObj.value = props.tool;
    showModal.value = true;
};

const closeModal = () => {
    fileObj.value = null;
    showModal.value = false;
};

const form = useForm({
    toolIndicator: Object,
});

const deleteToolIndicator = (toolIndicatorId) => {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¿Quieres eliminar este indicador de la herramienta?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar!",
        cancelButtonText: "No, cancelar!"
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route("toolIndicators.destroy", { toolIndicatorId }), {
                preserveScroll: true,
            });
        }
    });
};


const goBack = () => {
    form.get(route('tools.index'));
};

const goToQuestions = (toolIndicatorId) => {
    form.get(route('questions.index', { toolIndicatorId: toolIndicatorId }));
};

</script>

<template>
    <AppLayout title="Fichas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ficha para el indicador <p class="text-blue-500 text-xl font-bold inline-block">{{ props.tool?.name }}</p>
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-between py-2 px-4 mr-4 mt-4">
                        <div >
                            <button
                                @click.prevent="goBack"
                                class="bg-slate-400 hover:bg-slate-500 p-2 text-white rounded-lg flex items-center"
                            >
                                <v-icon
                                    name="fa-arrow-left"
                                    scale="1.5"
                                />
                            </button>
                        </div>
                        <div>
                            <button
                                class="bg-sky-900 hover:bg-sky-800 p-2 text-white rounded-lg flex items-center"
                                @click="addFile"
                            >
                                <v-icon name="io-add-circle-sharp" />
                                <p class="sm:block hidden ml-2">agregar</p>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-sky-200">
                                <thead class="bg-sky-50">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Indicador
                                        </th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center"
                                        >
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>

                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr
                                        v-for="toolIndicator in toolIndicators"
                                        :key="toolIndicator.id"
                                    >
                                        <td
                                            class="text-xs md:text-sm px-6 py-4 whitespace-nowrap"
                                        >
                                            {{ toolIndicator.indicator.name }}
                                        </td>

                                        <td
                                            class="text-xs md:text-sm px-6 py-4 whitespace-nowrap text-center"
                                        >
                                            <button
                                                @click="goToQuestions(toolIndicator.id)"
                                                class="bg-violet-400 text-white p-1 rounded-md hover:bg-violet-500 cursor-pointer mr-1"
                                            >
                                                <v-icon name="md-questionmark-twotone" />
                                            </button>
                                            <button
                                                @click="deleteToolIndicator(toolIndicator.id)"
                                                class="bg-red-400 text-white p-1 rounded-md hover:bg-red-500 cursor-pointer"
                                            >
                                                <v-icon name="md-delete" />
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="toolIndicators.length <= 0">
                                        <td class="text-center" colspan="3">
                                            No hay registros
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <Modal
                        :show="showModal"
                        @close="showModal = false"
                        maxWidth="lg"
                    >
                        <FileForm :tool="fileObj" :indicators="props.indicators" @close-modal="closeModal" />
                    </Modal>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
