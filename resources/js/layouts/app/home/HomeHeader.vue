<script setup lang="ts">
defineProps<{
    title: string;
    description: string;
    priceText: string;
}>();
</script>

<template>
    <div class="mb-8 text-center">
        <h1 class="mb-4 text-4xl font-bold text-blue-400 md:text-5xl">{{ title }}</h1>
        <p class="mb-6 text-xl text-gray-300">{{ description }}</p>

        <div class="mb-8 inline-flex items-center rounded-full border border-blue-400/30 bg-blue-900/30 px-6 py-2">
            <span class="font-medium text-blue-300">{{ priceText }}</span>
        </div>
    </div>
</template>
