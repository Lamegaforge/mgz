<template>
  <button
    v-if="!rejected"
    class="inline-flex items-center mt-6 space-x-2 focus:outline-none"
    @click="handleToggle"
  >
    <span
      class="items-start justify-between p-1 text-base font-medium leading-5 text-white transition duration-150 ease-in-out bg-gray-900 border border-transparent rounded"
    >
      <svg
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
    <span>Rejeter</span>
  </button>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    clipId: Number,
  },

  setup(props) {
    const rejected = ref(false);
    const isLoading = ref(false);

    async function handleToggle() {
      if (isLoading.value) return;

      isLoading.value = true;
      rejected.value = true;
      try {
        const response = await axios.post("/api/clips/reject", {
          clip_id: props.clipId,
        });
        window.location.href = "/clips";
      } catch (err) {
        console.log(err);
      }

      isLoading.value = false;
    }

    return { rejected, handleToggle };
  },
};
</script>