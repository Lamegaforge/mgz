<template>
  <div
    class="flex flex-col items-start mt-4 space-y-3 md:mt-6 sm:space-y-0 sm:items-center sm:flex-row"
  >
    <div v-if="type === 'clip'" class="w-full sm:w-56">
      <select-menu />
    </div>
    <input
      class="w-full bg-gray-800 border-transparent rounded-full sm:w-64 sm:ml-auto form-input"
      id="search"
      placeholder="Rechercher"
      type="search"
    />
    <div className="ml-auto sm:ml-3">
      <dropdown button-class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded focus:outline-none focus:shadow-outline focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800">
        <template #trigger>
          <svg
            class="w-5 h-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
            ></path></svg
          ><span class="ml-2">Trier par</span
          ><svg
            class="w-5 h-5 ml-2 -mr-1"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </template>
        <template #content>
          <div
            class="py-1"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="sort-menu"
          >
            <a
              href="#"
              class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-700 focus:outline-none focus:bg-gray-700"
              role="menuitem"
              >Date</a
            ><a
              href="#"
              class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-700 focus:outline-none focus:bg-gray-700"
              role="menuitem"
              >Nombre de vues</a
            >
          </div>
        </template>
      </dropdown>
    </div>
  </div>
  <div :class="gridClass">
    <div v-for="(item, index) in items" :key="index">
      <clip :item="item" v-if="type === 'clip'" />
      <card :item="item" v-if="type === 'card'" />
    </div>
  </div>
</template>
<script>
import { ref, onMounted } from "vue";
export default {
  props: {
    type: String,
    gridClass: String,
  },
  setup() {
    const items = ref([]);
    onMounted(async () => {
        try {
          const response = await axios.get("/clips/api");
          items.value = response.data.data;
        } catch (err) {
          console.log(err);
        }
    });
    return {
      items,
    };
  },
};
</script>