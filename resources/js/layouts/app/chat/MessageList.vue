<script setup lang="ts">
import MessageItem from './MessageItem.vue';
import { Message } from './types';

defineProps<{
    messages: Message[];
}>();
</script>

<template>
    <MessageItem v-for="message in messages" :key="message.id" :message="message" />
</template>
