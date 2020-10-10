<template>
  <nav class="sticky top-0 z-50 w-full bg-gray-900 shadow">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <div class="flex items-center flex-shrink-0">
            <a
              href=""
              class="text-xl font-bold tracking-tight text-white uppercase"
              >LaMegaforge</a
            >
          </div>
          <div class="hidden sm:ml-6 sm:flex">
            <!-- <a
              href="#"
              class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out border-b-2 border-indigo-500 focus:outline-none focus:border-indigo-700"
            >
              Clips
            </a> -->
            <a
              href="#"
              class="inline-flex items-center px-1 pt-1 ml-8 text-sm font-medium leading-5 text-gray-300 transition duration-150 ease-in-out border-b-2 border-transparent hover:text-white hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300"
            >
              Clips
            </a>
            <a
              href="#"
              class="inline-flex items-center px-1 pt-1 ml-8 text-sm font-medium leading-5 text-gray-300 transition duration-150 ease-in-out border-b-2 border-transparent hover:text-white hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300"
            >
              Fiches
            </a>
          </div>
        </div>
        <div class="hidden sm:ml-6 sm:flex sm:items-center">
          <dropdown class="ml-3" button-class="flex text-sm transition duration-150 ease-in-out border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
            <template #trigger>
              <img
                class="object-cover w-8 h-8 rounded-full"
                src="https://cdn.discordapp.com/emojis/761566071151919104.png?v=1"
                alt=""
              />
            </template>
            <template #content>
              <div
                class="py-1"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="sort-menu"
              >
                <a
                  href="#"
                  class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-800"
                  role="menuitem"
                  >Mon profil</a
                ><a
                  href="#"
                  class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-800"
                  role="menuitem"
                  >Paramètres</a
                >
                <a
                  href="#"
                  class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-800"
                  role="menuitem"
                  >Déconnexion</a
                >
              </div>
            </template>
          </dropdown>
        </div>
        <div class="flex items-center -mr-2 sm:hidden">
          <!-- Mobile menu button -->
          <button
            class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-white hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-white"
            aria-label="Main menu"
            aria-expanded="false"
            @click="toggleMobileMenu()"
          >
            <svg
              class="w-6 h-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              :class="{ hidden: isMobileOpen, block: !isMobileOpen }"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
            <svg
              class="w-6 h-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              :class="{ block: isMobileOpen, hidden: !isMobileOpen }"
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
    </div>
    <div
      class="sm:hidden"
      :class="{ block: isMobileOpen, hidden: !isMobileOpen }"
    >
      <div class="pt-2 pb-3">
        <!-- <a
          href="#"
          class="block py-2 pl-3 pr-4 text-base font-medium text-indigo-500 transition duration-150 ease-in-out border-l-4 border-indigo-500 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700"
          >Clips</a
        > -->
        <a
          href="#"
          class="block py-2 pl-3 pr-4 mt-1 text-base font-medium text-gray-300 transition duration-150 ease-in-out border-l-4 border-transparent hover:text-white hover:bg-gray-800 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-gray-50 focus:border-gray-300"
          >Clips</a
        >
        <a
          href="#"
          class="block py-2 pl-3 pr-4 mt-1 text-base font-medium text-gray-300 transition duration-150 ease-in-out border-l-4 border-transparent hover:text-white hover:bg-gray-800 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-gray-50 focus:border-gray-300"
          >Fiches</a
        >
      </div>
      <div class="pt-4 pb-3 border-t border-gray-800">
        <div class="flex items-center px-4">
          <div class="flex-shrink-0">
            <img
              class="object-cover w-10 h-10 rounded-full"
              src="https://cdn.discordapp.com/emojis/761566071151919104.png?v=1"
              alt=""
            />
          </div>
          <div class="ml-3">
            <div class="text-base font-medium leading-6 text-white">
              Basalte
            </div>
          </div>
        </div>
        <div class="mt-3">
          <a
            href="#"
            class="block px-4 py-2 text-base font-medium text-gray-400 transition duration-150 ease-in-out hover:text-white hover:bg-gray-800 focus:outline-none focus:text-white focus:bg-gray-800"
            >Mon profil</a
          >
          <a
            href="#"
            class="block px-4 py-2 mt-1 text-base font-medium text-gray-400 transition duration-150 ease-in-out hover:text-white hover:bg-gray-800 focus:outline-none focus:text-white focus:bg-gray-800"
            >Paramètres</a
          >
          <a
            href="#"
            class="block px-4 py-2 mt-1 text-base font-medium text-gray-400 transition duration-150 ease-in-out hover:text-white hover:bg-gray-800 focus:outline-none focus:text-white focus:bg-gray-800"
            >Déconnexion</a
          >
        </div>
      </div>
    </div>
  </nav>
</template>
<script>
import { ref } from "vue";
export default {
  setup() {
    const isMobileOpen = ref(false);

    function toggleMobileMenu() {
      isMobileOpen.value = !isMobileOpen.value;
    }
  
    return {
      isMobileOpen,
      toggleMobileMenu,
    };
  },
};
</script>