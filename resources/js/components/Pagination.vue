<template>
  <nav
    class="flex items-center justify-between px-4 mt-6 border-t border-gray-900 sm:px-0"
  >
    <div class="flex flex-1 w-0">
      <button
        type="button"
        @click="handleClick(prevPageUrl)"
        class="inline-flex items-center pt-4 pr-1 -mt-px text-sm font-medium leading-5 text-gray-300 transition duration-150 ease-in-out border-t-2 border-transparent hover:text-gray-400 hover:border-gray-500 focus:outline-none focus:border-gray-500"
      >
        <svg
          class="w-5 h-5 mr-3 text-gray-400"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
            clip-rule="evenodd"
          />
        </svg>
        Précédent
      </button>
    </div>
    <div class="hidden md:flex">
      <button
        type="button"
        @click="handleClick(link.url)"
        :key="index"
        v-for="(link, index) in numberLinks"
        :class="{
          'text-indigo-400  border-indigo-500 focus:text-indigo-800 focus:border-indigo-700':
            link.active,
          'text-gray-300 border-transparent  hover:text-gray-400 hover:border-gray-500 focus:border-gray-500': !link.active,
        }"
        class="inline-flex items-center px-4 pt-4 -mt-px text-sm font-medium leading-5 transition duration-150 ease-in-out border-t-2 focus:outline-none"
      >
        {{ link.label }}
      </button>
    </div>
    <div class="flex justify-end flex-1 w-0">
      <button
        type="button"
        @click="handleClick(nextPageUrl)"
        class="inline-flex items-center pt-4 pl-1 -mt-px text-sm font-medium leading-5 text-gray-300 transition duration-150 ease-in-out border-t-2 border-transparent hover:text-gray-400 hover:border-gray-500 focus:outline-none focus:border-gray-500"
      >
        Suivant
        <svg
          class="w-5 h-5 ml-3 text-gray-400"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
            clip-rule="evenodd"
          />
        </svg>
      </button>
    </div>
  </nav>
</template>
<script>
import { computed } from "vue";
export default {
  props: {
    links: Array,
    prevPageUrl: String,
    nextPageUrl: String,
  },
  setup(props, context) {
    const numberLinks = computed(() => {
      return props.links.filter(
        (item) => item.label !== "Previous" && item.label !== "Next"
      );
    });
    function handleClick(url) {
      if (!url) {
        return;
      }
      context.emit("onClick", url);
    }

    return { handleClick, numberLinks };
  },
};
</script>