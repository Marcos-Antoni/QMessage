<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Home, LogOut } from 'lucide-vue-next';

defineProps({
    user: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['logout']);
</script>

<template>
    <div class="flex items-center justify-between bg-blue-900/90 px-6 py-4 text-white">
        <div class="flex items-center space-x-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white">
                {{ user.first_name[0].toUpperCase() }}
            </div>
            <h1 class="text-xl font-semibold">Chat Grupal</h1>
        </div>
        <div class="flex items-center gap-2">
            <Link
                class="flex h-full items-center gap-2 rounded bg-blue-600 p-2 text-white transition duration-200 hover:bg-blue-700"
                :href="route('home')"
            >
                <Home />
                <p class="text-xs">página principal</p>
            </Link>

            <button
                class="flex h-full items-center gap-2 rounded bg-blue-600 p-2 text-white transition duration-200 hover:bg-red-500"
                @click="$emit('logout')"
            >
                <LogOut />
                <p class="text-xs">cerrar sesión</p>
            </button>
        </div>
    </div>
</template>
