<template>
  <a :href="`/cards/${item.id}`" class="block group">
    <div class="relative pt-2/3">
      <img
        class="absolute top-0 left-0 object-cover object-center w-full h-full duration-200 ease-in-out transform rounded group-hover:scale-105"
        :src="item.medias.vignette"
      />
    </div>
    <p class="mt-4 leading-4 text-white">{{ item.title }}</p>
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