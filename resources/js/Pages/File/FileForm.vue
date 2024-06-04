
<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";

const props = defineProps({
    tool: Object,
    indicators: Array,
});

const form = useForm({
    tool_id: props.tool.id,
    indicator_id: '',
});


const submit = () => {
    form.post(route('toolIndicators.store', { toolId: props.tool.id }), {
        preserveScroll: true,
        onSuccess: () => emit("close-modal"),
    });
};

const emit = defineEmits(["close-modal"]);

</script>

<template>
    <form @submit.prevent="submit">
        <div class="bg-white shadow-md rounded-md p-4">
            <div class="text-lg sm:text-xl text-slate-800 font-bold mb-4 border-b-2">
                Agregar Archivo
            </div>
            <div class="mb-4">
                <div class="grid grid-cols-6 gap-3">
                    <div class="col-span-6 sm:col-span-6">
                        <InputLabel value="Indicador" />
                        <select
                            id="select"
                            v-model="form.indicator_id"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 white:border-gray-600 white:placeholder-gray-4000 white:text-white white:focus:ring-blue-500 white:focus:border-blue-500"
                        >
                            <option disabled selected value="">
                                Seleccione un opción
                            </option>
                            <option
                                v-for="indicator in props.indicators"
                                :key="indicator.id"
                                :value="indicator.id"
                            >
                                {{ indicator.name }}
                            </option>
                        </select>
                        <InputError
                            class="w-full"
                            :message="form.errors.indicator_id"
                        />
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2"
                    :disabled="form.processing"
                >
                    Registrar
                </button>
            </div>
        </div>
    </form>
</template>
