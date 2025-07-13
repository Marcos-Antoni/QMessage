<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { useEcho } from '@laravel/echo-vue';
import axios from 'axios';
import { nextTick, onMounted, ref } from 'vue';

const { user } = usePage().props.auth;

// Interfaz para los mensajes
interface Message {
    id: number;
    user_id: number;
    username: string;
    message: string;
    timestamp: string;
    avatar?: string;
}

interface MessageWebSocket extends Omit<Message, 'id'> {}

const { messages } = defineProps<{ messages: Message[] }>();

const messagesRef = ref<Message[]>(messages || []);

const form = useForm({
    message: '',
});

const chatContainer = ref<HTMLElement | null>(null);

// Función para desplazar hacia abajo
const scrollToBottom = () => {
    nextTick(() => {
        if (chatContainer.value) {
            chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
        }
    });
};

const enviarMensaje = async () => {
    if (!form.message.trim()) return;

    const nuevoMensaje: Message = {
        id: messagesRef.value.length + 1,
        user_id: user.id,
        username: `${user.first_name} ${user.last_name}`,
        message: form.message,
        timestamp: new Date()
            .toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
            })
            .toUpperCase()
            .replace(/\.\s*/g, ''),
        avatar: user.first_name[0].toUpperCase(),
    };

    // Agregar mensaje localmente
    messagesRef.value.push(nuevoMensaje);
    form.message = '';
    scrollToBottom();

    try {
        console.log('Enviando mensaje');
        await axios.post(route('chat'), nuevoMensaje);
        console.log('Mensaje enviado');
    } catch (error) {
        console.error('error ', error);
    }
};

// Función para determinar si el mensaje es del usuario actual
const isOwnMessage = (message: Message) => {
    return message.user_id === user.id;
};

// Escuchar eventos de chat
useEcho(
    'chat.global', // Nombre del canal privado (ej. 'users.1')
    'ChatEventClass', // Nombre del evento de transmisión (definido en broadcastAs())
    (e: MessageWebSocket) => {
        if (e.user_id == user.id) return;

        messagesRef.value.push({
            id: messagesRef.value.length + 1,
            user_id: e.user_id,
            username: e.username,
            message: e.message,
            timestamp: e.timestamp,
            avatar: e.avatar,
        });
        scrollToBottom();
    },
);

onMounted(() => {
    scrollToBottom();
});
</script>

<template>
    <Head title="Chat Grupal" />

    <div class="flex h-screen bg-gray-900">
        <!-- Contenedor principal del chat -->
        <div class="mx-auto flex w-full max-w-4xl flex-col bg-gray-800 shadow-2xl">
            <!-- Header del chat -->
            <div class="flex items-center justify-between bg-blue-900/90 px-6 py-4 text-white">
                <div>
                    <h1 class="text-xl font-semibold">Chat Grupal</h1>
                    <p class="text-sm text-blue-300">{{ messagesRef.length }} mensajes</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm">Usuario: {{ user.id }}</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white">
                        {{ user.first_name[0].toUpperCase() }}
                    </div>
                </div>
            </div>

            <!-- Área de mensajes -->
            <div ref="chatContainer" class="flex-1 space-y-4 overflow-y-auto bg-gray-900 p-4" style="height: calc(100vh - 140px)">
                <div
                    v-for="message in messagesRef"
                    :key="message.id"
                    :class="['flex items-start space-x-3', isOwnMessage(message) ? 'justify-end' : 'justify-start']"
                >
                    <!-- Avatar (solo para mensajes de otros) -->
                    <div
                        v-if="!isOwnMessage(message)"
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-600 text-white"
                    >
                        {{ message.avatar }}
                    </div>

                    <!-- Contenido del mensaje -->
                    <div
                        :class="[
                            'max-w-xs rounded-lg px-4 py-2 lg:max-w-md',
                            isOwnMessage(message) ? 'bg-blue-600 text-white' : 'border border-gray-600/30 bg-gray-700/80 shadow-sm',
                        ]"
                    >
                        <!-- Nombre del usuario (solo para mensajes de otros) -->
                        <p v-if="!isOwnMessage(message)" class="mb-1 text-xs font-medium text-gray-300">
                            {{ message.username }}
                        </p>

                        <!-- Mensaje -->
                        <p class="text-sm text-white">{{ message.message }}</p>

                        <!-- Timestamp -->
                        <p :class="['mt-1 text-xs', isOwnMessage(message) ? 'text-blue-200' : 'text-gray-400']">
                            {{ message.timestamp }}
                        </p>
                    </div>

                    <!-- Avatar (solo para mensajes propios) -->
                    <div
                        v-if="isOwnMessage(message)"
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-500 text-white"
                    >
                        {{ message.avatar }}
                    </div>
                </div>
            </div>

            <!-- Formulario de envío -->
            <div class="border-t border-gray-700 bg-gray-800/80 p-4 backdrop-blur-sm">
                <form @submit.prevent="enviarMensaje" class="flex items-center space-x-3">
                    <Input
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
        </div>
    </div>
</template>

<style scoped>
/* Estilos para el scroll personalizado */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #1f2937;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #4b5563;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
}
</style>
