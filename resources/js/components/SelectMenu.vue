<template>
  <div class="relative z-10 block rounded-md shadow-sm">
    <input
      v-if="!selectedItem"
      @input="handleSearch($event)"
      type="text"
      placeholder="Filtrer par fiche"
      class="w-full bg-gray-900 border-transparent form-input"
    />
    <div
      v-if="selectedItem"
      class="relative w-full py-2 pl-3 pr-10 text-left transition duration-150 ease-in-out bg-gray-900 border border-transparent rounded-md sm:text-sm sm:leading-5"
    >
      <div class="flex items-center space-x-3 text-white">
        <img
          :src="selectedItem.medias?.vignette"
          alt=""
          class="flex-shrink-0 w-6 h-6 rounded-full"
        />
        <span class="block truncate">{{ selectedItem.title }}</span>
      </div>
      <span
        class="absolute inset-y-0 right-0 flex items-center pr-2 cursor-pointer"
        @click="reset()"
      >
        <svg
          class="w-5 h-5 text-gray-400"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-kinejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </span>
    </div>
    <div
      v-if="fileredItems.length && !selectedItem"
      class="absolute w-full mt-1 bg-gray-900 rounded-md shadow-lg"
    >
      <ul
        tabIndex="-1"
        role="listbox"
        aria-labelledby="listbox-label"
        aria-activedescendant="listbox-item-3"
        class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-56 focus:outline-none sm:text-sm sm:leading-5"
      >
        <li
          v-for="(item, index) in fileredItems"
          :key="index"
          @click="handleClick(item)"
          id="listbox-item-0"
          role="option"
          class="relative py-2 pl-3 text-gray-200 cursor-pointer select-none hover:bg-gray-800 pr-9"
        >
          <div class="flex items-center space-x-3">
            <img
              :src="item.medias?.vignette"
              alt=""
              class="flex-shrink-0 w-6 h-6 rounded-full"
            />
            <span class="block font-normal truncate">{{ item.title }}</span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    items: {
      type: Array,
      default: [
        {
          id: 1,
          title: "Grounded",
          cover: "https://static-cdn.jtvnw.net/ttv-boxart/Grounded-jpg",
        },
      ],
    },
  },
  setup(props, context) {
    const fileredItems = ref([]);
    const selectedItem = ref(null);

    function handleSearch(q) {
      let search = q.target.value;
      let result = [];
      if (search && search.length > 2) {
        result = props.items.filter((item) => {
          return item.title.toLowerCase().includes(search.toLowerCase());
        });
      }
      fileredItems.value = result;
    }

    function handleClick(item) {
      selectedItem.value = item;
      context.emit("onSelected", selectedItem.value.id);
    }

    function reset() {
      selectedItem.value = null;
      fileredItems.value = [];
      context.emit("onSelected", null);
    }

    return { fileredItems, selectedItem, handleSearch, handleClick, reset };
  },
};
</script>