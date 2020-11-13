<template>
  <div class="fixed inset-0 z-20 overflow-y-auto">
    <div
      class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
    >
      <!--
      Background overlay, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
      <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-800 opacity-75"></div>
      </div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span
      >&#8203;
      <!--
      Modal panel, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        To: "opacity-100 translate-y-0 sm:scale-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100 translate-y-0 sm:scale-100"
        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    -->
      <div
        class="inline-block w-full overflow-hidden text-left align-bottom transition-all transform bg-gray-900 rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-xl"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-headline"
      >
        <div>
          <div class="w-full h-full" ref="container">
            <div ref="destination"></div>
          </div>
        </div>
        <div
          class="px-4 pb-4 mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense"
        >
          <span class="flex w-full rounded-md shadow-sm sm:col-start-2">
            <button
              @click="handleConfirm"
              type="button"
              class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo sm:text-sm sm:leading-5"
            >
              Confirmer
            </button>
          </span>
          <span
            class="flex w-full mt-3 rounded-md shadow-sm sm:mt-0 sm:col-start-1"
          >
            <button
              @click="handleCancel"
              type="button"
              class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-white underline transition duration-150 ease-in-out border border-transparent rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue sm:text-sm sm:leading-5"
            >
              Annuler
            </button>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Croppie from "croppie";
import "croppie/croppie.css";
import { computed, onMounted, ref } from "vue";
export default {
  props: {
    src: String,
  },
  setup(props, context) {
    const container = ref(null);
    const blob = ref(null);
    const destination = ref(null);
    const preview = ref(null);
    let canvas = null;

    const setCropper = () => {
      let boundaryWidth = container.value.clientWidth;
      let boundaryHeight = (boundaryWidth / 100) * 56.25;
      let viewportHeight = (boundaryWidth / 100) * 27.778;

      canvas = new Croppie(destination.value, {
        viewport: { width: boundaryWidth, height: viewportHeight },
        boundary: { width: boundaryWidth, height: boundaryHeight },
      });
      canvas.bind({
        url: props.src,
      });
    };

    const handleConfirm = async () => {
      blob.value = await canvas.result({
        type: "blob",
        size: { height: 400, width: 1440 },
        format: "jpeg",
      });

      context.emit("onConfirm", blob.value);
    };

    const handleCancel = () => {
      context.emit("onCancel");
    };

    onMounted(() => {
      setCropper();
    });

    return {
      container,
      destination,
      handleConfirm,
      handleCancel,
      preview,
      blob,
    };
  },
};
</script>