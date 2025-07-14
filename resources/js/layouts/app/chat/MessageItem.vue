<script setup lang="ts">
import { Message } from './types';

defineProps<{
    message: Message;
    isOwnMessage: boolean;
}>();
</script>

<template>
    <div :class="['flex items-start space-x-3', isOwnMessage ? 'justify-end' : 'justify-start']">
        <!-- Avatar (solo para mensajes de otros) -->
        <div v-if="!isOwnMessage" class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-600 text-white">
            {{ message.avatar }}
        </div>

        <!-- Contenido del mensaje -->
        <div
            :class="[
                'max-w-xs rounded-lg px-4 py-2 lg:max-w-md',
                isOwnMessage ? 'bg-blue-600 text-white' : 'border border-gray-600/30 bg-gray-700/80 shadow-sm',
            ]"
        >
            <!-- Nombre del usuario (solo para mensajes de otros) -->
            <p v-if="!isOwnMessage" class="mb-1 text-xs font-medium text-gray-300">
                {{ message.username }}
            </p>

            <!-- Mensaje -->
            <p class="text-sm text-white">{{ message.message }}</p>

            <!-- Timestamp -->
            <p :class="['mt-1 text-xs', isOwnMessage ? 'text-blue-200' : 'text-gray-400']">
                {{ message.timestamp }}
            </p>
        </div>

        <!-- Avatar (solo para mensajes propios) -->
        <div v-if="isOwnMessage" class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-500 text-white">
            {{ message.avatar }}
        </div>
    </div>
</template>
