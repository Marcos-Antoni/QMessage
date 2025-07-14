<script setup lang="ts">
import AuthForm from '@/layouts/auth/AuthFrom.vue';
import FormInput from '@/layouts/auth/FormInput.vue';
import SubmitButton from '@/layouts/auth/SubmitButton.vue';
import FormFooter from '@/layouts/auth/FormFooter.vue';
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
    <Head title="Registro" />

    <AuthForm title="Registrarse" @submit="submit">
        <div class="grid gap-6">
            <div class="flex flex-col gap-6 sm:flex-row sm:gap-2">
                <FormInput
                    id="first_name"
                    label="Nombre"
                    type="text"
                    :required="true"
                    :autofocus="true"
                    :tabindex="1"
                    autocomplete="given-name"
                    v-model="form.first_name"
                    placeholder="Nombre"
                    :error="form.errors.first_name"
                    input-class="w-full"
                />

                <FormInput
                    id="last_name"
                    label="Apellido"
                    type="text"
                    :required="true"
                    :tabindex="2"
                    autocomplete="family-name"
                    v-model="form.last_name"
                    placeholder="Apellido"
                    :error="form.errors.last_name"
                    input-class="w-full"
                />
            </div>

            <FormInput
                id="email"
                label="Correo electrónico"
                type="email"
                :required="true"
                :tabindex="3"
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
                :tabindex="4"
                autocomplete="new-password"
                v-model="form.password"
                placeholder="••••••••"
                :error="form.errors.password"
            />

            <FormInput
                id="password_confirmation"
                label="Confirmar contraseña"
                type="password"
                :required="true"
                :tabindex="5"
                autocomplete="new-password"
                v-model="form.password_confirmation"
                placeholder="••••••••"
                :error="form.errors.password_confirmation"
            />

            <SubmitButton
                :processing="form.processing"
                label="Crear cuenta"
                loading-label="Creando cuenta..."
                :tabindex="6"
                class="mt-2"
            />
        </div>

        <FormFooter
            question="¿Ya tienes una cuenta?"
            link-text="Iniciar sesión"
            :link-href="route('login')"
            :link-tabindex="7"
        />
    </AuthForm>
</template>
