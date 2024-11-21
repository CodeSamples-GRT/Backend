<script setup>
import { nextTick, ref } from 'vue';
import { useDebounceFn } from '@vueuse/core';

const emit = defineEmits(['submit', 'typing']);
const model = ref('');
const textarea = ref(null);

const setTextareaHeight = () => {
  if (textarea.value) {
    // We need to reset the height momentarily to get the correct scrollHeight for the textarea
    textarea.value.style.height = '0';
    const scrollHeight = textarea.value.scrollHeight;

    // We then set the height directly, outside the render loop
    // Trying to set this with state or a ref will product an incorrect value.
    textarea.value.style.height = scrollHeight + 2 + 'px';
  }
};

const debounceStopTyping = useDebounceFn(() => {
  emit('typing', false);
}, 3000);
const handleInput = () => {
  setTextareaHeight();
  emit('typing', true);
  debounceStopTyping();
};

const handleSubmit = (type) => {
  if (model.value) {
    emit('submit', model.value);
    emit('typing', false);
    model.value = '';
    nextTick().then(() => {
      setTextareaHeight();
    });
  }
};
</script>

<template>
  <form class="flex gap-3" @submit.prevent="handleSubmit('form')">
    <textarea
      ref="textarea"
      v-model.trim="model"
      class="grow max-h-36 resize-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
      placeholder="Type a message"
      rows="1"
      @input="handleInput"
      @keydown.enter.exact.prevent="handleSubmit('field')"
    />
    <button
      class="bg-sky-700 transition hover:bg-sky-600 active:scale-90 text-white rounded-2xl size-10 flex items-center justify-center"
      type="submit"
    >
      <svg
        class="size-5"
        fill="currentColor"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 20 20"
      >
        <path
          d="M3.105 2.288a.75.75 0 0 0-.826.95l1.414 4.926A1.5 1.5 0 0 0 5.135 9.25h6.115a.75.75 0 0 1 0 1.5H5.135a1.5 1.5 0 0 0-1.442 1.086l-1.414 4.926a.75.75 0 0 0 .826.95 28.897 28.897 0 0 0 15.293-7.155.75.75 0 0 0 0-1.114A28.897 28.897 0 0 0 3.105 2.288Z"
        />
      </svg>
    </button>
  </form>
</template>
