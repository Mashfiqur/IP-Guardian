<template>
    <Navbar/>
    <Sidebar/>

    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 h-screen border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <router-view/>
        </div>
    </div>
</template>

<script setup>
import Sidebar from '@src/components/layouts/auth-layout/Sidebar.vue';
import Navbar from '@src/components/layouts/auth-layout/Navbar.vue';
</script>