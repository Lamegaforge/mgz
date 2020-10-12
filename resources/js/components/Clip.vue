<template>
  <a :href="`/clips/${item.id}`" className="block rounded group">
    <div
      className="relative transition duration-200 ease-in-out transform shadow-md pt-16/9 group-hover:scale-105"
    >
      <img
        className="absolute top-0 left-0 object-cover object-center w-full h-full rounded"
        :src="item.thumbnail"
      />
    </div>
    <div className="mt-3 text-white">
      <p
        className="transition duration-200 ease-in-out group-hover:text-indigo-400"
      >
        {{ item.title }}
      </p>
      <p className="text-sm text-gray-300">{{ item.card.title }}</p>
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