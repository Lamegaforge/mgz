<template>
  <div>
    <form @submit.prevent="postComment" v-if="!sent">
      <p class="text-sm text-gray-300">Exprime-toi, connard</p>
      <div class="flex max-w-lg mt-1 rounded-sm shadow-sm">
        <textarea
          v-model="content"
          rows="2"
          class="block w-full transition duration-150 ease-in-out bg-gray-900 border-gray-900 rounded-sm form-textarea sm:text-sm sm:leading-5"
        ></textarea>
      </div>
      <button
        type="submit"
        class="inline-flex items-center px-3 py-2 mt-1 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out border border-transparent border-gray-700 rounded hover:text-indigo-300 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800"
      >
        Comment
      </button>
    </form>
    <div v-if="sent" class="max-w-lg px-4 py-2 text-sm bg-indigo-900 rounded">
      <p>Merci connard ! Ton commentaire s'affichera une fois approuvé.</p>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    clipId: Number,
    parentId: {
      default: null,
      type: Number,
    },
  },

  setup(props) {
    const isLoading = ref(false);
    const content = ref(null);
    const sent = ref(false);

    async function postComment() {
      if (isLoading.value) return;
      isLoading.value = true;
      try {
        const response = await axios.post("/api/comments/store", {
          clip_id: props.clipId,
          parent_comment_id: props.parentId,
          content: content.value,
        });
        sent.value = true;
        content.value = null;
      } catch (err) {
        console.log(err);
      }
      isLoading.value = false;
    }

    return { postComment, content, sent };
  },
};
</script>