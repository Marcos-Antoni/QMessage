<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import AuthForm from '@/layouts/auth/AuthFrom.vue';

import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <AuthForm title="Registrarse" @submit="submit">
        <div class="grid gap-6">
            <div class="flex flex-col gap-6 sm:flex-row sm:gap-2">
                <div class="grid w-full gap-2 sm:w-1/2">
                    <Label class="text-gray-300" for="first_name">Nombre</Label>
                    <Input
                        id="first_name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="first_name"
                        v-model="form.first_name"
                        placeholder="Nombre"
                        class="border-gray-600/50 bg-gray-700/50 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30"
                    />
                    <InputError :message="form.errors.first_name" />
                </div>

                <div class="grid w-full gap-2 sm:w-1/2">
                    <Label class="text-gray-300" for="last_name">Apellido</Label>
                    <Input
                        id="last_name"
                        type="text"
                        required
                        :tabindex="2"
                        autocomplete="last_name"
                        v-model="form.last_name"
                        placeholder="Apellido"
                        class="border-gray-600/50 bg-gray-700/50 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30"
                    />
                    <InputError :message="form.errors.last_name" />
                </div>
            </div>

            <div class="grid gap-2">
                <Label class="text-gray-300" for="email">Correo</Label>
                <Input
                    id="email"
                    type="email"
                    required
                    :tabindex="3"
                    autocomplete="email"
                    v-model="form.email"
                    placeholder="email@example.com"
                    class="border-gray-600/50 bg-gray-700/50 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30"
                />
                <InputError :message="form.errors.email" />
            </div>

            <div class="grid gap-2">
                <Label class="text-gray-300" for="password">Contraseña</Label>
                <Input
                    id="password"
                    type="password"
                    required
                    :tabindex="4"
                    autocomplete="new-password"
                    v-model="form.password"
                    placeholder="Contraseña"
                    class="border-gray-600/50 bg-gray-700/50 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30"
                />
                <InputError :message="form.errors.password" />
            </div>

            <div class="grid gap-2">
                <Label class="text-gray-300" for="password_confirmation">Confirmar contraseña</Label>
                <Input
                    id="password_confirmation"
                    type="password"
                    required
                    :tabindex="5"
                    autocomplete="new-password"
                    v-model="form.password_confirmation"
                    placeholder="Confirmar contraseña"
                    class="border-gray-600/50 bg-gray-700/50 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30"
                />
                <InputError :message="form.errors.password_confirmation" />
            </div>

            <Button
                type="submit"
                class="mt-2 w-full bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500/30"
                tabindex="6"
                :disabled="form.processing"
            >
                {{ form.processing ? 'Creando cuenta...' : 'Crear cuenta' }}
            </Button>
        </div>

        <div class="mt-6 text-center text-sm text-gray-400">
            ¿Ya tienes una cuenta?
            <TextLink :href="route('login')" class="text-decoration-none font-medium text-white hover:underline" :tabindex="7"
                >Iniciar sesión</TextLink
            >
        </div>
    </AuthForm>
</template>
