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
    <div class="flex min-h-screen items-center justify-center bg-gray-900 p-4">
        <div class="w-full max-w-md">
            <!-- Logo/Branding -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-blue-400">QMessage</h1>
                <p class="mt-2 text-gray-400">{{ title }}</p>
            </div>

            <!-- Form Container -->
            <div class="overflow-hidden rounded-xl bg-gray-800/80 shadow-2xl backdrop-blur-sm">
                <div class="p-8">
                    <form @submit.prevent="submit" class="space-y-6">
                        <slot />
                    </form>
                </div>

                <!-- Footer -->
                <div class="border-t border-gray-700/50 bg-gray-800/50 p-4 text-center">
                    <p class="text-xs text-gray-500">© {{ new Date().getFullYear() }} QMessage. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Smooth transitions */
form {
    transition: all 0.3s ease;
}

/* Button hover effect */
:deep(button:not(:disabled)) {
    transition: all 0.2s ease;
}

:deep(button:not(:disabled):hover) {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px -1px rgba(0, 0, 0, 0.2);
}

:deep(button:not(:disabled):active) {
    transform: translateY(0);
}
</style>
