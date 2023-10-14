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
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Before
                    </th>
                    <th scope="col" class="px-6 py-3">
                        After
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actioned By
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actioned At
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="log in ipAddressStore.ipAddress?.audit_logs" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ log.action_type }}
                    </th>
                    <td class="px-6 py-4">
                        <ul>
                            <li v-for="(change, index) in log.difference">{{ index + ':' + change[0] }}</li>
                        </ul>
                    </td>
                    <td class="px-6 py-4">
                        <ul>
                            <li v-for="(change, index) in log.difference">{{ index + ':' + change[1] }}</li>
                        </ul>
                    </td>
                    <td class="px-6 py-4">
                        {{ log.actioned_by?.name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ log.actioned_at }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
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