<template>
    <div class="flex bg-gray-100 min-h-screen">
        <Sidebar />
        <div class="flex-grow text-gray-800">
            <Navbar />
            <main class="p-6 sm:p-10 space-y-6">
                <router-view />
            </main>
        </div>
    </div>
</template>

<script setup>
import Sidebar from '@src/components/layouts/auth-layout/Sidebar.vue';
import Navbar from '@src/components/layouts/auth-layout/Navbar.vue';
</script>