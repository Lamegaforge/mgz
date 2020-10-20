<template>
  <nav class="sticky top-0 z-50 w-full bg-gray-900 shadow">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <div class="flex items-center flex-shrink-0">
            <a
              href="/"
              class="text-xl font-bold tracking-tight text-white uppercase"
              >megasaurus</a
            >
          </div>
          <div class="hidden sm:ml-6 sm:flex">
            <a
              :href="link[1]"
              v-for="(link, index) in links"
              :key="index"
              :class="{
                'text-white border-indigo-500 focus:border-indigo-700': link[2],
                'text-gray-300 border-transparent hover:text-white hover:border-gray-300 focus:text-gray-700 focus:border-gray-300': !link[2],
              }"
              class="inline-flex items-center px-1 pt-1 ml-8 text-sm font-medium leading-5 transition duration-150 ease-in-out border-b-2 first:ml-0 focus:outline-none focus:text-gray-700"
              >{{ link[0] }}</a
            >
          </div>
        </div>
        <div class="hidden sm:ml-6 sm:flex sm:items-center">
          <a
            v-if="!user"
            :href="profileLinks.login.url"
            class="inline-flex items-center h-full px-1 pt-1 ml-8 text-sm font-medium leading-5 text-gray-300 transition duration-150 ease-in-out border-b-2 border-transparent hover:text-white hover:border-gray-300 focus:text-gray-700 focus:border-gray-300 first:ml-0 focus:outline-none"
            >{{ profileLinks.login.label }}</a
          >
          <dropdown
            v-if="user"
            class="ml-3"
            button-class="flex text-sm transition duration-150 ease-in-out border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300"
          >
            <template #trigger>
              <img
                class="object-cover w-8 h-8 rounded-full"
                :src="user?.profile_image_url"
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
                  :href="`${profileLinks.profile.url}/${user.id}`"
                  class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-800"
                  role="menuitem"
                  >{{ profileLinks.profile.label }}</a
                ><a
                  :href="profileLinks.settings.url"
                  class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-800"
                  role="menuitem"
                  >{{ profileLinks.settings.label }}</a
                >
                <a
                  :href="profileLinks.logout.url"
                  class="block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-800"
                  role="menuitem"
                  >{{ profileLinks.logout.label }}</a
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
        <a
          :href="link[1]"
          v-for="(link, index) in links"
          :key="index"
          :class="{
            'text-indigo-500 border-indigo-500 focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700':
              link[2],
            'text-gray-300 border-transparent hover:text-white hover:bg-gray-800 hover:border-gray-300 focus:text-white focus:bg-gray-50 focus:border-gray-300': !link[2],
          }"
          class="block py-2 pl-3 pr-4 mt-1 text-base font-medium transition duration-150 ease-in-out border-l-4 focus:outline-none"
          >{{ link[0] }}</a
        >
        <a
          v-if="!user"
          :href="profileLinks.login.url"
          class="block py-2 pl-3 pr-4 mt-1 text-base font-medium text-gray-300 transition duration-150 ease-in-out border-l-4 border-transparent hover:text-white hover:bg-gray-800 hover:border-gray-300 focus:text-white focus:bg-gray-50 focus:border-gray-300 focus:outline-none"
          >{{ profileLinks.login.label }}</a
        >
      </div>
      <div class="pt-4 pb-3 border-t border-gray-800" v-if="user">
        <div class="flex items-center px-4">
          <div class="flex-shrink-0">
            <img
              class="object-cover w-10 h-10 rounded-full"
              :src="user?.profile_image_url"
              alt=""
            />
          </div>
          <div class="ml-3">
            <div class="text-base font-medium leading-6 text-white">
              {{ user?.display_name }}
            </div>
          </div>
        </div>
        <div class="mt-3">
          <a
            :href="`${profileLinks.profile.url}/${user.id}`"
            class="block px-4 py-2 text-base font-medium text-gray-400 transition duration-150 ease-in-out hover:text-white hover:bg-gray-800 focus:outline-none focus:text-white focus:bg-gray-800"
            >{{ profileLinks.profile.label }}</a
          >
          <a
            :href="profileLinks.settings.url"
            class="block px-4 py-2 mt-1 text-base font-medium text-gray-400 transition duration-150 ease-in-out hover:text-white hover:bg-gray-800 focus:outline-none focus:text-white focus:bg-gray-800"
            >{{ profileLinks.settings.label }}</a
          >
          <a
            :href="profileLinks.logout.url"
            class="block px-4 py-2 mt-1 text-base font-medium text-gray-400 transition duration-150 ease-in-out hover:text-white hover:bg-gray-800 focus:outline-none focus:text-white focus:bg-gray-800"
            >{{ profileLinks.logout.label }}</a
          >
        </div>
      </div>
    </div>
  </nav>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    links: Array,
    user: Object,
  },
  setup() {
    const isMobileOpen = ref(false);
    const profileLinks = ref({
      login: {
        label: "Connexion",
        url: "/oauth/login",
      },
      profile: {
        label: "Mon profil",
        url: "/users",
      },
      settings: {
        label: "Paramètres",
        url: "#",
      },
      logout: {
        label: "Déconnexion",
        url: "/logout",
      },
    });
    function toggleMobileMenu() {
      isMobileOpen.value = !isMobileOpen.value;
    }

    return {
      isMobileOpen,
      toggleMobileMenu,
      profileLinks,
    };
  },
};
</script>