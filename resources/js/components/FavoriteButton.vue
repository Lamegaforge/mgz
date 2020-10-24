<template>
  <button
    class="inline-flex items-center mt-6 space-x-2 focus:outline-none"
    @click="handleToggle"
  >
    <span
      class="items-start justify-between p-1 text-base font-medium leading-5 text-white transition duration-150 ease-in-out bg-gray-900 border border-transparent rounded"
    >
      <svg
        v-if="!isFavorite"
        class="w-5 h-5"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
        />
      </svg>
      <svg
        v-if="isFavorite"
        class="w-5 h-5"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
          clip-rule="evenodd"
        />
      </svg>
    </span>
    <span>Favoris</span>
  </button>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    clipId: Number,
    active: Boolean,
    isAuth: Boolean,
  },

  setup(props) {
    const isFavorite = ref(props.active);
    const isLoading = ref(false);

    async function handleToggle() {
      if (isLoading.value) return;

      if (!props.isAuth) {
        window.location.href = "/oauth/login";
      }

      isLoading.value = true;
      try {
        const response = await axios.post("/api/favorites/toggle", {
          clip_id: props.clipId,
        });
        isFavorite.value = !isFavorite.value;
      } catch (err) {
        console.log(err);
      }

      isLoading.value = false;
    }

    return { isFavorite, handleToggle };
  },
};
</script>