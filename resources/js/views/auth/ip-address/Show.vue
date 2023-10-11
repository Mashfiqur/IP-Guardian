<template>
    <div class="flex items-center justify-between p-4">
        <h1 class="text-lg font-semibold">IP Address</h1>
    </div>

    <h3>Information</h3>
    <div class="flex text-gray-600">
        <h4 class="text-dark">IP:</h4>
        <span class="ml-3">{{ ipAddressStore.ipAddress?.ip }}</span>
    </div>
    <div class="flex text-gray-600">
        <h4 class="text-dark">Label:</h4>
        <span class="ml-3">{{ ipAddressStore.ipAddress?.label }}</span>
    </div>
    <div class="flex text-gray-600">
        <h4 class="text-dark">Comment:</h4>
        <span class="ml-3">{{ ipAddressStore.ipAddress?.comment }}</span>
    </div>
    
    <h3>Audir Logs</h3>

</template>

<script setup>
import { useRoute } from 'vue-router';
import { onMounted } from 'vue';
import { useIPAddressStore } from '@src/store/ipAddress';

// Initiate stores
const ipAddressStore = useIPAddressStore();

ipAddressStore.initiateIPAddress();

const route = useRoute();

const id = route.params.id;

onMounted(async() => {
    if (id !== undefined) await ipAddressStore.showIPAddress(id);
})

</script>