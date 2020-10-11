<template>
  <span class="relative">
    <button
      :class="buttonClass"
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
      <div class="bg-gray-900 rounded-md shadow-xs">
        <slot name="content" />
      </div>
    </div>
  </span>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    buttonClass: String,
  },
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