<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthForm from '@/layouts/auth/AuthFrom.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Iniciar sesión" />

    <AuthForm title="Iniciar sesión" @submit="submit">
        <div class="space-y-6">
            <!-- Email Field -->
            <div class="space-y-2">
                <Label class="text-gray-300" for="email">Correo electrónico</Label>
                <Input
                    id="email"
                    type="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    v-model="form.email"
                    placeholder="tucorreo@ejemplo.com"
                    class="border-gray-600/50 bg-gray-700/50 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30"
                />
                <InputError :message="form.errors.email" />
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <Label class="text-gray-300" for="password">Contraseña</Label>
                </div>
                <Input
                    id="password"
                    type="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    v-model="form.password"
                    placeholder="••••••••"
                    class="border-gray-600/50 bg-gray-700/50 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30"
                />
                <InputError :message="form.errors.password" />
            </div>

            <!-- Submit Button -->
            <Button
                type="submit"
                class="w-full bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500/30"
                :disabled="form.processing"
                :tabindex="4"
            >
                <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                {{ form.processing ? 'Iniciando sesión...' : 'Iniciar sesión' }}
            </Button>
        </div>

        <!-- Registration Link -->
        <div class="mt-6 text-center text-sm text-gray-400">
            ¿No tienes una cuenta?
            <TextLink :href="route('register')" class="font-medium text-white hover:underline" :tabindex="5"> Regístrate </TextLink>
        </div>
    </AuthForm>
</template>
