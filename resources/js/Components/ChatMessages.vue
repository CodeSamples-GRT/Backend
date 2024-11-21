<script setup>
import { ref, useSlots, watch } from 'vue';
import { useIntersectionObserver } from '@vueuse/core';
import ChatMessage from '@/Components/ChatMessage.vue';
import ChatScrollToEndButton from '@/Components/ChatScrollToEndButton.vue';

const props = defineProps({
  hasMore: {
    type: Boolean,
    default: true,
  },
  messages: {
    type: Array,
    required: true,
  },
});
const emit = defineEmits(['load-more']);

const list = ref(null);
const target = ref(null);
const showToEndBtn = ref(false);

const { stop } = useIntersectionObserver(target, ([{ isIntersecting }]) => {
  if (isIntersecting) {
    emit('load-more');
  }
});

watch(
  () => props.hasMore,
  (hasMore) => {
    if (!hasMore) {
      stop();
    }
  }
);

const scrollListToEnd = () => {
  list.value.firstElementChild?.scrollIntoView();
  scrollToEndButtonPosition.value = 0;
};

const scrollToEndButtonPosition = ref(0);
const handleScroll = (e) => {
  scrollToEndButtonPosition.value = e.target.scrollTop * -1;
  showToEndBtn.value = e.target.scrollTop !== 0;
};

const slots = useSlots();
</script>

<template>
  <div
    ref="list"
    class="relative h-64 border border-gray-200 rounded-lg pl-4 pr-20 py-4 overflow-y-auto flex flex-col-reverse gap-3"
    @scroll="handleScroll"
  >
    <p v-show="slots.typing" class="mt-4 text-xs italic text-gray-700">
      <slot name="typing" />
    </p>
    <ChatMessage
      v-for="message in messages"
      :key="message.id"
      :message="message"
    />
    <span v-show="hasMore" ref="target" class="translate-y-20" />

    <ChatScrollToEndButton
      v-show="showToEndBtn"
      :position-bottom="scrollToEndButtonPosition"
      @click="scrollListToEnd"
    />
  </div>
</template>
