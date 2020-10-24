<template>
  <div class="relative xl:pt-0 pt-3/1 xl:h-400px">
    <img
      alt="profil banner"
      class="absolute top-0 left-0 object-cover object-center w-full h-full"
      :src="banner"
    />
    <div
      class="absolute top-0 left-0 z-20 w-full px-4 py-2 bg-indigo-700"
      v-if="errors"
    >
      <ul>
        <li v-for="(error, index) in errors" :key="index">
          {{ error }}
        </li>
      </ul>
    </div>
    <div
      class="absolute top-0 left-0 z-10 flex items-center justify-center w-full h-full space-x-3 text-white transition-opacity duration-150 ease-in-out bg-black bg-opacity-25"
    >
      <button
        type="button"
        class="relative flex items-center justify-center w-full h-full text-center cursor-pointer"
        v-if="!changed"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          class="w-8 h-8 pointer-events-none"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
          />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
          />
        </svg>
        <input
          type="file"
          class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer"
          @change="handleChange"
        />
      </button>
      <button
        type="button"
        class="cursor-pointer"
        v-if="changed"
        @click="saveBanner"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          class="w-8 h-8"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M5 13l4 4L19 7"
          />
        </svg>
      </button>
      <button v-if="changed" @click="reset">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          class="w-8 h-8"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    banner: {
      type: String,
      default: null,
    },
  },

  setup(props) {
    const isLoading = ref(false);
    const banner = ref(props.banner);
    const file = ref(null);
    const changed = ref(false);
    const errors = ref(null);

    function handleChange(upload) {
      let input = upload.target.files[0];
      if (input) {
        let reader = new FileReader();
        reader.onload = (e) => {
          banner.value = e.target.result;
          file.value = input;
          changed.value = true;
        };
        reader.readAsDataURL(input);
      }
    }

    async function saveBanner() {
      if (isLoading.value) return;
      isLoading.value = true;
      try {
        let formData = new FormData();

        formData.append("banner", file.value);
        const response = await axios.post(
          "/api/account/update-banner",
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );
        changed.value = false;
        errors.value = null;
      } catch (err) {
        errors.value = err.response.data.errors.banner;
      }
      isLoading.value = false;
    }

    function reset() {
      banner.value = props.banner;
      file.value = null;
      changed.value = false;
      errors.value = null;
    }

    return { banner, handleChange, file, changed, reset, saveBanner, errors };
  },
};
</script>