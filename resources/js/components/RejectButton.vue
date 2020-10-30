<template>
  <button
    v-if="!rejected"
    class="inline-flex items-center mt-6 space-x-2 focus:outline-none"
    @click="handleToggle"
  >
    <span
      class="items-start justify-between p-1 text-base font-medium leading-5 text-white transition duration-150 ease-in-out bg-gray-900 border border-transparent rounded"
    >
      <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
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