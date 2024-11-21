import { defineStore } from 'pinia';
import { computed, ref } from 'vue';
import { httpRequest } from '@/api/httpRequest.js';

export const useChatUserStore = defineStore('chatUser', () => {
  const users = ref([]);

  const setUsers = (inputUsers) => {
    users.value = inputUsers.map((u) => ({
      ...u,
      typing: false,
    }));
  };

  const setTyping = (data) => {
    const user = users.value.find((u) => u.id === data.id);
    if (user) {
      user.typing = data.typing;
    }
  };

  const joinUser = (user) => {
    if (users.value.findIndex((u) => u.id === user.id) === -1) {
      users.value.push(user);
    }
  };

  const leaveUser = (user) => {
    users.value = users.value.filter((u) => u.id !== user.id);
  };

  const typingUsersInfo = computed(() => {
    const typingUsers = users.value.filter((u) => u.typing).map((u) => u.name);

    if (!typingUsers.length) {
      return '';
    }
    if (typingUsers.length === 1) {
      return typingUsers.join('') + ' is typing...';
    }
    if (typingUsers.length === 2) {
      return typingUsers.join(' and ') + ' are typing...';
    }

    const countWithoutFirstTwo = typingUsers.length - 2 + 3;
    const otherWord = countWithoutFirstTwo > 1 ? 'others' : 'other';

    return `${typingUsers.slice(0, 2).join(', ')} and ${countWithoutFirstTwo} ${otherWord} are typing...`;
  });

  return {
    users,
    setUsers,
    setTyping,
    joinUser,
    leaveUser,
    typingUsersInfo,
  };
});
