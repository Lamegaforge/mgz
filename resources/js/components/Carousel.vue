<template>
  <div class="relative" ref="container">
    <div
      class="absolute top-0 left-0 z-10 items-center hidden h-full -ml-5 text-gray-800 lg:flex"
      @click="prev"
      v-if="hasPrev"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        class="w-10 h-10 transition duration-150 ease-in-out transform bg-white rounded-full shadow cursor-pointer md:hover:scale-110"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M15 19l-7-7 7-7"
        />
      </svg>
    </div>
    <div
      class="absolute top-0 right-0 z-10 items-center hidden h-full -mr-5 text-gray-800 lg:flex"
      @click="next"
      v-if="hasNext"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        class="w-10 h-10 transition duration-150 ease-in-out transform bg-white rounded-full shadow cursor-pointer md:hover:scale-110"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M9 5l7 7-7 7"
        />
      </svg>
    </div>
    <div class="carousel-container" :style="style.container">
      <div class="carousel-list" :class="style.list" ref="list">
        <div
          v-for="(item, index) in items"
          :key="index"
          ref="item"
          class="box-content pt-2"
          :style="style.item"
        >
          <slot :item="item">{{ item }}</slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, onBeforeUnmount, onMounted, ref, nextTick } from "vue";
export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
    /**
     * item.class = css class for each individual item.
     * item.padding = padding between each item in the list.
     *
     * list.class = css class for the parent of item
     * list.windowed = maximum width of the list it can extend to, basically the container max-width
     * list.padding = padding of the list, if container < windowed what is the left-right padding of the list
     */
    options: {
      type: Object,
      required: false,
    },
  },

  setup(props) {
    const position = ref(0);
    const width = ref({
      container: 0,
      window: 640,
    });
    const container = ref(null);
    const item = ref(null);
    const list = ref(null);

    function resize() {
      width.value.window = window.innerWidth;
      width.value.container = container.value.clientWidth;
    }

    function go(index) {
      const maxPosition = props.items.length - size.value;
      position.value = index > maxPosition ? maxPosition : index;
      const left =
        itemWidth.value * position.value +
        position.value * options.value.item.padding;
      list.value.scrollTo({ top: 0, left: left, behavior: "smooth" });
    }

    function prev() {
      go(position.value - size.value);
    }

    function next() {
      go(position.value + size.value);
    }

    onMounted(() => {
      resize();
      nextTick(() => {
        window.addEventListener("resize", resize);
      });
    });

    onBeforeUnmount(() => {
      window.removeEventListener("resize", resize);
    });

    const options = computed(() => {
      return {
        item: {
          padding: props.options?.item?.padding ? props.options?.item?.padding : 16,
        },
        list: {
          windowed: 1024,
          padding: props.options?.list?.padding
            ? props.options.list.padding
            : 24,
        },
        responsive: props.options?.responsive
          ? props.options.responsive
          : [
              { end: 640, size: 1 },
              { start: 640, end: 768, size: 2 },
              { start: 768, end: 1024, size: 3 },
              { start: 1024, end: 1280, size: 4 },
              { start: 1280, size: 5 },
            ],
      };
    });

    const workingWidth = computed(() => {
      // Full Screen Mode
      if (width.value.window < options.value.list.windowed) {
        return width.value.window - options.value.list.padding * 2;
      }
      // Windowed Mode
      else {
        return width.value.container;
      }
    });

    const size = computed(() => {
      const width = workingWidth.value;
      return options.value.responsive.find((value) => {
        return (
          (!value.start || value.start <= width) &&
          (!value.end || value.end >= width)
        );
      }).size;
    });

    const itemWidth = computed(() => {
      return (
        (workingWidth.value - (size.value - 1) * options.value.item.padding) /
        size.value
      );
    });

    const style = computed(() => {
      const _style = {
        container: {},
        list: {},
        item: {},
        tail: {},
      };
      const _workingWidth = workingWidth.value;
      const _size = size.value;
      // Full Screen Mode
      if (width.value.window < options.value.list.windowed) {
        _style.container.marginLeft = `-${options.value.list.padding}px`;
        _style.container.marginRight = `-${options.value.list.padding}px`;
        _style.item.width = `${
          (_workingWidth - (_size - 1) * options.value.item.padding) / _size
        }px`;
        _style.item.paddingLeft = `${options.value.list.padding}px`;
        _style.item.paddingRight = `${options.value.item.padding}px`;
        _style.item.marginRight = `-${options.value.list.padding}px`;
      }
      // Windowed Mode
      else {
        _style.item.paddingLeft = `${options.value.item.padding / 2}px`;
        _style.item.paddingRight = `${options.value.item.padding / 2}px`;
        _style.container.marginLeft = `-${options.value.item.padding / 2}px`;
        _style.container.marginRight = `-${options.value.item.padding / 2}px`;
        _style.item.width = `${
          (_workingWidth - (_size - 1) * options.value.item.padding) / _size
        }px`;
      }
      return _style;
    });

    const hasNext = computed(() => {
      return props.items.length > position.value + size.value;
    });

    const hasPrev = computed(() => {
      return position.value > 0;
    });

    return {
      container,
      item,
      style,
      list,
      prev,
      next,
      hasPrev,
      hasNext,
    };
  },
};
</script>