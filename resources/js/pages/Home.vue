<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Chat Grupal Premium" />

    <div class="min-h-screen bg-gray-900 text-white">
        <div class="container mx-auto flex min-h-screen flex-col items-center justify-center px-4 py-16">
            <div class="w-full max-w-3xl overflow-hidden rounded-xl bg-gray-800 shadow-2xl">
                <div class="p-8 md:p-12">
                    <div class="mb-8 text-center">
                        <h1 class="mb-4 text-4xl font-bold text-blue-400 md:text-5xl">Chat Grupal Premium</h1>
                        <p class="mb-6 text-xl text-gray-300">Conéctate y comparte con la comunidad</p>

                        <div class="mb-8 inline-flex items-center rounded-full border border-blue-400/30 bg-blue-900/30 px-6 py-2">
                            <span class="font-medium text-blue-300">Solo 1Q por entrar</span>
                        </div>
                    </div>

                    <div class="grid items-center gap-8 md:grid-cols-2">
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
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
                                    <h3 class="text-lg font-medium text-white">Acceso Ilimitado</h3>
                                    <p class="mt-1 text-gray-400">Chatea con todos los miembros</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
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
                                    <h3 class="text-lg font-medium text-white">Soporte 24/7</h3>
                                    <p class="mt-1 text-gray-400">Asistencia cuando la necesites</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border border-gray-600/30 bg-gray-700/50 p-6">
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-600 font-bold text-white"
                                    >
                                        <span>1Q</span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-300">Pago único de</p>
                                        <p class="font-bold text-white">1 Quetzal</p>
                                    </div>
                                </div>
                                <Link
                                    :href="route('register')"
                                    class="block w-full rounded-lg bg-blue-600 px-6 py-3 text-center font-bold text-white transition duration-200 hover:bg-blue-700"
                                >
                                    Unirme Ahora
                                </Link>
                                <p class="text-center text-xs text-gray-400">
                                    ¿Ya tienes cuenta?
                                    <Link :href="route('login')" class="text-blue-400 hover:underline">Inicia sesión</Link>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
