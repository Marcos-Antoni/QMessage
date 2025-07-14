<script setup lang="ts">
import { computed } from 'vue';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const props = defineProps<{
    id: string;
    label: string;
    type?: string;
    modelValue: string | number;
    placeholder?: string;
    required?: boolean;
    autofocus?: boolean;
    autocomplete?: string;
    error?: string;
    tabindex?: number | string;
    inputClass?: string;
    maxlength?: number | string;
}>();

const emit = defineEmits(['update:modelValue', 'input']);

const value = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit('update:modelValue', value);
        emit('input', { target: { value } });
    },
});
</script>

<template>
    <div class="space-y-2">
        <Label :for="id" class="text-gray-300">{{ label }}</Label>
        <Input
            :id="id"
            :type="type || 'text'"
            :required="required"
            :autofocus="autofocus"
            :autocomplete="autocomplete"
            :placeholder="placeholder"
            :tabindex="tabindex"
            :maxlength="maxlength"
            v-model="value"
            :class="[
                'border-gray-600/50 bg-gray-700/50 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30',
                inputClass,
            ]"
        />
        <InputError v-if="error" :message="error" />
    </div>
</template>
