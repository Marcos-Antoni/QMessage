<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    message: '',
});

const emit = defineEmits(['send']);

const sendMessage = () => {
    if (form.message.trim()) {
        emit('send', form.message);
        form.reset();
    }
};
</script>

<template>
    <div class="border-t border-gray-700 bg-gray-800/80 p-4 backdrop-blur-sm">
        <form @submit.prevent="sendMessage" class="flex items-center space-x-3">
            <input
                type="text"
                v-model="form.message"
                placeholder="Escribe tu mensaje..."
                class="flex-1 rounded-lg border border-gray-600/50 bg-gray-700/50 px-4 py-2 text-white placeholder-gray-400 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 focus:outline-none"
            />
            <button
                type="submit"
                :disabled="!form.message.trim()"
                class="rounded-lg bg-blue-600 px-6 py-2 font-medium text-white transition-colors hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-gray-600/50 disabled:text-gray-400"
            >
                Enviar
            </button>
        </form>
    </div>
</template>
