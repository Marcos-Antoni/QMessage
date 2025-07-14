<script setup lang="ts">
interface Feature {
    title: string;
    description: string;
}

defineProps<{
    features: Feature[];
}>();
</script>

<template>
    <div class="space-y-6">
        <div v-for="(feature, index) in features" :key="index" class="flex items-start space-x-4">
            <div class="mt-1 flex-shrink-0">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-medium text-white">{{ feature.title }}</h3>
                <p class="mt-1 text-gray-400">{{ feature.description }}</p>
            </div>
        </div>
    </div>
</template>
