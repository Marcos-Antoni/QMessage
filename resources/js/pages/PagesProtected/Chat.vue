<script setup lang="ts">
// import { Select } from '@/components/ui/select';

defineProps<{ userEmail: string }>();
</script>
<template>
    <div class="flex h-screen items-center justify-center">
        <div class="text-center">
            <h1 class="text-6xl">Chat</h1>
            <p class="text-2xl">Welcome, {{ userEmail }}</p>
        </div>
    </div>
</template>
