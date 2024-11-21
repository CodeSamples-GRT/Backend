<script setup>
import { computed } from 'vue';

const props = defineProps({
  message: {
    type: Object,
    required: true,
  },
});

const body = computed(() => props.message.body.replaceAll('\n', '<br>'));
const createdAt = computed(() => {
  return new Intl.DateTimeFormat('en-GB', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
    hour12: false,
  }).format(new Date(props.message.created_at));
});
</script>

<template>
  <div
    class="flex items-start gap-2.5"
    :class="{ 'justify-end': message.from_me }"
  >
    <img
      v-if="!message.from_me"
      class="w-8 h-8 rounded-full"
      :src="message.user.avatar"
      alt="Avatar"
    />
    <div class="flex flex-col w-full max-w-[320px] leading-1.5">
      <div
        class="flex items-center space-x-2 rtl:space-x-reverse pb-1"
        :class="{ 'justify-end': message.from_me }"
      >
        <span
          v-if="!message.from_me"
          class="text-sm font-semibold text-gray-900 dark:text-white"
          >{{ message.user.name }}</span
        >
        <span class="text-xs font-normal text-gray-500 dark:text-gray-400">{{
          createdAt
        }}</span>
      </div>

      <div
        :class="[
          'px-4 py-3',
          message.from_me
            ? 'border-sky-200 bg-sky-100 rounded-t-xl rounded-bl-xl'
            : 'border-gray-200 bg-gray-100 rounded-b-xl rounded-tr-xl',
        ]"
      >
        <p
          class="text-sm font-normal text-gray-900 dark:text-white"
          v-html="body"
        />
      </div>
    </div>
  </div>
</template>
