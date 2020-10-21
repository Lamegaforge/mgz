<template>
  <a :href="`/clips/${item.id}`" class="block rounded group">
    <div
      class="relative transition duration-200 ease-in-out transform shadow-md pt-16/9 group-hover:scale-105"
    >
      <img
        class="absolute top-0 left-0 object-cover object-center w-full h-full rounded"
        :src="item.thumbnail"
      />
    </div>
    <div class="mt-3 text-white">
      <p
        class="transition duration-200 ease-in-out group-hover:text-indigo-400"
      >
        {{ item.title }}
      </p>
      <p class="text-sm text-gray-300">{{ item.card?.title }}</p>
    </div>
  </a>
</template>
<script>
export default {
  props: {
    item: {
      type: Object,
      default: {},
    },
  },
};
</script>