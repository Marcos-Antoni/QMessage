<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';

defineProps<{
    question: string;
    linkText: string;
    linkHref: string;
    linkTabindex?: number;
}>();
</script>

<template>
    <div class="mt-6 text-center text-sm text-gray-400">
        {{ question }}
        <TextLink :href="linkHref" class="font-medium text-white hover:underline" :tabindex="linkTabindex">
            {{ linkText }}
        </TextLink>
    </div>
</template>
