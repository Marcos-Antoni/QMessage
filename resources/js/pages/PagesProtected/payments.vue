<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AuthForm from '@/layouts/auth/AuthFrom.vue';
import FormInput from '@/layouts/auth/FormInput.vue';
import SubmitButton from '@/layouts/auth/SubmitButton.vue';
import { Head, router, useForm } from '@inertiajs/vue3';

interface limitCardParams {
    event: { target: HTMLInputElement };
    number: number;
    from: 'card' | 'cvc' | 'zip';
}

defineProps<{ error: string }>();

const form = useForm({
    name: '',
    card: '',
    month: 0,
    year: 0,
    cvc: '',
    payment: '',

    city: '',
    state: '',
    country: '',
    zip: '',
});

const submit = async () => {
    const res = await form.post(route('payments'), {
        onFinish: () => form.reset('cvc', 'card', 'month', 'year'),
    });

    console.log(res);
};

const limitCard = ({ event, number, from }: limitCardParams) => {
    if (event.target.value.length > number) {
        form[from] = event.target.value.slice(0, number);
    }
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <Head title="Payment" />
    <AuthForm title="Método de pago" @submit="submit">
        <div class="space-y-6">
            <InputError :message="form.errors.payment" />

            <!-- Cardholder Name -->
            <FormInput
                id="name"
                label="Nombre del titular"
                type="text"
                :required="true"
                v-model="form.name"
                placeholder="Como aparece en la tarjeta"
                :error="form.errors.name"
                input-class="py-3 text-base"
            />

            <!-- Address -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <FormInput
                    id="city"
                    label="Ciudad"
                    type="text"
                    :required="true"
                    v-model="form.city"
                    placeholder="Ciudad"
                    :error="form.errors.city"
                    input-class="py-3 text-base"
                />

                <FormInput
                    id="state"
                    label="Estado"
                    type="text"
                    :required="true"
                    v-model="form.state"
                    placeholder="Estado"
                    :error="form.errors.state"
                    input-class="py-3 text-base"
                />

                <FormInput
                    id="country"
                    label="País"
                    type="text"
                    :required="true"
                    v-model="form.country"
                    placeholder="País"
                    :error="form.errors.country"
                    input-class="py-3 text-base"
                />

                <FormInput
                    id="zip"
                    label="Código postal"
                    type="text"
                    :required="true"
                    v-model="form.zip"
                    placeholder="Código postal"
                    :error="form.errors.zip"
                    input-class="py-3 text-base"
                    @input="limitCard({ event: $event, number: 5, from: 'zip' })"
                    :maxlength="5"
                />
            </div>

            <!-- Card Number -->
            <FormInput
                id="card"
                label="Número de tarjeta"
                type="text"
                :required="true"
                v-model="form.card"
                placeholder="1234 1234 1234 1234"
                :error="form.errors.card"
                input-class="py-3 text-base"
                @input="limitCard({ event: $event, number: 16, from: 'card' })"
                :maxlength="16"
            />

            <!-- Expiry and CVC -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Expiry Date -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-300">Vencimiento</label>
                    <div class="flex gap-2">
                        <Select v-model="form.month" required>
                            <SelectTrigger class="border-gray-600/50 bg-gray-700/50 text-white focus:ring-2 focus:ring-blue-500/30">
                                <SelectValue placeholder="MM" class="text-center" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="month in 12" :key="month" :value="month">
                                    {{ String(month).padStart(2, '0') }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <span class="flex items-center text-gray-500">/</span>
                        <Select v-model="form.year" required>
                            <SelectTrigger class="border-gray-600/50 bg-gray-700/50 text-white focus:ring-2 focus:ring-blue-500/30">
                                <SelectValue placeholder="AA" class="text-center" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="year in 12" :key="year" :value="year + new Date().getFullYear() - 2001">
                                    {{ String(year + new Date().getFullYear() - 2001).slice(-2) }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <InputError :message="form.errors.month || form.errors.year" />
                </div>

                <!-- CVC -->
                <FormInput
                    id="cvc"
                    label="CVC"
                    type="text"
                    :required="true"
                    v-model="form.cvc"
                    placeholder="123"
                    :error="form.errors.cvc"
                    input-class="py-3 text-base"
                    @input="limitCard({ event: $event, number: 4, from: 'cvc' })"
                    :maxlength="4"
                />
            </div>

            <!-- Submit Button -->
            <SubmitButton
                :processing="form.processing"
                :label="'Agregar método de pago'"
                :loading-label="'Procesando...'"
                class="w-full py-3 text-base font-medium"
            />

            <p class="mt-4 text-center text-sm text-white">
                ¿Quieres cambiar de cuenta?
                <span class="text-decoration-none cursor-pointer font-medium text-gray-300 hover:underline" @click="logout">cambiar de cuenta</span>
            </p>
        </div>
    </AuthForm>
</template>

<style scoped>
input[type='number']::-webkit-outer-spin-button,
input[type='number']::-webkit-inner-spin-button {
    -webkit-appearance: none;
    appearance: none;
    margin: 0;
}

input[type='number'] {
    -moz-appearance: textfield;
    appearance: textfield;
}
</style>
