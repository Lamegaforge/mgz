<template>
  <div class="flex items-center py-4 border-b border-gray-900">
    <div class="flex items-center flex-1 min-w-0">
      <div class="flex-shrink-0">
        <img
          class="w-12 h-12 rounded-sm"
          src="https://cdn.discordapp.com/emojis/765870979921608725.png?v=1"
          alt=""
        />
      </div>
      <div class="flex-1 min-w-0 px-4 md:grid md:grid-cols-2 md:gap-8">
        <div>
          <div class="text-sm font-medium leading-5 text-white truncate">
            Fashion Victime
          </div>
          <div class="flex items-center mt-2 text-sm leading-5 text-gray-500">
            <p>
              Avoir renseigné une bannière, une description et au moins un
              réseau social
            </p>
          </div>
        </div>
        <div
          class="items-center hidden text-gray-500 md:flex"
        >
          <p class="text-sm text-indigo-400">Très rare</p>
          <div class="ml-auto">
            <div class="text-sm leading-5">
              <time datetime="2020-01-07">27/10/2020</time>
            </div>
            <div class="flex items-center mt-2 ml-auto text-sm leading-5">
              <svg
                class="flex-shrink-0 w-5 h-5 mr-1 text-green-400"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"
                />
              </svg>
              100 points
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    item: Object,
  },
};
</script>