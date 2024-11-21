<script setup>
import { computed } from 'vue';

const props = defineProps({
  positionBottom: {
    type: Number,
    default: 0,
  },
  size: {
    type: Number,
    default: 40,
  },
});

const positionBottomIncludeSize = computed(() => props.positionBottom + 16);
</script>

<template>
  <button
    class="absolute right-4 flex justify-center items-center rounded-full bg-gray-100 transition hover:opacity-75 active:scale-90"
    type="button"
  >
    <svg
      class="size-5"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke-width="1.5"
      stroke="currentColor"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="m19.5 8.25-7.5 7.5-7.5-7.5"
      />
    </svg>
  </button>
</template>

<style scoped>
button {
  width: calc(v-bind(size) * 1px);
  height: calc(v-bind(size) * 1px);
  bottom: calc(v-bind(positionBottomIncludeSize) * 1px);
}
</style>
