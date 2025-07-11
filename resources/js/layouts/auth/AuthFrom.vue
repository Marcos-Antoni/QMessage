<script setup lang="ts">
const emit = defineEmits(['submit']);

const props = defineProps<{
    title: string;
}>();

const submit = () => {
    emit('submit');
};
</script>

<template>
    <div class="flex h-screen flex-col items-center justify-center gap-6">
        <h1 class="text-2xl font-bold">QMessage - {{ title }}</h1>
        <form @submit.prevent="submit" class="flex w-[400px] flex-col gap-6 rounded-lg border border-gray-200 p-6">
            <slot />
        </form>
    </div>
</template>
