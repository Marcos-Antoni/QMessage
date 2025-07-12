<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

import AuthForm from '@/layouts/auth/AuthFrom.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

interface limitCardParams {
    event: { target: HTMLInputElement };
    number: number;
    from: 'card' | 'cvc';
}

defineProps<{ error: string }>();

const form = useForm({
    name: '',
    card: '',
    month: 0,
    year: 0,
    cvc: '',
    payment: '',
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
</script>

<template>
    <Head title="Payment" />
    <AuthForm title="Método de pago" @submit="submit">
        <div class="space-y-6">
            <InputError :message="form.errors.payment" />
            <!-- Card Number -->
            <div class="space-y-2">
                <Label for="card">Número de tarjeta</Label>
                <Input
                    id="card"
                    type="text"
                    required
                    v-model="form.card"
                    placeholder="1234 1234 1234 1234"
                    class="py-6 text-base"
                    @input="limitCard({ event: $event, number: 16, from: 'card' })"
                />
                <InputError :message="form.errors.card" />
            </div>

            <!-- Cardholder Name -->
            <div class="space-y-2">
                <Label for="name">Nombre del titular</Label>
                <Input id="name" type="text" required v-model="form.name" placeholder="Como aparece en la tarjeta" class="py-6 text-base" />
                <InputError :message="form.errors.name" />
            </div>

            <!-- Expiry and CVC -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Expiry Date -->
                <div class="space-y-2">
                    <Label for="month">Vencimiento</Label>
                    <div class="flex gap-2">
                        <Select v-model="form.month" class="text-center text-base" required>
                            <SelectTrigger>
                                <SelectValue placeholder="MM" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="month in 12" :key="month" :value="month">{{ month }}</SelectItem>
                            </SelectContent>
                        </Select>
                        <span class="flex items-center text-gray-500">/</span>
                        <Select v-model="form.year" class="text-center text-base" required>
                            <SelectTrigger>
                                <SelectValue placeholder="AA" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="year in 12"
                                    :key="year + new Date().getFullYear()"
                                    :value="year + new Date().getFullYear() - 2001"
                                    >{{ year + new Date().getFullYear() - 2001 }}</SelectItem
                                >
                            </SelectContent>
                        </Select>
                    </div>
                    <InputError :message="form.errors.month || form.errors.year" />
                </div>

                <!-- CVC -->
                <div class="space-y-2">
                    <Label for="cvc">CVC</Label>
                    <Input
                        id="cvc"
                        type="number"
                        required
                        v-model="form.cvc"
                        placeholder="CVC"
                        class="py-[8px] text-base"
                        @input="limitCard({ event: $event, number: 4, from: 'cvc' })"
                    />
                    <InputError :message="form.errors.cvc" />
                </div>
            </div>

            <!-- Submit Button -->
            <Button type="submit" class="w-full py-6 text-base font-medium" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="mr-2 h-5 w-5 animate-spin" />
                {{ form.processing ? 'Procesando...' : 'Agregar método de pago' }}
            </Button>
        </div>
    </AuthForm>
</template>

<style scoped>
input[type='number']::-webkit-outer-spin-button,
input[type='number']::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type='number'] {
    -moz-appearance: textfield;
}
</style>
