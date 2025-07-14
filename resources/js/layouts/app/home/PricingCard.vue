<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    price: string;
    priceDescription: string;
    isLogged: boolean;
}>();
</script>

<template>
    <div class="rounded-lg border border-gray-600/30 bg-gray-700/50 p-6">
        <div class="space-y-4">
            <div class="flex items-center space-x-3">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-600 font-bold text-white">
                    <span>{{ price }}</span>
                </div>
                <div>
                    <p class="text-sm text-gray-300">{{ priceDescription }}</p>
                    <p class="font-bold text-white">1 Quetzal</p>
                </div>
            </div>
            <div v-if="isLogged">
                <Link
                    :href="route('chat')"
                    class="block w-full rounded-lg bg-blue-600 px-6 py-3 text-center font-bold text-white transition duration-200 hover:bg-blue-700"
                >
                    Regresar al Chat
                </Link>
            </div>
            <div class="space-y-2" v-else>
                <Link
                    :href="route('register')"
                    class="block w-full rounded-lg bg-blue-600 px-6 py-3 text-center font-bold text-white transition duration-200 hover:bg-blue-700"
                >
                    Unirme Ahora
                </Link>
                <p class="text-center text-xs text-gray-400">¿Ya tienes cuenta?</p>
                <Link
                    :href="route('login')"
                    class="block w-full rounded-lg bg-blue-600 px-6 py-3 text-center font-bold text-white transition duration-200 hover:bg-blue-700"
                >
                    Iniciar sesión
                </Link>
            </div>
        </div>
    </div>
</template>
