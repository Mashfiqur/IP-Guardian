<template>
    <div class="flex items-center justify-between p-4">
        <h1 class="text-lg font-semibold">IP Address</h1>
        <router-link
            to="/ip-addresses/create"
            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded"
        >
        Add IP Address
        </router-link>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex items-center justify-between pb-4">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="table-search" v-model="searchTableQuery" @keyup="handleSearchIpAddress"
                    class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search for items">
            </div>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        LABEL
                    </th>
                    <th scope="col" class="px-6 py-3">
                        IP
                    </th>
                    <th scope="col" class="px-6 py-3">
                        COMMENT
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="ipAddressStore.ipAddresses.length" v-for="ipAddress in ipAddressStore.ipAddresses" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <router-link
                            :to="`/ip-addresses/${ipAddress.id}`"
                        >
                         {{ ipAddress?.label }}
                        </router-link>
                    </th>
                    <td class="px-6 py-4">
                        {{ ipAddress?.ip }}
                    </td>
                    <td class="px-6 py-4">
                        {{ ipAddress?.comment }}
                    </td>
                    <td class="flex px-6 py-4">
                        <router-link
                            :to="`/ip-addresses/${ipAddress.id}`"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-2"
                        >
                        <svg width="17" height="13" viewBox="0 0 17 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.375 6.75C5.375 4.83594 6.93359 3.25 8.875 3.25C10.7891 3.25 12.375 4.83594 12.375 6.75C12.375 8.69141 10.7891 10.25 8.875 10.25C6.93359 10.25 5.375 8.69141 5.375 6.75ZM8.875 8.9375C10.0781 8.9375 11.0625 7.98047 11.0625 6.75C11.0625 5.54688 10.0781 4.5625 8.875 4.5625C8.84766 4.5625 8.82031 4.5625 8.79297 4.5625C8.84766 4.72656 8.875 4.86328 8.875 5C8.875 5.98438 8.08203 6.75 7.125 6.75C6.96094 6.75 6.82422 6.75 6.6875 6.69531C6.6875 6.72266 6.6875 6.75 6.6875 6.75C6.6875 7.98047 7.64453 8.9375 8.875 8.9375ZM3.59766 2.83984C4.88281 1.63672 6.66016 0.625 8.875 0.625C11.0625 0.625 12.8398 1.63672 14.125 2.83984C15.4102 4.01562 16.2578 5.4375 16.668 6.42188C16.75 6.64062 16.75 6.88672 16.668 7.10547C16.2578 8.0625 15.4102 9.48438 14.125 10.6875C12.8398 11.8906 11.0625 12.875 8.875 12.875C6.66016 12.875 4.88281 11.8906 3.59766 10.6875C2.3125 9.48438 1.46484 8.0625 1.05469 7.10547C0.972656 6.88672 0.972656 6.64062 1.05469 6.42188C1.46484 5.4375 2.3125 4.01562 3.59766 2.83984ZM8.875 1.9375C7.07031 1.9375 5.62109 2.75781 4.5 3.79688C3.43359 4.78125 2.72266 5.92969 2.33984 6.75C2.72266 7.57031 3.43359 8.74609 4.5 9.73047C5.62109 10.7695 7.07031 11.5625 8.875 11.5625C10.6523 11.5625 12.1016 10.7695 13.2227 9.73047C14.2891 8.74609 15 7.57031 15.3828 6.75C15 5.92969 14.2891 4.78125 13.2227 3.79688C12.1016 2.75781 10.6523 1.9375 8.875 1.9375Z" fill="#565865"/>
                        </svg>
                        </router-link>
                        <router-link
                            :to="`/ip-addresses/${ipAddress.id}/edit`"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                        >
                        <span class="flex">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.1992 1.43359C10.9648 0.667969 12.1953 0.667969 12.9609 1.43359L13.3164 1.78906C14.082 2.55469 14.082 3.78516 13.3164 4.55078L7.90234 9.96484C7.68359 10.1836 7.38281 10.375 7.05469 10.457L4.32031 11.25C4.10156 11.3047 3.85547 11.25 3.69141 11.0586C3.5 10.8945 3.44531 10.6484 3.5 10.4297L4.29297 7.69531C4.375 7.36719 4.56641 7.06641 4.78516 6.84766L10.1992 1.43359ZM12.0312 2.36328C11.7852 2.11719 11.375 2.11719 11.1289 2.36328L10.3086 3.15625L11.5938 4.44141L12.3867 3.62109C12.6328 3.375 12.6328 2.96484 12.3867 2.71875L12.0312 2.36328ZM5.55078 8.05078L5.08594 9.66406L6.69922 9.19922C6.80859 9.17188 6.89062 9.11719 6.97266 9.03516L10.6641 5.34375L9.40625 4.08594L5.71484 7.77734C5.63281 7.85938 5.57812 7.94141 5.55078 8.05078ZM5.46875 2.5C5.82422 2.5 6.125 2.80078 6.125 3.15625C6.125 3.53906 5.82422 3.8125 5.46875 3.8125H2.40625C1.77734 3.8125 1.3125 4.30469 1.3125 4.90625V12.3438C1.3125 12.9727 1.77734 13.4375 2.40625 13.4375H9.84375C10.4453 13.4375 10.9375 12.9727 10.9375 12.3438V9.28125C10.9375 8.92578 11.2109 8.625 11.5938 8.625C11.9492 8.625 12.25 8.92578 12.25 9.28125V12.3438C12.25 13.6836 11.1562 14.75 9.84375 14.75H2.40625C1.06641 14.75 0 13.6836 0 12.3438V4.90625C0 3.59375 1.06641 2.5 2.40625 2.5H5.46875Z" fill="#565865"/>
                            </svg>
                        </span>
                        </router-link>
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="4" class="text-center py-5 text-gray-600">Data Not Found</td>
                </tr>
            </tbody>
        </table>
        <Paginator
            :title="'IP Addresses'"
            :fetchRecords="ipAddressStore.fetchIPAddresses"
        />
    </div>
</template>

<script setup>
import { useIPAddressStore } from '@src/store/ipAddress';
import Paginator from '@src/components/global/Paginator.vue';
import { ref } from 'vue';

// Initiate stores
const ipAddressStore = useIPAddressStore();

const searchTableQuery = ref(null);
let searchQueryCounter;

ipAddressStore.fetchIPAddresses();

const handleSearchIpAddress = () => {
    clearTimeout(searchQueryCounter);
    searchQueryCounter = setTimeout(() => {
        ipAddressStore.setSearchParam({query: searchTableQuery.value});
        ipAddressStore.fetchIPAddresses();
    }, 500);
}
</script>