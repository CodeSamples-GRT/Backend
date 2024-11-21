<script setup>
import { onUnmounted } from 'vue';
import { storeToRefs } from 'pinia';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ChatUsers from '@/Components/ChatUsers.vue';
import ChatMessages from '@/Components/ChatMessages.vue';
import ChatForm from '@/Components/ChatForm.vue';
import { useChatMessageStore } from '@/Store/chatMessage.js';
import { useChatUserStore } from '@/Store/chatUser.js';

const { messages, hasMore } = storeToRefs(useChatMessageStore());
const { fetchMessages, storeMessage, pushMessage, resetChatMessage } =
  useChatMessageStore();
const { users, typingUsersInfo } = storeToRefs(useChatUserStore());
const { setUsers, setTyping, joinUser, leaveUser } = useChatUserStore();

const props = defineProps({
  room: {
    type: Object,
    required: true,
  },
});

const handleSubmit = (message) => {
  storeMessage(props.room.slug, { body: message });
};

const handleLoadMore = () => {
  fetchMessages(props.room.slug);
};
handleLoadMore();

const channelName = `chat.${props.room.id}`;
const echoChannel = Echo.join(channelName);
echoChannel
  .listen('.chat.message.created', (e) => {
    pushMessage(e.data);
  })
  .here((users) => setUsers(users))
  .joining((user) => joinUser(user))
  .leaving((user) => leaveUser(user))
  .listenForWhisper('typing', (e) => setTyping(e))
  .error((error) => {
    console.error(error);
  });

const handleMessageTyping = (typing) => {
  const { user } = usePage().props.auth;
  echoChannel.whisper('typing', {
    id: user.id,
    typing,
  });
};

onUnmounted(() => {
  resetChatMessage();
  Echo.leave(channelName);
});
</script>

<template>
  <Head :title="`Chat ${room.name}`" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Chat "{{ room.name }}"
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-12 gap-6">
        <div
          class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-3"
        >
          <div class="p-6 text-gray-900">
            <ChatUsers :users="users" />
          </div>
        </div>
        <div
          class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-9"
        >
          <div class="p-6 space-y-3 text-gray-900">
            <ChatMessages
              :has-more="hasMore"
              :messages="messages"
              @load-more="handleLoadMore"
            >
              <template #typing>
                {{ typingUsersInfo }}
              </template>
            </ChatMessages>

            <ChatForm @submit="handleSubmit" @typing="handleMessageTyping" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
