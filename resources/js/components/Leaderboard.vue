<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div
        class="inline-block w-full min-w-full py-2 align-middle sm:px-6 lg:px-8"
      >
        <div class="overflow-hidden shadow">
          <table class="w-full min-w-full divide-y divide-gray-900">
            <thead>
              <tr>
                <th
                  class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50"
                >
                  Position
                </th>
                <th
                  class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50"
                >
                  Nom
                </th>
                <th
                  v-for="(order, index) in orders"
                  :key="index"
                  @click="changeOrder(order.value)"
                  :class="{
                    'text-gray-300': order.value === selectedOrder,
                    'text-gray-500 cursor-pointer hover:text-gray-300': order.value !== selectedOrder,
                  }"
                  class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left uppercase transition-colors duration-150 ease-in-out"
                >
                  <div class="flex items-center space-x-1">
                    <span>{{ order.name }}</span>
                    <span
                      ><svg
                        v-if="selectedOrder === order.value"
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        class="w-4 h-4"
                      >
                        <path d="M19 9l-7 7-7-7"></path></svg
                    ></span>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-black">
              <tr
                class="transition-colors duration-150 ease-in-out bg-gray-900 hover:bg-gray-800"
                v-for="(item, index) in items"
                :key="index"
              >
                <td class="px-6 py-4 text-xl">{{ item.rank }}</td>
                <td class="font-medium leading-5 text-white whitespace-no-wrap">
                  <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                      <img
                        :src="item.profile_image_url"
                        class="object-cover w-10 h-10 rounded-full"
                        alt=""
                      />
                    </div>
                    <a :href="`/users/${item.login ? item.login : item.id}`" class="transition-colors duration-150 ease-in-out hover:text-indigo-400">{{
                      item.display_name
                    }}</a>
                  </div>
                </td>
                <td
                  class="px-6 py-4 leading-5 text-gray-500 whitespace-no-wrap"
                >
                  {{ item.points }}
                </td>
                <td
                  class="px-6 py-4 leading-5 text-gray-500 whitespace-no-wrap"
                >
                  {{ item.achievements_count }}
                </td>
                <td
                  class="px-6 py-4 leading-5 text-gray-500 whitespace-no-wrap"
                >
                  {{ item.clips_count }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";

export default {
  props: {
    items: Array,
    selectedOrder: String,
  },
  setup(props, context) {
    const orders = ref([
      { name: "Points", value: "points" },
      { name: "Succès", value: "achievements" },
      { name: "Clips", value: "clips" },
    ]);
    function changeOrder(order) {
      if (order === props.selectedOrder) {
        return;
      }
      context.emit("orderChanged", order);
    }
    return { changeOrder, orders };
  },
};
</script>