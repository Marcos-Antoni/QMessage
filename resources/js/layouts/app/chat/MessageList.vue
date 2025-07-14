<script setup lang="ts">
import MessageItem from './MessageItem.vue';
import { Message } from './types';

const props = defineProps<{
    messages: Message[];
    currentUserId: number;
}>();

const isOwnMessage = (message: Message) => {
    return message.user_id === props.currentUserId;
};
</script>

<template>
    <MessageItem v-for="message in messages" :key="message.id" :message="message" :is-own-message="isOwnMessage(message)" />
</template>
