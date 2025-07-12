<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { useEcho } from '@laravel/echo-vue'; // Importa useEcho
import axios from 'axios';

const form = useForm({});

const enviarMensaje = async () => {
    try {
        await axios.post(route('chat'));
        console.log('Mensaje enviado');
    } catch (error) {
        console.error('error ', error);
    }
};

useEcho(
    'order.user', // Nombre del canal privado (ej. 'users.1')
    'OrderShipmentStatusUpdated', // Nombre del evento de transmisión (definido en broadcastAs())
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
            <button class="pointer mt-4 rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-900" @click="enviarMensaje">Enviar mensaje</button>
        </div>
    </div>
</template>
