<template>
  <input :value="displayValue" @input="debounceListener" />
</template>

<script>
import { ref } from "vue";

export default {
  setup(props, context) {
    let timeoutRef = null;
    const displayValue = ref("");

    const debounceListener = (e) => {
      if (timeoutRef !== null) {
        clearTimeout(timeoutRef);
      }

      displayValue.value = e.target.value;
      timeoutRef = setTimeout(() => {
        context.emit("onDebounced", e.target.value);
      }, 800);
    };

    return { displayValue, debounceListener };
  },
};
</script>