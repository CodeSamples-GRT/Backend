import { defineStore } from 'pinia';
import { ref } from 'vue';
import { httpRequest } from '@/api/httpRequest.js';

export const useChatMessageStore = defineStore('chatMessage', () => {
  const messages = ref([]);
  const nextCursor = ref(undefined);
  const hasMore = ref(true);

  const fetchMessages = async (roomSlug) => {
    if (!hasMore.value) {
      return;
    }
    const path =
      `/chats/${roomSlug}/messages` +
      (nextCursor.value ? `?cursor=${nextCursor.value}` : '');

    const { data: rsp } = await httpRequest.get(path);

    messages.value.push(...rsp.data);
    nextCursor.value = rsp.meta.next_cursor || undefined;
    hasMore.value = !!nextCursor.value;
  };

  const storeMessage = async (roomSlug, payload) => {
    const { data } = await httpRequest.post(
      `/chats/${roomSlug}/messages`,
      payload
    );
    pushMessage(data);
  };

  const pushMessage = (message) => {
    messages.value.unshift(message);
  };

  const resetChatMessage = () => {
    messages.value = [];
    nextCursor.value = undefined;
    hasMore.value = true;
  };

  return {
    messages,
    nextCursor,
    hasMore,
    fetchMessages,
    storeMessage,
    pushMessage,
    resetChatMessage,
  };
});
