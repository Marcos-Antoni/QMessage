<script setup lang="ts">
import ChatHeader from '@/layouts/app/chat/ChatHeader.vue';
import MessageInput from '@/layouts/app/chat/MessageInput.vue';
import MessageList from '@/layouts/app/chat/MessageList.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
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
const chatContainer = ref<HTMLElement | null>(null);

// Función para desplazar hacia abajo
const scrollToBottom = () => {
    nextTick(() => {
        if (chatContainer.value) {
            chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
        }
    });
};

const enviarMensaje = async (messageText: string) => {
    if (!messageText.trim()) return;

    const message = newMessage(messageText);

    // Agregar mensaje localmente
    messagesRef.value.push(message);
    scrollToBottom();

    try {
        await axios.post(route('chat'), message);
    } catch (error) {
        console.error('Error al enviar mensaje:', error);
    }
};

const newMessage = (messageText: string): Message => {
    return {
        id: messagesRef.value.length + 1,
        user_id: user.id,
        username: `${user.first_name} ${user.last_name}`,
        message: messageText,
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
};

const logout = () => {
    router.post(route('logout'));
};

// Escuchar eventos de chat
useEcho('chat.global', 'ChatEventClass', (e: MessageWebSocket) => {
    if (e.user_id == user.id) return;

    const message = {
        id: messagesRef.value.length + 1,
        user_id: e.user_id,
        username: e.username,
        message: e.message,
        timestamp: new Date()
            .toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
            })
            .toUpperCase()
            .replace(/\.\s*/g, ''),
        avatar: e.avatar,
    };

    messagesRef.value.push(message);
    scrollToBottom();
});

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
            <ChatHeader :user="user" @logout="logout" />

            <!-- Área de mensajes -->
            <div ref="chatContainer" class="flex-1 space-y-4 overflow-y-auto bg-gray-900 p-4" style="height: calc(100vh - 140px)">
                <MessageList :messages="messagesRef" />
            </div>

            <!-- Formulario de envío -->
            <MessageInput @send="enviarMensaje" />
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
    background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background-color: #3b82f6;
    border-radius: 20px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background-color: #2563eb;
}
</style>
