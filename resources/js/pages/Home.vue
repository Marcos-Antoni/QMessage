<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import HomeHeader from '@/layouts/app/home/HomeHeader.vue';
import FeatureList from '@/layouts/app/home/FeatureList.vue';
import PricingCard from '@/layouts/app/home/PricingCard.vue';

defineProps<{
    isLogged: boolean;
}>();

const features = [
    {
        title: 'Acceso Ilimitado',
        description: 'Chatea con todos los miembros'
    },
    {
        title: 'Soporte 24/7',
        description: 'Asistencia cuando la necesites'
    }
];
</script>

<template>
    <Head title="Chat Grupal Premium" />

    <div class="min-h-screen bg-gray-900 text-white">
        <div class="container mx-auto flex min-h-screen flex-col items-center justify-center px-4 py-16">
            <div class="w-full max-w-3xl overflow-hidden rounded-xl bg-gray-800 shadow-2xl">
                <div class="p-8 md:p-12">
                    <HomeHeader 
                        title="Chat Grupal Premium"
                        description="Conéctate y habla en el chat grupal"
                        price-text="Solo Q1 por entrar"
                    />

                    <div class="grid items-center gap-8 md:grid-cols-2">
                        <FeatureList :features="features" />
                        <PricingCard 
                            price="Q1"
                            price-description="Pago único de"
                            :is-logged="isLogged"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
