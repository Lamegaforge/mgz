<template>
  <div
    class="flex flex-col items-start mt-4 space-y-3 md:mt-6 sm:space-y-0 sm:items-center sm:flex-row"
  >
    <div v-if="type === 'clip'" class="w-full sm:w-56">
      <select-menu :items="cards" @onSelected="handleSelectedCard" />
    </div>
    <div class="relative w-full sm:ml-auto sm:w-64">
      <div
        class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 pointer-events-none"
      >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path
            fill-rule="evenodd"
            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
            clip-rule="evenodd"
          ></path>
        </svg>
      </div>
      <debounce-input
        class="w-full pl-10 bg-gray-900 border-transparent rounded-full form-input"
        placeholder="Rechercher"
        type="search"
        @onDebounced="handleSearch"
      />
    </div>
    <div className="ml-auto sm:ml-3">
      <dropdown
        button-class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-gray-900 border border-transparent rounded focus:outline-none focus:shadow-outline focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800"
      >
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
            class="py-1 shadow"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="sort-menu"
          >
            <a
              href="#"
              class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-700"
              role="menuitem"
              >Date</a
            ><a
              href="#"
              class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-700"
              role="menuitem"
              >Nombre de vues</a
            >
          </div>
        </template>
      </dropdown>
    </div>
  </div>
  <div :class="gridClass" class="relative" ref="grid">
    <div
      v-show="isLoading"
      class="absolute top-0 z-50 w-full h-full transition-opacity duration-150 bg-black opacity-75 left-O"
    ></div>
    <div v-for="(item, index) in items" :key="index">
      <clip :item="item" v-if="type === 'clip'" />
      <card :item="item" v-if="type === 'card'" />
    </div>
  </div>
  <div v-if="!items.length && !isLoading" class="py-16 text-center">
    Aucun résultat 🦕
  </div>
  <pagination
    :links="links"
    :prev-page-url="prevPageUrl"
    :next-page-url="nextPageUrl"
    @onClick="fetchItems"
  />
</template>
<script>
import { ref, onMounted, watch } from "vue";
export default {
  props: {
    type: String,
    gridClass: String,
    fetchUrl: String,
    cards: Array,
  },
  setup(props) {
    const grid = ref(null);
    const items = ref([]);
    const isLoading = ref(false);
    const links = ref([]);
    const prevPageUrl = ref(null);
    const nextPageUrl = ref(null);
    const search = ref(null);
    const cardId = ref(null);

    onMounted(async () => {
      fetchItems();
    });

    async function fetchItems(url) {
      isLoading.value = true;
      window.scrollTo(0, grid.offsetTop - 100);
      try {
        const response = await axios.get(constructUrl(url));
        links.value = response.data?.clips.links;
        items.value = response.data?.clips?.data;
        prevPageUrl.value = response.data?.clips.prev_page_url;
        nextPageUrl.value = response.data?.clips.next_page_url;
      } catch (err) {
        console.log(err);
      }
      isLoading.value = false;
    }

    function constructUrl(url) {
      if (search.value && cardId.value) {
        return `${props.fetchUrl}?title=${search.value}&card_id=${cardId.value}`;
      }
      if (cardId.value) {
        return `${props.fetchUrl}?card_id=${cardId.value}`;
      }
      if (search.value) {
        return `${props.fetchUrl}?title=${search.value}`;
      }
      if (url) {
        return url;
      }

      return props.fetchUrl;
    }

    function handleSelectedCard(id) {
      cardId.value = id;
      fetchItems();
    }

    function handleSearch(query) {
      search.value = query;
      fetchItems();
    }

    return {
      items,
      links,
      prevPageUrl,
      nextPageUrl,
      isLoading,
      fetchItems,
      handleSelectedCard,
      handleSearch,
    };
  },
};
</script>