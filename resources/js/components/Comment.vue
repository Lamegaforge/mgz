<template>
  <div class="flex py-4 space-x-3 border-t border-gray-900 sm:space-x-4">
    <img
      class="inline-block w-10 h-10 rounded-full sm:w-12 sm:h-12"
      src="https://cdn.discordapp.com/emojis/761566071151919104.png?v=1"
      alt=""
    />
    <div class="w-full text-gray-300">
      <p class="font-semibold text-white">
        {{ comment.user.display_name }}
        <span class="text-sm font-normal text-gray-500"
          >- {{ timeSince(comment.created_at) }}</span
        >
      </p>
      <p>
        {{ comment.content }}
      </p>
      <div class="inline-flex items-center mt-2">
        <button
          class="font-semibold hover:text-indigo-300"
          @click="clicked = true"
        >
          Répondre
        </button>
      </div>
      <post-comment
        class="mt-4"
        v-if="clicked"
        :clip-id="comment.clip_id"
        :parent-id="
          comment.parent_comment_id ? comment.parent_comment_id : comment.id
        "
      />
      <div className="mt-4">
        <comment
          v-for="(child, index) in comment.children"
          :key="index"
          :comment="child"
        />
      </div>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    comment: Object,
  },
  setup() {
    const intervals = [
      { label: "année", seconds: 31536000 },
      { label: "mois", seconds: 2592000 },
      { label: "jour", seconds: 86400 },
      { label: "heure", seconds: 3600 },
      { label: "minute", seconds: 60 },
      { label: "seconde", seconds: 0 },
    ];

    const clicked = ref(false);

    function timeSince(date) {
      let time = new Date(date);
      let seconds = (+new Date() - +time) / 1000;

      if (seconds == 0 || (seconds > 0 && seconds < 60)) {
        return "à l'instant";
      }

      if (seconds < 0) {
        seconds = Math.abs(seconds);
      }
      const interval = intervals.find((i) => i.seconds < seconds);
      const count = Math.floor(seconds / interval.seconds);
      return `${count} ${interval.label}${
        count !== 1 && interval.label !== "mois" ? "s" : ""
      }`;
    }

    return { timeSince, clicked };
  },
};
</script>