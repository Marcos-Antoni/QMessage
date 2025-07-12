<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Head, useForm } from '@inertiajs/vue3';
import { useEcho } from '@laravel/echo-vue'; // Importa useEcho

import axios from 'axios';

const form = useForm({
    message: '',
});

const enviarMensaje = async () => {
    try {
        await axios.post(route('chat'), form);
        console.log('Mensaje enviado');
    } catch (error) {
        console.error('error ', error);
    }
};

useEcho(
    'chat.global', // Nombre del canal privado (ej. 'users.1')
    'ChatEventClass', // Nombre del evento de transmisión (definido en broadcastAs())
    (e) => {
        console.log('Evento de pedido procesado recibido:', e);
    },
);
</script>
<template>
    <Head title="Chat" />
    <div class="flex h-screen items-center justify-center">
        <div class="text-center">
            <h1 class="text-6xl">Chat</h1>
            <p class="text-2xl">Welcome, {{ $page.props.auth.user.id }}</p>

            <form class="mt-4 flex items-center justify-center gap-2" @submit.prevent="enviarMensaje">
                <Input type="text" v-model="form.message" />
                <button class="pointer rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-900" type="submit">Enviar mensaje</button>
            </form>
        </div>
    </div>
</template>
