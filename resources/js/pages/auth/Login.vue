<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthForm from '@/layouts/auth/AuthFrom.vue';

import { Head, useForm } from '@inertiajs/vue3';

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
    <Head title="Log in" />

    <AuthForm title="Iniciar sesión" @submit="submit">
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="email">Correo</Label>
                <Input
                    id="email"
                    type="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    v-model="form.email"
                    placeholder="email@example.com"
                />
                <InputError :message="form.errors.email" />
            </div>

            <div class="grid gap-2">
                <Input
                    id="password"
                    type="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    v-model="form.password"
                    placeholder="Contraseña"
                />
                <InputError :message="form.errors.password" />
            </div>

            <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Iniciar sesión
            </Button>
        </div>

        <div class="text-center text-sm text-muted-foreground">
            No tienes una cuenta?
            <TextLink :href="route('register')" :tabindex="5">Registrarse</TextLink>
        </div>
    </AuthForm>
</template>
