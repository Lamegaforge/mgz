<template>
  <div class="flex items-center" v-if="isLoading">
    <svg
      class="w-5 h-5 mr-3 text-white animate-spin"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
    >
      <circle
        class="opacity-25"
        cx="12"
        cy="12"
        r="10"
        stroke="currentColor"
        stroke-width="4"
      ></circle>
      <path
        class="opacity-75"
        fill="currentColor"
        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
      ></path>
    </svg>
    Chargement des commentaires...
  </div>
  <div v-for="(comment, index) in comments" :key="index">
    <comment :comment="comment" :is-auth="isAuth" />
  </div>
</template>
<script>
import { onMounted, ref } from "vue";
export default {
  props: {
    fetchUrl: String,
    isAuth: {
      type: Boolean,
      default: false,
    },
  },
  setup(props) {
    const comments = ref([]);
    const isLoading = ref(false);

    onMounted(() => {
      fetchComments();
    });

    async function fetchComments() {
      isLoading.value = true;
      try {
        const response = await axios.get(props.fetchUrl);
        comments.value = response.data.comments;
      } catch (err) {
        console.log(err);
      }
      isLoading.value = false;
    }

    return { isLoading, comments };
  },
};
</script>