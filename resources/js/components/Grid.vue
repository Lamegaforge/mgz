<template>
  <div
    v-if="filters"
    class="flex flex-col items-start mt-4 space-y-3 md:mt-6 sm:space-y-0 sm:items-center sm:flex-row"
  >
    <div v-if="type === 'clips' && cards" class="w-full sm:w-56">
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
            <button
              type="button"
              class="relative inline-flex w-full px-4 py-2 pr-8 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-700"
              @click="handleSort(order.value)"
              v-for="(order, index) in sorts[type]"
              :key="index"
            >
              <span>{{ order.label }}</span>
              <span
                class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-500"
              >
                <svg
                  class="w-5 h-5"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  v-if="selectedOrder == order.value"
                >
                  <path
                    fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd"
                  />
                </svg>
              </span>
            </button>
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
      <clip :item="item" v-if="type === 'clips'" />
      <card :item="item" v-if="type === 'cards'" />
      <achievement :item="item" v-if="type === 'achievements'" />
    </div>
  </div>
  <div v-if="!items?.length && !isLoading" class="py-16 text-center">
    Aucun résultat 🦕
  </div>
  <pagination
    v-if="lastPage > 1"
    :links="links"
    :prev-page-url="prevPageUrl"
    :next-page-url="nextPageUrl"
    @onClick="fetchItems"
  />
</template>
<script>
import { ref, onMounted, watch } from "vue";
const sorts = {
  clips: [
    {
      label: "Date",
      value: "approved_at",
    },
    {
      label: "Nombre de vues",
      value: "views",
    },
  ],
  cards: [
    {
      label: "Nom",
      value: "title",
    },
    {
      label: "Popularité",
      value: "count",
    },
    {
      label: "Date",
      value: "created_at",
    },
  ],
  achievements: [
    {
      label: "Date d'obtention",
      value: "unlocked",
    }
  ],
};
export default {
  props: {
    type: String,
    gridClass: String,
    fetchUrl: String,
    cards: Array,
    cardId: Number,
    userId: Number,
    filters: {
      type: Boolean,
      default: false
    },
  },
  setup(props) {
    const grid = ref(null);
    const items = ref([]);
    const isLoading = ref(false);
    const links = ref([]);
    const prevPageUrl = ref(null);
    const nextPageUrl = ref(null);
    const search = ref(null);
    const cardId = ref(props.cardId ? props.cardId : null);
    const selectedOrder = ref(sorts[props.type][0].value);
    const lastPage = ref(null);

    onMounted(async () => {
      fetchItems();
    });

    async function fetchItems(url) {
      isLoading.value = true;
      if (url) {
        if (!props.filters) {
          window.scrollTo(0, grid.value.offsetTop - 70);
        } else {
          window.scrollTo(0, 0);
        }
      }
      try {
        const response = await axios.get(constructUrl(url));
        links.value = response.data[props.type]?.links;
        items.value = response.data[props.type]?.data;
        prevPageUrl.value = response.data[props.type].prev_page_url;
        nextPageUrl.value = response.data[props.type].next_page_url;
        lastPage.value = response.data[props.type].last_page;
      } catch (err) {
        console.log(err);
      }
      isLoading.value = false;
    }

    function constructUrl(url) {
      if (url) {
        return url;
      }
      if (search.value && cardId.value) {
        return `${props.fetchUrl}?title=${search.value}&card_id=${cardId.value}&order=${selectedOrder.value}`;
      }
      if (cardId.value) {
        return `${props.fetchUrl}?card_id=${cardId.value}&order=${selectedOrder.value}`;
      }
      if (props.userId) {
        return `${props.fetchUrl}?user_id=${props.userId}&order=${selectedOrder.value}`;
      }
      if (search.value) {
        return `${props.fetchUrl}?title=${search.value}&order=${selectedOrder.value}`;
      }

      return `${props.fetchUrl}?order=${selectedOrder.value}`;
    }

    function handleSelectedCard(id) {
      cardId.value = id;
      fetchItems();
    }

    function handleSearch(query) {
      search.value = query;
      fetchItems();
    }

    function handleSort(order) {
      selectedOrder.value = order;
      fetchItems();
    }

    return {
      items,
      grid,
      links,
      selectedOrder,
      sorts,
      prevPageUrl,
      nextPageUrl,
      lastPage,
      isLoading,
      fetchItems,
      handleSelectedCard,
      handleSearch,
      handleSort,
    };
  },
};
</script>