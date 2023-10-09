<template>
    <header class="flex items-center h-20 px-6 sm:px-10 bg-white">
        <div 
            @mouseenter="showProfileMenu = true"
            @mouseleave="showProfileMenu = false"
            class="flex flex-shrink-0 items-center ml-auto"
        >
            <button class="relative inline-flex items-center p-2 hover:bg-gray-100 focus:bg-gray-100 rounded-lg">
                <div class="hidden md:flex md:flex-col md:items-end md:leading-tight">
                    <span class="font-semibold">Mashfiqur Rahman</span>
                    <span class="text-sm text-gray-600">Software Engineer</span>
                </div>
                <span class="h-12 w-12 ml-2 sm:ml-3 mr-2 bg-gray-100 rounded-full overflow-hidden">
                    <img class="h-full w-full object-cover" src="@src/assets/avatar.png" alt="logo">
                </span>
                <svg aria-hidden="true" viewBox="0 0 20 20" fill="currentColor"
                    class="hidden sm:block h-6 w-6 text-gray-300">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div class="absolute top-[72px] bg-white border rounded-md p-2 w-[250px]" v-if="showProfileMenu">
                <div class="p-2 hover:bg-blue-100 cursor-pointer">My Profile</div>
                <div class="p-2 hover:bg-blue-100 cursor-pointer" @click="authStore.logout">Logout</div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@src/store/auth';

// Initiate store
const authStore = useAuthStore();

const showProfileMenu = ref(false);
</script>