<template>
  <section class="relative z-10 border-t border-gray-900">
    <div class="px-4 py-6 mx-auto -mt-10 max-w-7xl sm:px-6 lg:px-8">
      <div class="flex flex-col items-center sm:flex-row">
        <img
          class="inline-block w-40 h-40 mx-auto border-4 border-black rounded-md sm:ml-0 sm:mr-0"
          :src="user.profile_image_url"
          alt=""
        />
        <div class="sm:ml-6 sm:mt-3">
          <p class="text-3xl leading-tight">{{ user.display_name }}</p>
          <p class="max-w-lg">{{ description }}</p>
          <div class="flex mt-2 space-x-2">
            <a
              :href="`https://twitch.tv/${user.login}`"
              target="_blank"
              rel="nofollow noreferrer"
              class="text-gray-400 hover:text-gray-500"
            >
              <span class="sr-only">Twitch</span>
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 512 512">
                <path
                  d="M391.17,103.47H352.54v109.7h38.63ZM285,103H246.37V212.75H285ZM120.83,0,24.31,91.42V420.58H140.14V512l96.53-91.42h77.25L487.69,256V0ZM449.07,237.75l-77.22,73.12H294.61l-67.6,64v-64H140.14V36.58H449.07Z"
                ></path>
              </svg>
            </a>
            <a
              v-if="twitter"
              :href="`https://twitter.com/${twitter}`"
              target="_blank"
              rel="nofollow noreferrer"
              class="text-gray-400 hover:text-gray-500"
              ><span class="sr-only">Twitter</span>
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 512 512">
                <path
                  d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
                ></path>
              </svg>
            </a>
            <a
              :href="`https://youtube.com/${youtube}`"
              target="_blank"
              rel="nofollow noreferrer"
              v-if="youtube"
              class="text-gray-400 hover:text-gray-500"
              ><span class="sr-only">Youtube</span>
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 576 512">
                <path
                  d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"
                ></path>
              </svg>
            </a>
            <a
              :href="`https://instagram.com/${instagram}`"
              target="_blank"
              rel="nofollow noreferrer"
              v-if="instagram"
              class="text-gray-400 hover:text-gray-500"
              ><span class="sr-only">Instagram</span>
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 448 512">
                <path
                  fill="currentColor"
                  d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"
                ></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <form
    @submit="submitForm"
    class="max-w-4xl px-4 py-6 pb-16 mx-auto space-y-6 md:pb-20 lg:pb-24 sm:px-6 lg:px-8"
  >
    <div>
      <label
        for="description"
        class="block text-sm font-medium leading-5 text-gray-300"
        >Description</label
      >
      <div class="relative mt-1 rounded-md shadow-sm">
        <textarea
          id="description"
          rows="2"
          v-model="description"
          class="block w-full px-4 py-3 transition duration-150 ease-in-out bg-gray-900 border-transparent form-textarea"
        ></textarea>
      </div>
    </div>
    <div>
      <label
        for="company_website"
        class="block text-sm font-medium leading-5 text-gray-300"
      >
        Twitter
      </label>
      <div class="flex mt-1 rounded-md shadow-sm">
        <span
          class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-900 rounded-l-md sm:text-sm"
        >
          https://twitter.com/
        </span>
        <input
          v-model="twitter"
          class="flex-1 block w-full px-3 py-2 bg-gray-900 border-transparent rounded-none form-input rounded-r-md sm:text-sm sm:leading-5"
          placeholder="exemple"
        />
      </div>
    </div>
    <div>
      <label
        for="company_website"
        class="block text-sm font-medium leading-5 text-gray-300"
      >
        Youtube
      </label>
      <div class="flex mt-1 rounded-md shadow-sm">
        <span
          class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-900 rounded-l-md sm:text-sm"
        >
          https://youtube.com/
        </span>
        <input
          v-model="youtube"
          class="flex-1 block w-full px-3 py-2 bg-gray-900 border-transparent rounded-none form-input rounded-r-md sm:text-sm sm:leading-5"
          placeholder="channel/id ou user/nom"
        />
      </div>
    </div>
    <div>
      <label
        for="company_website"
        class="block text-sm font-medium leading-5 text-gray-300"
      >
        Instagram
      </label>
      <div class="flex mt-1 rounded-md shadow-sm">
        <span
          class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-900 rounded-l-md sm:text-sm"
        >
          https://instagram.com/
        </span>
        <input
          v-model="instagram"
          class="flex-1 block w-full px-3 py-2 bg-gray-900 border-transparent rounded-none form-input rounded-r-md sm:text-sm sm:leading-5"
          placeholder="exemple"
        />
      </div>
    </div>
    <div class="flex items-center space-x-4">
      <span
        role="checkbox"
        tabindex="0"
        :aria-checked="autoplay"
        @click="autoplay = !autoplay"
        :class="{ 'bg-gray-800': !autoplay, 'bg-indigo-600': autoplay }"
        class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:shadow-outline"
      >
        <span
          aria-hidden="true"
          :class="{ 'translate-x-5': autoplay, 'translate-x-0': !autoplay }"
          class="inline-block w-5 h-5 transition duration-200 ease-in-out transform bg-white rounded-full shadow"
        ></span>
      </span>
      <label
        class="block text-sm font-medium leading-5 text-gray-300"
      >
        Lecture auto des clips
      </label>
    </div>
    <div class="text-right">
      <button
        type="submit"
        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-5 text-white transition duration-150 ease-in-out bg-indigo-700 border border-transparent rounded hover:bg-indigo-600 sm:w-auto focus:outline-none focus:shadow-outline focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800"
      >
        Enregistrer
      </button>
    </div>
  </form>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    user: Object,
  },

  setup(props) {
    const isLoading = ref(false);
    const description = ref(props.user.description);
    const twitter = ref(props.user.twitter);
    const youtube = ref(props.user.youtube);
    const instagram = ref(props.user.instagram);
    const autoplay = ref(props.user.autoplay);

    async function submitForm(e) {
      if (isLoading.value) return;
      e.preventDefault();
      isLoading.value = true;
      try {
        const response = await axios.post("/api/account/update-user", {
          description: description.value,
          twitter: twitter.value,
          youtube: youtube.value,
          instagram: instagram.value,
          autoplay: autoplay.value
        });
        window.location.href = "/users/account";
      } catch (err) {
        console.log(err);
      }

      isLoading.value = false;
    }

    return { description, twitter, youtube, instagram, submitForm, autoplay };
  },
};
</script>