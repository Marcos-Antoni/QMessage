<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    processing: boolean;
    label: string;
    loadingLabel?: string;
    class?: string;
}>();
</script>

<template>
    <Button
        type="submit"
        :class="[
            'w-full bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500/30',
            $props.class,
        ]"
        :disabled="processing"
    >
        <LoaderCircle v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
        {{ processing ? loadingLabel || label : label }}
    </Button>
</template>
