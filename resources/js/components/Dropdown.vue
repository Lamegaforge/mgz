<template>
  <span class="relative">
    <button
      ref="trigger"
      class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded focus:outline-none focus:shadow-outline focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800"
      @click="handleClick()"
      v-click-outside="handleClose"
    >
      <slot name="trigger" />
    </button>
    <div
      :class="{
        'opacity-100 scale-100': isOpened,
        'opacity-0 scale-95 pointer-events-none': !isOpened,
      }"
      class="absolute right-0 z-10 w-56 mt-2 transition duration-75 ease-in origin-top-right transform rounded-md shadow-lg"
    >
      <div class="bg-gray-800 rounded-md shadow-xs">
        <slot name="content" />
      </div>
    </div>
  </span>
</template>
<script>
import { ref } from "vue";
export default {
  setup() {
    const isOpened = ref(false);
    const trigger = ref(null);

    function handleClick() {
      isOpened.value = !isOpened.value;
    }

    function handleClose() {
        isOpened.value = false;
    }

    return { isOpened, handleClick, handleClose };
  },
};
</script>