<template>
    <div class="flex items-center justify-between py-4">
        <h1 class="flex text-lg font-semibold">
            <img src="@src/assets/angle-left.svg" class="cursor-pointer" alt="IP" width="20" @click="router.push({name: 'ip-address' })">
            <span class="text-gray-600">IP Address</span>
        </h1>
    </div>

    <div class="flex text-gray-600 py-1">
        <h4 class="text-dark text-md font-semibold">IP:</h4>
        <span class="ml-3">{{ ipAddressStore.ipAddress?.ip }}</span>
    </div>
    <div class="flex text-gray-600 py-1">
        <h4 class="text-dark text-md font-semibold">Label:</h4>
        <span class="ml-3">{{ ipAddressStore.ipAddress?.label }}</span>
    </div>
    <div class="flex text-gray-600 py-1">
        <h4 class="text-dark text-md font-semibold">Comment:</h4>
        <span class="ml-3">{{ ipAddressStore.ipAddress?.comment }}</span>
    </div>
    
    <h3 class="text-gray-600 text-md font-semibold py-2 mb-2">Audit Logs</h3>
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
                        {{ log?.action_type }}
                    </th>
                    <td class="px-6 py-4">
                        <ul>
                            <li v-for="(change, index) in log.difference">
                                <span v-if="change.length > 0">{{ index + ' : ' + change[0] }}</span>
                            </li>
                        </ul>
                    </td>
                    <td class="px-6 py-4">
                        <ul>
                            <li v-for="(change, index) in log.difference">
                                <span v-if="change.length > 1">{{ index + ' : ' + change[1] }}</span>
                            </li>
                        </ul>
                    </td>
                    <td class="px-6 py-4">
                        {{ log?.actioned_by?.name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ log?.actioned_at }}
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
import router from '@src/router';

// Initiate stores
const ipAddressStore = useIPAddressStore();

ipAddressStore.initiateIPAddress();

const route = useRoute();

const id = route.params.id;

onMounted(async() => {
    if (id !== undefined) await ipAddressStore.showIPAddress(id);
})

</script>