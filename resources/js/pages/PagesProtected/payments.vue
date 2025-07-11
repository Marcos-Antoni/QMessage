<script setup lang="ts">
defineProps<{ userName: string }>();
</script>

<template>
    <div class="flex h-screen items-center justify-center">
        <h1 class="text-6xl">Hola mundo {{ userName }}</h1>
    </div>
</template>

<style scoped></style>
