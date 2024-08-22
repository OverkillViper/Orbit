<script setup>
import { ref } from 'vue';

const model = defineModel({
    type: [String, Number],
    required: true,
});

const props = defineProps({
    icon        : String,
    placeholder : String,
    label       : String,
    password    : Boolean,
});

const type = ref(props.password ? 'password' : 'text');

const togglePassword = () => {
    type.value = type.value == 'password' ? 'text' : 'password';
}

</script>

<template>
    <div>
        <div v-if="label" class="text-xs text-gray-400 uppercase font-medium mb-1">{{ label }}</div>
        <div class="bg-secondary px-3 h-10 flex items-center rounded-lg border border-transparent hover:border-neutral-800 transition">
            <div v-if="icon" class="">
                <span class="pi text-gray-500 w-2 h-2" :class="'pi-' + icon" style="font-size: 0.8rem;"></span>
            </div>
            <input :type="type" class="border-0 bg-secondary focus:border-0 ring-0 focus:ring-0 font-medium text-sm p-0 flex-grow m-0" v-model="model" :placeholder="placeholder" :class="icon ? 'ms-6' : ''">
            <div v-if="password">
                <span class="pi text-gray-400" :class="type == 'password' ? 'pi-eye' : 'pi-eye-slash'" @click="togglePassword"></span>
            </div>
            <div class="flex items-center">

            </div>
        </div>
    </div>
    
</template>