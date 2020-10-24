<template>
  <nav
    class="flex -mb-px space-x-6 overflow-x-scroll border-b border-gray-900 sm:overflow-x-auto sm:space-x-8"
  >
    <button
      @click="selectTab(index)"
      v-for="(tab, index) in tabs"
      :key="index"
      :class="{
        'px-1 py-4 text-base font-medium leading-5 text-indigo-400 whitespace-no-wrap border-b-2 border-indigo-500 focus:outline-none focus:text-indigo-800 focus:border-indigo-700':
          selectedIndex === index,
        'px-1 py-4 text-base font-medium leading-5 text-gray-400 whitespace-no-wrap border-b-2 border-transparent hover:text-white hover:border-gray-300 focus:outline-none focus:text-white focus:border-gray-300':
          selectedIndex !== index,
      }"
    >
      {{ tab.props.title }}
    </button>
  </nav>
  <slot />
</template>
<script>
import { computed, onMounted, provide, reactive, ref, toRefs } from "vue";
export default {
  setup(props, context) {
    const tabs = context.slots.default();
    const selectedIndex = ref(0);
    const state = reactive({
      active: computed(() => selectedIndex.value),
    });

    provide("tabs", {
      state,
    });

    function selectTab(index) {
      selectedIndex.value = index;
    }

    return {
      tabs,
      selectedIndex,
      selectTab,
    };
  },
};
</script>