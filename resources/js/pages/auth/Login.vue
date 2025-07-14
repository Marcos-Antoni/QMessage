<script setup lang="ts">
import AuthForm from '@/layouts/auth/AuthFrom.vue';
import FormInput from '@/layouts/auth/FormInput.vue';
import SubmitButton from '@/layouts/auth/SubmitButton.vue';
import FormFooter from '@/layouts/auth/FormFooter.vue';
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
    <Head title="Iniciar sesión" />

    <AuthForm title="Iniciar sesión" @submit="submit">
        <div class="space-y-6">
            <FormInput
                id="email"
                label="Correo electrónico"
                type="email"
                :required="true"
                :autofocus="true"
                :tabindex="1"
                autocomplete="email"
                v-model="form.email"
                placeholder="tucorreo@ejemplo.com"
                :error="form.errors.email"
            />

            <FormInput
                id="password"
                label="Contraseña"
                type="password"
                :required="true"
                :tabindex="2"
                autocomplete="current-password"
                v-model="form.password"
                placeholder="••••••••"
                :error="form.errors.password"
            />

            <SubmitButton
                :processing="form.processing"
                label="Iniciar sesión"
                loading-label="Iniciando sesión..."
                :tabindex="4"
            />
        </div>

        <FormFooter
            question="¿No tienes una cuenta?"
            link-text="Regístrate"
            :link-href="route('register')"
            :link-tabindex="5"
        />
    </AuthForm>
</template>
