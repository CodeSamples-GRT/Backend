<script setup>
defineProps({
  users: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <h2 class="text-lg font-semibold">Users online ({{ users.length }})</h2>

  <ul class="space-y-2 mt-3">
    <li
      v-for="user in users"
      :key="user.id"
      class="bg-gray-100 rounded-lg px-3 py-1 flex items-center justify-between"
    >
      <span>{{ user.name }}</span>
      <svg
        class="size-4 animate-bounce opacity-0 transition-opacity"
        :class="{ 'opacity-100': user.typing }"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
        />
      </svg>
    </li>
  </ul>
</template>
