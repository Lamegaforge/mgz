<template>
  <div v-show="isActive">
    <slot />
  </div>
</template>
<script>
import { computed, inject, onUpdated, reactive, ref, toRefs } from "vue";
import { Tabs } from "./Tabs.vue";

export default {
  props: {
    title: String,
    value: Number,
  },

  setup(props) {
    const tabs = inject("tabs", {
      state: reactive({
        active: null,
      }),
    });
    const state = reactive({
      isActive: computed(() => tabs.state.active === props.value),
    });
    return {
      ...toRefs(state),
    };
  },
};
</script>