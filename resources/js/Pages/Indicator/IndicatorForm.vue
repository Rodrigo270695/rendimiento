<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";

const props = defineProps({
    indicator: Object,
});

const form = useForm({
    id: props.indicator ? props.indicator.id : "",
    name: props.indicator ? props.indicator.name : "",
    description: props.indicator ? props.indicator.description : "",
});

const toTitleCase = (str) => {
    return str.replace(/\w\S*/g, (txt) => {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
};

const submit = () => {
    if (props.indicator) {
        form.put(route('indicators.update', props.indicator), {
            preserveScroll: true,
            onSuccess: () => emit('close-modal')
        });
    } else {
        form.post(route("indicators.store"), {
            preserveScroll: true,
            onSuccess: () => emit("close-modal"),
        });
    }
};

const emit = defineEmits(["close-modal"]);

</script>

<template>
    <form @submit.prevent="submit">
        <div class="bg-white shadow-md rounded-md p-4">
            <div class="text-lg sm:text-xl text-slate-800 font-bold mb-4 border-b-2">
                {{ form.id == 0 ? "Registrar Indicador" : "Actualizar Indicador" }}
            </div>
            <div class="mb-4">
                <div class="grid grid-cols-6 gap-3">
                    <div class="col-span-6 sm:col-span-6">
                        <InputLabel value="Nombre" />
                        <TextInput
                            class="w-full"
                            v-model="form.name"
                            @input="form.name = toTitleCase(form.name)"
                        />
                        <InputError
                            class="w-full"
                            :message="form.errors.name"
                        />
                    </div>
                    <div class="col-span-6 sm:col-span-6">
                        <InputLabel value="Descripción" />
                        <TextArea
                            class="w-full"
                            v-model="form.description"
                        />
                        <InputError
                            class="w-full"
                            :message="form.errors.description"
                        />
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2"
                    :disabled="form.processing"
                >
                    {{ form.id == 0 ? "Registrar" : "Actualizar" }}
                </button>
            </div>
        </div>
    </form>
</template>
