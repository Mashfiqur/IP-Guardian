<template>
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                        type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="#" class="flex ml-2 md:mr-24">
                        <img class="h-8 mr-3" src="@src/assets/ip.png" alt="logo">
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">IP Guardian</span>
                    </a>
                </div>
                <div @mouseenter="showProfileMenu = true" @mouseleave="showProfileMenu = false" class="flex flex-shrink-0 items-center ml-auto">
                    <button class="relative inline-flex items-center p-2 hover:bg-gray-100 focus:bg-gray-100 rounded-lg">
                        <span class="h-12 w-12 ml-2 sm:ml-3 mr-2 bg-gray-100 rounded-full overflow-hidden">
                            <img class="h-full w-full object-cover" src="@src/assets/avatar.png" alt="logo">
                        </span>
                    </button>
                    <div class="absolute top-[72px] right-[12px] bg-white border rounded-md p-2 w-[240px]" v-if="showProfileMenu">
                        <div class="px-4 py-3">
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ authStore.user?.name }}
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300">
                                {{ authStore.user?.email }}
                            </p>
                        </div>
                        <hr>
                        <ul class="py-1">
                            <li>
                                <router-link to="/my-profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                    My Profile
                                </router-link>
                            </li>
                            <li>
                                <p @click="authStore.logout" class="cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Sign out
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@src/store/auth';

// Initiate store
const authStore = useAuthStore();

const showProfileMenu = ref(false);
</script>